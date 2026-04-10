<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing - Inventory Manager</title>

    <!-- Fonts -->  
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <!-- Header -->
    <header class="w-full py-4 px-6 sm:px-10 flex justify-between items-center bg-white shadow-sm border-b border-gray-100">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <!-- Placeholder Logo Image -->
            <img src="{{ asset('assets/images/wikrama-logo.png') }}" alt="Logo" class="h-10 w-auto object-contain" onerror="this.src='https://placehold.co/100x40?text=Logo'">
            <span class="font-bold text-xl text-gray-800 tracking-tight hidden sm:block">SBM APP</span>
        </div>
        
        <!-- Action / Login Button -->
        <div>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm">
                Login
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="w-full flex-grow flex flex-col items-center pt-24 px-4 bg-gray-50 min-h-[calc(100vh-73px)]">
        
        <!-- Hero Text -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Inventory Manager
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 font-medium">
                Manage all your inventory efficiently
            </p>
        </div>

        <!-- Hero Illustration -->
        <div class="w-full max-w-4xl mx-auto relative flex justify-center items-center mt-4">
            <!-- Replace this src with your provided illustration -->
            <img src="{{ asset('assets/images/landing-illustration.svg') }}" alt="Inventory Management Illustration" class="w-full h-auto object-contain " onerror="this.src='https://placehold.co/800x400?text=Your+Landing+Illustration+Here'">
        </div>
        
    </main>

    <!-- Footer -->
    <footer class="w-full bg-white py-16 px-6 sm:px-10 border-t border-gray-100 mt-auto">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between gap-12 md:gap-8">
            
            <!-- Left Column: Logo & Contact -->
            <div class="flex flex-col items-start">
                <img src="{{ asset('assets/images/wikrama-logo.png') }}" alt="SMK Wikrama Logo" class="h-16 w-auto mb-6 object-contain" onerror="this.src='https://placehold.co/100x100?text=Logo'">
                <div class="text-gray-500 space-y-1 font-medium">
                    <p>smkwikrama@sch.id</p>
                    <p>001-7876-2876</p>
                </div>
            </div>

            <!-- Middle Column: Guidelines -->
            <div class="flex flex-col">
                <h3 class="font-bold text-gray-900 text-lg mb-6">Our Guidelines</h3>
                <ul class="space-y-4 font-medium">
                    <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Terms</a></li>
                    <li><a href="#" class="text-red-500 hover:text-red-600 transition-colors">Privacy policy</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Cookie Policy</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-gray-900 transition-colors">Discover</a></li>
                </ul>
            </div>

            <!-- Right Column: Address & Social -->
            <div class="flex flex-col">
                <h3 class="font-bold text-gray-900 text-lg mb-6">Our address</h3>
                <div class="text-gray-500 space-y-1 font-medium mb-6">
                    <p>Jalan Wangun Tengah</p>
                    <p>Sindangsari</p>
                    <p>Jawa Barat</p>
                </div>
                
                <!-- Social Media Icons -->
                <div class="flex items-center gap-3">
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-400 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-400 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-400 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-400 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
