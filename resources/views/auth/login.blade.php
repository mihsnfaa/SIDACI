@extends('layouts.guest')

@section('content')
    <div class="bg-[#339999] rounded-lg p-10 shadow-lg w-full max-w-xl text-white">
        <div class="flex flex-col items-center mb-6">
            <div class="flex items-center gap-4 mb-2">
                <img src="{{ asset('images/logo-cimahi.png') }}" alt="Logo Cimahi" class="h-14">
                <img src="{{ asset('images/logo-smartcity.png') }}" alt="Logo Smartcity" class="h-10">
            </div>
            <h1 class="text-2xl font-bold text-white">SIDACI</h1>
            <p class="text-lg font-semibold">Login</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-white">Username</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full px-4 py-2 mt-1 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="relative mb-6">
                <label for="password" class="block text-sm font-semibold text-white">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 pr-10 mt-1 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="button" onclick="togglePassword()" 
                    class="absolute text-gray-600 right-3 top-9 hover:text-white focus:outline-none">
                    👁️
                </button>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="px-8 py-2 font-semibold text-black bg-gray-100 rounded hover:bg-gray-200">
                    Sign in
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection
