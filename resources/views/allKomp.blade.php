@extends('layouts.app')


@section('content')
    <div class="container my-2">
        <div class="row gy-5">
            @forelse ($comp as $c)
                <div class="col">
                    <a href="{{ route('detailk', $c->id) }}" style="text-decoration: none; color: black;">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('/storage/competition/' . $c->img) }}" style="max-height: 150px" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $c->nama }}</h5>
                                <p class="card-text">{!! $c->desk !!}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
    @endsection
