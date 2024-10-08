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
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center">Obat</th>
                            <th scope="col" style="text-align: center">Harga</th>
                            <th scope="col" style="text-align: center">Kuantiti</th>
                            <th scope="col" style="text-align: center">Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp
                        @if ($data != null)
                            @foreach ($data->obat as $obat)
                                @php $totalHarga += $obat->total_harga; @endphp
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{ $obat->obat->photo }}" width="100">
                                            </div>
                                            <div class="col-md-9">
                                                <span><b>{{ $obat->obat->nama_obat }}</b></span> <br>
                                                stok: {{ $obat->obat->stok->sum('jumlah_obat') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center">Rp. {{ number_format($obat->obat->harga) }}</td>
                                    <td style="text-align: center">{{ $obat->kuantiti }}</td>
                                    <td style="text-align: center">Rp. {{ number_format($obat->total_harga) }}</td>
                                    <td style="text-align: center"><button type="button" class="btn btn-danger" onclick="hapus({{ $obat->id }})">X</button></td>
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
            </div>
            <div class="col-md-12">
                <div class="text-right">
                    @if ($data != null)
                    <a href="{{ route('pesan', ['id' => $data->id]) }}" class="btn btn-success">Pesan</a>
                        <a href="{{ route('isi-alamat', ['id' => $data->id]) }}" class="btn btn-primary">Beli</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade hapus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                <div class="mt-4">
                    <h4 class="mb-3">Hapus isi keranjang!</h4>
                    <p class="text-muted mb-4"> Yakin ingin menghapus obat ini dari keranjang anda? </p>
                    <div class="hstack gap-2 justify-content-center">
                        <form action="{{ route('hapus-isi-keranjang') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="hapus_id">
                            <button type="submit" class="btn btn-danger">Ya</button>
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
        function hapus(id) {
            $('#hapus_id').val(id);
            $('.hapus').modal('toggle');
        }
    </script>
@endpush
