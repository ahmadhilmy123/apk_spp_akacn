<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PembayaranExport implements FromView
{
    public function view(): View
    {
        $datas = Pembayaran::select('pembayarans.*', 'b.email as nim', 'b.name as nama_mhs', 'd.nama as prodi', 'e.nama as semester', 'f.nama as tahun_ajaran')
                        ->join('users as b', 'pembayarans.mhs_id', '=', 'b.id')
                        ->join('mahasiswas as c', 'c.user_id', '=', 'b.id')
                        ->join('prodi as d', 'd.id', '=', 'c.prodi_id')
                        ->join('semesters as e', 'e.id', '=', 'pembayarans.semester_id')
                        ->join('tahun_ajarans as f', 'f.id', '=', 'c.tahun_ajaran_id')
                        ->when(request('status'), function($q){
                            $q->where('pembayarans.status', request('status'));
                        })->when(request('prodi'), function($q){
                            $q->where('c.prodi_id', request('prodi'));
                        })->when(request('tahun_ajaran'), function($q){
                            $q->where('c.tahun_ajaran_id', request('tahun_ajaran'));
                        })->get();

        return view('kelola_pembayaran.export', compact('datas'));
    }
}
