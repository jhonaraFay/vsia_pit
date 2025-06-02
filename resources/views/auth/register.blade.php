<x-guest-layout>
    <div class="max-w-md mx-auto bg-white  bg-gray-800 p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-900  text-gray-100">Create Your Account</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="block mb-1 text-gray-700  text-gray-300" />
                <x-text-input id="name" class="block w-full rounded-md border border-gray-300  border-gray-600
                    focus:ring-indigo-500 focus:border-indigo-500  bg-gray-700  text-gray-100" 
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block mb-1 text-gray-700  text-gray-300" />
                <x-text-input id="email" class="block w-full rounded-md border border-gray-300  border-gray-600
                    focus:ring-indigo-500 focus:border-indigo-500  bg-gray-700  text-gray-100" 
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block mb-1 text-gray-700  text-gray-300" />
                <x-text-input id="password" class="block w-full rounded-md border border-gray-300  border-gray-600
                    focus:ring-indigo-500 focus:border-indigo-500  bg-gray-700  text-gray-100" 
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block mb-1 text-gray-700  text-gray-300" />
                <x-text-input id="password_confirmation" class="block w-full rounded-md border border-gray-300  border-gray-600
                    focus:ring-indigo-500 focus:border-indigo-500  bg-gray-700  text-gray-100" 
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600" />
            </div>

            <div>
                <x-primary-button class="w-full py-3 text-lg font-semibold">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-6 text-center text-gray-600  text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                Log in here
            </a>
        </p>
    </div>
</x-guest-layout>
