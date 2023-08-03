@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($tim)
        <h2>Nama Tim: {{ $tim->nama }}</h2>
        <form action="{{ route('resign') }}" method="POST">
            @csrf
            <button type="submit">Keluar dari Tim</button>
        </form>

            {{-- Tampilkan informasi lainnya tentang tim --}}

            @if (auth()->user()->type === 'admin' || auth()->user()->id === $tim->ketua)
                {{-- Jika user adalah admin atau ketua tim, tampilkan opsi untuk membubarkan tim dan mengeluarkan anggota --}}
                <form action="{{ route('disband', $tim->id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Anda yakin ingin membubarkan tim?')">Bubarkan Tim</button>
                </form>

                <h3>Anggota Tim:</h3>
                @if ($tim->anggota->isEmpty())
                    <p>Tim ini belum memiliki anggota.</p>
                @else
                    <ul>
                        @foreach ($tim->anggota as $anggota)
                            <li>
                                {{ $anggota->name }}
                                <form action="{{ route('kick', $anggota->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Anda yakin ingin mengeluarkan anggota ini dari tim?')">Keluarkan</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        @else
            <p>Anda belum tergabung dalam tim.</p>
            <p><a href="{{ route('show.timCreation.user') }}">Buat Tim Baru</a> atau <a
                    href="{{ route('showalltim') }}">Ikut Tim Lain</a>.</p>
        @endif
    </div>
@endsection
