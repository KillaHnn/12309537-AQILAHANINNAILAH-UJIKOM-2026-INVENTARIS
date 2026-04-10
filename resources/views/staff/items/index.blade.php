<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items - Inventory App</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

    <!-- Sidebar Partial -->
    @include('partials.sidebar')

    <!-- Main Wrapper Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Top Header -->
        <header class="w-full flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100">
            <div class="flex items-center space-x-4">
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
            <div>
                <p class="font-bold text-black tracking-tight">{{ now()->format('j F Y') }}</p>
            </div>
        </header>

        <!-- Secondary Bar -->
        <div class="w-full px-6 py-4 bg-white">
            <div class="w-full bg-[#f8f9fa] shadow-sm border border-gray-100 flex items-center justify-between px-6 py-3" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);">
                <div class="text-black font-semibold tracking-tight text-[1.05rem]">Dashboard > Items Data > Items</div>
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
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            <div class="w-full min-h-[400px] border border-gray-100 bg-[#fbfcfc] p-6 shadow-sm">
                
                <!-- Header Tabel: Judul (Tampilan Saja untuk Staff) -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Items Table</h3>
                        <p class="text-sm text-gray-500 mt-1">Check availability of <span class="text-[#486096] font-semibold">.items</span></p>
                    </div>
                </div>

                <!-- Tabel Items -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 w-16">#</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Category</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Name</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Total</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Repair</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Lending</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $index => $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $item->category->name }}</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">{{ $item->name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ $item->total }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ $item->repair }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ $item->lending }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ ($item->total - $item->repair) > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ($item->total - $item->repair) > 0 ? 'AVAILABLE' : 'OUT' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-sm text-gray-400">Belum ada data barang.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
