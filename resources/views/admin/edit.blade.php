<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Edit</title>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="card w-50">
                <h2 class="text-center">Edit Buku</h2>
                <div class="card-body">
                    <form action="{{ route('postedit', $buku->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ $buku->nama }}">
                        <label for="" class="form-label">Foto</label>
                        <input type="file" class="form-control" name="foto" value="{{ $buku->foto }}">
                        <label for="" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" value="{{ $buku->deskripsi }}">
                        <label for="" class="form-label">harga</label>
                        <input type="number" class="form-control" name="harga" value="{{ $buku->harga }}">
                        <label for="" class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stok" value="{{ $buku->stok }}">
                        <button class="btn btn-primary mt-1">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
