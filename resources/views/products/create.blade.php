<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        <h2 class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Add Product</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @include('products.form')
        </form>
    </div>
</x-app-layout>
