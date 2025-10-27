<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('sales')->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        // Get available products to show during customer creation
        $availableProducts = \App\Models\Product::active()
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();
            
        return view('customers.create', compact('availableProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'selected_products' => 'nullable|array',
            'selected_products.*' => 'exists:products,id'
        ]);

        $customer = Customer::create($request->all());

        // Store selected products in session for potential use
        if ($request->has('selected_products')) {
            session(['selected_products_for_customer_' . $customer->id => $request->selected_products]);
        }

        $message = 'Customer created successfully.';
        if ($request->has('selected_products') && count($request->selected_products) > 0) {
            $message .= ' Selected ' . count($request->selected_products) . ' products.';
        }
        $message .= ' <a href="' . route('sales.create', ['customer_id' => $customer->id]) . '" class="btn btn-sm btn-success ms-2">Create Sale for This Customer</a>';

        return redirect()->route('customers.index')
            ->with('success', $message);
    }

    public function edit(Customer $customer)
    {
        // Load customer with their sales and products
        $customer->load(['sales.product' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        // Get unique products the customer has purchased
        $purchasedProducts = $customer->sales()
            ->with('product')
            ->whereNotNull('product_id')
            ->get()
            ->pluck('product')
            ->unique('id')
            ->filter()
            ->values();
            
        return view('customers.edit', compact('customer', 'purchasedProducts'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code,' . $customer->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
