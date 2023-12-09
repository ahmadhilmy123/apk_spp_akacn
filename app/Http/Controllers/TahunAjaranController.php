<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_tahun_ajaran', ['only' => ['index', 'store']]);
        $this->middleware('permission:add_tahun_ajaran', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_tahun_ajaran', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_tahun_ajaran', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('tahun_ajaran.index');
    }

    public function data(){
        $datas = TahunAjaran::all();

        foreach ($datas as $data) {
                $options = '';

                if (auth()->user()->can('edit_tahun_ajaran')) {
                    $options = $options ."<a href='". route('tahun-ajaran.edit', $data->id) ."' class='btn btn-warning mx-2'>Edit</a>";
                }
                
                if (auth()->user()->can('delete_tahun_ajaran')) {
                    $options = $options . "<button class='btn btn-danger mx-2' onclick='deleteData(`". route('tahun-ajaran.destroy', $data->id) ."`)'>
                                        Hapus
                                    </button>";

                $data->options = $options;
            }
        }

        return DataTables::of($datas)
                            ->addIndexColumn()
                            ->rawColumns(['options'])
                            ->make(true);
    }

    public function create()
    {
        return view('tahun_ajaran.form');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        TahunAjaran::create(['nama' => $request->nama]);
        return redirect()->route('tahun-ajaran.index')->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {   
        $data = TahunAjaran::findOrFail($id);
        return view('tahun_ajaran.form', compact('data'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate(['nama' => 'required']);
        $tahunAjaran->update(['nama' => $request->nama]);
        return redirect()->route('tahun-ajaran.index')->with('success', 'Berhasil diubah');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        //
    }
}
