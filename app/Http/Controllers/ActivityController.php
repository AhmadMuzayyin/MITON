<?php

namespace App\Http\Controllers;

use App\Models\Pak;
use App\Models\PPTK;
use App\Models\Report;
use App\Models\Target;
use App\Models\Volume;
use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Pengadaan;
use App\Models\TKeuangan;
use App\Models\SumberDana;
use App\Models\Pelaksanaan;
use Illuminate\Http\Request;
use App\Exports\ActivityExport;
use App\Models\InputActivation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth()->user()->isAdmin == true) {
            $data = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
            $data2 = Activity::join('anggarans', 'activities.id', '=', 'anggarans.activity_id')->where('anggarans.pak_id', session()->get('pak_id'))->where('anggarans.kondisi', '=', session()->get('kondisi'))->get();
            $anggaran = Activity::join('anggarans', 'activities.id', '=', 'anggarans.activity_id')->where('activities.pak_id', session()->get('pak_id'))->get();
            return view('admin.entry.kegiatan', [
                'page' => false,
                'data' => $data2 ?? [],
                'aktif' => $data['Entry Kegiatan'],
            ]);
        }
        $data = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
        $data2 = Activity::join('anggarans', 'activities.id', '=', 'anggarans.activity_id')->where('anggarans.pak_id', session()->get('pak_id'))->where('anggarans.kondisi', '=', session()->get('kondisi'))->where('user_id', Auth()->user()->id)->get();
        $anggaran = Activity::join('anggarans', 'activities.id', '=', 'anggarans.activity_id')->where('user_id', Auth()->user()->id)->where('activities.pak_id', 
        session()->get('pak_id'))->get();
            if (session()->get('kondisi') == 1) {
                if (!$data2->isEmpty()) {
                    return view('admin.entry.kegiatan', [
                        'page' => false,
                        'data' => $data2,
                        'aktif' => $data['Entry Kegiatan'],
                    ]); 
                }
                return redirect()->route('anggaran.index');
            }
            return view('admin.entry.kegiatan', [
                'page' => false,
                'data' => $data2,
                'aktif' => $data['Entry Kegiatan'],
            ]); 
    }
    public function create()
    {
        return view('admin.entry.kegiatan',
        [
            'page' => 'create'
        ]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $lp = json_encode($request->laporan);
            $a = new Activity;
            foreach(json_decode($lp) as $val){
                if ($val == "dau") {
                    $a->dau = 1;
                }
                if ($val == "dak") {
                    $a->dak = 1;
                }
                if ($val == "dbhc") {
                    $a->dbhc = 1;
                }
            }

            $a->pak_id = $request->pak_id;
            $a->user_id = Auth()->user()->id;
            $a->rek = $request->rek;
            $a->nama = $request->subkegiatan;
            $a->sumber_dana_id = $request->dana;
            $a->pengadaan_id = $request->pengadaan;
            $a->pelaksanaan_id = $request->pelaksanaan;
            $a->kegiatan = $request->kegiatan;
            $a->program = $request->program;
            if ($request->anggaran >= 250000000) {
                $a->keterangan = "LELANG";
            }else{
                $a->keterangan = "NON LELANG";
            }
            $a->save();
                
            $anggaran = new Anggaran;
            $anggaran->activity_id = $a->id;
            $anggaran->pak_id = session()->get('pak_id');
            $anggaran->kondisi = $request->kondisi;
            $anggaran->anggaran = $request->anggaran;
            $anggaran->save();

            $s = new Schedule;
            $s->activity_id = $a->id;
            $s->persentase = 0;
            $s->save();
            return redirect()->route('activity.index')->with('success', 'Data berhasil ditambah!');

        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }


    public function edit(Activity $activity)
    {
        $d = Activity::where('id', $activity->id)->first();
        $s = SumberDana::all();
        return view('admin.entry.kegiatan', [
            'page' => "edit",
            'data' => $d,
            'dana' => $s,
            'pengadaan' => Pengadaan::all(),
            'pelaksanaan' => Pelaksanaan::all(),
        ]);
    }

    public function update(Request $request)
    {
        try {
            $ag = Anggaran::find($request->ag_id);
            $ag->activity_id = $request->id;
            $ag->pak_id = session()->get('pak_id');
            $ag->kondisi = $request->kondisi;
            $ag->anggaran = $request->anggaran;
            $ag->save();

            $activity = Activity::find($request->id);
            $lp = json_encode($request->laporan);
            $collect = json_decode($lp);
            if(in_array('dau', $collect)){
                $activity->dau = 1;
                $activity->save();
            }else{
                $activity->dau = null;
                $activity->save();
            }
            if(in_array('dak', $collect)){
                $activity->dak = 1;
                $activity->save();
            }else{
                $activity->dak = null;
                $activity->save();
            }
            if(in_array('dbhc', $collect)){
                $activity->dbhc = 1;
                $activity->save();
            }else{
                $activity->dbhc = null;
                $activity->save();
            }

            $activity->rek = $request->rek;
            $activity->nama = $request->subkegiatan;
            $activity->sumber_dana_id = $request->dana;
            $activity->pengadaan_id = $request->pengadaan;
            $activity->pelaksanaan_id = $request->pelaksanaan;
            $activity->kegiatan = $request->kegiatan;
            $activity->program = $request->program;
            if ($request->anggaran >= 250000000) {
                $activity->keterangan = "LELANG";
            }else{
                $activity->keterangan = "NON LELANG";
            }
            $activity->save();

            $report = Report::where('activity_id', $request->id)->get();
            foreach ($report as $value) {
                $data = array(
                    'sumber_dana_id' => $request->dana
                );
                Report::where('activity_id', $request->id)->update($data);
            }
            
            return response()->json(['success', 'Data berhasil diupdate!']);
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }

    public function destroy(Activity $activity)
    {
        try {
            $sc = Schedule::firstWhere('activity_id', $activity->id);
            DB::table('schedules')->where('activity_id', $activity->id)->delete();
            DB::table('locations')->where('schedule_id', $sc->id)->delete();
            DB::table('volumes')->where('schedule_id', $sc->id)->delete();
            DB::table('p_p_t_k_s')->where('schedule_id', $sc->id)->delete();
            DB::table('targets')->where('schedule_id', $sc->id)->delete();
            DB::table('t_keuangans')->where('schedule_id', $sc->id)->delete();
            DB::table('reports')->where('activity_id', $activity->id)->delete();
            DB::table('anggarans')->where('activity_id', $activity->id)->delete();
            Activity::destroy($activity->id);
            return response()->json(['success', 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['tryError',$th->getMessage()]);
        }
    }
    public function show(){
        // return Excel::download(new ActivityExport, 'SUB KEGIATAN.xlsx');
        return (new ActivityExport)->download('SUB KEGIATAN.xlsx');
    }
}
