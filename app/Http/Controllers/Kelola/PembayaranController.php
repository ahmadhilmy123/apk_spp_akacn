<?php

namespace App\Http\Controllers\Kelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use DataTables, Auth;

class PembayaranController extends Controller
{
    public function index(){
        return view('kelola_pembayaran.index');
    }

    public function data(){
        $datas = Pembayaran::all();
        foreach ($datas as $data) {
            $options = '';

            if (auth()->user()->can('edit_kelola_pembayaran')) {
                $options = $options ."<a href='". route('kelola.pembayaran.show', $data->id) ."' class='btn btn-warning mx-2'>Verifikasi</a>";
            }
        
            $data->options = $options;
        }

        return DataTables::of($datas)
                            ->addColumn('nis', function($datas){
                                return $datas->mahasiswa->email;
                            })
                            ->addColumn('nama_mhs', function($datas){
                                return $datas->mahasiswa->name;
                            })
                            ->addColumn('prodi', function($datas){
                                return $datas->mahasiswa->mahasiswa->prodi->nama;
                            })
                            ->editColumn('verify_id', function($datas){
                                return $datas->verify_id ? $datas->verify->name : '';
                            })
                            ->addIndexColumn()
                            ->rawColumns(['options'])
                            ->make(true);
    }

    public function show($pembayaran_id){
        $data = Pembayaran::findOrFail($pembayaran_id);
        return view('kelola_pembayaran.form', compact('data'));
    }

    public function store(Request $request, $pembayaran_id){
        $request->validate([
            'status' => 'required|in:diterima,ditolak'
        ]);

        $data = Pembayaran::findOrFail($pembayaran_id);

        if ($data->status != 'pending') {
            return redirect()->back()->with('error', 'Maaf telah terjadi kesalahan!');   
        }
        
        $data->update([
            'ket_verify' => $request->ket_verify,
            'status' => $request->status,
            'verify_id' => Auth::user()->id,
            'revisi' => $request->revisi ? "1" : "0"
        ]);

        return redirect()->route('kelola.pembayaran.index')->with('success', 'Berhasil disimpan!');
    }

    public function revisi($pembayaran_id){
        $data = Pembayaran::findOrFail($pembayaran_id);

        if ($data->status == 'pending') {
            return redirect()->back()->with('error', 'Maaf telah terjadi kesalahan!');   
        }

        $data->update([
            'ket_verify' => null,
            'status' => 'pending',
            'verify_id' => null
        ]);

        return redirect()->back()->with('success', 'Berhasil direvisi!');
    }
}
