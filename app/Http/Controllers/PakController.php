<?php

namespace App\Http\Controllers;

use App\Models\LockPak;
use App\Models\Pak;
use Illuminate\Http\Request;

class PakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pak()
    {
        $data = LockPak::where('status', 1)->get();
        return view('admin.pak', [
            'data' => $data != null ? $data : null,
        ]);
    }
    public function index()
    {
        return view('admin.PAK.index', [
            'data' => Pak::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $pak = new Pak();
            $pak->nama = date('Y', strtotime($request->nama));
            $pak->save();

            for ($i = 0; $i < 2; $i++) {
                $lk = new LockPak();
                $lk->pak_id = $pak->id;
                $lk->kondisi = $i;
                $lk->status = $i;
                $lk->save();
            }


            return redirect()->route('pak.index')->with('success', 'Data Berhasil ditambah!');
        } catch (\Throwable $th) {
            return response()->json(['tryErr', $th->getMessage()]);
        }
    }

    public function redirect(Request $request)
    {
        session([
            'pak_id' => $request->pak_id,
            'kondisi' => $request->kondisi
        ]);
        return redirect('/redirect');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pak  $pak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pak $pak)
    {
        try {
            $p = Pak::all();
            if ($p->count() == 1) {
                return response()->json(['error', 'Data PAK tidak boleh kosong!']);
            } else {
                $pk = Pak::firstWhere('id', $pak->id);
                if ($pk->status == 1) {
                    return response()->json(['error', 'Data PAK sedang aktif']);
                }

                Pak::destroy($pak->id);
                return response()->json(['success', 'Data berhasil dihapus']);
            }
        } catch (\Throwable $th) {
            return response()->json(['tryErr', $th->getMessage()]);
        }
    }

    public function kunci(Request $request)
    {
        // dd($request->all());
        try {
            if ($request->sebelum != null) {
                $kunci = LockPak::firstWhere('id', $request->sebelum);
                if ($kunci) {
                    if ($kunci->status == 0) {
                        $s = 1;
                    } else {
                        $s = 0;
                    }
                }
                $kunci->status = $s;
                $kunci->save();
            } else {
                $kunci = LockPak::firstWhere('id', $request->sesudah);
                if ($kunci) {
                    if ($kunci->status == 0) {
                        $s = 1;
                    } else {
                        $s = 0;
                    }
                }
                $kunci->status = $s;
                $kunci->save();
            }

            return redirect()->route('pak.index')->with('success', 'PAK dibuka!');
        } catch (\Throwable $th) {
            return response()->json(['tryErr', $th->getMessage()]);
        }
    }
}
