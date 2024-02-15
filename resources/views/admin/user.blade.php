<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('data/cdn.datatables.net_1.13.6_css_jquery.dataTables.min.css') }}">
    <title>Document</title>
</head>

<body>
    @include('template.nav')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-2">
            <a href="{{ route('tambahUser') }}" class="btn" style="background-color: #073B4C; color: #ffffff">Tambah</a>
        </div>
        <table class="table table-bordered" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <td width="50px">{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->role }}</td>
                        <td width="150px">
                            <a href="{{ route('editUser', $item->id) }}" class="btn" style="background-color: #096a87; color: #ffffff">Edit</a>
                            <a href="{{ route('delete', $item->id) }}" class="btn"  style="background-color: #073B4C; color: #ffffff" onclick="return confirm('Yakin')">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ asset('table/code.jquery.com_jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('table/cdn.datatables.net_1.13.6_js_dataTables.bootstrap4.min.js') }}"></script>
    <script>
        new DataTable('#example');
    </script>
</body>

</html>
