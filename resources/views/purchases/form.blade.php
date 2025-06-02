<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Customer</label>
    <select name="customers_id" class="w-full p-2 border rounded" required>
        <option value="">Select Customer</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}"
                {{ old('customers_id', $purchase->customers_id ?? '') == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Product</label>
    <select name="products_id" id="product-select" class="w-full p-2 border rounded" required>
        <option value="">Select Product</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}"
                data-stock="{{ $product->stock }}"
                {{ old('products_id', $purchase->products_id ?? '') == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Quantity</label>
    <input type="number" name="quantity" id="quantity-input"
           value="{{ old('quantity', $purchase->quantity ?? '') }}"
           min="1"
           class="w-full p-2 border rounded"
           required>
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    <a href="{{ route('products.index') }}" class="px-4 py-2 text-m text-gray-800  text-gray-200 leading-tight">Cancel</a>
</div>

{{-- JavaScript to dynamically update max quantity --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productSelect = document.getElementById('product-select');
        const quantityInput = document.getElementById('quantity-input');

        function updateMaxStock() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            quantityInput.max = stock || 1;
        }

        productSelect.addEventListener('change', updateMaxStock);
        updateMaxStock(); // Call on initial load to set default value
    });
</script>
