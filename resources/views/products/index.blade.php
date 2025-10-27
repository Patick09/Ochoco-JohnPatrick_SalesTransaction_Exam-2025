@extends('layout')

@section('content')
<h2>Product Inventory Management</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('dashboard') }}" class="btn btn-dark">⬅ Back to Dashboard</a>
    <a href="{{ route('products.create') }}" class="btn btn-success">Add New Product</a>
</div>


<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Selling Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->product_code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>₱{{ number_format($product->selling_price, 2) }}</td>
                <td>
                    <span class="badge badge-{{ $product->stock_status == 'out_of_stock' ? 'danger' : ($product->stock_status == 'low_stock' ? 'warning' : 'success') }}">
                        {{ $product->stock_quantity }}
                        @if($product->stock_status == 'low_stock')
                            (Low Stock)
                        @elseif($product->stock_status == 'out_of_stock')
                            (Out of Stock)
                        @endif
                    </span>
                </td>
                <td>
                    <span class="badge badge-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'warning' : 'danger') }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->id }}">Stock</button>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>

            <!-- Stock Update Modal -->
            <div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1">
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
            @empty
            <tr>
                <td colspan="7" class="text-center">No products found. <a href="{{ route('products.create') }}">Create the first product</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection