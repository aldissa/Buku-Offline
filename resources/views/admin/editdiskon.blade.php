<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Tambah</title>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="card w-50">
                <h2 class="text-center">Edit Kode Voucher</h2>
                <div class="card-body">
                    <form action="{{ route('postEditDiskon', $voucher->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="kode" value="{{ $voucher->kode }}">
                        <label for="" class="form-label">Diskon</label>
                        <input type="number" class="form-control" name="diskon" placeholder="" value="{{ $voucher->diskon }}"> 
                        <label for="" class="form-label">Kedaluwarsa</label>
                        <input type="date" class="form-control" name="kedaluwarsa">
                        <button class="btn btn-primary mt-1">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
