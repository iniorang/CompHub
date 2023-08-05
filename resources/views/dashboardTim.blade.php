@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nama Tim: {{ $tim->nama }}</h2>

        <h3>Ketua Tim:</h3>
        @if ($ketua)
            <p>{{ $ketua->name }}</p>
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

                {{-- Show the "Bubarkan Tim" button if the logged-in user is the ketua --}}
                @if ($ketua && auth()->user()->id === $ketua->id)
                    <form action="{{ route('disband', ['id' => $tim->id]) }}" method="POST">
                        @csrf
                        <button type="submit">Bubarkan Tim</button>
                    </form>
                @endif
            @endif

            {{-- Manajemen Permintaan Bergabung (if the logged-in user is the ketua) --}}
            @if (auth()->user()->tim && auth()->user()->tim->contains('id', $tim->id) && $ketua && auth()->user()->id === $ketua->id)
                @if ($permintaan->isEmpty())
                    <p>Tidak ada permintaan bergabung pada tim ini.</p>
                @else
                    <h3>Permintaan Bergabung:</h3>
                    <ul>
                        @foreach ($permintaan as $request)
                            <li>
                                {{ $request->user->name }} - Status: {{ $request->status }}
                                @if ($request->status === 'pending')
                                    <form action="{{ route('terima-permintaan', ['requestId' => $request->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit">Terima</button>
                                    </form>
                                    <form action="{{ route('tolak-permintaan', ['requestId' => $request->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit">Tolak</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        @endauth
    </div>
@endsection
