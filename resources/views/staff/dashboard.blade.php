<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Dashboard - Inventory App</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

    <!-- Sidebar Partial -->
    @include('partials.sidebar')

    <!-- Main Wrapper Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Top Header (Same as Admin) -->
        <header class="w-full flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-black focus:outline-none hover:text-gray-600 transition-colors">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center space-x-3 ml-2">
                    <img src="{{ asset('assets/images/wikrama-logo.png') }}" class="h-9 w-9 bg-blue-50 rounded-full" onerror="this.src='https://placehold.co/40x40?text=W'">
                    <h1 class="text-[1.1rem] font-bold text-black tracking-tight">Staff Dashboard, Welcome back {{ auth()->user()->name }}</h1>
                </div>
            </div>
            <div>
                <p class="font-bold text-black tracking-tight">{{ now()->format('j F Y') }}</p>
            </div>
        </header>

        <!-- Secondary Bar -->
        <div class="w-full px-6 py-4 bg-white">
            <div class="w-full bg-[#f8f9fa] shadow-sm border border-gray-100 flex items-center justify-between px-6 py-3" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);">
                <div class="text-black font-semibold tracking-tight text-[1.05rem]">Dashboard Staff </div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 focus:outline-none hover:opacity-80 transition-opacity p-1">
                        <div class="bg-[#486096] text-white h-8 w-8 rounded-full flex items-center justify-center shadow-sm border border-blue-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <span class="font-bold text-black tracking-tight">{{ auth()->user()->name }}</span>
                        <svg class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-3 w-48 bg-white shadow-lg border border-gray-100 z-50 py-1" style="display: none;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center">
                                <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-white p-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Stats Card 1 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Items</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Item::count() }}</p>
                    </div>

                    <!-- Stats Card 2 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium">Active Lendings</h3>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Lending::whereNull('return_date')->count() }}</p>
                    </div>
                </div>

                <!-- Recent Activity Placeholder -->
                <div class="mt-8 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('staff.items.index') }}" class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="p-2 bg-white rounded-lg shadow-sm mr-4">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <span class="font-medium text-gray-700">Check Items Availability</span>
                        </a>
                        <a href="{{ route('staff.lending.index') }}" class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="p-2 bg-white rounded-lg shadow-sm mr-4">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0l3 3m-3-3l-3 3m5 8h-4a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="font-medium text-gray-700">Start New Lending</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
