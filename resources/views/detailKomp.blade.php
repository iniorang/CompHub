@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row gx-5">
            <div class="col-9 card">
                <img src="{{ asset('/storage/competition/' . $comp->img) }}" class="card-img-top py-3" alt="...">
                <h1>{{ $comp->nama }}</h1>
                {!! $comp->desk !!}
            </div>
            <div class="col-3 card">
                @if (Auth::check())
                    @if (Auth::user()->kompetisis()->where('komps_id', $comp->id)->exists())
                        <p>Anda sudah terdaftar dalam kompetisi ini.</p>
                    @else
                        @if ($comp->harga_daftar > 0)
                            <form action="{{ route('daftarsendiri', ['id' => $comp->id]) }}" method="POST">
                                @csrf
                                <button type="submit">Ikuti Kompetisi ({{ $comp->harga_daftar }})</button>
                            </form>
                        @else
                            <form action="{{ route('daftarsendiri', ['id' => $comp->id]) }}" method="POST">
                                @csrf
                                <button type="submit">Ikuti Kompetisi (Gratis)</button>
                            </form>
                        @endif
                    @endif
                @else
                    <p>Silakan login untuk mengikuti kompetisi.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
