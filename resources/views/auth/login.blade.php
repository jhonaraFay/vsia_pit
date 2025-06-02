<x-guest-layout>
    <div class="max-w-md mx-auto bg-white  bg-gray-800 p-8 rounded-lg shadow-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h1 class="text-3xl font-bold mb-6 text-center text-gray-900  text-gray-100">
            Welcome Back
        </h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block mb-1 text-gray-700  text-gray-300" />
                <x-text-input id="email" class="block w-full rounded-md border border-gray-300  border-gray-600
                    focus:ring-indigo-500 focus:border-indigo-500  bg-gray-700  text-gray-100"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block mb-1 text-gray-700  text-gray-300" />
                <x-text-input id="password" class="block w-full rounded-md border border-gray-300  border-gray-600
                    focus:ring-indigo-500 focus:border-indigo-500  bg-gray-700  text-gray-100"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="rounded  bg-gray-900 border-gray-300  border-gray-700
                    text-indigo-600 shadow-sm focus:ring-indigo-500  focus:ring-indigo-600  focus:ring-offset-gray-800"
                    name="remember">
                <label for="remember_me" class="ms-2 text-sm text-gray-600  text-gray-400 select-none">
                    {{ __('Remember me') }}
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600  text-gray-400 hover:text-gray-900  hover:text-gray-100
                        rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3 px-6 py-2 text-lg font-semibold">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-6 text-center text-gray-600  text-gray-400">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                Register here
            </a>
        </p>
    </div>
</x-guest-layout>
