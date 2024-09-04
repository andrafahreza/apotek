@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Input Penjualan</h4>
            </div>
            <div class="QA_table mb_30">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('tambah-keranjang') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Nama Obat <span class="text-danger">*</span></label>
                                            <select class="form-control" name="obat_id" id="obat" required>
                                                <option value="">Pilih Obat</option>
                                                @foreach ($obat as $item)
                                                    <option value="{{ $item->id }}">#{{ $item->id }} -
                                                        {{ $item->nama_obat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Stok Obat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="stok" id="stok"
                                                readonly>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Jumlah Obat <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="total" id="jumlah_obat"
                                                required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Total Harga <span class="text-danger">*</span></label>
                                            <input type="hidden" id="harga">
                                            <input type="number" class="form-control" name="total_bayar" id="total_bayar"
                                                readonly>
                                            <br>
                                            <button class="btn btn-primary" type="submit">Tambah Keranjang</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Keranjang</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Obat</th>
                                                <th>Harga</th>
                                                <th>Kuantiti</th>
                                                <th>Total</th>
                                                <th></th>
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
                                                        <td style="text-align: center">Rp.
                                                            {{ number_format($obat->obat->harga) }}</td>
                                                        <td style="text-align: center">{{ $obat->kuantiti }}</td>
                                                        <td style="text-align: center">Rp.
                                                            {{ number_format($obat->total_harga) }}</td>
                                                        <td style="text-align: center"><button type="button"
                                                                class="btn btn-danger" onclick="hapus({{ $obat->id }})">X</button></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total Harga</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right; font-weight:bold">Rp.
                                                    {{ number_format($totalHarga) }}</td>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="row">
                                    @if ($data != null)
                                        <form action="{{ route('jual') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="keranjang_id" value="{{ $data->id }}">
                                            <div class="col-md-12 mt-4">
                                                <label>Nomor Pembelian <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nomor_pembelian" required>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <label>Pembayaran <span class="text-danger">*</span></label>
                                                <select class="form-control" name="pembayaran" required>
                                                    <option value="">Pilih Pembayaran</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="transfer">Transfer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <label>Bukti Pembayaran <br> <small>Isi jika melakukan pembayaran via
                                                        transfer</small></label>
                                                <input type="file" class="form-control" name="bukti_transfer">
                                                <br>
                                                <button class="btn btn-primary" type="submit">Bayar</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
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
        $('#obat').on('change', function() {
            var id = $(this).val();

            if (id != "" && id != null) {
                var url = "{{ route('obat-show') }}" + "/" + id;
                var urlstok = "{{ route('obat-show-stok') }}" + "/" + id;

                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            const data = response.data;
                            var jumlah_obat = $('#jumlah_obat').val();
                            var total = data.harga * jumlah_obat;


                            $('#harga').val(data.harga);
                            $('#total_bayar').val(total);
                        } else {
                            alert('gagal mendapatkan data obat, silahkan refresh halaman');
                        }
                    },
                    error: function(response) {
                        alert(response.message);
                    }
                });

                $.ajax({
                    type: "get",
                    url: urlstok,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.alert == '1') {
                            const data = response.data;

                            $('#stok').val(data);
                        } else {
                            alert('gagal mendapatkan data obat, silahkan refresh halaman');
                        }
                    },
                    error: function(response) {
                        alert(response.message);
                    }
                });

            } else {
                $('#total_bayar').val("");
            }
        })

        $('#jumlah_obat').keyup(function() {
            var value = $('#jumlah_obat').val();
            var total = value * $('#harga').val();
            $('#total_bayar').val(total);
        })

        function hapus(id) {
            $('#hapus_id').val(id);
            $('.hapus').modal('toggle');
        }
    </script>
@endpush
