<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Login</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6" >
                <div class="card" style="height: 500px;">
                    <div class="row g-2 h-100">
                        <div class="col-md-6 h-100">
                            <img src="{{ asset('img/library2.jpg') }}" class="img-fluid h-100">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                @if (Session::has('err'))
                                    <span class="alert alert-danger">
                                        {{ Session::get('err') }}
                                    </span>
                                @endif
                                    <form action="{{ route('postlogin') }}" method="POST">
                                        @csrf
                                        <label for="" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" required>
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                        <button class="btn btn-primary mt-3 w-100">Login</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
