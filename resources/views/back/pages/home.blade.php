@extends('back.layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="single_element">
            <div class="quick_activity">
                <div class="row">
                    <div class="col-12">
                        <div class="quick_activity_wrap">
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/man.svg" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($customer->count()) }}</span></h3>
                                    <p>Customer</p>
                                </div>
                            </div>
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/cap.svg" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($obat->count()) }}</span></h3>
                                    <p>Obat</p>
                                </div>
                            </div>
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/transaction.png" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($penjualan->count()) }}</span></h3>
                                    <p>Penjualan</p>
                                </div>
                            </div>
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/pharma.svg" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($pemasok->count()) }}</span></h3>
                                    <p>Pemasok</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="white_box card_height_100">
                            <div class="box_header border_bottom_1px">
                                <div class="main-title" style="width: 100%">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h3 class="mb_25">Kadaluarsa Obat</h3>
                                        </div>
                                        <div class="col-md-8">
                                            <form action="{{ route('home') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="date" name="from" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="date" name="to" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="btn btn-sm btn-primary">Cari</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Activity_timeline">
                                <ul>
                                    @if ($filter == "")
                                        @if ($persediaan->count() == 0)
                                            <li>
                                                <div class="activity_bell"></div>
                                                <div class="activity_wrap">
                                                    <h6>Tidak ada obat yang kadaluarsa dalam seminggu mendatang</h6>
                                                </div>
                                            </li>
                                        @else
                                            @php $no = 0; @endphp
                                            @foreach ($persediaan as $item)
                                                @if (strtotime(now() . '+7 days') >= strtotime($item->tgl_kadaluarsa) || strtotime(now()) > strtotime($item->tgl_kadaluarsa))
                                                    @php $no ++; @endphp
                                                    <li>
                                                        <div class="activity_bell"></div>
                                                        <div class="activity_wrap">
                                                            <h6>{{ $item->obat->nama_obat }}</h6>
                                                            <p>
                                                                - ID Pembelian : {{ $item->pembelian_id }} <br>
                                                                - Tgl Kadaluarsa : {{ date('d-m-Y', strtotime($item->tgl_kadaluarsa)) }} <br>
                                                                - Stok : {{ $item->jumlah_obat }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                            @if ($no == 0)
                                                <li>
                                                    <div class="activity_bell"></div>
                                                    <div class="activity_wrap">
                                                        <h6>Tidak ada obat yang kadaluarsa dalam seminggu mendatang</h6>
                                                    </div>
                                                </li>
                                            @endif
                                        @endif
                                    @else
                                        @if ($persediaan->count() == 0)
                                            <li>
                                                <div class="activity_bell"></div>
                                                <div class="activity_wrap">
                                                    <h6>Tidak ada obat yang kadaluarsa dalam waktu tersebut</h6>
                                                </div>
                                            </li>
                                        @else
                                            @php $no = 0; @endphp
                                            @foreach ($persediaan as $item)
                                                @php $no ++; @endphp
                                                <li>
                                                    <div class="activity_bell"></div>
                                                    <div class="activity_wrap">
                                                        <h6>{{ $item->obat->nama_obat }}</h6>
                                                        <p>
                                                            - ID Pembelian : {{ $item->pembelian_id }} <br>
                                                            - Tgl Kadaluarsa : {{ date('d-m-Y', strtotime($item->tgl_kadaluarsa)) }} <br>
                                                            - Stok : {{ $item->jumlah_obat }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                            @if ($no == 0)
                                                <li>
                                                    <div class="activity_bell"></div>
                                                    <div class="activity_wrap">
                                                        <h6>Tidak ada obat yang kadaluarsa dalam waktu tersebut</h6>
                                                    </div>
                                                </li>
                                            @endif
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
