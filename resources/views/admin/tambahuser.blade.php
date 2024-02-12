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
                <h2 class="text-center">Tambah User</h2>
                <div class="card-body">
                    <form action="{{ route('postUser') }}" method="POST">
                        @csrf
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                        <label for="" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                        <label for="" class="form-label">Password</label>
                        <input type="text" class="form-control" name="password" required>
                        <label for="" class="form-label">Role</label>
                        <select name="role" id="" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                        <button class="btn btn-primary mt-1">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
