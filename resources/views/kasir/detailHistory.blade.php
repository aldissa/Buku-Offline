<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Detail History</title>
</head>
<body>
    @include('template.nav')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h2>Detail Pembelian</h2>
                    <a href="{{ route('pdf', $transaksi->id) }}">
                        <img src="{{ asset('icon/printer.png') }}" width="30px" alt="">
                    </a>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <h3 style="font-weight: 300">Pembeli: <span style="font-weight: 500">{{ $transaksi->nama_user }}</span></h3>
                    <p style="padding: 7px; border-radius: 2px; background-color: #073B4C; color: #ffffff">
                        {{ $transaksi->invoice }}</p>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <h5 style="font-weight: 100">Total Harga : <span style="font-weight: 500">Rp. {{ number_format($transaksi->totalharga, 2, ',','.') }}</span></h5>
                </div>
                <hr>
                <div class="card-body">
                    <div class="mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Total Harga Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi->detailtransaksi as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($item->buku->foto) }}" alt="" width="70px" height="110px">
                                        </td>
                                        <td>{{ $item->buku->nama }}</td>
                                        <td>Rp. {{ number_format($item->buku->harga, 2,',','.') }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>Rp. {{ number_format($item->buku->harga * $item->qty, 2,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>