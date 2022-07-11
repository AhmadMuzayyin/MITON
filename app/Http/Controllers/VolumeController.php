<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $cek = Volume::firstWhere('schedule_id', $request->id);
            if ($cek == true) {
                $s = Volume::find($cek->id);
                $s->schedule_id = $request->id;
                $s->volume = $request->volume;
                $s->satuan = $request->satuan;
                $s->save();
            } else {
                $v = new Volume;
                $v->schedule_id = $request->id;
                $v->volume = $request->volume;
                $v->satuan = $request->satuan;
                $v->save();

                $s = Schedule::find($request->id);
                if ($s == null) {
                    $s->persentase = 20;
                }
                $s->persentase = $s->persentase + 20;
                $s->save();
            }

            toastr()->success('Data Volume berhasil disimpan!');
            return redirect('/schedule/' . $request->id . '/edit/volume');
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error('Gagal menyimpan data Volume!');
            return redirect()->back();
        }
    }
}
