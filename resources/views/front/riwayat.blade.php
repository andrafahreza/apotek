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
            <div class="col-lg-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">No Pembelian</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Jumlah Obat</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Status Pembelian</th>
                            <th scope="col">Kurir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>
                                    @if ($item->nomor_pembelian == "unknown")
                                        Belum dikonfirmasi
                                    @else
                                        {{ $item->nomor_pembelian }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->obat->nama_obat }}
                                </td>
                                <td>{{ $item->jumlah_obat }}</td>
                                <td>Rp. {{ number_format($item->total_bayar) }}</td>
                                <td>
                                    @if ($item->status_pembayaran == "ditolak")
                                        ditolak <br>
                                        keterangan: {{ $item->keterangan }}
                                    @else
                                        {{ $item->status_pembayaran }}
                                    @endif
                                </td>
                                <td>{{ $item->status_pembelian }}</td>
                                <td>{{ $item->kurir }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
