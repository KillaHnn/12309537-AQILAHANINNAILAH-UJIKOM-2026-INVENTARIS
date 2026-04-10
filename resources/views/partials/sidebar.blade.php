<!-- Sidebar component dengan Alpine.js untuk toggle dan dropdown -->
<aside class="bg-[#486096] text-white flex flex-col h-full shadow-lg z-20 flex-shrink-0 transition-all duration-300"
       :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'">
    <div class="px-6 py-6 h-16 flex items-center justify-between min-w-[16rem]">
        <span class="font-bold text-lg tracking-wide text-white uppercase italic">Inventory App</span>
    </div>

    <nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto min-w-[16rem]">
        <!-- Menu Utama -->
        <p class="px-3 text-[11px] font-bold text-blue-300/80 uppercase tracking-widest mb-3">Menu</p>
        <div class="space-y-1.5">
            <!-- Dashboard Link -->
            <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}" 
               class="group flex items-center justify-between px-3 py-2.5 rounded-lg transition-all border border-transparent 
               {{ request()->routeIs('admin.dashboard') || request()->routeIs('staff.dashboard') ? 'bg-white/10 text-white shadow-sm border-white/10 backdrop-blur-md' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:border-white/5' }}">
                <div class="flex items-center">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') || request()->routeIs('staff.dashboard') ? 'text-white' : 'opacity-70 group-hover:opacity-100' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span class="font-medium tracking-wide text-sm">Dashboard</span>
                </div>
            </a>
        </div>

        <!-- Section: Items Data -->
        <div class="pt-8">
            <p class="px-3 text-[11px] font-bold text-blue-300/80 uppercase tracking-widest mb-3">Items Data</p>
            <div class="space-y-1.5">
                @if(auth()->user()->role == 'admin')
                <!-- Categories Link (Admin Only) -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="group flex items-center justify-between px-3 py-2.5 rounded-lg transition-all border border-transparent 
                   {{ request()->routeIs('admin.categories.index') ? 'bg-white/10 text-white shadow-sm border-white/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:border-white/5' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.categories.index') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                        <span class="font-medium tracking-wide text-sm">Categories</span>
                    </div>
                </a>
                @endif

                <!-- Items Link (Both) -->
                <a href="{{ auth()->user()->role == 'admin' ? route('admin.items.index') : route('staff.items.index') }}" 
                   class="group flex items-center justify-between px-3 py-2.5 rounded-lg transition-all border border-transparent 
                   {{ request()->routeIs('admin.items.index') || request()->routeIs('staff.items.index') ? 'bg-white/10 text-white shadow-sm border-white/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:border-white/5' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5 {{ request()->is('*items*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        <span class="font-medium tracking-wide text-sm">Items</span>
                    </div>
                </a>

                @if(auth()->user()->role == 'staff')
                <!-- Lending Link (Staff Only) -->
                <a href="{{ route('staff.lending.index') }}" 
                   class="group flex items-center justify-between px-3 py-2.5 rounded-lg transition-all border border-transparent 
                   {{ request()->routeIs('staff.lending.index') ? 'bg-white/10 text-white shadow-sm border-white/10' : 'text-blue-100 hover:bg-white/10 hover:text-white hover:border-white/5' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('staff.lending.index') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-medium tracking-wide text-sm">Lending</span>
                    </div>
                </a>
                @endif
            </div>
        </div>

        <!-- Section: Accounts (With Sub-menu) -->
        <div class="pt-8" x-data="{ openUsers: {{ request()->is('admin/users*') || request()->is('staff/profile*') ? 'true' : 'false' }} }">
            <p class="px-3 text-[11px] font-bold text-blue-300/80 uppercase tracking-widest mb-3">Accounts</p>
            <div class="space-y-1.5">
                <!-- Dropdown Trigger untuk Users -->
                <button @click="openUsers = !openUsers" 
                   class="w-full group flex items-center justify-between px-3 py-2.5 text-blue-100 hover:bg-white/10 hover:text-white rounded-lg transition-all border border-transparent hover:border-white/5 focus:outline-none">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span class="font-medium tracking-wide text-sm">Users</span>
                    </div>
                    <!-- Icon Arrow: Berputar saat open -->
                    <svg class="h-4 w-4 transition-transform duration-300" :class="openUsers ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>

                <!-- Sub-menu Items (Transition fold-down) -->
                <div x-show="openUsers" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="pl-11 space-y-2 mt-2">
                    @if(auth()->user()->role == 'admin')
                    <!-- Link Admin -->
                    <a href="{{ route('admin.users.admin') }}" 
                       class="flex items-center text-sm font-medium transition-colors hover:text-white {{ request()->routeIs('admin.users.admin') ? 'text-white' : 'text-blue-200/70' }}">
                        <span class="mr-3 w-1.5 h-1.5 bg-current rounded-full"></span>
                        Admin
                    </a>
                    <!-- Link Operator (Staff) -->
                    <a href="{{ route('admin.users.operator') }}" 
                       class="flex items-center text-sm font-medium transition-colors hover:text-white {{ request()->routeIs('admin.users.operator') ? 'text-white' : 'text-blue-200/70' }}">
                        <span class="mr-3 w-1.5 h-1.5 bg-current rounded-full"></span>
                        Operator
                    </a>
                    @else
                    <!-- Link Edit (Staff Only) -->
                    <a href="{{ route('staff.profile.edit') }}" 
                       class="flex items-center text-sm font-medium transition-colors hover:text-white {{ request()->routeIs('staff.profile.edit') ? 'text-white' : 'text-blue-200/70' }}">
                        <span class="mr-3 w-1.5 h-1.5 bg-current rounded-full"></span>
                        Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</aside>
