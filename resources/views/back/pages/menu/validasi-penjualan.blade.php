@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Validasi</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            <div class="search_field">
                                <input id="search" type="text" placeholder="Cari Email...">
                            </div>
                            <button type="button" id="btnSearch"> <i class="ti-search"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="QA_table mb_30">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>  {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong>  {{ Session::get('success'); }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <table class="table lms_table_active">
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
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>
                                    @if ($item->no_pembelian == "unknown")
                                        Belum dikonfirmasi
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
                                <td>
                                    @if ($item->status_pembelian == "menunggu")
                                        <button type="button" class="btn btn-sm btn-primary" onclick="terima({{ $item->id }})" id="btnDetail">Terima</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="tolak({{ $item->id }})" id="btnTolak">Tolak</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade tolak" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Tolak Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menolak ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('validasi-tolak') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="tolak_id">
                                <textarea class="form-control" name="keterangan" placeholder="Masukkan alasan penolakan" required></textarea> <br>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade terima" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Terima Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menerima ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('validasi-terima') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="terima_id">
                                <input class="form-control" name="nomor_pembelian" placeholder="Masukkan Nomor Pembelian" required> <br>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
        function tolak(id) {
            $('#tolak_id').val(id);
            $('.tolak').modal('toggle');
        }

        function terima(id) {
            $('#terima_id').val(id);
            $('.terima').modal('toggle');
        }
    </script>
@endpush
