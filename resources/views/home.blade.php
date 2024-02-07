<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Home</title>
</head>
<body style="background-color: #F4F1DE;">
    @include('template.nav')
    <div class="container mt-5" style="padding-bottom: 100px">
        <div class="d-flex justify-content-between">
            <h2 style="color: #8F4D4D;">Pilih Buku</h2>
            @if (Session::has('msg'))
                <span class="alert alert-success" style="color: #8F4D4D;">{{ Session::get('msg') }}</span>
            @endif
            @if (Session::has('err'))
                <span class="alert alert-danger" style="color: #8F4D4D;">{{ Session::get('err') }}</span>
            @endif
        </div>

        <div class="mt-4">
            <div class="row">
                @foreach ($buku as $item)
                    <div class="col-2 mt-3">
                        <img src="{{ asset($item->foto) }}" alt="Sampul Buku" width="100px" height="250px" class="card-img-top">
                    </div>
                    <div class="col-4 p-3 mt-3 mb-auto" style="background-color: #5E4634;">
                        <div class="d-flex justify-content-between">
                            <h3 style="color: #F4F1DE;">{{ $item->nama }}</h3>
                            <p style="margin-top: 5px; color: #F4F1DE;">Stok: <span style="color: red; font-weight: 500;">{{ $item->stok }}</span></p>
                        </div>
                        <p style="color: #F4F1DE;">{{ $item->deskripsi }}</p>
                        <form action="{{ route('postkeranjang', $item->id) }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <p style="margin-top: 4px; color: #F4F1DE;">Jumlah</p>
                                <input type="number" class="form-control" value="1" min="1" name="qty" style="height: 35px; width: 130px">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn" style="border-radius: 2px; background-color: #8F4D4D; color: #F4F1DE;">Masukkan ke Keranjang</button>
                                <h5 style="margin-top: 4px; color: #F4F1DE;">Rp. {{ number_format($item->harga, 2, ',','.') }}</h5>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>