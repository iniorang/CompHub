<table class='table table-bordered'>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Penyelenggara</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach ($comp as $c)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $c->nama }}</td>
                <td>{{ $c->desk }}</td>
                <td>{{ $c->org }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
