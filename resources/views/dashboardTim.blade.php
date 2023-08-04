@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nama Tim: {{ $tim->nama }}</h2>

        <h3>Ketua Tim:</h3>
        @if ($ketua)
            {{-- <p>{{ $ketua->name }}</p> --}}
        @else
            <p>Belum ada ketua untuk tim ini.</p>
        @endif

        <h3>Anggota Tim:</h3>
        @if ($anggota->isEmpty())
            <p>Tim ini belum memiliki anggota.</p>
        @else
            <ul>
                @foreach ($anggota as $a)
                    <li>{{ $a->name }}</li>
                @endforeach
            </ul>
        @endif

        @auth
            @if (auth()->user()->tim && auth()->user()->tim->contains('id', $tim->id))
                <form action="{{ route('resign', ['timId' => $tim->id]) }}" method="POST">
                    @csrf
                    <button type="submit">Keluar dari Tim</button>
                </form>
            @endif

        @endauth
    </div>
@endsection
