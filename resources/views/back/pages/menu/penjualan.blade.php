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
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('jual') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Nama Obat <span class="text-danger">*</span></label>
                                            <select class="form-control" name="obat_id" id="obat" required>
                                                <option value="">Pilih Obat</option>
                                                @foreach ($obat as $item)
                                                    <option value="{{ $item->id }}">#{{ $item->id }} - {{ $item->nama_obat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Nomor Pembelian <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="nomor_pembelian" required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Stok Obat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="stok" id="stok" readonly>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Jumlah Obat <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="jumlah_obat" id="jumlah_obat" required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Total Bayar <span class="text-danger">*</span></label>
                                            <input type="hidden" id="harga">
                                            <input type="number" class="form-control" name="total_bayar" id="total_bayar" readonly>
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
                                            <label>Bukti Pembayaran <br> <small>Isi jika melakukan pembayaran via transfer</small></label>
                                            <input type="file" class="form-control" name="bukti_transfer">
                                            <br>
                                            <button class="btn btn-primary" type="submit">simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </script>
@endpush
