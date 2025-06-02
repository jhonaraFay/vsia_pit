<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Purchase</h2>
        <form method="POST" action="{{ route('purchases.update', $purchase) }}">
            @csrf
            @method('PUT')
            @include('purchases.form')
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Update</button>
        </form>
    </div>
</x-app-layout>
