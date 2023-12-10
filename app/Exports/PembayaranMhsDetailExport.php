<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
use Maatwebsite\Excel\Concerns\WithTitle;

class PembayaranMhsDetailExport implements FromView, WithTitle
{
    protected $semester;

    public function __construct($semester)
    {
        $this->semester = $semester;
    }

    public function title(): string
    {
        return $this->semester->nama;
    }

    public function view(): View
    {
        $datas = Pembayaran::where('mhs_id', Auth::user()->id)
                    ->where('semester_id', $this->semester->id)
                    ->get();

        return view('pembayaran.export', compact('datas'));
    }
}
