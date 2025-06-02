@csrf

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Name</label>
    <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" class="w-full p-2 border rounded" required>
</div>

<div class="mb-4">
    <label class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Email</label>
    <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" class="w-full p-2 border rounded" required>
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    <a href="{{ route('products.index') }}" class="px-4 py-2 text-m text-gray-800  text-gray-200 leading-tight">Cancel</a>
</div>