<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .invoice {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .header{
        text-align: center;
        margin-bottom: 20px;
    }

    .invoice-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .invoice-info div{
        width: 48%;
    }

    .invoice-table{
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .invoice-table th,
    .invoice-table td{
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .invoice-total{
        margin-top: 20px;
        text-align: right;
    }
</style>

<body>
    <div class="invoice">
        <div class="header">
            <h1>Invoice</h1>
        </div>

        <div class="invoice-info">
            <div>
                <p>Invoice : <strong>{{ $data->invoice }}</strong></p>
                <p>Tanggal : <strong>{{ $data->updated_at }}</strong></p>
                <p>Pembeli : <strong>{{ $data->nama_user }}</strong></p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Jumlah Harga</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->detailtransaksi as $item)
                <tr>
                    <th>{{ $item->buku->nama }}</th>
                    <th>Rp. {{ number_format($item->buku->harga, 2,',','.') }}</th>
                    <th>{{ $item->qty }}</th>
                    <th>Rp. {{ number_format($item->buku->harga * $item->qty, 2,',','.') }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $totalSemua = 0;
            foreach ($data->detailtransaksi as $dt) {
                $hargaAwal = $dt->buku->harga * $dt->qty;
                $totalSemua += $hargaAwal;
            }
        @endphp
        <div class="invoice-total">
            <p><strong>Total: {{ number_format($totalSemua, 2,',','.') }}</strong></p>
        </div>
    </div>
</body>

</html>