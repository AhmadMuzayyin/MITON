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
        try {
            $p = Pak::firstWhere('nama', $request->nama);
            if (!$p) {
                $pak = new Pak();
                $pak->nama = $request->nama;
                $pak->save();

                for ($i = 0; $i < 2; $i++) {
                    $lk = new LockPak();
                    $lk->pak_id = $pak->id;
                    $lk->kondisi = $i;
                    $lk->status = 0;
                    $lk->save();
                }

                toastr()->success('Data PAK berhasil ditambah!');
                return redirect()->route('pak.index');
            } else {
                toastr()->error('Data PAK sudah ada!');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error('Gagal menambahkan data PAK!');
            return redirect()->route('pak.index');
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
                $pk = LockPak::firstWhere('pak_id', $pak->id);
                dd($pk);
                if ($pk->status == 1) {
                    return response()->json(['error', 'Data PAK sedang aktif']);
                } else {
                    LockPak::where('pak_id', $pak->id)->delete();
                    Pak::destroy($pak->id);
                    return response()->json(['success', 'Data berhasil dihapus']);
                }
            }
        } catch (\Illuminate\Database\QueryException $th) {
            return response()->json(['error', $th->errorInfo]);
        }
    }

    public function kunci(Request $request)
    {
        // dd($request->all());
        try {
            if (isset($request->sebelum)) {
                $kunci = LockPak::firstWhere('id', $request->sebelum);
                if ($kunci) {
                    if ($kunci->status == 0) {
                        $s = 1;
                        $kunci->status = $s;
                        $kunci->save();
                        toastr()->success('PAK Sebelum berhasil di buka!');
                    } else {
                        $s = 0;
                        $kunci->status = $s;
                        $kunci->save();
                        toastr()->success('PAK Sebelum berhasil di kunci!');
                    }
                }
            } else {
                $kunci = LockPak::firstWhere('id', $request->sesudah);
                if ($kunci) {
                    if ($kunci->status == 0) {
                        $s = 1;
                        $kunci->status = $s;
                        $kunci->save();
                        toastr()->success('PAK Sesudah berhasil di buka!');
                    } else {
                        $s = 0;
                        $kunci->status = $s;
                        $kunci->save();
                        toastr()->success('PAK Sesudah berhasil di kunci!');
                    }
                }
            }
            return redirect()->route('pak.index');
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error('Gagal melakukan perubahan PAK!');
            redirect()->back();
        }
    }
}
