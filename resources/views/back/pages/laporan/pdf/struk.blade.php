<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .receipt {
            width: 100%;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }
        .sub_title {
            text-align: center;
            font-size: 10px;
            margin-bottom: 20px;
        }
        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="title">Apotek Fortuna</div>
        <div class="sub_title">Jl. Setiabudi No.418F. Psr. 4, Kel. Tanjung Sari, Kec. Medan Selayang Kota Medan. Sumatera Utara</div>
        <table style="border: 0px; width: 100%">
            @foreach ($data->keranjang->obat as $obat)
                <tr>
                    <td style="width: 50%">{{ $obat->obat->nama_obat }}</td>
                    <td style="width: 50%; text-align: right">Rp. {{ number_format($obat->total_harga) }}</td>
                </tr>
            @endforeach
        </table>
        <div class="total">
            Total: Rp. {{ number_format($data->keranjang->obat->sum('total_harga')) }}
        </div>
        <br><br><br>
        <center>
            Terimakasih
        </center>
    </div>
</body>
</html>
