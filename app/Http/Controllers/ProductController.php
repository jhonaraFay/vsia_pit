<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $query = Product::with(['customer', 'product', 'user']);

    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
    
    $search = $request->input('search');
    $sort = $request->input('sort', 'name');
    $direction = $request->input('direction', 'asc');

    $products = Product::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('description', 'like', "%{$search}%");
    })->orderBy($sort, $direction)->paginate(10);

    return view('products.index', compact('products', 'search', 'sort', 'direction'));
}
//export pdf
public function exportPdf(Request $request) // ✅ must be passed like this
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
    $search = $request->input('search');
    $sort = $request->input('sort', 'name'); // default to name
    $direction = $request->input('direction', 'asc');

    $products = Product::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('description', 'like', "%{$search}%");
    })->orderBy($sort, $direction)->get();

    $pdf = Pdf::loadView('products.pdf', compact('products'));
    return $pdf->download('products.pdf');
}
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
    public function exportIndividualPdf($id)
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }
    $product = Product::findOrFail($id);

    $pdf = PDF::loadView('products.individual_pdf', compact('product'));
    return $pdf->download("product_{$product->id}_report.pdf");
}
}
