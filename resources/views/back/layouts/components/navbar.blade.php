<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a href="{{ route('home') }}"><img src="/front/assets/logo.png" alt style="width: 100px;"></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li class="side_menu_title">
            <span>MENU</span>
        </li>
        <li class="@if ($title == 'beranda') mm-active @endif">
            <a href="{{ route('home') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Beranda</span>
            </a>
        </li>
        <li class="@if ($title == 'pembelian') mm-active @endif">
            <a href="{{ route('pembelian') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Pembelian</span>
            </a>
        </li>
        <li class="@if ($title == 'penjualan') mm-active @endif">
            <a href="{{ route('penjualan') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Penjualan</span>
            </a>
        </li>

        <li class="@if ($title == 'transaksi-pembelian' || $title == 'transaksi-penjualan') mm-active @endif">
            <a class="has-arrow" href="#" aria-expanded="false">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Transaksi</span>
            </a>
            <ul>
                <li><a class="@if ($title == 'transaksi-pembelian') active @endif" href="{{ route('transaksi-pembelian') }}">Pembelian</a></li>
                <li><a class="@if ($title == 'transaksi-penjualan') active @endif" href="{{ route('transaksi-penjualan') }}">Penjualan</a></li>
            </ul>
        </li>

        <li class="@if ($title == 'validasi') mm-active @endif">
            <a href="{{ route('validasi-penjualan') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Validasi Penjualan</span>
            </a>
        </li>

        <li class="side_menu_title">
            <span>DATA MASTER</span>
        </li>
        <li class="@if ($title == 'pemasok') mm-active @endif">
            <a href="{{ route('pemasok') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Pemasok</span>
            </a>
        </li>
        <li class="@if ($title == 'obat') mm-active @endif">
            <a href="{{ route('obat') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Obat</span>
            </a>
        </li>
        <li class="@if ($title == 'akun') mm-active @endif">
            <a href="{{ route('akun') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Akun</span>
            </a>
        </li>
        <li class="@if ($title == 'pengaturan') mm-active @endif">
            <a href="{{ route('pengaturan') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Pengaturan</span>
            </a>
        </li>
        <li class="@if ($title == 'rekening') mm-active @endif">
            <a href="{{ route('rekening') }}">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Rekening</span>
            </a>
        </li>
    </ul>
</nav>
