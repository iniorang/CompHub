@extends('layouts.app')

@section('content')
    <h2>Dashboard Tim</h2>

    @if ($tim)
        <h3>Nama Tim: {{ $tim->nama }}</h3>
        {{-- Tampilkan informasi lainnya tentang tim --}}

        <h3>Anggota Tim:</h3>
        @if ($tim->anggota->isEmpty())
            <p>Tim ini belum memiliki anggota.</p>
        @else
            <ul>
                @foreach ($tim->anggota as $anggota)
                    <li>{{ $anggota->name }}</li>
                    {{-- Tampilkan informasi lainnya tentang anggota tim --}}
                @endforeach
            </ul>
        @endif
    @else
        <p>Anda belum tergabung dalam tim.</p>
        <p><a href="{{ route('show.timCreation.user') }}">Buat Tim Baru</a> atau <a href="{{ route('showalltim') }}">Ikut Tim Lain</a>.</p>
    @endif
@endsection
