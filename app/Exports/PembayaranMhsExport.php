<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\Exportable;
use DB, Auth;

class PembayaranMhsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];
        $mhs = Auth::user()->mahasiswa;
        $semester = DB::table('semesters')
                            ->where('prodi_id', $mhs->prodi_id)
                            ->get();
        
        foreach ($semester as $row) {
            $sheets[] = new PembayaranMhsDetailExport($row);
        }

        return $sheets;
    }
}
