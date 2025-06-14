<header class="bg-[#22b8b0] text-white px-6 py-4 flex items-center justify-between shadow">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-2xl text-white focus:outline-none">☰</button>
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo-cimahi.png') }}" class="h-8" alt="Logo Dinkes">
            <span class="text-lg font-bold">SIDACI</span>
        </div>
    </div>
    <div class="text-sm font-semibold uppercase">
        {{ Auth::user()->role ?? 'USER' }}
    </div>
</header>
