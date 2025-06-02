<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;



class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['customer', 'product']);


        $user = Auth::user();

        if ($user->role === 'staff') {
            // Staff see only purchases they added
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'customer') {
            // Customer see only their own purchases via customers table
            $customer = $user->customer; // Assuming user hasOne Customer relationship
            if ($customer) {
                $query->where('customers_id', $customer->id);
            } else {
                // No customer record linked — return empty
                $query->whereRaw('1=0');
            }
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', "%$search%"))
                  ->orWhereHas('product', fn($q) => $q->where('name', 'like', "%$search%"));
            // Add other search fields if needed
        }
    
        // Sorting logic
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
    
        // Allow sorting only on certain columns to prevent SQL injection
        $allowedSorts = ['id', 'customer_id', 'product_id', 'quantity', 'total', 'created_at'];
    
        if (in_array($sort, $allowedSorts)) {
            // For customer and product sorting, join the related tables
            if ($sort === 'customer_id') {
                $query->join('customers', 'purchases.customers_id', '=', 'customers.id')
                      ->orderBy('customers.name', $direction)
                      ->select('purchases.*');
            } elseif ($sort === 'product_id') {
                $query->join('products', 'purchases.products_id', '=', 'products.id')
                      ->orderBy('products.name', $direction)
                      ->select('purchases.*');
            } else {
                $query->orderBy($sort, $direction);
            }
        } else {
            // Default sorting
            $query->orderBy('id', 'asc');
        }
    
        $purchases = $query->paginate(10);
    
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('purchases.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,id',
            'customers_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            function ($attribute, $value, $fail) use ($request) {
                $product = Product::find($request->products_id);
                if ($product && $value > $product->stock) {
                    $fail('Quantity must not exceed available stock of ' . $product->stock . '.');
                }
            },
        ]);

        $product = Product::find($request->products_id);
        $total = $product->price * $request->quantity;

        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available!']);
        }

        Purchase::create([
            'products_id' => $request->products_id,
            'customers_id' => $request->customers_id,
            'quantity' => $request->quantity,
            'total' => $total,
            'user_id' => Auth::id(), // link purchase to logged-in user
        ]);

        $product->decrement('stock', $request->quantity);


        return redirect()->route('purchases.index')->with('success', 'Purchase added successfully!');
    }

    public function edit(Purchase $purchase)
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('purchases.edit', compact('purchase', 'products', 'customers'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'products_id' => 'required|exists:products,id',
            'customers_id' => 'required|exists:customers,id',
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request, $purchase) {
                    $product = Product::find($request->products_id);
                    if ($product) {
                        // Available stock + current purchase quantity
                        $availableStock = $product->stock + $purchase->quantity;
    
                        if ($value > $availableStock) {
                            $fail('Quantity must not exceed available stock of ' . $availableStock . '.');
                        }
                    }
                },
            ],
        ]);
    
        $product = Product::find($request->products_id);
    
        if ($purchase->products_id == $product->id) {
            // Same product: restore the old quantity before deducting the new quantity
            $product->stock += $purchase->quantity;
        } else {
            // Different product selected:
            // Restore stock for old product
            $oldProduct = Product::findOrFail($purchase->products_id);
            $oldProduct->stock += $purchase->quantity;
            $oldProduct->save();
        }
    
        // Deduct the new quantity from the product's stock
        $product->stock -= $request->quantity;
        $product->save();
    
        // Calculate total price
        $total = $product->price * $request->quantity;
    
        // Update the purchase record
        $purchase->update([
            'products_id' => $request->products_id,
            'customers_id' => $request->customers_id,
            'quantity' => $request->quantity,
            'total' => $total,
        ]);
    
        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully!');
    }
    

    public function destroy(Purchase $purchase)
    {

            // Find the product related to this purchase
    $product = Product::find($purchase->products_id);

    if ($product) {
        // Restore the stock by adding back the quantity from this purchase
        $product->stock += $purchase->quantity;
        $product->save();
    }
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully!');
    }
    
    public function exportPdf(Request $request)
    {
        $user = Auth::user(); // currently logged-in user
    
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
    
        $query = Purchase::query();
    
        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', fn($q2) => $q2->where('name', 'like', "%$search%"))
                  ->orWhereHas('product', fn($q2) => $q2->where('name', 'like', "%$search%"));
            });
        }
    
        // Sorting logic
        if ($sort === 'customer_id') {
            $query->join('customers', 'purchases.customers_id', '=', 'customers.id')
                  ->orderBy('customers.name', $direction)
                  ->select('purchases.*');
        } elseif ($sort === 'product_id') {
            $query->join('products', 'purchases.products_id', '=', 'products.id')
                  ->orderBy('products.name', $direction)
                  ->select('purchases.*');
        } else {
            $query->orderBy($sort, $direction);
        }
    
        $purchases = $query->with(['customer', 'product'])->get();
    
        // Pass the user to the PDF view
        $pdf = Pdf::loadView('purchases.pdf', compact('purchases', 'user'));
    
        return $pdf->download('purchases.pdf');
    }
    
    public function exportSinglePdf(Purchase $purchase)
    {
        $user = Auth::user(); // currently logged-in user
    
        $purchase->load(['customer', 'product']);
    
        // Pass the user to the PDF view
        $pdf = Pdf::loadView('purchases.single-pdf', compact('purchase', 'user'));
    
        return $pdf->download("purchase_{$purchase->id}.pdf");
    }
    
    

    
}

