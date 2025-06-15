@extends('layouts.app')

@section('content')
    <div class="p-6">
        @php
            $user = $user ?? Auth::user();
            $level = $level ?? $user->level;
            $bidang = $bidang ?? $user->bidang;
        @endphp

        <h1 class="mb-4 text-2xl font-bold">Selamat datang, {{ $user->name }}</h1>

        {{-- Tampilan berdasarkan level atau bidang --}}
        @if ($level === 'admin' && empty($admin_akses_bidang))
            {{-- Admin view default: semua bidang --}}
            @include('partials.admin', [
                'jumlahFilePerBidang' => $jumlahFilePerBidang,
                'dataDokumenPerBidang' => $dataDokumenPerBidang,
            ])
        @elseif ($bidang === 'kesmas')
            @include('partials.kesmas', ['documents' => $documents])
        @elseif ($bidang === 'p2p')
            @include('partials.p2p', ['documents' => $documents])
        @elseif ($bidang === 'progsi')
            @include('partials.progsi', ['documents' => $documents])
        @elseif ($bidang === 'sekretariat')
            @include('partials.sekretariat', ['documents' => $documents])
        @elseif ($bidang === 'yansdk' || $bidang === 'yansdk')
            @include('partials.yansdk', ['documents' => $documents])
        @else
            <p>Tampilan umum untuk user.</p>
        @endif
    </div>
@endsection
