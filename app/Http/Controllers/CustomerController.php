<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;



class CustomerController extends Controller
{
    public function index(Request $request)
    {

        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');
    
        $customers = Customer::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->orderBy($sort, $direction)
          ->paginate(10);
    
        return view('customers.index', compact('customers'));
    }
    

    public function create()
    {
        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        return view('customers.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    public function edit(Customer $customer)
    {
        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }

    public function exportPdf(Request $request)
    {
        if (Auth::user()->role == 'customer') {
            abort(403, 'Unauthorized');
        }
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');
    
        $customers = Customer::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->orderBy($sort, $direction)->get();
    
        $pdf = Pdf::loadView('customers.pdf', compact('customers'));
    
        return $pdf->download('customers.pdf');
    }

    public function generateIndividualPDF($id)
{
    if (Auth::user()->role == 'customer') {
        abort(403, 'Unauthorized');
    }
    $customer = Customer::findOrFail($id);

    $pdf = PDF::loadView('customers.individual_pdf', compact('customer'));

    return $pdf->download('customer_'.$customer->id.'_report.pdf');
}
}
