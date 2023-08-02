@extends('layouts.polos')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('kompetisi.update', $comp->id) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <input type="hidden" name="id" value="{{ $comp->id }}">
                            <div class="form-group">
                                <label class="font-weight-bold">Gambar</label>
                                <input type="file" class="form-control" name="img">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama', $comp->nama) }}"
                                    placeholder="Masukkan Nama Kompetisi">

                                <!-- error message untuk title -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">Harga Daftar</label>
                                <input type="text" class="form-control @error('harga_daftar') is-invalid @enderror"
                                    name="daftar" value="{{ old('harga_daftar', $comp->harga_daftar) }}"
                                    placeholder="Harga daftar kompetisi">

                                <!-- error message untuk title -->
                                @error('nama')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" name="desk" rows="5"
                                    placeholder="Masukkan Deskripsi">{{ old('desk', $comp->desk) }}</textarea>

                                <!-- error message untuk content -->
                                @error('content')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="font-weight-bold">Penyelengara</label>
                                <select class="form-control @error('org') is-invalid @enderror" name="org">
                                    <option value="">Pilih Penyelengara</option>
                                    @foreach ($org as $o)
                                        <option value="{{ $o->id }}"
                                            {{ old('org', $comp->organizer_id) == $o->id ? 'selected' : '' }}>
                                            {{ $o->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('org')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('desk');
    </script>
@endsection
