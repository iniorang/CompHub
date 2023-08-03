@extends('layouts.polos')

@section('content')
    <h1>Participants in {{ $comp->nama }}</h1>

    @isset($part)
        <ul>
            @foreach ($part as $p)
                <li>{{ $p->name }} ({{ $p->email }})</li>
            @endforeach
        </ul>
    @else
        <p>No participants found.</p>
    @endisset
@endsection
