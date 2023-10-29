@php
    $routeActive = Route::currentRouteName();
@endphp

<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
        <i class="ni ni-tv-2 text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>
@if (Auth::user()->role == 'masteradmin')
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'data-admin.index' ? 'active' : '' }}" href="{{ route('data-admin.index') }}">
        <i class="fas fa-users-cog text-info"></i>
        <span class="nav-link-text">Data Admin</span>
    </a>
</li>
@endif
@if (Auth::user()->role == 'masteradmin' || Auth::user()->role == 'admin')
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'data-pendaftar.index' ? 'active' : '' }}" href="{{ route('data-pendaftar.index') }}">
        <i class="fas fa-users text-warning"></i>
        <span class="nav-link-text">Data Pendaftar</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'data-pelanggan.index' ? 'active' : '' }}" href="{{ route('data-pelanggan.index') }}">
        <i class="fas fa-user-check text-primary"></i>
        <span class="nav-link-text">Data Pelanggan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'transaksi-regis.index' ? 'active' : '' }}" href="{{ route('transaksi-regis.index') }}">
        <i class="fas fa-money-check-alt"></i>
        <span class="nav-link-text">Transaksi Regis</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'transaksi.index' ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
        <i class="fas fa-money-check-alt"></i>
        <span class="nav-link-text">Transaksi Paket</span>
    </a>
</li>

@endif
@if (Auth::user()->role == 'masteradmin' || Auth::user()->role == 'admin' || Auth::user()->role == 'teknisi')
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'lokasi-tiang.index' ? 'active' : '' }}" href="{{ route('lokasi-tiang.index') }}">
        <i class="fas fa-map-marker-alt"></i>
        <span class="nav-link-text">Lokasi</span>
    </a>
</li>
@endif
@if (Auth::user()->role == 'masteradmin' || Auth::user()->role == 'admin' || Auth::user()->role == 'user')
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'paket.index' ? 'active' : '' }}" href="{{ route('paket.index') }}">
        <i class="fas fa-globe"></i>
        <span class="nav-link-text">Paket</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ $routeActive == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
        <i class="fas fa-user-circle text-success"></i>
        <span class="nav-link-text">Profile</span>
    </a>
</li>
@endif
