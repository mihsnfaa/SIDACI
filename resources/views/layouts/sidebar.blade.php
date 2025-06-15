<aside 
    x-show="sidebarOpen" 
    x-transition 
    class="fixed inset-y-0 left-0 z-40 w-64 bg-[#339999] text-white flex flex-col transition-transform duration-300 transform lg:relative lg:translate-x-0"
    :class="{ '-translate-x-full': !sidebarOpen && !isDesktop }"
>
    {{-- User Info --}}
    <div class="flex flex-col items-center p-4 border-b border-white/30">
        <div class="p-4 bg-white rounded-full">
            <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A13.937 13.937 0 0112 15c2.182 0 4.233.523 6.061 1.447M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="mt-2 text-center">
            <p class="font-bold">{{ Auth::user()->name }}</p>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 p-2 rounded hover:bg-white hover:text-[#339999]">
            🏠 Dashboard
        </a>
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="p-4 mt-auto border-t border-white/20">
        @csrf
        <button type="submit"
                class="flex items-center gap-2 p-2 w-full text-left rounded hover:bg-white hover:text-[#339999]">
            🧾 Logout
        </button>
    </form>
</aside>
