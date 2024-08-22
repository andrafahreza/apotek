@extends('front.layouts.app')

@section('content')
    <!--    featured-area-start-->
    <div class="featured-area position-relative">
        <img src="/front/assets/img/homepage2/pluse-2.png" alt="" class="pluse-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3>Produk</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured-teb">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">Semua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Obat dengan resep dokter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                                    role="tab" aria-controls="pills-contact" aria-selected="false">Obat tanpa resep dokter</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="inner-featured">
                                    <div class="row">
                                        @foreach ($obatDokter as $obat)
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <div class="single-featured">
                                                    <div class="singl-top position-relative">
                                                        <div class="feet-img">
                                                            <img src="{{ $obat->photo }}" alt="">
                                                        </div>
                                                        <span style="width: auto; padding-right: 5px; padding-left: 5px;">{{ $obat->jenis_obat }} </span>
                                                    </div>
                                                    <div class="fecure-containt">
                                                        <h3>{{ $obat->nama_obat }}</h3>
                                                        <h5>{!! $obat->keterangan !!}</h5>
                                                        <h4>Rp. {{ number_format($obat->harga) }}</h4>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('beli', ['id' => $obat->id]) }} @endif" class="theme-btn">Beli</a>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('pesan', ['id' => $obat->id]) }} @endif" class="theme-btn">Pesan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach ($obatBiasa as $obat)
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <div class="single-featured">
                                                    <div class="singl-top position-relative">
                                                        <div class="feet-img">
                                                            <img src="{{ $obat->photo }}" alt="">
                                                        </div>
                                                        <span style="width: auto; padding-right: 5px; padding-left: 5px;">{{ $obat->jenis_obat }} </span>
                                                    </div>
                                                    <div class="fecure-containt">
                                                        <h3>{{ $obat->nama_obat }}</h3>
                                                        <h5>{!! $obat->keterangan !!}</h5>
                                                        <h4>Rp. {{ number_format($obat->harga) }}</h4>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('beli', ['id' => $obat->id]) }} @endif" class="theme-btn">Beli</a>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('pesan', ['id' => $obat->id]) }} @endif" class="theme-btn">Pesan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="inner-featured">
                                    <div class="row">
                                        @foreach ($obatDokter as $obat)
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <div class="single-featured">
                                                    <div class="singl-top position-relative">
                                                        <div class="feet-img">
                                                            <img src="{{ $obat->photo }}" alt="">
                                                        </div>
                                                        <span style="width: auto; padding-right: 5px; padding-left: 5px;">{{ $obat->jenis_obat }} </span>
                                                    </div>
                                                    <div class="fecure-containt">
                                                        <h3>{{ $obat->nama_obat }}</h3>
                                                        <h5>{!! $obat->keterangan !!}</h5>
                                                        <h4>Rp. {{ number_format($obat->harga) }}</h4>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('beli', ['id' => $obat->id]) }} @endif" class="theme-btn">Beli</a>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('pesan', ['id' => $obat->id]) }} @endif" class="theme-btn">Pesan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="inner-featured">
                                    <div class="row">
                                        @foreach ($obatBiasa as $obat)
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <div class="single-featured">
                                                    <div class="singl-top position-relative">
                                                        <div class="feet-img">
                                                            <img src="{{ $obat->photo }}" alt="">
                                                        </div>
                                                        <span style="width: auto; padding-right: 5px; padding-left: 5px;">{{ $obat->jenis_obat }} </span>
                                                    </div>
                                                    <div class="fecure-containt">
                                                        <h3>{{ $obat->nama_obat }}</h3>
                                                        <h5>{!! $obat->keterangan !!}</h5>
                                                        <h4>Rp. {{ number_format($obat->harga) }}</h4>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('beli', ['id' => $obat->id]) }} @endif" class="theme-btn">Beli</a>
                                                        <a href="@if (!Auth::check()) {{ route('login') }} @else {{ route('pesan', ['id' => $obat->id]) }} @endif" class="theme-btn">Pesan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    featured-area-end-->

@endsection
