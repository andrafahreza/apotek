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
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">No Pembelian</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Obat</th>
                                <th scope="col">Total Bayar</th>
                                <th scope="col">Status Pembayaran</th>
                                <th scope="col">Status Pembelian</th>
                                <th scope="col">Kurir</th>
                                <th scope="col">Aksi</th>
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
                                    <td>{{ $item->alamat }} <br> Ongkir: Rp. {{ number_format($item->ongkir) }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($item->keranjang->obat as $obat)
                                                <li>- {{ $obat->obat->nama_obat }} ({{ $obat->kuantiti }} pcs)</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>Rp. {{ number_format($item->keranjang->obat->sum('total_harga') + $item->ongkir) }}</td>
                                    <td>
                                        @if ($item->status_pembayaran == "ditolak")
                                            ditolak <br>
                                            keterangan: {{ $item->keterangan }}
                                        @else
                                            {{ $item->status_pembayaran }}
                                        @endif
                                        <br>
                                        <a href="{{ $item->bukti_transfer }}" target="_blank">Lihat Bukti</a>
                                    </td>
                                    <td>
                                        {{ $item->status_pembelian }}
                                        @if ($item->status_pembelian == "sukses")
                                            <br>
                                            <a href="{{ route('cetak-struk', ['id' => $item->id]) }}" target="_blank">Cetak Struk</a>
                                        @endif
                                    </td>
                                    <td>{{ $item->kurir }}</td>
                                    <td>
                                        @if ($item->status_ongkir == "diterima")
                                            @if ($item->bukti_transfer == null)
                                                <a href="{{ route('beli', ['id' => $item->keranjang_id]) }}" class="btn btn-sm btn-primary">Pembayaran</a>
                                            @endif
                                        @elseif ($item->status_ongkir == "menunggu")
                                            <span>Menunggu inputan ongkir</span>
                                        @endif
                                        @if ($item->status_pembayaran == "diterima" && $item->status_pembelian == "diantar")
                                            <button type="button" class="btn btn-sm btn-primary" onclick="konfirmasi({{ $item->id }})">Konfirmasi</button>
                                        @endif
                                        @if ($item->status_pembayaran == "ditolak")
                                            <a href="{{ $item->bukti_transfer_kembali }}" target="_blank">Lihat bukti refund</a>
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
</div>

<div class="modal fade konfirmasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                <div class="mt-4">
                    <h4 class="mb-3">Konfirmasi Pembelian!</h4>
                    <p class="text-muted mb-4"> Pastikan pembelian anda telah anda terima </p>
                    <div class="hstack gap-2 justify-content-center">
                        <form action="{{ route('konfirmasi-pembelian') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="konfirmasi_id">
                            <button type="submit" class="btn btn-success">Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection

@push('scripts')
    <script>
        function konfirmasi(id) {
            $('#konfirmasi_id').val(id);
            $('.konfirmasi').modal('toggle');
        }
    </script>
@endpush
