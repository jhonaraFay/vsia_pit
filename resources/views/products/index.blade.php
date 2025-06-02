<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">📦 Products</h2>
                <p class="text-sm text-gray-500">Manage your product catalog here.</p>
            </div>
            <a href="{{ route('products.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow">
                ➕ Add Product
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search products..."
                           class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                        🔍 Search
                    </button>
                </form>

                <a href="{{ route('products.exportPdf', [
                    'search' => request('search'),
                    'sort' => request('sort'),
                    'direction' => request('direction')
                ]) }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    Export all as PDF
                </a>
            </div>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        @php
                            $columns = ['name' => 'Product Name', 'description' => 'Details', 'price' => 'Price', 'stock' => 'Stock'];
                        @endphp
                        @foreach ($columns as $field => $label)
                            <th class="px-6 py-3 font-medium tracking-wide">
                                <a href="{{ route('products.index', [
                                    'search' => request('search'),
                                    'sort' => $field,
                                    'direction' => (request('sort') === $field && request('direction') === 'asc') ? 'desc' : 'asc'
                                ]) }}" class="flex items-center gap-1">
                                    {{ $label }}
                                    @if(request('sort') === $field)
                                        <span>{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                        @endforeach
                        <th class="px-6 py-3 font-medium tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $product->description }}</td>
                            <td class="px-6 py-4 font-medium text-blue-700">₱{{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4">{{ $product->stock }}</td>
                            <td class="px-6 py-4 flex flex-wrap gap-2">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-black text-sm px-3 py-1 rounded shadow">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Delete this product?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded shadow">
                                        🗑️ Delete
                                    </button>
                                </form>
                                <a href="{{ route('products.pdf', $product->id) }}" target="_blank"
                                   class="bg-green-500 hover:bg-green-600 text-black text-sm px-3 py-1 rounded shadow">
                                    📥 PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
