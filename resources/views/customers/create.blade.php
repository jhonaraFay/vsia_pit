<x-app-layout>
<div class="max-w-xl mx-auto py-6">
<h2 class="font-semibold text-xl text-gray-800  text-gray-200 leading-tight">Add Customer</h2>
        <form method="POST" action="{{ route('customers.store') }}">
            @csrf
            @include('customers.form')            
        </form>
    </div>
</x-app-layout>
