<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->hasRole('kasir'));
        $isKasir = auth()->user()->hasRole('kasir');

        if ($isKasir) {

            if (session()->has('selected_toko_id') && session()->has('selected_toko_nama')) {
                return to_route('kasir.kasir_dashboard');

            }

            $ishaveToko = (bool) auth()->user()->toko_id;

            if ($ishaveToko) {
                $toko = Toko::find(auth()->user()->toko_id);


                session([
                    'selected_toko_id' => $toko->id,
                    'selected_toko_nama' => $toko->name,
                    'selected_toko_data' => $toko
                ]);

                return to_route('dashboard');
            }
        
            return to_route('kasir.kasir_pilihToko');



        }
        return view('dashboard');
    }
}
