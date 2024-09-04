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

            <div class="row content-justify-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h1>Pembayaran</h1></div>
                        <div class="card-body">
                            <div class="zoom-containt">
                                <div class="zoom-containt-bottom">
                                    <div class="re-form">
                                        <form action="{{ route('pembayaran-customer') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="keranjang_id" value="{{ $keranjang->id }}">
                                            <span style="font-weight: bold">Total Tagihan: Rp. {{ number_format($keranjang->obat->sum('total_harga')) }}</span>
                                            <div class="single-re-input">
                                                <label for="total_bayar">Bukti Pembayaran*</label>
                                                <input type="file" name="bukti_transfer" id="bukti_transfer" required>
                                                <ul>
                                                    @foreach ($rekening as $rek)
                                                        <li>{{ $rek->nama_rekening }} : {{ $rek->no_rekening }} Atas Nama {{ $rek->atas_nama }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="single-re-input">
                                                <label for="kurir">Kurir* <br> <small>Biaya kurir ditanggung oleh pembeli</small></label>
                                                <select class="form-control" name="kurir" required>
                                                    <option value="">Pilih Kurir</option>
                                                    <option value="Gojek">Gojek</option>
                                                    <option value="Maxim">Maxim</option>
                                                    <option value="Grab">Grab</option>
                                                </select>
                                            </div>
                                            <button class="team-1" type="submit">Beli</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
