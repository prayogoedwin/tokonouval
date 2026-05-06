<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSelectedToko
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user sudah pilih toko, lanjutkan
        if (session()->has('selected_toko_id') && session()->has('selected_toko_nama')) {
            return $next($request);
        }

        // Jika belum pilih toko, redirect ke halaman pilih toko
        return redirect()->route('kasir.pilihtoko');
    }
}