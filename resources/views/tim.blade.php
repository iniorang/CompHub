@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($tim)
            <h2>Nama Tim: {{ $tim->nama }}</h2>
            {{-- Tampilkan informasi lainnya tentang tim --}}

            @if ($tim->ketua === Auth::user()->id)
                {{-- Jika user adalah ketua tim, tampilkan opsi untuk bubarkan tim dan keluarkan anggota --}}
                <form action="{{ route('tim.bubarkan') }}" method="POST">
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
                                <form action="{{ route('tim.keluarkan', $anggota->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Anda yakin ingin mengeluarkan anggota ini dari tim?')">Keluarkan</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @else
            @endif
        @else
            <p>Anda belum tergabung dalam tim.</p>
            <p><a href="{{ route('show.timCreation.user') }}">Buat Tim Baru</a> atau <a href="{{ route('showalltim') }}">Ikut Tim Lain</a>.</p>
        @endif
    </div>
@endsection
