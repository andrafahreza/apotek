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
                            <th scope="col">Obat</th>
                            <th scope="col">Total harga</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->keranjang->obat as $obat)
                                            <li>- {{ $obat->obat->nama_obat }} ({{ $obat->kuantiti }} pcs)</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>Rp. {{ number_format($item->keranjang->obat->sum('total_harga')) }}</td>
                                <td>
                                    {{ $item->status }}
                                    @if ($item->status == "ditolak")
                                        <br> Ket: {{ $item->alasan_penolakan }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
