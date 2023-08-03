@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Deactivate Account Confirmation</h5>
                    </div>
                    <div class="card-body">
                        <p>Are you sure you want to deactivate your account? This action cannot be undone.</p>
                        <form action="{{ route('matikanakun') }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <button type="submit" class="btn btn-danger">Deactivate</button>
                            <a href="{{ route('profile', Auth::user()->id) }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
