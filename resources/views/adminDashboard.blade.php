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
                                <h1 class="card-title">Organizer</h1>
                                <p class="card-text">{{ $org_count }}</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Tim</h1>
                                <p class="card-text">{{ $tim_count}}.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">User</h1>
                                <p class="card-text">{{ $user_count}}.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h1 class="card-title">Kompetisi</h1>
                                <p class="card-text">{{ $comp_count}}</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="peserta">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="card-body">
                                <a href="{{ route('user.create') }}" class="btn btn-md btn-success mb-3">Tambah
                                    User</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Nomor Telpon</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($user as $u)
                                            <tr>
                                                <td>{{ $u->id }}</td>
                                                <td>{{ $u->name }}</td>
                                                <td>{{ $u->email }}</td>
                                                <td>{{ $u->telp }}</td>
                                                <td>{{ $u->alamat }}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('user.destroy', $u->id) }}" method="POST">
                                                        <a href="{{ route('user.edit', $u->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
                                {{ $user->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="kompetisi">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="card-body">
                                <div class="container my-4">
                                    <a href="{{ route('kompetisi.create') }}" class="btn btn-md btn-success">Tambah Kompetisi</a>
                                    <a href="{{ route('kompetisi.pdf') }}" class="btn btn-primary" target="_blank">Export ke PDF</a>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Thumbnail</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Penyelenggara</th>
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
                                                <td>{{ $c->organizer->nama }}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('kompetisi.destroy', $c->id) }}" method="GET">
                                                        {{-- <a href="{{ route('kompetisi.detail', $c->id) }}"
                                                            class="btn btn-sm btn-dark">Tampilkan</a> --}}
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
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="card-body">
                                <a href="{{ route('tim.create') }}" class="btn btn-md btn-success mb-3">Tambah
                                    Tim</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Logo</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Ketua</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tim as $t)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ asset('/storage/timlogo/' . $t->logo) }}"
                                                        class="rounded" style="width: 150px">
                                                </td>
                                                <td>{{ $t->nama }}</td>
                                                <td>{{ $t->ketua }}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('tim.destroy', $t->id) }}" method="POST">
                                                        {{-- <a href="{{ route('tim.detail', $t->id) }}"
                                                            class="btn btn-sm btn-dark">Detail</a> --}}
                                                        <a href="{{ route('tim.edit', $t->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Tim belum Tersedia.
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $tim->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="trans">
            <div class="container">
                <h1>Transaksi</h1>
            </div>
        </div>
        <div class="tab-pane" id="org">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded">
                            <div class="card-body">
                                <a href="{{ route('org.create') }}" class="btn btn-md btn-success mb-3">Tambah
                                    Penyelengara</a>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($org as $o)
                                            <tr>
                                                <td>{{ $o->id }}</td>
                                                <td>{{ $o->nama}}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('org.destroy', $o->id) }}" method="POST">
                                                        <a href="{{ route('org.edit', $o->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Penyelenggara belum Tersedia.
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $org->links() }}
                            </div>
                        </div>
                    </div>
                </div>
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
