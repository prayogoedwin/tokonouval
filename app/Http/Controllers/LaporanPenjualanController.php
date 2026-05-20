<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanPenjualanController extends Controller
{
    private function getPagedata()
    {

        $pagedata = [
            'title' => 'Laporan Penjualan',
            'tableaction' => false,
            'canCreate' => false,
            'columns' => [
                ['name' => 'toko_id', 'value' => 'toko',  'title' => 'Toko', 'type' => 'text', 'intable' => true],
                ['name' => 'produk_id', 'value' => 'produk',  'title' => 'Produk', 'type' => 'text', 'intable' => true],
                ['name' => 'harga_beli', 'value' => 'harga_beli',  'title' => 'Harga Beli', 'type' => 'number', 'intable' => true],
                ['name' => 'harga_jual', 'value' => 'harga_jual',  'title' => 'Harga Jual', 'type' => 'number', 'intable' => true],
                ['name' => 'terjual', 'value' => 'terjual',  'title' => 'Terjual', 'type' => 'number', 'intable' => true],
                ['name' => 'kas_masuk', 'value' => 'kas_masuk',  'title' => 'Kas Masuk', 'type' => 'number', 'intable' => true],
                ['name' => 'pendapatan', 'value' => 'pendapatan',  'title' => 'Pendapatan', 'type' => 'number', 'intable' => true],

            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        $pagedata = $this->getPagedata();

        // 1. Default dates: Start and end of the current month
        $startdate = Carbon::now()->startOfMonth()->toDateString(); // e.g., 2026-05-01
        $enddate = Carbon::now()->endOfMonth()->toDateString();     // e.g., 2026-05-31

        // 2. Override if custom date request exists
        if ($request->has(['startdate', 'enddate']) && $request->startdate != '' && $request->enddate != '') {
            // It's safer to parse using Carbon to ensure standard Y-m-d formatting
            $startdate = Carbon::parse($request->startdate)->toDateString();
            $enddate = Carbon::parse($request->enddate)->toDateString();
        }

        // // 3. Build the query
        // // We eager-load ('with') the product and its store (toko) to avoid N+1 query issues.
        // $penjualandetails = PenjualanDetail::with(['produk.toko'])
        //     ->whereHas('penjualan', function ($query) use ($startdate, $enddate) {
        //         // Filter based on the parent sale's transaction date
        //         $query->whereBetween('created_at', [
        //             $startdate . ' 00:00:00',
        //             $enddate . ' 23:59:59'
        //         ]);
        //     })
        //     ->get();

        // $produks = Produk::where('deleted_at', null)->get();

        // $laporan = [];
        // foreach($produks as $produk) {
        //     $terjual = $penjualandetails->where('produk_id', $produk->id)->sum('jumlah');
        //     $harga_beli = $produk->harga_beli;
        //     $harga_jual = $produk->harga_jual;
        //     $kas_masuk = $terjual * $harga_jual;
        //     $pendapatan = ($harga_jual - $harga_beli) * $terjual;

        //     // Simpan hasil perhitungan ke dalam array atau langsung ke database
        //     // Contoh menyimpan ke array:
        //     $laporan[] = [
        //         'toko_id' => $produk->toko->name,
        //         'produk_id' => $produk->name,
        //         'harga_beli' => $harga_beli,
        //         'harga_jual' => $harga_jual,
        //         'terjual' => $terjual,
        //         'kas_masuk' => $kas_masuk,
        //         'pendapatan' => $pendapatan,
        //     ];
        // }

        // dd($laporan);
        // dd($request->all(), $startdate, $enddate);

        if ($request->ajax()) {

            // 3. Build the query
            // We eager-load ('with') the product and its store (toko) to avoid N+1 query issues.
            $penjualandetails = PenjualanDetail::with(['produk.toko'])
                ->whereHas('penjualan', function ($query) use ($startdate, $enddate) {
                    // Filter based on the parent sale's transaction date
                    $query->whereBetween('created_at', [
                        $startdate . ' 00:00:00',
                        $enddate . ' 23:59:59'
                    ]);
                });

            

            $penjualandetails = $penjualandetails->get();

            $produks = Produk::where('deleted_at', null);

            if ($request->has('toko') && $request->toko != '') {
                $toko = $request->toko;
                $produks->whereHas('toko', function ($query) use ($toko) {
                    $query->where('id', $toko);
                });
            }

            $produks = $produks->get();

            $laporan = [];
            foreach ($produks as $produk) {
                $terjual = $penjualandetails->where('produk_id', $produk->id)->sum('jumlah');
                $harga_beli = $produk->harga_beli;
                $harga_jual = $produk->harga_jual;
                $kas_masuk = $terjual * $harga_jual;
                $pendapatan = ($harga_jual - $harga_beli) * $terjual;

                $laporan[] = [
                    'toko' => $produk->toko->name,
                    'produk' => $produk->name,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'terjual' => $terjual,
                    'kas_masuk' => $kas_masuk,
                    'pendapatan' => $pendapatan,
                ];
            }

            // dd($laporan);

            return DataTables::of($laporan)->make(true);
        }



        $tokos = Toko::where('deleted_at', null)->get();


        return view('laporans.penjualan', compact('tokos'), $pagedata);
    }






    public function export()
    {
        // return Excel::download(new AbsensiExport, 'absensis-' . date('Y-m-d') . '.xlsx');
    }

    
}
