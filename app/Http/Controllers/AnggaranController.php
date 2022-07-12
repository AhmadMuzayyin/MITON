<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Schedule;
use App\Models\TKeuangan;
use Illuminate\Http\Request;
use App\Models\InputActivation;
use Illuminate\Support\Facades\DB;

class AnggaranController extends Controller
{
    public function index()
    {
        $data = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
        $anggaran = Activity::join('anggarans', 'activities.id', '=', 'anggarans.activity_id')->where('user_id', Auth()->user()->id)->where(
            'activities.pak_id',
            session()->get('pak_id')
        )->get();
        return view('admin.entry.page.perubahanPAK', [
            'anggaran' => $anggaran,
            'aktif' => $data['Entry Kegiatan'],
        ]);
    }
    public function store(Request $request)
    {
        try {
            foreach ($request->activityID as $key => $value) {
                $data = array([
                    'activity_id' => $value,
                    'pak_id' => session()->get('pak_id'),
                    'kondisi' => $request->kondisi,
                    'anggaran' => $request->anggaran[$key],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                Anggaran::insert($data);
                $sc = Schedule::where('activity_id', $value)->first();
                $keuangan = TKeuangan::where('schedule_id', $sc->id)->get()->sum('anggaran');
                $persen = ($keuangan / $request->anggaran[$key]) * 100;
                $scup = Schedule::find($sc->id);
                $scup->persentase = $sc->persentase >= 100 ? 60 : '';
                $scup->save();
            }
            toastr()->success('Berhasil menambahkan data anggaran!');
            return redirect()->route('activity.index');
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error($th->errorInfo);
            return redirect()->back();
        }
    }
    public function perubahanstore(Request $request)
    {
        // dd($request->data);
        try {
            foreach ($request->data as $key => $value) {
                // dd($value['name'], $value['value']);
                $data = array([
                    'activity_id' => $value['name'],
                    'pak_id' => session()->get('pak_id'),
                    'kondisi' => session()->get('kondisi'),
                    'anggaran' => $value['value'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                Anggaran::insert($data);
                $sc = Schedule::where('activity_id', $value['name'])->first();
                $scup = Schedule::find($sc->id);
                $scup->persentase = 60;
                $scup->save();
            }
            toastr()->success('Berhasil menambahkan data Perubahan Anggaran Kegiatan!');
            return redirect('/activity');
        } catch (\Illuminate\Database\QueryException $th) {
            toastr()->error($th->errorInfo);
            return redirect()->back();
        }
    }
}
