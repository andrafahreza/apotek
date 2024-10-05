<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Pemesanan;
use App\Models\Penjualan;
use PDF;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetak($from = null, $to = null, $jenis = null)
    {
        if ($from == null || $to == null || $jenis == null) {
            abort(404);
        }

        if ($jenis == "obat") {
            $data = Obat::whereBetween('created_at', [$from, $to." 23:59"])->get();
            $pemesanan = null;
        } else if ($jenis == "pembelian") {
            $data = Pembelian::with(['pemasok', 'obat', 'persediaan'])->whereBetween('created_at', [$from, $to." 23:59"])->get();
            $pemesanan = null;
        } else if ($jenis == "penjualan") {
            $data = Penjualan::whereBetween('created_at', [$from, $to." 23:59"])->where('status_pembelian', 'sukses')->get();
            $pemesanan = Pemesanan::where('status', 'diterima')->whereBetween('created_at', [$from, $to." 23:59"])->get();
        } else {
            abort(404);
        }


        $pdf = PDF::loadView('back.pages.laporan.pdf.laporan', [
            'data' => $data,
            'from' => $from,
            'to' => $to,
            'jenis' => $jenis,
            'pemesanan' => $pemesanan
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        return $pdf->stream('laporan.pdf');
    }

    public function cetak_struk($id = null)
    {
        $penjualan = Penjualan::findOrFail($id);

        $pdf = PDF::loadView('back.pages.laporan.pdf.struk', [
            'data' => $penjualan,
        ])
        ->setPaper([0, 0, 226.77, 566.93])
        ->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        return $pdf->stream('struk.pdf');
    }

    public function obat()
    {
        $title = "laporan-obat";
        $data = Obat::get();

        return view('back.pages.laporan.obat', compact('data', 'title'));
    }

    public function pembelian()
    {
        $title = "laporan-pembelian";
        $data = Pembelian::get();

        return view('back.pages.laporan.pembelian', compact('data', 'title'));
    }

    public function penjualan()
    {
        $title = "laporan-penjualan";
        $data = Penjualan::get();

        return view('back.pages.laporan.penjualan', compact('data', 'title'));
    }
}
