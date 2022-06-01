<?php

namespace App\Http\Controllers;

use App\Models\PenggunaAnggaran;
use Illuminate\Http\Request;

class PenggunaAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pa.pa', [
            'data' => PenggunaAnggaran::first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenggunaAnggaran  $penggunaAnggaran
     * @return \Illuminate\Http\Response
     */
    public function show(PenggunaAnggaran $penggunaAnggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenggunaAnggaran  $penggunaAnggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(PenggunaAnggaran $penggunaAnggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenggunaAnggaran  $penggunaAnggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenggunaAnggaran $penggunaAnggaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenggunaAnggaran  $penggunaAnggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenggunaAnggaran $penggunaAnggaran)
    {
        //
    }
}
