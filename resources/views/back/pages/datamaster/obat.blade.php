@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Obat</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            <div class="search_field">
                                <input id="search" type="text" placeholder="Cari Obat...">
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
                            <th scope="col">Nama Obat</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>
                                    {{ $item->nama_obat }}
                                    <br>
                                    <a href="{{ $item->photo }}" target="_blank">
                                        <img src="{{ $item->photo }}" width="200">
                                    </a>
                                </td>
                                <td>{{ $item->jenis_obat }}</td>
                                <td>Rp. {{ number_format($item->harga) }}</td>
                                <td>{!! $item->keterangan !!}</td>
                                <td>
                                    <a class="btn btn-sm btn-success text-white" href="{{ route('obat-stok', ['id' => $item->id]) }}">
                                        {{ number_format($item->stok->sum('jumlah_obat')) }}
                                    </a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="detail({{ $item->id }})" id="btnDetail">Detail</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
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
                <form action="{{ route('obat-simpan') }}" method="POST" id="formData" enctype="multipart/form-data">
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
                                <label>Nama Obat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Masukkan Nama Obat" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Photo Obat <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="photo" id="photo" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jenis <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenis_obat" id="jenis_obat" required>
                                    <option value="">Pilih Jenis Obat</option>
                                    <option value="obat dengan resep dokter">Obat dengan resep dokter</option>
                                    <option value="obat tanpa resep dokter">Obat tanpa resep dokter</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Tipe <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipe_obat" id="tipe_obat" required>
                                    <option value="">Pilih Tipe Obat</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Cair">Cair</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Oles">Oles</option>
                                    <option value="Tetes">Tetes</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="harga" id="harga" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Keterangan Obat <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Tutup</a>
                        <button type="submit" class="btn btn-primary ">Simpan</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade hapus" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Hapus Data!</h4>
                        <p class="text-muted mb-4"> Yakin ingin menghapus ini? </p>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('obat-hapus') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="hapus_id">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
        $('#btnTambah').on('click', function() {
            $('#formData')[0].reset();
            $('#errorMessage').addClass('d-none');
            $("#formData :input").prop("disabled", false);
            $('.modalForm').modal('toggle');
        })

        $('#btnSearch').on('click', function() {
            var search = $('#search').val();
            var url = "{{ route('obat') }}" + "/" + search;
            window.location = url;
        })

        function detail(id) {
            $('#formData')[0].reset();
            var url = "{{ route('obat-show') }}" + "/" + id;

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('.modalForm').modal('toggle');
                        $('#errorMessage').addClass('d-none');
                        $("#formData :input").prop("disabled", false);

                        const data = response.data;
                        $('#formData')[0].reset();
                        $('#formData').attr("action", "{{ route('obat-simpan') }}" + "/" + data.id);
                        $('#nama_obat').val(data.nama_obat);
                        $('#jenis_obat').val(data.jenis_obat);
                        $('#harga').val(data.harga);
                        $('#keterangan').val(data.keterangan);
                        $('#tipe_obat').val(data.tipe_obat);
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

        function hapus(id) {
            $('#hapus_id').val(id);
            $('.hapus').modal('toggle');
        }
    </script>
@endpush
