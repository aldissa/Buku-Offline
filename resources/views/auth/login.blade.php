<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Login</title>
</head>

<body style="background-image: url('img/prps.jpg')">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (Session::has('err'))
                    <span class="alert alert-danger w-50">
                        {{ Session::get('err') }}
                    </span>
                @endif
                <div class="card mt-5" style="background-color: #2D3748">
                    <div class="card-body">
                        <h2 class="text-center" style="color: #F4F1DE">LOGIN</h2>
                        <form action="{{ route('postlogin') }}" method="POST">
                            @csrf
                            <label for="" class="form-label" style="color: #F4F1DE">Username</label>
                            <input type="text" class="form-control" name="username" required>
                            <label for="" class="form-label" style="color: #F4F1DE">Password</label>
                            <input type="password" class="form-control" name="password" required>
                            <button class="btn btn-primary mt-3 w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
