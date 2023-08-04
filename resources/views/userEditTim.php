@extends('layouts.polos')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('view.user.update', $tim->id) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group">
                                <label class="font-weight-bold">Logo</label>
                                <input type="file" class="form-control" name="logo">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama', $tim->nama) }}" placeholder="Masukkan Nama TIm">

                                <!-- error message untuk nama -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Ketua Tim</label>
                                <input type="text" class="form-control @error('ketua') is-invalid @enderror"
                                    name="ketua" value="{{ old('ketua', $tim->ketua) }}" placeholder="Masukkan Ketuaa">

                                <!-- error message untuk nama -->
                                @error('ketua')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
