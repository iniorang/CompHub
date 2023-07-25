@extends('layouts.dashboard')

@section('content')
    <div class="tab-content">
        <div class="tab-pane active" id="overview">
            <div class="container">
                <h1>Overview</h1>
                <div class="row row-cols-4">
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Card title</h1>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Card title</h1>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Card title</h1>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Card title</h1>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="peserta">
            {{-- <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="card-body">
                                <a href="{{ route('create') }}" class="btn btn-md btn-success mb-3">TAMBAH
                                    POST</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($comp as $c)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ asset('/storage/competition/' . $c->image) }}"
                                                        class="rounded" style="width: 150px">
                                                </td>
                                                <td>{{ $c->nama }}</td>
                                                <td>{!! $c->desk !!}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('destroy', $c->id) }}" method="POST">
                                                        <a href="{{ route('detail', $c->id) }}"
                                                            class="btn btn-sm btn-dark">SHOW</a>
                                                        <a href="{{ route('edit', $c->id) }}"
                                                            class="btn btn-sm btn-primary">EDIT</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Peserta belum Tersedia.
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $comp->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="tab-pane" id="kompetisi">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="card-body">
                                <a href="{{ route('kompetisi.create') }}" class="btn btn-md btn-success mb-3">Tambah Kompetisi</a>
                                <a href="{{ route('kompetisi.pdf') }}" class="btn btn-primary" target="_blank">CETAK PDF</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($comp as $c)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ asset('/storage/competition/' . $c->img) }}"
                                                        class="rounded" style="width: 150px">
                                                </td>
                                                <td>{{ $c->nama }}</td>
                                                <td>{!! $c->desk !!}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('kompetisi.destroy', $c->id) }}" method="GET">
                                                        <a href="{{ route('kompetisi.detail', $c->id) }}"
                                                            class="btn btn-sm btn-dark">SHOW</a>
                                                        <a href="{{ route('kompetisi.edit', $c->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Kompetisi belum Tersedia.
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $comp->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tim">
            <div class="container">
                <h1>Tim</h1>
            </div>
        </div>
        <div class="tab-pane" id="trans">
            <div class="container">
                <h1>Transaksi</h1>
            </div>
        </div>
        <div class="tab-pane" id="org">
            <div class="container">
                <h1>Penyelanggara</h1>
            </div>
        </div>
    </div>
@endsection


<script>
    //message with toastr
    @if (session()->has('success'))

        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif (session()->has('error'))

        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
</script>

</body>

</html>
