@extends('layout')

@section('content')
<h2>Add Customer</h2>

<a href="{{ route('dashboard') }}" class="btn btn-dark mb-3">⬅ Back to Dashboard</a>
<a href="{{ route('sales.index') }}" class="btn btn-secondary mb-3">View Sales</a>
<a href="{{ route('products.index') }}" class="btn btn-info mb-3">Manage Inventory</a>

<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Customer Code <span class="text-danger">*</span></label>
                <input type="text" name="customer_code" class="form-control" required>
                <small class="form-text text-muted">Unique identifier for the customer</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3" placeholder="Customer's address..."></textarea>
    </div>

    @if($availableProducts->count() > 0)
    <div class="mb-4">
        <h4>🛍️ Select Products for This Customer</h4>
        <p class="text-muted">Choose products that this customer is interested in or has purchased</p>
        
        <div class="row">
            @foreach($availableProducts as $product)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="selected_products[]" 
                                   value="{{ $product->id }}" 
                                   id="product_{{ $product->id }}"
                                   data-price="{{ $product->selling_price }}"
                                   data-name="{{ $product->name }}">
                            <label class="form-check-label" for="product_{{ $product->id }}">
                                <strong>{{ $product->name }}</strong>
                                <br><small class="text-muted">{{ $product->product_code }}</small>
                            </label>
                        </div>
                        <div class="mt-2">
                            <p class="mb-1">
                                <strong>Price:</strong> ₱{{ number_format($product->selling_price, 2) }}<br>
                                <strong>Category:</strong> {{ $product->category }}<br>
                                <strong>Stock:</strong> 
                                <span class="badge badge-{{ $product->stock_status == 'out_of_stock' ? 'danger' : ($product->stock_status == 'low_stock' ? 'warning' : 'success') }}">
                                    {{ $product->stock_quantity }}
                                    @if($product->stock_status == 'low_stock')
                                        (Low Stock)
                                    @elseif($product->stock_status == 'out_of_stock')
                                        (Out of Stock)
                                    @endif
                                </span>
                            </p>
                            @if($product->description)
                                <small class="text-muted">{{ Str::limit($product->description, 80) }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-3">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="selectAllProducts()">Select All</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAllProducts()">Deselect All</button>
        </div>
    </div>
    @endif

    <button type="submit" class="btn btn-success">Create Customer</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
</form>

<script>
function selectAllProducts() {
    document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllProducts() {
    document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>

@if($availableProducts->count() > 0)
<div class="mt-5">
    <h3>🛍️ Available Products</h3>
    <p class="text-muted">Products available for purchase after creating this customer</p>
    
    <div class="row">
        @foreach($availableProducts as $product)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text">
                        <small class="text-muted">{{ $product->product_code }}</small><br>
                        <strong>Price:</strong> ₱{{ number_format($product->selling_price, 2) }}<br>
                        <strong>Category:</strong> {{ $product->category }}<br>
                        <strong>Stock:</strong> 
                        <span class="badge badge-{{ $product->stock_status == 'out_of_stock' ? 'danger' : ($product->stock_status == 'low_stock' ? 'warning' : 'success') }}">
                            {{ $product->stock_quantity }}
                            @if($product->stock_status == 'low_stock')
                                (Low Stock)
                            @elseif($product->stock_status == 'out_of_stock')
                                (Out of Stock)
                            @endif
                        </span>
                    </p>
                    @if($product->description)
                        <p class="card-text">
                            <small class="text-muted">{{ Str::limit($product->description, 100) }}</small>
                        </p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="text-center mt-3">
        <p class="text-muted">After creating the customer, you can create sales for these products</p>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">View All Products</a>
    </div>
</div>
@else
<div class="mt-5">
    <div class="alert alert-warning">
        <h4>No Products Available</h4>
        <p>There are currently no active products with stock available.</p>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Products to Inventory</a>
    </div>
</div>
@endif
@endsection
