<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Home</title>
</head>

<body style="background-color: #F0F4F8;">
    @include('template.nav')
    <div class="container mt-5" style="padding-bottom: 100px">
        <div class="d-flex justify-content-between">
            <h2 style="color: #2D3748;">Pilih Buku</h2>

            <form action="{{ route('search') }}" method="GET">
                <div class="d-flex gap-2">
                    <input type="search" name="cari" class="form-control" placeholder="Cari buku">
                    <button class="btn btn-primary" style="background-color: #073B4C">Search</button>
                </div>
            </form>
        </div>
        <div class="mt-3">
            @if (Session::has('msg'))
                <span class="alert alert-success" style="color: #2D3748;">{{ Session::get('msg') }}</span>
            @endif
            @if (Session::has('success'))
                <span class="alert alert-success" style="color: #2D3748;">{{ Session::get('success') }}</span>
            @endif
            @if (Session::has('err'))
                <span class="alert alert-danger" style="color: #2D3748;">{{ Session::get('err') }}</span>
            @endif
        </div>

        <div class="mt-4">
            <div class="row">
                @foreach ($buku as $item)
                    <div class="col-2 mt-3">
                        <img src="{{ asset($item->foto) }}" alt="Sampul Buku" width="100px" height="250px"
                            class="card-img-top">
                    </div>
                    <div class="col-4 p-3 mt-3 mb-auto"
                        style="background-color: #FFFFFF; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 5px">
                        <div class="d-flex justify-content-between">
                            <h3 style="color: #2D3748;">{{ $item->nama }}</h3>
                            <p style="margin-top: 5px">Stok: <span
                                    style="color: #EF4444; font-weight: 500;">{{ $item->stok }}</span></p>
                        </div>
                        <p style="color: #6B7280;">{{ $item->deskripsi }}</p>
                        <form action="{{ route('postkeranjang', $item->id) }}" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <p style="margin-top: 4px">Jumlah</p>
                                <input type="number" class="form-control" value="1" min="1" name="qty"
                                    style="height: 35px; width: 130px">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary"
                                    style="border-radius: 2px; background-color: #073B4C; color: #FFFFFF;">Masukkan ke
                                    Keranjang</button>
                                <h5 style="margin-top: 4px;">Rp. {{ number_format($item->harga, 2, ',', '.') }}</h5>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>
