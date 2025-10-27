@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Sales Transactions</h2>
    <div>
        <a href="{{ route('dashboard') }}" class="btn btn-dark me-2">⬅ Back to Dashboard</a>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary me-2">View Customers</a>
        <a href="{{ route('products.index') }}" class="btn btn-info me-2">Manage Inventory</a>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">+ Add Sale Transaction</a>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Transaction ID</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date & Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td><strong>{{ $sale->transaction_id }}</strong></td>
                <td>
                    {{ $sale->product_name }}
                    @if($sale->product)
                        <br><small class="text-muted">{{ $sale->product->product_code }}</small>
                    @endif
                </td>
                <td>{{ $sale->customer->full_name }}</td>
                <td>₱{{ number_format($sale->amount, 2) }}</td>
                <td>{{ $sale->quantity }}</td>
                <td><strong>₱{{ number_format($sale->total_amount, 2) }}</strong></td>
                <td>
                    <span class="badge badge-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($sale->status) }}
                    </span>
                </td>
                <td>{{ $sale->sale_date->format('M d, Y') }} at {{ $sale->sale_time }}</td>
                <td>
                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this sale transaction?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($sales->isEmpty())
<div class="text-center py-5">
    <h4>No sales transactions found</h4>
    <p>Start by creating your first sale transaction.</p>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sale Transaction</a>
</div>
@endif
@endsection
