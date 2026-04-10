<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories - Inventory App</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased text-gray-900 bg-white flex h-screen overflow-hidden" x-data="{ sidebarOpen: true, showAddModal: {{ $errors->any() ? 'true' : 'false' }}, showEditModal: false, editCategory: {} }">

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
                <div class="text-black font-semibold tracking-tight text-[1.05rem]">
                    Check menu in sidebar
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 focus:outline-none hover:opacity-80 transition-opacity p-1">
                        <div class="bg-[#486096] text-white h-8 w-8 rounded-full flex items-center justify-center shadow-sm border border-blue-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="font-bold text-black tracking-tight">{{ auth()->user()->name }}</span>
                        <svg class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="absolute right-0 mt-3 w-48 bg-white shadow-lg border border-gray-100 z-50 py-1" style="display: none;">
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
            <div class="w-full min-h-[400px] border border-gray-100 bg-[#fbfcfc] p-6 shadow-sm">

                <!-- Header Tabel: Judul + Tombol Add -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Categories Table</h3>
                        <p class="text-sm text-gray-500 mt-1">Add, delete, update <span class="text-[#486096] font-semibold">.categories</span></p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <!-- Tombol Export Excel -->
                        <a href="{{ route('admin.categories.export') }}" class="inline-flex items-center px-4 py-2.5 bg-[#486096] hover:bg-[#3a5080] text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export Excel
                        </a>
                        <!-- Tombol Add Category -->
                        <button @click="showAddModal = true" class="inline-flex items-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add
                    </button>
                    </div>
                    <!-- Tombol Add Category -->
                    
                </div>

                <!-- Alert Sukses -->
                @if (session('success'))
                <div class="mb-4 py-3 px-4 rounded bg-green-100 text-green-800 border border-green-300">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                @endif

                <!-- Tabel Kategori -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 w-16">#</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Name</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Division PJ</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600">Total Item</th>
                                <th class="py-4 px-4 text-sm font-semibold text-gray-600 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $index => $category)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $category->division_pj }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $category->items_count ?? 0 }}</td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Tombol Edit -->
                                        <button @click="editCategory = { id: {{ $category->id }}, name: '{{ $category->name }}', division_pj: '{{ $category->division_pj }}' }; showEditModal = true"
                                            class="inline-flex items-center px-4 py-1.5 bg-[#486096] hover:bg-[#3a5080] text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                                            Edit
                                        </button>
                                        <!-- Tombol Delete -->
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                                <td colspan="5" class="py-8 text-center text-sm text-gray-400">Belum ada data kategori.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal: Tambah Kategori Baru -->
    <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" style="display: none;">
        <div @click.away="showAddModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg p-8 mx-4">
            <!-- Header Modal -->
            <h3 class="text-lg font-bold text-gray-800">Add Category Forms</h3>
            <p class="text-sm text-gray-500 mt-1 mb-6">Please <span class="text-red-500 font-semibold">.fill-all</span> input form with right value.</p>

            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <!-- Input Nama Kategori -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-white border rounded-lg text-sm focus:ring-2 focus:ring-[#486096] focus:border-[#486096] transition-colors
                        {{ $errors->has('name') ? 'border-red-400' : 'border-gray-200' }}"
                        placeholder="Alat Dapur">
                    <!-- Pesan error validasi inline -->
                    @error('name')
                    <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Select Divisi PJ (Dropdown) -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Division PJ</label>
                    <div class="relative">
                        <!-- Ikon kecil di kiri select -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <select name="division_pj"
                            class="w-full pl-10 pr-4 py-3 bg-white border rounded-lg text-sm appearance-none focus:ring-2 focus:ring-[#486096] focus:border-[#486096] transition-colors
                            {{ $errors->has('division_pj') ? 'border-red-400' : 'border-gray-200' }}">
                            <option value="" disabled {{ old('division_pj') ? '' : 'selected' }}>Select Division PJ</option>
                            <option value="Sarpras" {{ old('division_pj') == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                            <option value="Tata Usaha" {{ old('division_pj') == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                            <option value="Tefa" {{ old('division_pj') == 'Tefa' ? 'selected' : '' }}>Tefa</option>
                        </select>
                        <!-- Ikon panah kanan -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <!-- Pesan error validasi inline -->
                    @error('division_pj')
                    <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="showAddModal = false" class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-[#486096] hover:bg-[#3a5080] rounded-lg transition-colors shadow-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Kategori -->
    <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" style="display: none;">
        <div @click.away="showEditModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-lg p-8 mx-4">
            <h3 class="text-lg font-bold text-gray-800">Edit Category Forms</h3>
            <p class="text-sm text-gray-500 mt-1 mb-6">Please <span class="text-red-500 font-semibold">.fill-all</span> input form with right value.</p>

            <form method="POST" :action="'/admin/categories/' + editCategory.id">
                @csrf
                @method('PUT')
                <!-- Input Nama Kategori -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" x-model="editCategory.name"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#486096] focus:border-[#486096]">
                </div>

                <!-- Select Divisi PJ (Dropdown) -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Division PJ</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <select name="division_pj" x-model="editCategory.division_pj"
                            class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm appearance-none focus:ring-2 focus:ring-[#486096] focus:border-[#486096]">
                            <option value="" disabled>Select Division PJ</option>
                            <option value="Sarpras">Sarpras</option>
                            <option value="Tata Usaha">Tata Usaha</option>
                            <option value="Tefa">Tefa</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="showEditModal = false" class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-[#486096] hover:bg-[#3a5080] rounded-lg transition-colors shadow-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>