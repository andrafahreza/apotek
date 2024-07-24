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
        <li class="">
            <a href="#">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Penjualan</span>
            </a>
        </li>
        <li class="">
            <a href="#">
                <img src="/back/img/menu-icon/3.svg" alt>
                <span>Transaksi</span>
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
        <li class="">
            <a href="#">
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
    </ul>
</nav>
