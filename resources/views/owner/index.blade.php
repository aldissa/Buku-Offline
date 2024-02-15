<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <title>Owner</title>
</head>
<body>
    @include('template.nav')

    <div class="container mt-5">
        <div class="mt-3">
            <h4>Total Pendapatan Rp.{{ number_format($totalPendapatan, 2, ',','.') }}</h4>
        </div>
        <div class="row">
            <div class="col-8">
                {!! $chart->container() !!}
            </div>
            <div class="col-4">
                <form action="{{ route('filteredhome.owner') }}" method="GET" class="form-group">
                    <div class="d-flex justify-content-between gap-2">
                        <label for="From">From</label>
                        <input type="date" name="dateFrom" class="form-control w-75" required>
                    </div>
                    <div class="d-flex justify-content-between gap-2 mt-3">
                        <label for="To">To</label>
                        <input type="date" name="dateTo" class="form-control w-75" required>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div></div>
                    <button class="btn w-75" style="background-color: #073B4C; color: #ffffff">Filter</button>
                    </div>
                    @if (Session::has('err'))
                        <span class="alert alert-danger">{{ Session::get('err') }}</span>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
</body>
</html>