@extends('layout')

@section('content')
<h2>Product Details</h2>

<a href="{{ route('products.index') }}" class="btn btn-dark mb-3">⬅ Back to Products</a>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ $product->name }}</h4>
                <small class="text-muted">Product Code: {{ $product->product_code }}</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Category:</strong> {{ $product->category }}</p>
                        <p><strong>Supplier:</strong> {{ $product->supplier ?: 'Not specified' }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge badge-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'warning' : 'danger') }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Selling Price:</strong> ₱{{ number_format($product->selling_price, 2) }}</p>
                        <p><strong>Cost Price:</strong> ₱{{ number_format($product->cost_price, 2) }}</p>
                        <p><strong>Profit Margin:</strong> ₱{{ number_format($product->selling_price - $product->cost_price, 2) }}</p>
                    </div>
                </div>
                
                @if($product->description)
                <div class="mt-3">
                    <strong>Description:</strong>
                    <p>{{ $product->description }}</p>
                </div>
                @endif

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5>Current Stock</h5>
                            <h3 class="text-{{ $product->stock_status == 'out_of_stock' ? 'danger' : ($product->stock_status == 'low_stock' ? 'warning' : 'success') }}">
                                {{ $product->stock_quantity }}
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5>Minimum Stock</h5>
                            <h3>{{ $product->minimum_stock }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5>Stock Status</h5>
                            <span class="badge badge-{{ $product->stock_status == 'out_of_stock' ? 'danger' : ($product->stock_status == 'low_stock' ? 'warning' : 'success') }}">
                                {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit Product</a>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#stockModal">Update Stock</button>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($product->sales->count() > 0)
<div class="mt-4">
    <h4>Sales History</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->sales as $sale)
                <tr>
                    <td>{{ $sale->transaction_id }}</td>
                    <td>{{ $sale->customer->full_name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>₱{{ number_format($sale->amount, 2) }}</td>
                    <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Stock Update Modal -->
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Stock - {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('products.stock.update', $product) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Stock: {{ $product->stock_quantity }}</label>
                        <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection