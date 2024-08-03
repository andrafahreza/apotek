@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Rekening</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">

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
                            <th scope="col">Nama Rekening</th>
                            <th scope="col">No Rekening</th>
                            <th scope="col">Atas Nama</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->nama_rekening }}</td>
                                <td>{{ $item->no_rekening }}</td>
                                <td>{{ $item->atas_nama }}</td>
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
                <form action="{{ route('rekening-simpan') }}" method="POST" id="formData">
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
                                <label>Nama Bank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_rekening" id="nama_rekening" placeholder="Masukkan Nama Bank" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>No Rekening <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_rekening" id="no_rekening" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Atas Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="atas_nama" id="atas_nama" required>
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
                            <form action="{{ route('rekening-hapus') }}" method="POST">
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

        function detail(id) {
            $('#formData')[0].reset();
            var url = "{{ route('rekening-show') }}" + "/" + id;

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
                        $('#formData').attr("action", "{{ route('rekening-simpan') }}" + "/" + data.id);
                        $('#nama_rekening').val(data.nama_rekening);
                        $('#no_rekening').val(data.no_rekening);
                        $('#atas_nama').val(data.atas_nama);
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
