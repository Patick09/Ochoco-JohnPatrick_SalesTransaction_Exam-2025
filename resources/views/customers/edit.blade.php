@extends('layout')

@section('content')
<h2>Edit Customer</h2>

<a href="{{ route('dashboard') }}" class="btn btn-dark mb-3">⬅ Back to Dashboard</a>
<a href="{{ route('sales.index') }}" class="btn btn-secondary mb-3">View Sales</a>
<a href="{{ route('sales.create') }}?customer_id={{ $customer->id }}" class="btn btn-success mb-3">Create Sale for This Customer</a>

<form action="{{ route('customers.update', $customer) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Customer Code <span class="text-danger">*</span></label>
                <input type="text" name="customer_code" class="form-control" value="{{ $customer->customer_code }}" required>
                <small class="form-text text-muted">Unique identifier for the customer</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control" value="{{ $customer->first_name }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="last_name" class="form-control" value="{{ $customer->last_name }}" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3" placeholder="Customer's address...">{{ $customer->address }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Update Customer</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
</form>

@if($customer->sales->count() > 0)
<div class="mt-5">
    <h3>🛍️ Customer Purchase History</h3>
    <p class="text-muted">Products this customer has purchased</p>
    
    <div class="row">
        @foreach($purchasedProducts as $product)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text">
                        <small class="text-muted">{{ $product->product_code }}</small><br>
                        <strong>Price:</strong> ₱{{ number_format($product->selling_price, 2) }}<br>
                        <strong>Category:</strong> {{ $product->category }}<br>
                        <strong>Status:</strong> 
                        <span class="badge badge-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'warning' : 'danger') }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="mt-4">
    <h4>📊 Recent Sales Transactions</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->sales->take(10) as $sale)
                <tr>
                    <td>{{ $sale->transaction_id }}</td>
                    <td>
                        {{ $sale->product_name }}
                        @if($sale->product)
                            <br><small class="text-muted">{{ $sale->product->product_code }}</small>
                        @endif
                    </td>
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
@else
<div class="mt-5">
    <div class="alert alert-info">
        <h4>No Purchase History</h4>
        <p>This customer hasn't made any purchases yet.</p>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Create First Sale</a>
    </div>
</div>
@endif
@endsection
