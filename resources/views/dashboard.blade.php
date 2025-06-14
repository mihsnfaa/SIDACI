@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="mb-4 text-2xl font-bold">Selamat datang, {{ $user->name }}</h1>

    @if ($level === 'admin')
        <p>Ini tampilan khusus untuk <strong>Admin</strong>.</p>
        {{-- Bisa include komponen admin --}}
        @include('partials.admin')

    @elseif ($bidang === 'Kesmas')
        <p>Ini tampilan untuk bidang <strong>Kesmas</strong>.</p>
        @include('partials.kesmas')

    @elseif ($bidang === 'P2P')
        <p>Ini tampilan untuk bidang <strong>P2P</strong>.</p>
        @include('partials.p2p')

    @elseif ($bidang === 'Progsi')
        <p>Ini tampilan untuk bidang <strong>Progsi</strong>.</p>
        @include('partials.progsi')

    @else
        <p>Tampilan umum untuk user.</p>
    @endif

</div>
@endsection
