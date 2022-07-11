<?php

namespace App\Http\Controllers;

use App\Models\PenggunaAnggaran;
use Illuminate\Http\Request;

class PenggunaAnggaranController extends Controller
{
    public function index()
    {
        return view('admin.pa.pa', [
            'data' => PenggunaAnggaran::first()
        ]);
    }
    public function store(Request $request)
    {
        try {
            $cek = PenggunaAnggaran::firstWhere('NIP', $request->nip);

            if ($cek == true) {

                $cek->NIP = $request->nip;
                $cek->nama = $request->nama;
                $cek->jabatan = $request->jabatan;
                $cek->save();
            }

            $pa = new PenggunaAnggaran();
            $pa->NIP = $request->nip;
            $pa->nama = $request->nama;
            $pa->jabatan = $request->jabatan;
            $pa->save();
            return redirect()->route('pa.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            return response()->json(['tryErr', $th->getMessage()]);
        }
    }
}
