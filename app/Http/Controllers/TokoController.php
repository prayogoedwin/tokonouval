<?php

namespace App\Http\Controllers;

use App\Exports\TokoExport;
use App\Models\Toko;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TokoController extends Controller
{
    private function getPagedata()
    {

        $pagedata = [
            'title' => 'Toko',
            'tablename' => 'tokos',
            'tableaction' => true,
            'columns' => [
                ['name' => 'nama', 'value' => 'nama',  'title' => 'Nama Toko', 'type' => 'text', 'inform' => true, 'intable' => true],
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
            $tokos = Toko::where('tokos.isactive', true)
                ->get();
            // dd($tokos);

            return DataTables::of($tokos)
                // ->filterColumn('name', function ($query, $keyword) {
                //     $query->where('tokos.nama_Toko', 'like', "%{$keyword}%");
                // })
                // ->filterColumn('kategori', function ($query, $keyword) {
                //     $query->where('kategori_tokos.nama', 'like', "%{$keyword}%");
                // })



                ->addColumn('actions', function ($Toko) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-tokos')) {
                        $actions .= '<a href="' . route('tokos.show', $Toko) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }

                    if (auth()->user()->hasPermission('edit-tokos')) {
                        $actions .= '<a href="' . route('tokos.edit', $Toko) . '" class="text-blue-600 dark:text-blue-400 hover:underline mr-3">Edit</a>';
                    }

                    if (auth()->user()->hasPermission('delete-tokos')) {
                        $actions .= '<form action="' . route('tokos.destroy', $Toko) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
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
        // return Excel::download(new TokoExport, 'tokos-' . date('Y-m-d') . '.xlsx');
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
            'kode_toko' => $request->input('kode_toko'),
            'pass_toko' => $request->input('alamat'),
            'status_toko' => $request->input('status_toko'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'kode_toko' => ['required'],
            'pass_toko' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string'],

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Toko = Toko::create($store_data);
        

        return to_route('tokos.index')->with('status', 'Toko updated successfully.');
    }

    public function show(Toko $Toko): View
    {

        $data = $Toko;


        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe



        return view('dynamiccrud.show', compact('data'), $pagedata);
    }

    public function edit(Toko $Toko): View
    {
        $data = $Toko;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Toko $Toko): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'name' => $request->input('name'),
            'kode_toko' => $request->input('kode_toko'),
            'pass_toko' => $request->input('alamat'),
            'status_toko' => $request->input('status_toko'),

            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'kode_toko' => ['required'],
            'pass_toko' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string'],

            'updated_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Toko->update($store_data);


        // dd("Toko updated: " . json_encode($Toko));



        return to_route('tokos.index')->with('status', 'Toko updated successfully.');
    }

    //soft delete
    public function destroy(Toko $Toko): RedirectResponse
    {
        $Toko->update(['deleted_by' => auth()->id(), 'deleted_at' => now()]);


        return to_route('tokos.index')->with('status', 'Toko deleted successfully.');
    }
}
