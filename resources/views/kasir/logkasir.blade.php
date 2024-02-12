<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('data/cdn.datatables.net_1.13.6_css_jquery.dataTables.min.css') }}">
    <title>Log</title>
</head>
<body>
    @include('template.nav')
    <div class="container mt-5">
            <form action="{{ route('filterLog') }}" method="GET" class="form-inline mb-3">
                <label for="start" class="mr-2">Dari Tanggal:</label>
                <input type="date" id="start" name="start" class="form-control w-25" required>
                <label for="end" class="mr-2">Sampai Tanggal:</label>
                <input type="date" id="end" name="end" class="form-control w-25" required>
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
        
        <table class="table table-bordered" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama User</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($log as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->aktivitas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <script src="{{ asset('table/code.jquery.com_jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('table/cdn.datatables.net_1.13.6_js_dataTables.bootstrap4.min.js') }}"></script>
    <script>new DataTable('#example');</script>
</body>
</html>