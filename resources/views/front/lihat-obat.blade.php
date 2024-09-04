@extends('front.layouts.app')

@section('content')
    <div class="shop-area">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>  {{ $errors->first() }}
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong>  {{ Session::get('success'); }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-5">
                    <div class="zoom-img">
                        <img src="{{ $obat->photo }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="zoom-containt">
                        <div class="zoom-containt-top">
                            <h3>{{ $obat->nama_obat }}</h3>
                            <span>Rp. {{ number_format($obat->harga) }}</span>
                        </div>
                        <div class="zoom-containt-bottom">
                            <p>{!! $obat->keterangan !!}</p>
                            <div class="zoom-df zomm-ll">
                                <h3>Stok: {{ $stok }}</h3>
                                <h3>Tipe Obat: {{ $obat->tipe_obat }}</h3>
                            </div>
                            <div class="re-form">
                                <form action="{{ route('tambah-keranjang') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="obat_id" value="{{ $obat->id }}">
                                    <input type="hidden" name="stok" value="{{ $stok }}">

                                    Total Pembelian <input type="number" class="form-control" name="total" min="1" max="{{ $stok }}">
                                    <button class="team-1 mt-2" type="submit">Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
