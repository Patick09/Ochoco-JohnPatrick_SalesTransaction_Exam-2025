<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::with(['customer', 'product'])->orderBy('created_at', 'desc')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();

        // Determine selected product automatically
        $preSelectedProducts = [];
        $selectedProduct = null;

        if (request('customer_id')) {
            $preSelectedProducts = session('selected_products_for_customer_' . request('customer_id'), []);
        }

        if (request('product_id')) {
            $selectedProduct = Product::where('status', 'active')->find(request('product_id'));
        } elseif (count($preSelectedProducts) === 1) {
            $selectedProduct = Product::where('status', 'active')->find($preSelectedProducts[0]);
        }

        return view('sales.create', compact('customers', 'preSelectedProducts', 'selectedProduct'));
    }

    public function store(Request $request)
    {
        // Support multi-item submission
        $isMulti = $request->has('items');

        $baseRules = [
            'status' => 'required|in:pending,completed,cancelled',
            'sale_date' => 'required|date',
            'sale_time' => 'required',
            'notes' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id',
        ];

        if ($isMulti) {
            $request->validate($baseRules + [
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.amount' => 'required|numeric|min:0',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            foreach ($request->items as $index => $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock_quantity < (int) $item['quantity']) {
                    return redirect()->back()
                        ->withErrors(["items.$index.quantity" => 'Insufficient stock. Available: ' . $product->stock_quantity])
                        ->withInput();
                }

                Sales::create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'amount' => $item['amount'],
                    'quantity' => $item['quantity'],
                    'status' => $request->status,
                    'sale_date' => $request->sale_date,
                    'sale_time' => $request->sale_time,
                    'notes' => $request->notes,
                    'customer_id' => $request->customer_id,
                ]);

                $product->decrement('stock_quantity', (int) $item['quantity']);
            }
        } else {
            $request->validate($baseRules + [
                'product_id' => 'required|exists:products,id',
                'amount' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
            ]);

            $product = Product::findOrFail($request->product_id);

            if ($product->stock_quantity < $request->quantity) {
                return redirect()->back()
                    ->withErrors(['quantity' => 'Insufficient stock. Available: ' . $product->stock_quantity])
                    ->withInput();
            }

            Sales::create([
                'product_id' => $request->product_id,
                'product_name' => $product->name,
                'amount' => $request->amount,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'sale_date' => $request->sale_date,
                'sale_time' => $request->sale_time,
                'notes' => $request->notes,
                'customer_id' => $request->customer_id
            ]);

            $product->decrement('stock_quantity', $request->quantity);
        }

        return redirect()->route('sales.index')->with('success', 'Sale transaction(s) created successfully.');
    }

    public function customerProducts(Customer $customer)
    {
        $productIds = session('selected_products_for_customer_' . $customer->id, []);
        $products = Product::whereIn('id', $productIds)->where('status', 'active')->get(['id', 'name', 'product_code', 'selling_price', 'stock_quantity']);
        return response()->json([
            'products' => $products,
        ]);
    }

    public function edit(Sales $sale)
    {
        $customers = Customer::where('status', 'active')->get();
        $products = Product::where('status', 'active')->get();
        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, Sales $sale)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
            'sale_date' => 'required|date',
            'sale_time' => 'required',
            'notes' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        $oldQuantity = $sale->quantity;
        $newQuantity = $request->quantity;
        
        // Calculate stock difference
        $stockDifference = $newQuantity - $oldQuantity;
        
        // Check if there's enough stock for the increase
        if ($stockDifference > 0 && $product->stock_quantity < $stockDifference) {
            return redirect()->back()
                ->withErrors(['quantity' => 'Insufficient stock. Available: ' . $product->stock_quantity])
                ->withInput();
        }

        // Update the sale
        $sale->update([
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'amount' => $request->amount,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'sale_date' => $request->sale_date,
            'sale_time' => $request->sale_time,
            'notes' => $request->notes,
            'customer_id' => $request->customer_id
        ]);

        // Update stock quantity
        if ($stockDifference != 0) {
            $product->decrement('stock_quantity', $stockDifference);
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sale transaction updated successfully.');
    }

    public function destroy(Sales $sale)
    {
        // Restore stock quantity when deleting a sale
        if ($sale->product) {
            $sale->product->increment('stock_quantity', $sale->quantity);
        }
        
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sale transaction deleted successfully.');
    }
}
