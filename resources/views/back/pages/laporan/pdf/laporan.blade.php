<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        table {
            font-size: 14px;
        }

        .table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .table thead th {
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 1px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

    </style>
</head>

<body>
    <span> Tanggal : {{ date('d-m-Y', strtotime($from)) }} s/d {{ date('d-m-Y', strtotime($to)) }} </span>
    @if ($jenis == "obat")
        <table class="table table-bordered table-striped" style="text-align: center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id Obat</th>
                    <th>Nama Obat</th>
                    <th>Stok</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama_obat }}</td>
                        <td>{{ number_format($item->stok->sum('jumlah_obat')) }}</td>
                        <td>Rp. {{ number_format($item->harga) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif ($jenis == "pembelian")
        <table class="table table-bordered table-striped" style="text-align: center">
            <thead>
                <tr>
                    <th>No Pembelian</th>
                    <th>Obat</th>
                    <th>Pemasok</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Kadaluarsa</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $item->no_pembelian }}</td>
                        <td>{{ $item->obat->nama_obat }}</td>
                        <td>{{ $item->pemasok->nama_pemasok }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($item->persediaan->tgl_masuk)) }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($item->persediaan->tgl_kadaluarsa)) }}</td>
                        <td>Rp. {{ number_format($item->total_bayar) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif ($jenis == "penjualan")
        <table class="table table-bordered table-striped" style="text-align: center">
            <thead>
                <tr>
                    <th>No Pembelian</th>
                    <th>Obat</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($data as $key => $item)
                @php
                    $total += $item->keranjang->obat->sum('total_harga');
                @endphp
                    <tr>
                        <td>{{ $item->nomor_pembelian }}</td>
                        <td>
                            <ul>
                                @foreach ($item->keranjang->obat as $obat)
                                    <li>- {{ $obat->obat->nama_obat }} ({{ $obat->kuantiti }} pcs)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp. {{ number_format($item->keranjang->obat->sum('total_harga')) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total Pembayaran</td>
                    <td>Rp. {{ number_format($total) }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
    <br> <br>

    <table style="width: 100%">
        <tr>
            <td style="text-align: right; font-size: 17px;">Medan, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;">Apoteker</td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;"><br><br><br></td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        </tr>
    </table>
</body>

</html>
