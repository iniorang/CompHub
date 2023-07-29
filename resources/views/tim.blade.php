@extends('layouts.app')
@section('content')
    <h2>Manajemen Tim</h2>
    @if ($timUser)
        <h3>Anda adalah ketua tim:</h3>
        <p>Nama Tim: {{ $timUser->nama }}</p>
        {{-- Tampilkan informasi lain tentang tim --}}
        <h4>List Anggota:</h4>
        <ul>
            @foreach ($anggotaTim as $anggota)
                <li>{{ $anggota->name }}</li>
            @endforeach
        </ul>
    @else
        <p>Anda belum menjadi anggota tim.</p>
    @endif
@endsection
