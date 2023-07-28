@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row gx-5">
        <div class="col-9 card">
            <img src="{{ asset('/storage/competition/' . $comp->img) }}" class="card-img-top py-3" alt="...">
            <h1>{{ $comp->nama }}</h1>
            {!!$comp->desk!!}
        </div>
        <div class="col-3 card">
            <button type="" class="btn btn-md btn-primary">Ikut</button>
        </div>
    </div>
</div>
@endsection
