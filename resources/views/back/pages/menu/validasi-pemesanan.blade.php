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
                                <input id="search" type="text" placeholder="Cari User...">
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
                            <th scope="col">User</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Status</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->keranjang->obat as $obat)
                                            <li>- {{ $obat->obat->nama_obat }} ({{ $obat->kuantiti }} pcs)
                                                @if ($item->status == "menunggu")
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="kurangObat({{ $obat->id }})" id="btnKurangiObat">-</button>
                                                    <button type="button" class="btn btn-sm btn-success" onclick="tambahObat({{ $obat->id }})" id="btnTambahObat">+</button>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($item->keranjang->obat as $obat)
                                            <li>- {{ $obat->obat->stok->where('tgl_kadaluarsa', '>', now())->sum('jumlah_obat') }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>Rp. {{ number_format($item->keranjang->obat->sum('total_harga')) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    @if ($item->status == "menunggu")
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
                            <form action="{{ route('validasi-pemesanan-tolak') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="tolak_id">
                                <textarea class="form-control" name="alasan_penolakan" placeholder="Masukkan alasan penolakan" required></textarea> <br>
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
                            <form action="{{ route('validasi-pemesanan-terima') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="terima_id">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade kurangObat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Kurangi Obat!</h4>
                        <p class="text-muted mb-4"> Yakin ingin mengurangi obat pembeli ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('validasi-pemesanan-kurang-obat') }}" method="POST">
                                @csrf
                                <input class="form-control" name="kurang" required placeholder="Masukkan jumlah obat yang dikurangi">
                                <br>
                                <input type="hidden" name="id" id="kurang_obat_id">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade tambahObat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Tambah Obat!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menambah obat pembeli ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('validasi-pemesanan-tambah-obat') }}" method="POST">
                                @csrf
                                <input class="form-control" name="tambah" required placeholder="Masukkan jumlah obat yang ditambah">
                                <br>
                                <input type="hidden" name="id" id="tambah_obat_id">
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

        function kurangObat(id) {
            $('#kurang_obat_id').val(id);
            $('.kurangObat').modal('toggle');
        }

        function tambahObat(id) {
            $('#tambah_obat_id').val(id);
            $('.tambahObat').modal('toggle');
        }

        $('#btnSearch').on('click', function() {
            var search = $('#search').val();
            var url = "{{ route('validasi-pemesanan') }}" + "/" + search;
            window.location = url;
        })
    </script>
@endpush
