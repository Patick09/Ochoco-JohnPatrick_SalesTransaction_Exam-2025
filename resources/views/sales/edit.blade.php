@extends('layout')

@section('content')
<h2>Edit Sale Transaction</h2>

<a href="{{ route('dashboard') }}" class="btn btn-dark mb-3">⬅ Back to Dashboard</a>
<a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">View Customers</a>

<form action="{{ route('sales.update', $sale) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Transaction ID</label>
                <input type="text" class="form-control" value="{{ $sale->transaction_id }}" readonly>
                <small class="form-text text-muted">Transaction ID cannot be changed</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Product <span class="text-danger">*</span></label>
                <select name="product_id" id="product_id" class="form-control" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" 
                                data-price="{{ $product->selling_price }}" 
                                data-stock="{{ $product->stock_quantity }}"
                                data-name="{{ $product->name }}"
                                {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ $product->product_code }}) - ₱{{ number_format($product->selling_price, 2) }} - Stock: {{ $product->stock_quantity }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Customer <span class="text-danger">*</span></label>
                <select name="customer_id" class="form-control" required>
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" 
                            {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->full_name }} ({{ $customer->customer_code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $sale->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $sale->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Amount <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" value="{{ $sale->amount }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" name="quantity" class="form-control" min="1" value="{{ $sale->quantity }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Total Amount</label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="text" class="form-control" value="{{ number_format($sale->total_amount, 2) }}" readonly>
                </div>
                <small class="form-text text-muted">Automatically calculated (Amount × Quantity)</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Sale Date <span class="text-danger">*</span></label>
                <input type="date" name="sale_date" class="form-control" value="{{ $sale->sale_date->format('Y-m-d') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Sale Time <span class="text-danger">*</span></label>
                <input type="time" name="sale_time" class="form-control" value="{{ $sale->sale_time->format('H:i') }}" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes about this sale...">{{ $sale->notes }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Update Sale Transaction</button>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
</form>

<script>
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const priceInput = document.querySelector('input[name="amount"]');
    const quantityInput = document.querySelector('input[name="quantity"]');
    const maxStock = selectedOption.getAttribute('data-stock');
    
    if (selectedOption.value) {
        priceInput.value = selectedOption.getAttribute('data-price');
        quantityInput.max = maxStock;
        quantityInput.setAttribute('data-max-stock', maxStock);
    } else {
        priceInput.value = '';
        quantityInput.removeAttribute('max');
        quantityInput.removeAttribute('data-max-stock');
    }
});

document.querySelector('input[name="quantity"]').addEventListener('input', function() {
    const maxStock = this.getAttribute('data-max-stock');
    if (maxStock && parseInt(this.value) > parseInt(maxStock)) {
        this.setCustomValidity('Quantity cannot exceed available stock: ' + maxStock);
    } else {
        this.setCustomValidity('');
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection
