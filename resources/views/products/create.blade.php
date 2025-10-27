@extends('layout')

@section('content')
<h2>Add New Product</h2>

<a href="{{ route('products.index') }}" class="btn btn-dark mb-3">⬅ Back to Products</a>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" name="selling_price" class="form-control" step="0.01" min="0" value="{{ old('selling_price') }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" name="cost_price" class="form-control" step="0.01" min="0" value="{{ old('cost_price') }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Initial Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock_quantity" class="form-control" min="0" value="{{ old('stock_quantity', 0) }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Minimum Stock Level <span class="text-danger">*</span></label>
                <input type="number" name="minimum_stock" class="form-control" min="0" value="{{ old('minimum_stock', 0) }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Supplier</label>
                <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Create Product</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection