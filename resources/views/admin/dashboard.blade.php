<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Inventory App</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

    @include('partials.sidebar')

    <!-- Main Wrapper Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Top Header -->
        <header class="w-full flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100">
            <!-- Kiri: Hamburger, Logo, Text -->
            <div class="flex items-center space-x-4">
                <!-- Hamburger Icon -->
                <button @click="sidebarOpen = !sidebarOpen" class="text-black focus:outline-none hover:text-gray-600 transition-colors">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <div class="flex items-center space-x-3 ml-2">
                    <img src="{{ asset('assets/images/wikrama-logo.png') }}" class="h-9 w-9 bg-blue-50 rounded-full" onerror="this.src='https://placehold.co/40x40?text=W'">
                    <h1 class="text-[1.1rem] font-bold text-black tracking-tight">Welcome back, {{ auth()->user()->name }}</h1>
                </div>
            </div>
            
            <!-- Kanan: Date -->
            <div>
                <p class="font-bold text-black tracking-tight">{{ now()->format('j F Y') }}</p>
            </div>
        </header>

        <!-- Secondary Bar / Breadcrumb / Control Bar -->
        <div class="w-full px-6 py-4 bg-white">
            <div class="w-full bg-[#f8f9fa] shadow-sm border border-gray-100 flex items-center justify-between px-6 py-3" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);">
                
                <!-- Kiri: Area Title -->
                <div class="text-black font-semibold tracking-tight text-[1.05rem]">
                    Admin Dashboard Area
                </div>
                
                <!-- Kanan: dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 focus:outline-none hover:opacity-80 transition-opacity p-1">
                        <!-- User Avatar Circle -->
                        <div class="bg-[#486096] text-white h-8 w-8 rounded-full flex items-center justify-center shadow-sm border border-blue-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="font-bold text-black tracking-tight">{{ auth()->user()->name }}</span>
                        <!-- Custom dark smaller chevron down -->
                        <svg class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown body -->
                    <div x-show="open" 
                         x-transition
                         class="absolute right-0 mt-3 w-48 bg-white shadow-lg border border-gray-100 z-50 py-1"
                         style="display: none;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center">
                                <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            <div class="w-full h-full min-h-[400px] border border-gray-100  bg-[#fbfcfc] p-6 shadow-sm">
                <!-- Content here -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Total Categories -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Categories</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format(App\Models\Category::count()) }}</p>
                    </div>

                    <!-- Total Items -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Items</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format(App\Models\Item::sum('total')) }}</p>
                    </div>

                    <!-- Total Users -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format(App\Models\User::count()) }}</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('admin.categories.index') }}" class="group flex items-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all border-2 border-gray-200 hover:border-blue-300 hover:shadow-md">
                            <div class="p-3 bg-white rounded-lg shadow-sm mr-5 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7 text-gray-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Manage Categories</h4>
                                <p class="text-gray-600 text-sm">View, add, edit categories</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.items.index') }}" class="group flex items-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all border-2 border-gray-200 hover:border-emerald-300 hover:shadow-md">
                            <div class="p-3 bg-white rounded-lg shadow-sm mr-5 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7 text-gray-600 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Manage Items</h4>
                                <p class="text-gray-600 text-sm">View, add, update items inventory</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.admin') }}" class="group flex items-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all border-2 border-gray-200 hover:border-indigo-300 hover:shadow-md">
                            <div class="p-3 bg-white rounded-lg shadow-sm mr-5 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7 text-gray-600 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Manage Users</h4>
                                <p class="text-gray-600 text-sm">View admins & staff accounts</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
