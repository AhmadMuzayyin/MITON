<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Target;
use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Schedule;
use App\Models\TKeuangan;
use Illuminate\Http\Request;
use App\Models\InputActivation;
use App\Models\Month;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        if (Auth()->user()->isAdmin != 1) {
            if (request()->all() == null) {
                $dana = "1";
                $selected = Month::firstWhere('id', now()->format('n'));
                $bulan = Month::all();
                $now = date('n');
                $aktif = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
                $data = Report::where('sumber_dana_id', 1)->where('pak_id', session()->get('pak_id'))->where('month_id', $now)->where('user_id', Auth()->user()->id)->get();
                $realisasi = Report::where('sumber_dana_id', 1)->where('pak_id', session()->get('pak_id'))->where('status', 1)->where('user_id', Auth()->user()->id)->get()->sum('keuangan_sekarang');
                foreach ($data as $value) {
                    $anggaran = Anggaran::where('activity_id', $value->activity_id)->where('kondisi', session()->get('kondisi'))->first();
                }
                return view('admin.report.index', [
                    'data' => $data,
                    'dana' => $dana,
                    'bulan' => $bulan,
                    'batas' => $now,
                    'selected' => $selected,
                    'aktif' => $aktif['Laporan RFK'],
                    'anggaran' => isset($anggaran) ? $anggaran->anggaran - $realisasi : 0,
                ]);
            } else {
                $dana = request()->get('dana');
                $idbulan = request()->get('bulan');
                $selected = Month::firstWhere('id', $idbulan);
                $bulan = Month::all();
                $now = date('n');
                $aktif = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
                $data = Report::where('sumber_dana_id', $dana)->where('pak_id', session()->get('pak_id'))->where('month_id', $idbulan)->where('user_id', Auth()->user()->id)->get();
                $realisasi = Report::where('sumber_dana_id', $dana)->where('pak_id', session()->get('pak_id'))->where('status', 1)->where('user_id', Auth()->user()->id)->get()->sum('keuangan_sekarang');
                foreach ($data as $value) {
                    $anggaran = Anggaran::where('activity_id', $value->activity_id)->where('kondisi', session()->get('kondisi'))->first();
                }
                return view('admin.report.index', [
                    'data' => $data,
                    'dana' => $dana,
                    'bulan' => $bulan,
                    'batas' => $now,
                    'selected' => $selected,
                    'aktif' => $aktif['Laporan RFK'],
                    'anggaran' => isset($anggaran) ? $anggaran->anggaran - $realisasi : 0
                ]);
            }
        }
        if (request()->all() == null) {
            $dana = "1";
            $selected = Month::firstWhere('id', 1);
            $bulan = Month::all();
            $now = date('n');
            $aktif = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
            $data = Report::where('sumber_dana_id', 1)->where('month_id', 1)->get();
            return view('admin.report.index', [
                'data' => $data,
                'dana' => $dana,
                'bulan' => $bulan,
                'batas' => $now,
                'selected' => $selected,
                'aktif' => $aktif['Laporan RFK']
            ]);
        } else {
            $dana = request()->get('dana');
            $idbulan = request()->get('bulan');
            $selected = Month::firstWhere('id', $idbulan);
            $bulan = Month::all();
            $now = date('n');
            $aktif = InputActivation::select('id', 'nama', 'status')->get()->groupBy('nama');
            return view('admin.report.index', [
                'data' => Report::where('sumber_dana_id', $dana)->where('month_id', $idbulan)->get(),
                'dana' => $dana,
                'bulan' => $bulan,
                'batas' => $now,
                'selected' => $selected,
                'aktif' => $aktif['Laporan RFK']
            ]);
        }
    }

    public function getReport(Request $request)
    {
        return response()->json([
            'success' => 'Success',
            'dana' => $request->dana,
            'bulan' => $request->bulan
        ]);
    }
    public function store(Request $request)
    {
        try {
            foreach ($request->id as $key => $value) {
                if ($request->kegiatan[$key] == null && $request->keuangan[$key] == null) {
                    toastr()->error('Data tidak boleh kosong!');
                    return redirect()->route('report.index');
                } else {
                    $r = Report::find($value);
                    if ($request->keuangan[$key] > $r->t_keuangan->anggaran) {
                        toastr()->error('Realisasi keuangan tidak boleh lebih besar dari anggaran yang telah ditentukan!');
                        return redirect()->route('report.index');
                    } else {
                        $id = Report::firstWhere('id', $value);
                        $max = Activity::firstWhere('id', $id->activity_id);
                        if ($request->kegiatan[$key] > $r->target->persentase) {
                            toastr()->error('Realisasi keggiatan tidak boleh lebih besar dari target yang telah ditentukan!');
                            return redirect()->route('report.index');
                        } else {
                            if ($r->month_id > 1) {
                                $id = $r->id - 1;
                                $r = Report::find($id);
                                $data = Report::find($value);
                                $data->keuangan_lalu = $r->keuangan_sekarang;
                                $data->kegiatan_lalu = $r->kegiatan_sekarang;
                                $data->keuangan_sekarang = $request->keuangan[$key];
                                $data->kegiatan_sekarang = $request->kegiatan[$key];
                                $data->kendala = $request->kendala[$key];
                                $data->status = 1;
                                $data->save();
                            }
                            $data = Report::find($value);
                            $data->keuangan_sekarang = $request->keuangan[$key];
                            $data->kegiatan_sekarang = $request->kegiatan[$key];
                            $data->kendala = $request->kendala[$key];
                            $data->status = 1;
                            $data->save();
                        }
                    }
                }
            };
            toastr()->success('Berhasil melakukan Report!');
            return redirect()->route('report.index');
        } catch (\Illuminate\Database\QueryException $th) {
            return response()->json(['error', $th->errorInfo]);
        }
    }
}
