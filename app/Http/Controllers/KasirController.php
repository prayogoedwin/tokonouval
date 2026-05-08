<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\TipePembayaran;
use App\Models\Toko;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        // Cek session
        if (session()->has('selected_toko_id')) {
            return redirect()->route('kasir.dashboard');
        }

        return redirect()->route('kasir.pilihtoko');
    }


    // Halaman pilih toko
    public function pilihToko()
    {

        $tokos = Toko::all(); // Ambil semua toko
        return view('kasir.pilihtoko', compact('tokos'));
    }

    // Proses simpan pilihan toko ke session
    public function simpanPilihanToko(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id'
        ]);

        $toko = Toko::find($request->toko_id);

        // Simpan ke session
        session([
            'selected_toko_id' => $toko->id,
            'selected_toko_nama' => $toko->name,
            'selected_toko_data' => $toko
        ]);



        return to_route('kasir.dashboard')->with('status', 'Berhasil memilih toko: ' . $toko->name);
    }

    // Halaman utama kasir (setelah pilih toko)
    public function dashboard()
    {
        // Ambil data dari session
        $tokoId = session('selected_toko_id');
        $tokoNama = session('selected_toko_nama');

        // Load data yang diperlukan untuk kasir
        $produks = Produk::where('produks.toko_id', $tokoId)
            ->get();

        $tipe_pembayarans = TipePembayaran::get();

        // dd($produks);

        // TODO: ganti nextnya
        if ($tokoId == 1) {
            return view('kasir.dashboard', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
        }

        return view('kasir.tipe2', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
    }

    public function processPayment(Request $request)
    {
        // dd($request->all()); 

        $validated = $request->validate([
            'cart_items' => 'required|json',
            'subtotal_before_discount' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'total_payment' => 'required|numeric',
            'payment_amount' => 'required|numeric',
            'change_amount' => 'required|numeric',
            // 'transaction_id' => 'required|string'
        ]);
        $cartItems = json_decode($request->cart_items, true);

        // $fillable = [
        //     'customer_id',
        //     'toko_id',
        //     'no_invoice',
        //     'tipe_pembayaran_id',
        //     'total_pembelian',
        //     'diskon_percentage',
        //     'diskon_nominal',
        //     'total_harus_dibayar',
        //     'dibayar',
        //     'kembalian',
        //     'keterangan',

        //     'created_by',
        //     'updated_by',
        //     'deleted_by',
        // ];
        // dd("here");

        // Create penjualan record
        $penjualan = Penjualan::create([
            'toko_id' =>  session('selected_toko_id'),
            // 'no_invoice' => nanti di model
            // 'tipe_pembayaran_id' => $validated['discount_percent'],
            'tipe_pembayaran_id' => $validated['payment_method_id'],
            'diskon_percentage' => $validated['discount_percent'],
            'diskon_nominal' => $validated['discount_amount'],
            'total_pembelian' => $validated['subtotal_before_discount'],
            'total_harus_dibayar' => $validated['total_payment'],
            'dibayar' => $validated['payment_amount'],
            'kembalian' => $validated['change_amount'],
            'keterangan' => 'completed'
        ]);

        // dd($penjualan);

        // $fillable = [
        //     'penjualan_id',
        //     'produk_id',
        //     'harga_beli',
        //     'harga_jual',
        //     'jumlah',
        //     'satuan',
        //     'sub_total',
        //     'created_by',
        //     'updated_by',
        //     'deleted_by',
        // ];
        // Create penjualan details
        foreach ($cartItems as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $item['id'],
                'harga_jual' => $item['price'],
                'harga_beli' => $item['harga_beli'],
                'jumlah' => $item['quantity'],
                'satuan' => $item['unit'],
                'sub_total' => $item['total']
            ]);
        }

        return to_route('kasir.dashboard')
            ->with('status', 'Berhasil Melakukan Transaksi: ');
    }

    // Fitur exit toko (clear session tapi tidak logout)
    public function exitToko()
    {
        // Hapus session toko
        session()->forget(['selected_toko_id', 'selected_toko_nama', 'selected_toko_data']);

        return redirect()->route('kasir.pilihtoko')
            ->with('success', 'Berhasil keluar dari toko');
    }


    //--------KASIR ONLY-----------//

    public function kasir_dashboard()
    {
        // Ambil data dari session
        $tokoId = session('selected_toko_id');
        $tokoNama = session('selected_toko_nama');

        // Load data yang diperlukan untuk kasir
        $produks = Produk::where('produks.toko_id', $tokoId)
            ->get();

        $tipe_pembayarans = TipePembayaran::get();

        // dd($produks);

        // TODO: ganti nextnya
        if ($tokoId == 1) {
            return view('kasir.kasironlytipe1', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
        }

        return view('kasir.kasironlytipe2', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
    }

    public function kasir_pilihToko()
    {
        // dd('here');
        $tokos = Toko::all(); // Ambil semua toko
        return view('kasir.kasir_pilihtoko', compact('tokos'));
    }

    public function kasir_simpanPilihanToko(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id'
        ]);

        $toko = Toko::find($request->toko_id);

        // Simpan ke session
        session([
            'selected_toko_id' => $toko->id,
            'selected_toko_nama' => $toko->name,
            'selected_toko_data' => $toko
        ]);



        return to_route('kasir.kasir_dashboard')->with('status', 'Berhasil memilih toko: ' . $toko->name);
    }

    // Fitur exit toko (clear session tapi tidak logout)
    public function kasir_exitToko()
    {
        // Hapus session toko
        session()->forget(['selected_toko_id', 'selected_toko_nama', 'selected_toko_data']);

        return redirect()->route('kasir.kasir_pilihtoko')
            ->with('success', 'Berhasil keluar dari toko');
    }
}
