@csrf

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Name</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full p-2 border rounded" required>
</div>

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Description</label>
    <textarea name="description" class="w-full p-2 border rounded" required>{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Price</label>
    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full p-2 border rounded" required>
</div>

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Stock</label>
    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" class="w-full p-2 border rounded" required>
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    <a href="{{ route('products.index') }}" class="px-4 py-2 text-m text-gray-800  text-gray-200 leading-tight">Cancel</a>
</div>
