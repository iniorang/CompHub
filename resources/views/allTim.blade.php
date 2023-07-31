@extends('layouts.app')


@section('content')
    <div class="container my-2">
        <div class="row gy-5">
            @forelse ($tim as $t)
                <div class="col">
                    <a href="{{ route('detailt', $t->id) }}" style="text-decoration: none; color: black;">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('/storage/timlogo/' . $t->logo) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $t->nama }}</h5>
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
