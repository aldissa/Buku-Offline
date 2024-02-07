<navbar class="navbar" style="background-color: #8F4D4D;">
    @if (auth()->user()->role == 'kasir')
        <a href="{{ route('home') }}" class="navbar-brand" style="color: #F4F1DE;">Welcome, {{ auth()->user()->name }}!</a>
    @endif
    @if (auth()->user()->role == 'admin')
        <a href="{{ route('index') }}" class="navbar-brand" style="color: #F4F1DE;">Welcome, {{ auth()->user()->name }}!</a>
    @endif
    @if (auth()->user()->role == 'owner')
        <a href="{{ route('home.owner') }}" class="navbar-brand" style="color: #F4F1DE;">Welcome, {{ auth()->user()->name }}!</a>
    @endif
    <div class="d-flex justify-content-between">
        <a href="{{ route('keranjang') }}" class="nav-link" style="color: #F4F1DE;">Keranjang</a>
        <a href="{{ route('history') }}" class="nav-link" style="color: #F4F1DE;">History Pembelian</a>
        <a href="{{ route('log') }}" class="nav-link" style="color: #F4F1DE;">Aktivitas Terakhir</a>
        <a href="{{ route('logout') }}" class="nav-link" style="color: #F4F1DE;">Logout</a>
    </div>
</navbar>