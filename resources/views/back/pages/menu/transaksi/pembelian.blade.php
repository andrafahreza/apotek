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
                                <input id="search" type="text" placeholder="Cari...">
                            </div>
                            <button type="button" id="btnSearch"> <i class="ti-search"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="QA_table mb_30">
                <table class="table lms_table_active nowrap">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">No Pembelian</th>
                            <th scope="col">Pemasok</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Jumlah Obat</th>
                            <th scope="col">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->no_pembelian }}</td>
                                <td>#{{ $item->pemasok->id }} - {{ $item->pemasok->nama_pemasok }}</td>
                                <td>
                                    {{ $item->obat->nama_obat }}
                                    <br>
                                    <a href="{{ $item->obat->photo }}" target="_blank">
                                        <img src="{{ $item->obat->photo }}" width="200">
                                    </a>
                                </td>
                                <td>{{ $item->jumlah_obat }}</td>
                                <td>Rp. {{ number_format($item->total_bayar) }}</td>
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
        $('#btnSearch').on('click', function() {
            var search = $('#search').val();
            var url = "{{ route('transaksi-pembelian') }}" + "/" + search;
            window.location = url;
        })
    </script>
@endpush
