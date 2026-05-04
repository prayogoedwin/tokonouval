<?php

namespace App\Http\Controllers;

use App\Exports\ProdukExport;
use App\Models\Produk;
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

        $pagedata = [
            'title' => 'Produk',
            'tablename' => 'produks',
            'tableaction' => true,
            'columns' => [
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Produk', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'kontak', 'value' => 'kontak', 'title' => 'Kontak', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'alamat', 'value' => 'alamat', 'title' => 'Alamat', 'type' => 'text', 'inform' => true, 'intable' => true],

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
            'kode_produke' => $request->input('kode_produke'),
            'pass_produke' => $request->input('alamat'),
            'status_produke' => $request->input('status_produke'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'kode_produke' => ['required'],
            'pass_produke' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string'],

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


        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe



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
            'kode_produke' => $request->input('kode_produke'),
            'pass_produke' => $request->input('alamat'),
            'status_produke' => $request->input('status_produke'),

            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'kode_produke' => ['required'],
            'pass_produke' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string'],

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
