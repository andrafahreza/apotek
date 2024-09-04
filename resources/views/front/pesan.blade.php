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
                        <div class="card-header"><h1>Pemesanan</h1></div>
                        <div class="card-body">
                            <div class="zoom-containt">
                                <div class="zoom-containt-bottom">
                                    <div class="re-form">
                                        <form action="{{ route('pemesanan-customer-action') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="keranjang_id" value="{{ $data->id }}">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="text-align: center">Obat</th>
                                                        <th scope="col" style="text-align: center">Harga</th>
                                                        <th scope="col" style="text-align: center">Kuantiti</th>
                                                        <th scope="col" style="text-align: center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $totalHarga = 0; @endphp
                                                    @if ($data != null)
                                                        @foreach ($data->obat as $obat)
                                                            @php $totalHarga += $obat->total_harga; @endphp
                                                            <tr>
                                                                <td>
                                                                    <span><b>{{ $obat->obat->nama_obat }}</b></span> <br>
                                                                    stok: {{ $obat->obat->stok->sum('jumlah_obat') }}
                                                                </td>
                                                                <td style="text-align: center">Rp. {{ number_format($obat->obat->harga) }}</td>
                                                                <td style="text-align: center">{{ $obat->kuantiti }}</td>
                                                                <td style="text-align: center">Rp. {{ number_format($obat->total_harga) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right;">Total Harga</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right; font-weight:bold">Rp. {{ number_format($totalHarga) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <button class="team-1" type="submit">Pesan</button>
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
