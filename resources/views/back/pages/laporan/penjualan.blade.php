@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Obat</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        {{-- <div class="search_inner"> --}}
                            Dari <input id="from" type="date"> &nbsp; s/d
                            <input id="to" type="date">
                        {{-- </div> --}}
                    </div>
                    <div class="add_button ms-2">
                        <button class="btn_1" id="btnCetak">Cetak Laporan</button>
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
                            <th scope="col">Nomor Pembelian</th>
                            <th scope="col">User</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Jumlah Obat</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->nomor_pembelian }}</td>
                                <td>#{{ $item->user->id }} - {{ $item->user->name }}</td>
                                <td>
                                    {{ $item->obat->nama_obat }}
                                    <br>
                                    <a href="{{ $item->obat->photo }}" target="_blank">
                                        <img src="{{ $item->obat->photo }}" width="200">
                                    </a>
                                </td>
                                <td>{{ $item->jumlah_obat }}</td>
                                <td>Rp. {{ number_format($item->total_bayar) }}</td>
                                <td>
                                    {{ strtoupper($item->pembayaran) }}
                                    @if ($item->pembayaran == "transfer")
                                        <br>
                                        <a href="{{ $item->bukti_transfer }}" target="_blank">
                                            <img src="{{ $item->bukti_transfer }}" width="200">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btnCetak').on('click', function() {
            var from = $('#from').val();
            var to = $('#to').val();
            var url = "{{ route('cetak-laporan') }}/" + from + "/" + to + "/penjualan";
            console.log(url);

            window.open(url, '_blank');
        });
    </script>
@endpush
