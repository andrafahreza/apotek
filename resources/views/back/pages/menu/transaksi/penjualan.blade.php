@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Penjualan</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            <div class="search_field">
                                <input id="search" type="text" placeholder="Cari No Penjualan...">
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
                            <th scope="col">Nomor Pembelian</th>
                            <th scope="col">User</th>
                            <th scope="col">Obat</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($penjualan as $item)
                            @php
                                $total += $item->keranjang->obat->sum('total_harga');
                            @endphp
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $item->nomor_pembelian }}</td>
                                <td>#{{ $item->user->id }} - {{ $item->user->name }}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->keranjang->obat as $obat)
                                            <li>- {{ $obat->obat->nama_obat }} ({{ $obat->kuantiti }} pcs)</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    Rp. {{ number_format($item->keranjang->obat->sum('total_harga')) }} <br>
                                    <a href="{{ route('cetak-struk', ['id' => $item->id]) }}" target="_blank">Cetak Struk</a>
                                </td>
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
                    <tfoot>
                        <tr>
                            <td colspan="4">Total Pembayaran</td>
                            <td colspan="2">Rp. {{ number_format($total) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btnSearch').on('click', function() {
            var search = $('#search').val();
            var url = "{{ route('transaksi-penjualan') }}" + "/" + search;
            window.location = url;
        })
    </script>
@endpush
