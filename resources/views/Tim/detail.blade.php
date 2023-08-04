@extends('layouts.polos')

@section('content')
    <div class="container">
        <h1>Daftar Anggota Tim {{ $tim->nama }}</h1>
        @if ($anggota->isEmpty())
            <p>Tim ini belum memiliki anggota.</p>
        @else
            <ul>
                @foreach ($anggota as $member)
                    <li>{{ $member->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
