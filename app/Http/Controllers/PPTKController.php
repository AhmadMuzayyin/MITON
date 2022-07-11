<?php

namespace App\Http\Controllers;

use App\Models\PPTK;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PPTKController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $cek = PPTK::firstWhere('schedule_id', $request->id);
            if ($cek == true) {
                $p = PPTK::find($cek->id);
                $p->schedule_id = $request->id;
                $p->user_p_p_t_k_id = $request->pptk;
                $p->save();
            } else {
                $pptk = new PPTK;
                $pptk->schedule_id = $request->id;
                $pptk->user_p_p_t_k_id = $request->pptk;
                $pptk->save();

                $s = Schedule::find($request->id);
                if ($s == null) {
                    $s->persentase = 20;
                }
                $s->persentase = $s->persentase + 20;
                $s->save();
            }

            toastr()->success('Berhasil menyimpan data PPTK!');
            return redirect('/schedule/' . $request->id . '/edit/pptk');
        } catch (\Throwable $th) {
            return response()->json(['tryError', $th->getMessage()]);
        }
    }
}
