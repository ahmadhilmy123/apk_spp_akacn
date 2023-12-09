<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_guru,
    BukuTamu
};

class BukuTamuController extends Controller
{
    public function create()
    {
        $gurus = m_guru::all();
        return view('tambah', compact('gurus'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'alamat' => 'required',
            'kategori' => 'required',
            'image' => 'required',
            'signed' => 'required',
            'guru_id' => 'required',
            'keperluan' => 'required',
            'no_telp' => 'required'
        ]);

        $validatedData['image'] = BukuTamu::create_image($request->image);
        $validatedData['signed'] = BukuTamu::create_sinature($request->signed);

        $data = BukuTamu::create($validatedData);
        $this->sendMessageTele($data->guru->id_telegram, $data->nama . ' Sedang menunggu');
        
        return redirect()->route('index')->with('success', 'Data Berhasil Ditambahkan');
    }
}
