@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Customers</h2>
    <div>
        <a href="{{ route('dashboard') }}" class="btn btn-dark me-2">⬅ Back to Dashboard</a>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary me-2">View Sales</a>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Add Customer</a>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Customer Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Total Sales</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td><strong>{{ $customer->customer_code }}</strong></td>
                <td>{{ $customer->full_name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone ?? 'N/A' }}</td>
                <td>
                    <span class="badge badge-{{ $customer->status == 'active' ? 'success' : 'danger' }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </td>
                <td>{{ $customer->sales_count }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this customer?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($customers->isEmpty())
<div class="text-center py-5">
    <h4>No customers found</h4>
    <p>Start by creating your first customer.</p>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">Create Customer</a>
</div>
@endif
@endsection
