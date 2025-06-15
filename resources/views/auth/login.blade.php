@extends('layouts.guest')

@section('content')
    <div class="bg-[#339999] rounded-lg p-10 shadow-lg w-full max-w-xl text-white">
        <div class="flex flex-col items-center mb-6">
            <div class="flex flex-wrap items-center justify-center gap-6 mb-4">
                <img src="{{ asset('images/logocimahi.png') }}" alt="Logo Cimahi" class="object-contain w-auto h-24">
                <img src="{{ asset('images/campernik.png') }}" alt="Logo Smartcity" class="object-contain w-auto h-24">
            </div>
            <h1 class="text-3xl font-bold text-white">SIDACI</h1>
            <p class="text-lg font-semibold">Login</p>
        </div>

        {{-- Tampilkan pesan error --}}
        @if ($errors->any())
            <div class="p-3 mb-4 text-sm text-red-200 bg-red-600 border border-red-400 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-white">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                    class="w-full px-4 py-2 mt-1 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

                @error('username')
                    <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-6">
                <label for="password" class="block text-sm font-semibold text-white">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 pr-10 mt-1 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

                <button type="button" onclick="togglePassword()"
                    class="absolute text-gray-600 right-3 top-9 hover:text-white focus:outline-none">👁️</button>

                @error('password')
                    <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                @enderror
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
