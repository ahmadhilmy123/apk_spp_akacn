<?php

namespace App\Http\Controllers;

use DataTables, DB;
use App\Models\{
    TahunAjaran,
    Semester,
    Prodi
};
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    public function data($prodi_id, $semester_id){
        $datas = DB::table('semester_tahun as a')
                        ->select('b.nama as tahun_ajaran', 'a.ket', 'a.nominal', 'a.publish', 'b.id as tahun_ajaran_id')
                        ->join('tahun_ajarans as b', 'a.tahun_ajaran_id', 'b.id')
                        ->where('a.prodi_id', $prodi_id)
                        ->where('a.semester_id', $semester_id)
                        ->get();

        foreach ($datas as $data) {
                $options = '';

                $options = $options ."<a href='". route('data-master.prodi.semester.biaya.show', ['prodi_id' => $prodi_id, 'semester_id' => $semester_id, 'tahun_ajaran_id' => $data->tahun_ajaran_id]) ."' class='btn btn-info mx-2'>Set Biaya</a>";

                if (auth()->user()->can('edit_biaya')) {
                    $options = $options ."<a href='". route('data-master.prodi.semester.biaya.edit', ['prodi_id' => $prodi_id, 'semester_id' => $semester_id, 'tahun_ajaran_id' => $data->tahun_ajaran_id]) ."' class='btn btn-warning mx-2'>Edit</a>";
                }
                
                if (auth()->user()->can('delete_biaya')) {
                    $options = $options . "<button class='btn btn-danger mx-2' onclick='deleteData(`". route('data-master.prodi.semester.biaya.destroy', ['prodi_id' => $prodi_id, 'semester_id' => $semester_id, 'tahun_ajaran_id' => $data->tahun_ajaran_id]) ."`)'>
                                        Hapus
                                    </button>";

                $data->options = $options;
            }
        }

        return DataTables::of($datas)
                            ->addIndexColumn()
                            ->editColumn('publish', function($data){
                                return ($data->publish ? 'Ya' : 'Tidak');
                            })
                            ->rawColumns(['options'])
                            ->make(true);
    }

    public function create($prodi_id, $semester_id){
        $semester = Semester::findOrFail($semester_id);
        if ($semester->prodi_id != $prodi_id) {
            abort(403);
        }

        $prodi = Prodi::findOrFail($prodi_id);
        $tahun_ajarans = TahunAjaran::select('tahun_ajarans.*')
                                    ->leftJoin('semester_tahun', function($q) use($prodi_id, $semester_id){
                                        $q->on('semester_tahun.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                                            ->where('semester_tahun.prodi_id', $prodi_id)
                                            ->where('semester_tahun.semester_id', $semester_id);
                                    })
                                    ->whereNull('semester_tahun.tahun_ajaran_id')
                                    ->get();
        return view('data_master.prodi.semester.form', compact('prodi', 'semester', 'tahun_ajarans'));    
    }

    public function store(Request $request, $prodi_id, $semester_id){
        $request->validate([
            'tahun_ajaran_id' => 'required',
            'nominal' => 'required',
        ]);

        DB::table('semester_tahun')->insert([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'prodi_id' => $prodi_id,
            'semester_id' => $semester_id,
            'nominal' => $request->nominal,
            'ket' => $request->ket,
            'publish' => $request->publish ? 1 : 0
        ]);

        return redirect()->route('data-master.prodi.semester.show', ['prodi_id' => $prodi_id, 'semester_id' => $semester_id])
                ->with('success', 'Berhasil disimpan');
    }
}
