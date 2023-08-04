@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tim yang Anda Ikuti</h2>
        @if ($user->tim->isEmpty())
            <p>Anda belum bergabung dengan tim manapun.</p>
            <p><a href="{{ route('show.timCreation.user') }}">Buat Tim Baru</a> atau <a href="{{ route('showalltim') }}">Ikut
                    Tim Lain.</a></p>
        @else
            <ul>
                @foreach ($user->tim as $tim)
                    <li>{{ $tim->nama }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
