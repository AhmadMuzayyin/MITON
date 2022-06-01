<?php

namespace App\Http\Controllers;

use App\Models\PPTK;
use App\Models\Target;
use App\Models\Volume;
use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\UserPPTK;
use App\Models\TKeuangan;
use Illuminate\Http\Request;
use App\Models\InputActivation;
use Illuminate\Support\Facades\Auth;

class SchuduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth()->user()->isAdmin != 1) {
            $value = Activity::join('schedules', 'activities.id', '=', 'schedules.activity_id')->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
            return view(
                'admin.entry.schedule',
                [
                    'page' => 'index',
                    'data' => $value ? $value : '',
                ]
            );
        }
        $value = Activity::join('schedules', 'activities.id', '=', 'schedules.activity_id')->where('pak_id', session()->get('pak_id'))->get();
        return view(
            'admin.entry.schedule',
            [
                'page' => 'index',
                'data' => $value ? $value : '',
            ]
        );
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.entry.schedule', [
            'page' => 'lokasi',
            'data' => $schedule,
            'lokasi' => Location::where('schedule_id', $schedule->id)->get()
        ]);
    }

    public function volume(Schedule $schedule)
    {
        return view('admin.entry.schedule', [
            'page' => 'volume',
            'data' => $schedule,
            'volume' => Volume::firstWhere('schedule_id', $schedule->id)
        ]);
    }
    public function pptk(Schedule $schedule)
    {
        return view('admin.entry.schedule', [
            'page' => 'PPTK',
            'data' => $schedule,
            'Userpptk' => UserPPTK::where('user_id', Auth()->user()->id)->get(),
            'pptk' => PPTK::firstWhere('schedule_id', $schedule->id)
        ]);
    }
    public function target(Schedule $schedule)
    {
        $target = Target::where('schedule_id', $schedule->id)->get();
        $data = TKeuangan::where('schedule_id', $schedule->id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->get();
        $data2 = TKeuangan::where('schedule_id', $schedule->id)->where('pak_id', session()->get('pak_id'))->get();
        $aktif = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
        $anggaran = Anggaran::where('activity_id', $schedule->activity_id)->where('kondisi', session()->get('kondisi'))->first();
        return view('admin.entry.schedule', [
            'page' => 'target',
            'data' => $schedule,
            'target' => $target ? $target : [],
            'k' => $data ?? $data2,
            'ac' => Schedule::firstWhere('id', $schedule->id),
            'anggaran' => $anggaran ?? 0,
            'aktif' => $aktif['Target Fisik & Target Keuangan']
        ]);
    }
}
