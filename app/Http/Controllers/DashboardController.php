<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Target;
use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Month;
use App\Models\Pengadaan;
use App\Models\Schedule;
use App\Models\SumberDana;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    if (Auth()->user()->isAdmin == 1) {
      $data = Activity::where('pak_id', session()->get('pak_id'))->get();
      $jml_sub = Activity::where('pak_id', session()->get('pak_id'))->get()->count();
      $jml_dana = SumberDana::all();
      $jml_pengadaan = Pengadaan::all();
      $report = Report::where('pak_id', session()->get('pak_id'))->where('month_id', now()->format('n'))->where('status', 1)->get();
      $jml_sub_lapor = 0;
      foreach ($data as $key => $value) {
        $jml_dana_pake = $value->distinct()->count('sumber_dana_id');
        $jml_png_pake = $value->distinct()->count('pengadaan_id');
      }
      return view('admin.index', [
        'jml_sub' => $jml_sub,
        'jml_dana' => $jml_dana->count(),
        'jml_dana_pake' => $jml_dana_pake ?? 0,
        'jml_pengadaan' => $jml_pengadaan->count(),
        'jml_png_pake' => $jml_png_pake ?? 0,
        'jml_sub_lapor' => $report->count() ?? $jml_sub_lapor
      ]);
    }
    $data = Activity::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
    $jml_sub = Activity::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->count();
    $jml_dana = SumberDana::all();
    $jml_pengadaan = Pengadaan::all();
    $report = Report::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->where('month_id', now()->format('n'))->where('status', 1)->get();
    $jml_sub_lapor = 0;
    foreach ($data as $key => $value) {
      $jml_dana_pake = $value->distinct()->count('sumber_dana_id');
      $jml_png_pake = $value->distinct()->count('pengadaan_id');
    }
    return view('admin.index', [
      'jml_sub' => $jml_sub,
      'jml_dana' => $jml_dana->count(),
      'jml_dana_pake' => $jml_dana_pake ?? 0,
      'jml_pengadaan' => $jml_pengadaan->count(),
      'jml_png_pake' => $jml_png_pake ?? 0,
      'jml_sub_lapor' => $report->count() ?? $jml_sub_lapor
    ]);
  }

  public function indexData()
  {
    if (Auth()->user()->isAdmin != 1) {
      // realisasi
      $data = DB::table('reports')->select('month_id', DB::raw('SUM(keuangan_sekarang) AS keuangan'))
        ->where('status', 1)
        ->where('user_id', Auth()->user()->id)
        ->where('pak_id', \session()->get('pak_id'))
        ->groupBy('month_id')
        ->get()->toArray();

      // target berdasarkan kondisi (\session()->get('kondisi'));
      $target = DB::table('t_keuangans')->select('month_id', DB::raw('SUM(anggaran) AS keuangan'))
        ->where('user_id', Auth()->user()->id)
        ->where('pak_id', \session()->get('pak_id'))
        ->where('kondisi', \intval(\session()->get('kondisi')))
        ->groupBy('month_id')
        ->get()->toArray();

      return \response()->json([
        'realisasi' => array_map(function ($n) {
          return \floatval($n);
        }, array_column($data, 'keuangan')),
        'target' => array_map(function ($n) {
          return \floatval($n);
        }, array_column($target, 'keuangan'))
      ]);
    }

    // realisasi
    $data = DB::table('reports')->select('month_id', DB::raw('SUM(keuangan_sekarang) AS keuangan'))
      ->where('status', 1)
      ->where('pak_id', \session()->get('pak_id'))
      ->groupBy('month_id')
      ->get()->toArray();

    // target berdasarkan kondisi (\session()->get('kondisi'));
    $target = DB::table('t_keuangans')->select('month_id', DB::raw('SUM(anggaran) AS keuangan'))
      ->where('pak_id', \session()->get('pak_id'))
      ->where('kondisi', \intval(\session()->get('kondisi')))
      ->groupBy('month_id')
      ->get()->toArray();

    return \response()->json([
      'realisasi' => array_map(function ($n) {
        return \floatval($n);
      }, array_column($data, 'keuangan')),
      'target' => array_map(function ($n) {
        return \floatval($n);
      }, array_column($target, 'keuangan'))
    ]);

    // $data = Report::select('month_id', 'keuangan_lalu', 'keuangan_sekarang')->where('status', 1)->where('pak_id', session()->get('pak_id'))->get()->groupBy('month_id'); 
    // return response()->json(['data' => $data]);
  }
  public function indexData2()
  {
    if (Auth()->user()->isAdmin != 1) {
      // realisasi
      $data = DB::table('reports')->select('month_id', DB::raw('AVG(kegiatan_sekarang) AS persentase'))
        ->where('status', 1)
        ->where('user_id', Auth()->user()->id)
        ->where('pak_id', \session()->get('pak_id'))
        ->groupBy('month_id')
        ->get()->toArray();

      $target = DB::table('targets')->select('month_id', DB::raw('AVG(persentase) AS persentase'))
        ->where('user_id', Auth()->user()->id)
        ->where('pak_id', \session()->get('pak_id'))
        ->groupBy('month_id')
        ->get()->toArray();

      return \response()->json([
        'realisasi' => array_map(function ($n) {
          return \floatval($n);
        }, array_column($data, 'persentase')),
        'target' => array_map(function ($n) {
          return \floatval($n);
        }, array_column($target, 'persentase'))
      ]);
    }

    // realisasi
    $data = DB::table('reports')->select('month_id', DB::raw('AVG(kegiatan_sekarang) AS persentase'))
      ->where('status', 1)
      ->where('pak_id', \session()->get('pak_id'))
      ->groupBy('month_id')
      ->get()->toArray();

    $target = DB::table('targets')->select('month_id', DB::raw('AVG(persentase) AS persentase'))
      ->where('pak_id', \session()->get('pak_id'))
      ->groupBy('month_id')
      ->get()->toArray();

    return \response()->json([
      'realisasi' => array_map(function ($n) {
        return \floatval($n);
      }, array_column($data, 'persentase')),
      'target' => array_map(function ($n) {
        return \floatval($n);
      }, array_column($target, 'persentase'))
    ]);
  }

  public function profil($id)
  {
    $user = User::firstWhere('id', $id);
    $kegiatan = Activity::where('user_id', $id)->where('pak_id', session()->get('pak_id'))->get()->count();
    $melapor = Report::where('user_id', $id)->where('pak_id', session()->get('pak_id'))->where('status', 1)->get()->groupBy('activity_id')->count();
    $anggaran = Activity::join('anggarans', 'activities.id', '=', 'anggarans.activity_id')->where('user_id', $id)->where('anggarans.pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->get()->sum('anggaran');
    return view('admin.profile', compact(['user', 'kegiatan', 'melapor', 'anggaran']));
  }
  public function updateProfil(Request $request, $id)
  {
    $user = User::findOrFail($id);
    try {
      //  dd($request->all(), time().'_'.$request->file('foto')->getClientOriginalName());
      if ($request->file('foto') != null) {
        $fileName = Auth()->user()->username . now()->format('d-M-Y') . time() . '.' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->storeAs('public/uploads', $fileName);
        $password = bcrypt($request->password) ?? $user->password;
        // dd($password);
        // $password = bcrypt($request->password);
        $user->update([
          'kode_SKPD' => $request->kode_skpd,
          'nama_SKPD' => $request->nama_skpd,
          'nama_KPA' => $request->nama_kpa,
          'nama_operator' => $request->nama_operator,
          'no_hp' => $request->no_hp,
          'no_kantor' => $request->no_kantor,
          'password' => $password,
          'foto' => $fileName
        ]);
      } else {
        $user->update([
          'kode_SKPD' => $request->kode_skpd,
          'nama_SKPD' => $request->nama_skpd,
          'nama_KPA' => $request->nama_kpa,
          'nama_operator' => $request->nama_operator,
          'no_hp' => $request->no_hp,
          'no_kantor' => $request->no_kantor,
          'password' => bcrypt($request->password)
        ]);
      }
      return back()->with('success', 'Berhasil merubah data profil anda.');
    } catch (\Throwable $th) {
      return back()->with('error', $th->getMessage());
    }
  }
}
