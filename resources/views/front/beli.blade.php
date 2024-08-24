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
                                <form action="{{ route('pembayaran-customer') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="obat_id" value="{{ $obat->id }}">
                                    <input type="hidden" name="stok" value="{{ $stok }}">
                                    <div class="single-re-input">
                                        <label for="jumlah_obat">Jumlah Pembelian*</label>
                                        <input type="number" min="1" max="{{ $stok }}" name="jumlah_obat"
                                            id="jumlah_obat" required>
                                    </div>
                                    <div class="single-re-input">
                                        <label for="total_bayar">Total Bayar*</label>
                                        <input type="number" name="total_bayar" id="total_bayar" readonly>
                                    </div>
                                    <div class="single-re-input">
                                        <label for="total_bayar">Bukti Pembayaran*</label>
                                        <input type="file" name="bukti_transfer" id="bukti_transfer" required>
                                        <br>
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
@endsection

@push('scripts')
    <script>
        $('#jumlah_obat').keyup(function() {
            var value = $('#jumlah_obat').val();
            var total = value * "{{ $obat->harga }}";
            $('#total_bayar').val(total);
        })
    </script>
@endpush
