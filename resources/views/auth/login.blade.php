<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Inventory Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">
    <div class="min-h-screen bg-white flex w-full">
        <!-- Left Side: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-32 py-12">
            <div class="max-w-md w-full mx-auto">
                <!-- Logo -->
                <div class="mb-10">
                    <img src="{{ asset('assets/images/wikrama-logo.png') }}" alt="Logo" class="h-12 w-auto" onerror="this.src='https://placehold.co/100x40?text=Logo'">
                </div>

                <!-- Titles -->
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Login</h2>
                <p class="text-sm text-gray-500 mb-8">See your growth and get support!</p>

                <!-- Alert Success -->
                @if (session('success'))
                    <div class="mb-6 py-3 px-4 rounded bg-green-100 text-green-800 border border-green-300">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Alert Errors -->
                @if ($errors->any())
                    <div class="mb-6 py-3 px-4 rounded bg-red-200 text-red-800 border border-red-300">
                        <ul class="list-disc pl-5 text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email"
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Enter your email">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input id="password" type="password" name="password" 
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="minimum 8 characters">
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600 font-medium">Remember me</span>
                        </label>

                        <a href="#" class="text-sm font-medium text-gray-600 hover:text-black transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <p class="mt-8 text-sm text-gray-600 font-medium">
                    Not registered yet? 
                    <a href="#" class="font-bold text-black hover:underline transition-all">Create a new account</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="hidden lg:flex lg:w-1/2 bg-slate-50 items-center justify-center p-12">
            <div class="max-w-2xl w-full flex justify-center">
                <!-- Replace this src with your provided illustration -->
                <img src="{{ asset('assets/images/login-illustration.svg') }}" alt="Analytics Illustration" class="w-full h-auto object-contain" onerror="this.src='https://placehold.co/800x600?text=Your+Login+Illustration+Here'">
            </div>
        </div>
    </div>
</body>
</html>
