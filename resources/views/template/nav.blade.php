<nav class="navbar" style="background-color: #6CB4EE;">
    @if (auth()->user()->role == 'kasir')
        <a href="{{ route('home') }}" class="navbar-brand" style="color: #2D3748;">Welcome, {{ auth()->user()->name }}!</a>
    @endif
    @if (auth()->user()->role == 'admin')
        <a href="{{ route('index') }}" class="navbar-brand" style="color: #2D3748;">Welcome,{{ auth()->user()->name }}!</a>
    @endif
    @if (auth()->user()->role == 'owner')
        <a href="{{ route('home.owner') }}" class="navbar-brand" style="color: #2D3748;">Welcome,
            {{ auth()->user()->name }}!</a>
    @endif
    <div class="d-flex justify-content-between">
        @if (auth()->user()->role == 'kasir')
            <a href="{{ route('keranjang') }}" class="nav-link" style="color: #2D3748;">Keranjang</a>
            <a href="{{ route('history') }}" class="nav-link" style="color: #2D3748;">History Pembelian</a>
            <a href="{{ route('log') }}" class="nav-link" style="color: #2D3748;">Aktivitas Terakhir</a>
        @endif
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'owner')
            <a href="{{ route('log') }}" class="nav-link" style="color: #2D3748;">Aktivitas Terakhir</a>
            <a href="{{ route('user') }}" class="nav-link" style="color: #2D3748;">Data User</a>
        @endif
        <a href="{{ route('logout') }}" class="nav-link" style="color: #2D3748;">Logout</a>
    </div>
</nav>
