@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Pembelian</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            <div class="search_field">
                                <input id="search" type="text" placeholder="Cari No Pembelian...">
                            </div>
                            <button type="button" id="btnSearch"> <i class="ti-search"></i> </button>
                        </div>
                    </div>
                    <div class="add_button ms-2">
                        <button class="btn_1" id="btnTambah">+ Tambah</button>
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
                            <th scope="col">Pemasok</th>
                            <th scope="col">Nama Obat</th>
                            <th scope="col">Jumlah Obat</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->no_pembelian }}</td>
                                <td>{{ $item->pemasok->nama_pemasok }}</td>
                                <td>{{ $item->obat->nama_obat }}</td>
                                <td>{{ $item->jumlah_obat }}</td>
                                <td>{{ $item->total_bayar }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="detail({{ $item->id }})" id="btnDetail">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade modalForm" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="{{ route('pembelian-simpan') }}" method="POST" id="formData">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Simpan Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errorMessage d-none">
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong>  <span id="spanError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nomor Pembelian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_pembelian" id="no_pembelian" placeholder="Masukkan Nomor Pembelian" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Pemasok <span class="text-danger">*</span></label>
                                <select class="form-control" name="pemasok_id" id="pemasok_id" required>
                                    <option value="">Pilih Pemasok</option>
                                    @foreach ($pemasok as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_pemasok }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Obat <span class="text-danger">*</span></label>
                                <select class="form-control" name="obat_id" id="obat_id" required>
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_obat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jumlah Obat <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="jumlah_obat" id="jumlah_obat" placeholder="Masukkan Jumlah Obat" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tgl_kadaluarsa" id="tgl_kadaluarsa" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Total Bayar <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="total_bayar" id="total_bayar" placeholder="Masukkan Total Bayar" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="footerPembelian">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Tutup</a>
                        <button type="submit" class="btn btn-primary ">Simpan</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('scripts')
    <script>
        $('#btnTambah').on('click', function() {
            $('#formData')[0].reset();
            $('#errorMessage').addClass('d-none');
            $("#formData :input").prop("disabled", false);
            $('.modalForm').modal('toggle');
            $('#footerPembelian').removeClass('d-none');
        })

        $('#btnSearch').on('click', function() {
            var search = $('#search').val();
            var url = "{{ route('pembelian') }}" + "/" + search;
            window.location = url;
        })

        function detail(id) {
            console.log('asd');
            $('#formData')[0].reset();
            var url = "{{ route('pembelian-show') }}" + "/" + id;

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('.modalForm').modal('toggle');
                        $('#errorMessage').addClass('d-none');
                        $("#formData :input").prop("disabled", true);
                        $('#footerPembelian').addClass('d-none');

                        const data = response.data;
                        $('#formData')[0].reset();
                        $('#no_pembelian').val(data.no_pembelian);
                        $('#pemasok_id').val(data.pemasok_id);
                        $('#obat_id').val(data.obat_id);
                        $('#jumlah_obat').val(data.jumlah_obat);
                        $('#tgl_kadaluarsa').val(data.tgl_kadaluarsa);
                        $('#total_bayar').val(data.total_bayar);
                    } else {
                        $("#formData :input").prop("disabled", true);
                        $('#errorMessage').removeClass('d-none');
                        $('#spanError').text(response.message);
                    }
                },
                error: function(response) {
                    $("#formData :input").prop("disabled", true);
                    $('#errorMessage').removeClass('d-none');
                    $('#spanError').text(response.message);
                }
            });
        }
    </script>
@endpush
