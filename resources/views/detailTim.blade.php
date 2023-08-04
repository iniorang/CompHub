@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row gx-5">
                <div class="col-9 card">
                    <img src="{{ asset('/storage/timlogo/' . $tim->logo) }}" class="card-img-top py-3" alt="...">
                    <h1>{{ $tim->nama }}</h1>
                    {!! $tim->desk !!}
                </div>
                <div class="col-3 card">
                    @auth
                        @if (auth()->user()->tim && auth()->user()->tim->id === $tim->id)
                            <p>Anda sudah ikut tim.</p>
                        @else
                            <form action="{{ route('ikuttim', ['timId' => $tim->id]) }}" method="POST">
                                @csrf
                                <button type="submit">Ikut Tim</button>
                            </form>
                        @endif
                    @endauth

                    @guest
                        {{-- Jika user belum login --}}
                        <p>Silakan login untuk bergabung dengan tim.</p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection
