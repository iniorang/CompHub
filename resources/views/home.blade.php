@extends('layouts.app')

@section('content')
    <div class="container my-2">
        <h3>Kompetisi Baru</h3>
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
                <div class="col">
                    <div class="alert alert-danger">
                        Belum Ada Kompetisi
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="container my-2">
        <h3>Tim Baru</h3>
        <div class="row gy-5">
            @forelse ($tim as $t)
                <div class="col">
                    <a href="{{ route('detailt', $t->id) }}" style="text-decoration: none; color: black;">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('/storage/timlogo/' . $t->logo) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $t->nama }}</h5>
                                <p class="card-text">{!! $t->desk !!}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-danger">
                        Belum Ada Tim terdaftar
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @endsection
