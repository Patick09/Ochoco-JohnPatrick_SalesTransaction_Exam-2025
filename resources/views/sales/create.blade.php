@extends('layout')

@section('content')
<h2>Add Sale Transaction</h2>

<a href="{{ route('dashboard') }}" class="btn btn-dark mb-3">⬅ Back to Dashboard</a>
<a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">View Customers</a>
<a href="{{ route('products.index') }}" class="btn btn-info mb-3">Manage Inventory</a>

<form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Customer <span class="text-danger">*</span></label>
                <select id="customer_id" name="customer_id" class="form-control" required>
                    <option value="">-- Select Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->full_name }} ({{ $customer->customer_code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Product</label>
                <input type="hidden" id="product_id" name="product_id" value="{{ isset($selectedProduct) && $selectedProduct ? $selectedProduct->id : '' }}">
                <div id="selected-product-summary">
                    @if(isset($selectedProduct) && $selectedProduct)
                        <div class="card">
                            <div class="card-body">
                                <strong>{{ $selectedProduct->name }}</strong>
                                <div class="text-muted">{{ $selectedProduct->product_code }}</div>
                                <div>Price: ₱{{ number_format($selectedProduct->selling_price, 2) }}</div>
                                <div>Stock: {{ $selectedProduct->stock_quantity }}</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">Select a customer to see their chosen products.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="customer-products" class="mt-3" style="display:none;"></div>

    <div id="selected-items" class="mt-3" style="display:none;">
        <h5>Selected Items</h5>
        <div id="selected-items-list" class="list-group mb-2"></div>
        <button type="button" class="btn btn-sm btn-outline-danger" id="clear-items">Clear items</button>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Amount <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" name="quantity" class="form-control" min="1" value="1" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Sale Date <span class="text-danger">*</span></label>
                <input type="date" name="sale_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Sale Time <span class="text-danger">*</span></label>
                <input type="time" name="sale_time" class="form-control" value="{{ date('H:i') }}" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes about this sale..."></textarea>
    </div>

    <button type="submit" class="btn btn-success">Create Sale Transaction</button>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
</form>

<script>
function renderCustomerProducts(products) {
    const container = document.getElementById('customer-products');
    container.innerHTML = '';
    if (!products || products.length === 0) {
        container.style.display = 'none';
        return;
    }
    container.style.display = '';
    const row = document.createElement('div');
    row.className = 'row';
    products.forEach(p => {
        const col = document.createElement('div');
        col.className = 'col-md-4 mb-3';
        col.innerHTML = `
            <div class="card h-100 border-primary">
                <div class="card-body">
                    <h6 class="card-title">${p.name}</h6>
                    <p class="card-text">
                        <small class="text-muted">${p.product_code}</small><br>
                        <strong>Price:</strong> ₱${Number(p.selling_price).toFixed(2)}<br>
                        <strong>Stock:</strong> ${p.stock_quantity}
                    </p>
                    <button type="button" class="btn btn-sm btn-primary" data-product='${JSON.stringify(p)}'>Use this product</button>
                </div>
            </div>`;
        row.appendChild(col);
    });
    container.appendChild(row);

    // Attach click handlers
    container.querySelectorAll('button[data-product]').forEach(btn => {
        btn.addEventListener('click', () => {
            const p = JSON.parse(btn.getAttribute('data-product'));
            addItem(p);
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const customerSelect = document.getElementById('customer_id');
        const selectedItemsWrap = document.getElementById('selected-items');
        const selectedItemsList = document.getElementById('selected-items-list');
        const clearBtn = document.getElementById('clear-items');

        const items = [];

        function renderSelectedItems() {
            selectedItemsList.innerHTML = '';
            if (items.length === 0) {
                selectedItemsWrap.style.display = 'none';
                return;
            }
            selectedItemsWrap.style.display = '';
            items.forEach((it, idx) => {
                const li = document.createElement('div');
                li.className = 'list-group-item';
                li.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${it.name}</strong>
                            <div class="text-muted">${it.product_code}</div>
                            <div>Price: ₱${Number(it.selling_price).toFixed(2)} | Qty: ${it.quantity}</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-idx="${idx}">Remove</button>
                    </div>
                    <input type="hidden" name="items[${idx}][product_id]" value="${it.id}">
                    <input type="hidden" name="items[${idx}][amount]" value="${Number(it.selling_price)}">
                    <input type="hidden" name="items[${idx}][quantity]" value="${it.quantity}">
                `;
                selectedItemsList.appendChild(li);
            });
            // Remove handlers
            selectedItemsList.querySelectorAll('button[data-idx]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const i = parseInt(btn.getAttribute('data-idx'));
                    items.splice(i, 1);
                    renderSelectedItems();
                });
            });
        }

        window.addItem = function(p) {
            // Ask for quantity (simple prompt for now)
            const maxQty = parseInt(p.stock_quantity || 0);
            let qty = 1;
            if (maxQty > 0) {
                const entered = prompt(`Enter quantity for ${p.name} (max ${maxQty})`, '1');
                if (entered === null) return; // cancelled
                qty = Math.max(1, Math.min(maxQty, parseInt(entered || '1')));
            }
            items.push({ ...p, quantity: qty });
            renderSelectedItems();
        }

        clearBtn.addEventListener('click', function() {
            items.splice(0, items.length);
            renderSelectedItems();
        });
    function loadProductsForCustomer(customerId) {
        if (!customerId) {
            renderCustomerProducts([]);
            return;
        }
        const url = `${window.location.origin}/sales/customer-products/${customerId}`;
        fetch(url, { headers: { 'Accept': 'application/json' }})
            .then(r => r.json())
            .then(data => renderCustomerProducts(data.products || []))
            .catch(() => renderCustomerProducts([]));
    }

    customerSelect.addEventListener('change', e => loadProductsForCustomer(e.target.value));

    // Initial: if a customer is preselected (from redirect), load their products
    if (customerSelect.value) {
        loadProductsForCustomer(customerSelect.value);
    }

    // Quantity guard
    const qty = document.querySelector('input[name="quantity"]');
    qty.addEventListener('input', function() {
        const maxStock = this.getAttribute('data-max-stock');
        if (maxStock && parseInt(this.value) > parseInt(maxStock)) {
            this.setCustomValidity('Quantity cannot exceed available stock: ' + maxStock);
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endsection
