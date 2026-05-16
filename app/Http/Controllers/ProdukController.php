<?php

namespace App\Http\Controllers;

use App\Exports\ProdukExport;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    private function getPagedata()
    {
        $tokos = Toko::get();
        $kategories = Kategori::get();

    //     protected $fillable = [
    //     'toko_id',
    //     'kategori_id',
    //     'name',
    //     'harga_beli',
    //     'harga_jual',
    //     'created_by',
    //     'updated_by',
    //     'deleted_by',
        
    // ];

        $pagedata = [
            'title' => 'Produk',
            'tablename' => 'produks',
            'tableaction' => true,
            'columns' => [
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Produk', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'sku', 'value' => 'sku',  'title' => 'SKU', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'toko_id', 'value' => 'toko', 'title' => 'Toko', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ['value' => '', 'label' => 'Pilih Toko'],
                    ...$tokos->map(function ($toko) {
                        return ['value' => $toko->id, 'label' => $toko->name];
                    })->toArray(),
                    
                ]],

                ['name' => 'kategori_id', 'value' => 'kategori', 'title' => 'Kategori', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ['value' => '', 'label' => 'Pilih Toko'],
                    ...$kategories->map(function ($kategori) {
                        return ['value' => $kategori->id, 'label' => $kategori->name];
                    })->toArray(),
                    
                ]],
                ['name' => 'harga_beli', 'value' => 'harga_beli', 'title' => 'Harga Beli', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'harga_jual', 'value' => 'harga_jual', 'title' => 'Harga Jual', 'type' => 'number', 'inform' => true, 'intable' => true],

            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        // dd($request->headers->all());
        
        if ($request->ajax()) {
            // dd('masuk ajax');
            $produks = Produk::where('produks.deleted_at', null)
            ->join('kategories', 'produks.kategori_id', '=', 'kategories.id')
            ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
            ->select(
                    'produks.*',
                    'kategories.name as kategori',
                    'tokos.name as toko'
                )
            ->get();
            // dd($produks);

            return DataTables::of($produks)
                // ->filterColumn('name', function ($query, $keyword) {
                //     $query->where('produks.name_Produk', 'like', "%{$keyword}%");
                // })
                // ->filterColumn('produk', function ($query, $keyword) {
                //     $query->where('produk_produks.name', 'like', "%{$keyword}%");
                // })



                ->addColumn('actions', function ($Produk) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-produks')) {
                        $actions .= '<a href="' . route('produks.show', $Produk) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }
                    if (auth()->user()->hasPermission('show-stoks')) {
                        $actions .= '<a href="' . route('stoks.index', ['produk_id' => $Produk->id]) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">Stoks</a>';
                    }

                    if (auth()->user()->hasPermission('edit-produks')) {
                        $actions .= '<a href="' . route('produks.edit', $Produk) . '" class="text-blue-600 dark:text-blue-400 hover:underline mr-3">Edit</a>';
                    }

                    if (auth()->user()->hasPermission('delete-produks')) {
                        $actions .= '<form action="' . route('produks.destroy', $Produk) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                        </form>';
                    }

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.index', $pagedata);
    }





    public function export()
    {
        // return Excel::download(new ProdukExport, 'produks-' . date('Y-m-d') . '.xlsx');
    }

    public function create(): View
    {

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.create', $pagedata);
    }

    public function store(Request $request): RedirectResponse
    {
        $store_data = [
            'name' => $request->input('name'),
            'toko_id' => $request->input('toko_id'),
            'kategori_id' => $request->input('kategori_id'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'toko_id' => ['required', 'integer'],
            'kategori_id' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer'],

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Produk = Produk::create($store_data);
        

        return to_route('produks.index')->with('status', 'Produk updated successfully.');
    }

    public function show(Produk $Produk): View
    {

        $data = $Produk;
        $data->kategori = Kategori::find($Produk->kategori_id)->name;
        $data->toko = Toko::find($Produk->toko_id)->name;

        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe

        // dd($data, $pagedata);

        return view('dynamiccrud.show', compact('data'), $pagedata);
    }

    public function edit(Produk $Produk): View
    {
        $data = $Produk;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Produk $Produk): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'name' => $request->input('name'),
            'toko_id' => $request->input('toko_id'),
            'kategori_id' => $request->input('kategori_id'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),

            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'toko_id' => ['required', 'integer'],
            'kategori_id' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer'],

            'updated_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Produk->update($store_data);


        // dd("Produk updated: " . json_encode($Produk));



        return to_route('produks.index')->with('status', 'Produk updated successfully.');
    }

    //soft delete
    public function destroy(Produk $Produk): RedirectResponse
    {
        $Produk->update(['deleted_by' => auth()->id(), 'deleted_at' => now()]);


        return to_route('produks.index')->with('status', 'Produk deleted successfully.');
    }
}
