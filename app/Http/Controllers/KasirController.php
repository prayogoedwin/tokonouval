<?php

namespace App\Http\Controllers;

use App\Models\Produk;
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

        

        return redirect()->route('kasir.dashboard')
            ->with('success', 'Berhasil memilih toko: ' . $toko->name);
    }

    // Halaman utama kasir (setelah pilih toko)
    public function dashboard()
    {
        // Ambil data dari session
        $tokoId = session('selected_toko_id');
        $tokoNama = session('selected_toko_nama');

        // Load data yang diperlukan untuk kasir
        $produks = Produk::where('produks.toko_id', $tokoId )
        ->get();

        // dd()

        return view('kasir.dashboard', compact('tokoId', 'tokoNama', 'produks'));
    }

    // Fitur exit toko (clear session tapi tidak logout)
    public function exitToko()
    {
        // Hapus session toko
        session()->forget(['selected_toko_id', 'selected_toko_nama', 'selected_toko_data']);

        return redirect()->route('kasir.pilih-toko')
            ->with('success', 'Berhasil keluar dari toko');
    }
}
