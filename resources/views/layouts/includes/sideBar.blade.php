<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#" class="name-brand"
                style="font-family: 'Neuton_Reguler' !important; text-transform: capitalize !important; font-size: 2em !important;">
                {{ $data['toko']->nama_toko }}
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#" class="name-brand"
                style="font-family: 'Neuton_Reguler' !important;  font-size: 2em !important;">
                @php
                    $arr_nama = explode(' ', $data['toko']->nama_toko);
                    $nama = [];
                    foreach ($arr_nama as $key => $value) {
                        $nama[] = substr($value, 0, 1);
                    }
                    
                    $nama_toko2 = implode('', $nama);
                    echo substr($nama_toko2, 0, 3);
                @endphp
            </a>
        </div>
        <ul class="sidebar-menu">
            @if (auth()->user()->role == 1)
                <li class="menu-header">Dashboard</li>
                <li class="nav-item @yield('active_dash')">
                    <a href=" {{ route('dashboard.index') }}" class="nav-link">
                        <i class="fas fa-fire"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-header">Produk</li>
                <li class="nav-item @yield('active_produk')">
                    <a href="{{ route('produk.index') }}" class="nav-link">
                        <i class="fas fa-dice-d6"></i><span>Produk</span>
                    </a>
                </li>

                <li class="menu-header">Supplier</li>
                <li class="nav-item @yield('active_supplier')">
                    <a href="{{ route('supplier.index') }}" class="nav-link">
                        <i class="fas fa-archive"></i><span>Supplier</span>
                    </a>
                </li>

                <li class="menu-header">Laporan</li>
                <li class="nav-item @yield('active_laporan')">
                    <a href="{{ route('laporan.index') }}" class="nav-link">
                        <i class="fas fa-file-alt"></i><span>Laporan</span>
                    </a>
                </li>
            @elseif (auth()->user()->role == 2)
                <li class="menu-header">Transaksi</li>
                <li class="nav-item @yield('active_trans')">
                    <a href="{{ route('kasir.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i><span>Transaksi</span>
                    </a>
                </li>

                <li class="menu-header">History</li>
                <li class="nav-item @yield('active_history')">
                    <a href="{{ route('index-history') }}" class="nav-link">
                        <i class="fa fa-history"></i><span>History</span>
                    </a>
                </li>

                <li class="menu-header">Produk</li>
                <li class="nav-item @yield('active_produk')">
                    <a href="{{ route('produk.index') }}" class="nav-link">
                        <i class="fas fa-dice-d6"></i><span>Produk</span>
                    </a>
                </li>

                <li class="menu-header">Supplier</li>
                <li class="nav-item @yield('active_supplier')">
                    <a href="{{ route('supplier.index') }}" class="nav-link">
                        <i class="fas fa-archive"></i><span>Supplier</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>
