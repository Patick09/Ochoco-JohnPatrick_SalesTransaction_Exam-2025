@extends('layout')

@section('content')
<h1 class="text-center">Transaction Processing System (TPS) Dashboard</h1>

<div class="flex-row">
    <a href="{{ route('sales.index') }}" class="btn btn-blue btn-lg">Manage Sales</a>
    <a href="{{ route('customers.index') }}" class="btn btn-blue btn-lg">Manage Customers</a>
    <a href="{{ route('products.index') }}" class="btn btn-blue btn-lg">Manage Inventory</a>
</div>

<div class="flex-row" style="margin-top:20px;">
    <div class="stats-card">
        <h2>Total Sales</h2>
        <h1>{{ $totalSales }}</h1>
    </div>
    <div class="stats-card">
        <h2>Total Customers</h2>
        <h1>{{ $totalCustomers }}</h1>
    </div>
    <div class="stats-card">
        <h2>Total Revenue</h2>
        <h1>₱{{ number_format($totalRevenue, 2) }}</h1>
    </div>
    <div class="stats-card">
        <h2>Pending Sales</h2>
        <h1>{{ $pendingSales }}</h1>
    </div>
</div>

<div class="flex-row" style="margin-top:20px;">
    <div class="stats-card">
        <h2>Total Products</h2>
        <h1>{{ $totalProducts }}</h1>
    </div>
    <div class="stats-card">
        <h2>Active Products</h2>
        <h1>{{ $activeProducts }}</h1>
    </div>
    <div class="stats-card">
        <h2>Low Stock</h2>
        <h1 class="text-warning">{{ $lowStockProducts }}</h1>
    </div>
    <div class="stats-card">
        <h2>Out of Stock</h2>
        <h1 class="text-danger">{{ $outOfStockProducts }}</h1>
    </div>
</div>

@if($latestSale)
<div class="stats-card" style="margin-top:20px;">
    <h2>💰 Latest Sale Transaction</h2>
    <p><strong>Transaction ID:</strong> {{ $latestSale->transaction_id }}</p>
    <p><strong>Product:</strong> {{ $latestSale->product_name }}</p>
    <p><strong>Customer:</strong> {{ $latestSale->customer->full_name }}</p>
    <p><strong>Amount:</strong> ₱{{ number_format($latestSale->total_amount, 2) }}</p>
    <p><strong>Status:</strong> <span class="badge badge-{{ $latestSale->status == 'completed' ? 'success' : ($latestSale->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($latestSale->status) }}</span></p>
</div>
@endif

@if($recentSales->count() > 0)
<div class="stats-card" style="margin-top:20px;">
    <h2>📊 Recent Sales Transactions</h2>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSales as $sale)
                <tr>
                    <td>{{ $sale->transaction_id }}</td>
                    <td>{{ $sale->product_name }}</td>
                    <td>{{ $sale->customer->full_name }}</td>
                    <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                    <td><span class="badge badge-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($sale->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if(isset($availableProducts) && $availableProducts->count() > 0)
<div class="stats-card" style="margin-top:20px;">
    <h2>🛍️ Available Products</h2>
    <p class="text-muted">Choose from our inventory to create a new sale</p>
    <div class="row">
        @foreach($availableProducts as $product)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
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
                    <div class="d-grid">
                        <a href="{{ route('sales.create') }}?product_id={{ $product->id }}" class="btn btn-primary btn-sm">
                            Select for Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">View All Products</a>
    </div>
</div>
@endif
@endsection
