<header class="bg-[#22b8b0] text-white px-6 py-4 flex items-center justify-between shadow z-10">
    {{-- Sidebar toggle on mobile --}}
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-2xl focus:outline-none lg:hidden">
            ☰
        </button>
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logocimahi.png') }}" class="object-contain w-auto h-12" alt="Logo Dinkes">
            <span class="text-xl font-bold">SIDACI -  Sistem Informasi Data Dinkes Cimahi</span>
        </div>
    </div>
</header>
