@extends('layouts.app')
@section('content')
    <h2>Daftar Kompetisi yang Diikuti</h2>

    @if ($comp->isEmpty())
        <p>Anda belum mengikuti kompetisi apapun.</p>
    @else
        <ul>
            @foreach ($comp as $k)
                <li>{{ $k->nama }}</li>
                {{-- Tampilkan informasi lainnya tentang kompetisi --}}
            @endforeach
        </ul>
    @endif

@endsection
