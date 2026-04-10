<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lending - Inventory App</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-white flex h-screen overflow-hidden" 
      x-data="{ 
        sidebarOpen: true, 
        showAddModal: {{ $errors->any() ? 'true' : 'false' }},
        itemsList: [{ item_id: '', total: 1 }]
      }">

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
                <div class="text-black font-semibold tracking-tight text-[1.05rem]">Dashboard > Items Data > Lending</div>
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
                
                <!-- Header Tabel: Judul + Tombol -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Lending Table</h3>
                        <p class="text-sm text-gray-500 mt-1">Data of <span class="text-[#486096] font-semibold">.lendings</span></p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <!-- Tombol Export Excel -->
                        <a href="{{ route('staff.lending.export') }}" class="inline-flex items-center px-4 py-2.5 bg-[#486096] hover:bg-[#3a5080] text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export Excel
                        </a>
                        <!-- Tombol Add Lending -->
                        <button @click="showAddModal = true" class="inline-flex items-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Add
                        </button>
                    </div>
                </div>

                <!-- Alert Success -->
                @if (session('success'))
                    @if (str_contains(strtolower(session('success')), 'deleted'))
                        <div class="mb-4 py-3 px-4 rounded bg-orange-100 text-orange-800 border border-orange-200">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    @else
                        <div class="mb-4 py-3 px-4 rounded bg-green-100 text-green-800 border border-green-300">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    @endif
                @endif

                <!-- Alert Error (Stok) -->
                @if (session('error'))
                    <div class="mb-4 py-3 px-4 rounded bg-red-100 text-red-800 border border-red-300">
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Tabel Peminjaman -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 w-16 text-center">#</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Item</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Total</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Name</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Ket.</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Date</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Returned</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center italic">Edited By</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lendings as $index => $lending)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-sm text-gray-800">{{ $lending->item->name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ $lending->total }}</td>
                                <td class="py-4 px-4 text-sm text-gray-800 font-medium">{{ $lending->name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ $lending->notes ?? '-' }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 text-center">{{ \Carbon\Carbon::parse($lending->lending_date)->format('d F, Y') }}</td>
                                <td class="py-4 px-4 text-sm text-center">
                                    @if($lending->is_returned)
                                        <div class="px-3 py-1 text-[11px] font-bold border border-emerald-200 bg-emerald-50 text-emerald-500 rounded-md inline-block">
                                            {{ \Carbon\Carbon::parse($lending->return_date)->format('d F, Y') }}
                                        </div>
                                    @else
                                        <span class="px-3 py-1 text-[10px] font-bold border border-orange-200 bg-orange-50 text-orange-400 rounded-md">
                                            not returned
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-sm text-center font-bold text-gray-900 leading-tight">
                                    <span class="block">operator</span>
                                    <span class="block">{{ strtolower(explode(' ', $lending->user->name)[0]) }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @if(!$lending->is_returned)
                                            <form method="POST" action="{{ route('staff.lending.return', $lending) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-orange-400 hover:bg-orange-500 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                                                    Returned
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('staff.lending.destroy', $lending) }}" onsubmit="return confirm('Hapus data peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="py-12 text-center text-sm text-gray-400 italic">Belum ada data peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Add Lending -->
    <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 overflow-y-auto pt-10 pb-10" style="display: none;">
        <div @click.away="showAddModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 flex flex-col max-h-full">
            <div class="p-8 overflow-y-auto">
                <h3 class="text-lg font-bold text-gray-800">Lending Form</h3>
                <p class="text-sm text-gray-500 mt-1 mb-6">Please <span class="text-red-500 font-semibold">.fill-all</span> input form with right value.</p>
                
                <form method="POST" action="{{ route('staff.lending.store') }}">
                    @csrf
                    <!-- Borrower Name -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-[#486096] focus:border-[#486096] transition-colors"
                            placeholder="Name">
                    </div>

                    <!-- Dynamic Item List -->
                    <template x-for="(item, index) in itemsList" :key="index">
                        <div class="mb-8 p-4 bg-white border border-gray-200 rounded-xl relative">
                            <!-- Remove Button -->
                            <button type="button" @click="itemsList.splice(index, 1)" x-show="itemsList.length > 1"
                                class="absolute top-2 right-2 text-white bg-red-500 p-1 rounded-sm hover:bg-red-600 transition-colors">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>

                            <!-- Item Selection -->
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Items</label>
                                <select :name="'item_id['+index+']'" required
                                    class="w-full px-4 py-3 bg-white border border-gray-100 rounded-lg text-sm appearance-none focus:ring-2 focus:ring-[#486096] focus:border-[#486096] transition-colors">
                                    <option value="" disabled selected>Select Items</option>
                                    @foreach ($items as $itm)
                                        <option value="{{ $itm->id }}">{{ $itm->name }} (Available: {{ $itm->total - $itm->repair }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Total</label>
                                <input type="number" :name="'total['+index+']'" required x-model="item.total" min="1"
                                    class="w-full px-4 py-3 bg-white border border-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-[#486096] focus:border-[#486096] transition-colors"
                                    placeholder="total item">
                            </div>
                        </div>
                    </template>

                    <!-- More Link -->
                    <div class="mb-8">
                        <button type="button" @click="itemsList.push({ item_id: '', total: 1 })" 
                            class="flex items-center text-sm font-semibold text-cyan-400 hover:text-cyan-500 transition-colors">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            More
                        </button>
                    </div>

                    <!-- Notes (Ket.) -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ket.</label>
                        <textarea name="notes" rows="4"
                            class="w-full px-4 py-3 bg-white border border-gray-100 rounded-lg text-sm focus:ring-2 focus:ring-[#486096] focus:border-[#486096] transition-colors"
                            placeholder=""></textarea>
                    </div>

                    <!-- Hidden Date (use current) -->
                    <input type="hidden" name="lending_date" value="{{ now()->format('Y-m-d H:i:s') }}">

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button type="submit" class="px-8 py-2.5 text-sm font-semibold text-white bg-[#6c58be] hover:bg-[#5a48a0] rounded-lg transition-colors shadow-sm">Submit</button>
                        <button type="button" @click="showAddModal = false" class="px-8 py-2.5 text-sm font-semibold text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-100">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
