<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Keranjang</title>
</head>

<body style="background-color: #F0F4F8;">
    @include('template.nav')

    @php
        $totalSemua = 0;

        foreach ($transaksi as $item) {
            foreach ($item->detailtransaksi as $dt) {
                $hargaAwal = $dt->buku->harga * $dt->qty;
                $totalSemua += $hargaAwal;
            }
        }
    @endphp
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('postcheckout', ['tranID' => json_encode($transaksi->pluck('id'))]) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="total_semua" value="{{ $totalSemua }}">
                    <div class="d-flex justify-content-between">
                        <h3>Checkout barang anda</h3>
                        @if (Session::has('hapus'))
                            <span class="alert alert-success">{{ Session::get('hapus') }}</span>
                        @endif
                        <div class="d-flex">
                            <p style="margin-top: 10px; font-size: large;">Total Harga Semua buku:
                                <span style="font-weight: 500; margin-right: 10px;">Rp.
                                    <span id="totalHarga">{{ number_format($totalSemua, 2, ',', '.') }}</span></span>
                            </p>
                            <button class="btn" disabled id="btnCheckout" style="background-color: #073B4C; color: #F4F1DE">Bayar</button>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <input type="text" class="form-control w-25" name="uang_bayar" placeholder="Nominal Uang...."
                            id="uangBayar">
                        <p>Uang kembali: <span style="font-weight: 500" id="uangKembali">Rp. 0</span></p>
                    </div>
                    <div class="mt-3">
                        <input type="text" class="form-control w-25" placeholder="Nama Pembeli" name="nama_user" required>
                    </div>
                    <div class="mt-3">
                        <select name="kode_voucher" id="kode_voucher" class="form-control w-25">
                            <option value="">Pilih kode voucher</option>
                            @foreach ($voucher as $v)
                                <option value="{{ $v->kode }}" data-diskon="{{ $v->diskon }}">{{ $v->kode }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Gambar Buku</th>
                            <th>Nama Buku</th>
                            <th>Harga Buku</th>
                            <th>Jumlah Buku</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                            @foreach ($item->detailtransaksi as $dt)
                            <tr>
                                <td>
                                    <img src="{{ asset($dt->buku->foto) }}" width="70px" alt="">
                                </td>
                                <td>{{ $dt->buku->nama }}</td>
                                <td>Rp. {{ number_format($dt->buku->harga, 2, ',', '.') }}</td>
                                <td>{{ $dt->qty }}</td>
                                <td>Rp. {{ number_format($dt->buku->harga * $dt->qty, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('hapusKeranjang', $dt->id) }}" class="btn" style="background-color: #073B4C; color: #F4F1DE">Hapus</a>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('uangBayar');
            var lblKembali = document.getElementById('uangKembali');
            var btnCheckout = document.getElementById('btnCheckout');
            var selectVoucher = document.getElementById('kode_voucher');
            var totalHarga = document.getElementById('totalHarga');
            var totalSemua = parseFloat(totalHarga.textContent.replace('Rp. ', '').replace('.', '').replace(',', '.'));

            selectVoucher.addEventListener('change', function() {
                var diskon = parseInt(selectVoucher.options[selectVoucher.selectedIndex].getAttribute('data-diskon')) || 0;
                var totalAkhir = totalSemua - (totalSemua * diskon / 100);
                totalHarga.textContent = '' + totalAkhir.toFixed(2);
                update();
            });

            input.addEventListener('input', function() {
                update();
            });

            function update() {
                var diskon = parseInt(selectVoucher.options[selectVoucher.selectedIndex].getAttribute('data-diskon')) || 0;
                var totalAkhir = totalSemua - (totalSemua * diskon / 100)
                var uangBayar = parseFloat(input.value.replace(',', '').replace(',', '.')) || 0;
                var kembali = uangBayar - totalAkhir;

                if (uangBayar < totalAkhir) {
                    lblKembali.textContent = 'Uang tidak cukup';
                    btnCheckout.disabled = true;
                } else {
                    lblKembali.textContent = 'Rp. ' + kembali.toFixed(2);
                    btnCheckout.disabled = false;
                }
            }
        });
    </script>
</body>

</html>
