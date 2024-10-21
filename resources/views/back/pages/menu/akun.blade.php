@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Akun</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            <div class="search_field">
                                <input id="search" type="text" placeholder="Cari Email...">
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
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Role</th>
                            <th scope="col">Alamat</th>
                            {{-- <th scope="col">Ongkir</th> --}}
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->alamat }}</td>
                                {{-- <td>
                                    @if ($item->ongkir == null)
                                        <button type="button" class="btn btn-sm btn-primary" onclick="ongkir({{ $item->id }})" id="btnOngkir">Masukkan ongkir</button>
                                    @else
                                        Rp. {{ number_format($item->ongkir) }}
                                    @endif
                                </td> --}}
                                <td>
                                    @if ($item->id != Auth::user()->id)
                                        <button type="button" class="btn btn-sm btn-primary" onclick="detail({{ $item->id }})" id="btnDetail">Detail</button>
                                        <a href="{{ route('akun-reset', ['id' => $item->id]) }}" class="btn btn-sm btn-warning" >Reset Password</a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapus({{ $item->id }})" id="btnHapus">Hapus</button>
                                    @endif
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
                <form action="{{ route('akun-simpan') }}" method="POST" id="formData">
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
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telepon" id="telepon" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Role<span class="text-danger">*</span></label>
                                <select class="form-control" name="role" id="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="customer">Customer</option>
                                    <option value="pemilik">Pemilik</option>
                                    <option value="pegawai">Pegawai</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Alamat<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat" id="alamat" required></textarea>
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
                            <form action="{{ route('akun-hapus') }}" method="POST">
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

    <div class="modal fade ongkir" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Ongkir Data!</h4>
                        <div class="hstack gap-2 justify-content-center">
                            <form action="{{ route('akun-ongkir') }}" method="POST">
                                @csrf
                                <input class="form-control" name="ongkir" required placeholder="masukkan jumlah ongkir">
                                <br>
                                <input type="hidden" name="id" id="ongkir_id">
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
            var url = "{{ route('akun') }}" + "/" + search;
            window.location = url;
        })

        function detail(id) {
            $('#formData')[0].reset();
            var url = "{{ route('akun-show') }}" + "/" + id;

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
                        $('#formData').attr("action", "{{ route('akun-simpan') }}" + "/" + data.id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#telepon').val(data.telepon);
                        $('#jenis_kelamin').val(data.jenis_kelamin);
                        $('#role').val(data.role);
                        $('#alamat').val(data.alamat);
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

        function ongkir(id) {
            $('#ongkir_id').val(id);
            $('.ongkir').modal('toggle');
        }
    </script>
@endpush
