<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        <h2 class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Edit Product</h2>
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            @include('products.form')
        </form>
    </div>
</x-app-layout>
