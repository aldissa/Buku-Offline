<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Document</title>
</head>

<body>
    @include('template.nav')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-2">
            <a href="{{ route('tambah') }}" class="btn btn-primary">Tambah</a>
            <form action="{{ route('filteradmin') }}">
                <select name="statusBuku" class="form-select" onchange="this.form.submit()">
                    <option selected>Status Buku</option>
                    <option value="dijual">Dijual</option>
                    <option value="tidak dijual">Tidak Dijual</option>
                </select>
            </form>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Buku</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($buku as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if ($item->status == 'dijual')
                            <td><img src="{{ asset($item->foto) }}" alt="" width="80px"
                                    style="object-fit: cover"></td>
                        @elseif($item->status == 'tidak dijual')
                            <td><img src="{{ asset($item->foto) }}" alt="" width="80px"
                                    style="object-fit: cover; filter: grayscale(100%)"></td>
                        @endif
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a href="{{ route('edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            @if ($item->status == 'dijual')
                                <a href="{{ route('nonaktifkanbuku', $item->id) }}" class="btn btn-danger">Hapus</a>
                            @elseif($item->status == 'tidak dijual')
                                <a href="{{ route('aktifkanbuku', $item->id) }}" class="btn btn-success">Kembalikan</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
