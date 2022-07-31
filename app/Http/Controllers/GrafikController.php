<?php

namespace App\Http\Controllers;

use App\Models\Pak;
use App\Models\User;
use App\Models\Month;
use App\Models\Grafik;
use App\Models\Report;
use App\Models\Target;
use App\Models\Activity;
use App\Models\Location;
use App\Models\Schedule;
use App\Helpers\FormatUang;
use App\Models\Anggaran;
use App\Models\Pengadaan;
use App\Models\PPTK;
use App\Models\SumberDana;
use App\Models\TKeuangan;
use App\Models\UserPPTK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;

class GrafikController extends Controller
{
    public function rekap()
    {
        if (Auth()->user()->isAdmin != 1) {
            $report = Report::join('targets', 'reports.target_id', '=', 'targets.id')->join('t_keuangans', 'reports.t_keuangan_id', '=', 't_keuangans.id')->join('users', 'reports.user_id', '=', 'users.id')->join('activities', 'reports.activity_id', '=', 'activities.id')->where('reports.user_id', Auth()->user()->id)->where('reports.pak_id', session()->get('pak_id'))->get();
            $data = $report->groupBy('month_id')->map(function ($row) {
                return [
                    'tKegiatan' => $row->sum('persentase'),
                    'OldrKegiatan' => $row->sum('kegiatan_lalu'),
                    'rKegiatan' => $row->sum('kegiatan_sekarang'),
                    'tKeuangan' => $row->sum('anggaran'),
                    'OldrKeuangan' => $row->sum('keuangan_lalu'),
                    'rKeuangan' => $row->sum('keuangan_sekarang'),
                    'opd' => $row[0]->nama_SKPD,
                    'cek' => $row
                ];
            });
            $paket = Activity::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->count();
            $anggaran = Activity::select(DB::raw('sum(anggaran) as total'))
                ->join('anggarans', 'anggarans.activity_id', '=', 'activities.id')
                ->where('anggarans.kondisi', session()->get('kondisi'))
                ->where('user_id', Auth()->user()->id)->first();
            $bulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
            return view('admin.grafik.rekap', [
                'data' => $data->toArray(),
                'bulan' => $bulan,
                'opd' => $opd ?? '',
                'paket' => $paket,
                'anggaran' => $anggaran->total,
            ]);
        }
        if (request()->all() == null) {
            $report = Report::join('users', 'reports.user_id', '=', 'users.id')
                ->join('activities', 'reports.activity_id', '=', 'activities.id')
                ->join('targets', 'reports.target_id', '=', 'targets.id')
                ->join('t_keuangans', 'reports.t_keuangan_id', '=', 't_keuangans.id')
                ->join('anggarans', 'reports.activity_id', '=', 'anggarans.activity_id')
                ->where('t_keuangans.pak_id', session()->get('pak_id'))
                ->where('reports.pak_id', session()->get('pak_id'))
                ->where('reports.month_id', now()->format('n'))
                ->where('reports.sumber_dana_id', 1)
                ->where('users.isAdmin', 0)
                ->get();
            // dd($report);
            $anggaran = 0;
            $paket = 0;
            $targetfisik = 0;
            $realisasifisik = 0;
            $targetkeuangan = 0;
            $realisasikeuangan = 0;
            foreach ($report as $key => $value) {
                $anggaran += $value->anggaran;
                $paket += $value->user->activity->count();
                $targetfisik += $value->target->persentase;
                $realisasifisik += $value->kegiatan_sekarang;
                $targetkeuangan += $value->t_keuangan->anggaran;
                $realisasikeuangan += $value->keuangan_sekarang;
            }
            $rekap = [
                'anggaran' => $anggaran,
                'paket' => $paket,
                'tgf' => $targetfisik,
                'rgf' => $realisasifisik,
                'tgu' => $targetkeuangan,
                'rgu' => $realisasikeuangan
            ];
            // dd($rekap);
            $bulan = Month::all();
            return view('admin.grafik.rakapAdmin', [
                'data' => $report ?? [],
                'bulan' => $bulan,
                'selected' => now()->format('n'),
                'dana' => SumberDana::all(),
                'selectedDana' => 1,
                'rekap' => $rekap
            ]);
        } else {
            if (request()->get('user') == 'all') {
                $report = Report::join('users', 'reports.user_id', '=', 'users.id')
                    ->join('activities', 'reports.activity_id', '=', 'activities.id')
                    ->join('targets', 'reports.target_id', '=', 'targets.id')
                    ->join('t_keuangans', 'reports.t_keuangan_id', '=', 't_keuangans.id')
                    ->join('anggarans', 'reports.activity_id', '=', 'anggarans.activity_id')
                    ->where('t_keuangans.pak_id', session()->get('pak_id'))
                    ->where('reports.pak_id', session()->get('pak_id'))
                    ->where('reports.month_id', request()->get('bulan'))
                    ->where('reports.sumber_dana_id', request()->get('dana'))
                    ->where('users.isAdmin', 0)
                    ->get();
                // dd($report);
                $anggaran = 0;
                $paket = 0;
                $targetfisik = 0;
                $realisasifisik = 0;
                $targetkeuangan = 0;
                $realisasikeuangan = 0;
                foreach ($report as $key => $value) {
                    $anggaran += $value->anggaran;
                    $paket += $value->user->activity->count();
                    $targetfisik += $value->target->persentase;
                    $realisasifisik += $value->kegiatan_sekarang;
                    $targetkeuangan += $value->t_keuangan->anggaran;
                    $realisasikeuangan += $value->keuangan_sekarang;
                }
                $rekap = [
                    'anggaran' => $anggaran,
                    'paket' => $paket,
                    'tgf' => $targetfisik,
                    'rgf' => $realisasifisik,
                    'tgu' => $targetkeuangan,
                    'rgu' => $realisasikeuangan
                ];
                $bulan = Month::all();
                return view('admin.grafik.rakapAdmin', [
                    'data' => $report ?? [],
                    'bulan' => $bulan,
                    'selected' => request()->get('bulan'),
                    'dana' => SumberDana::all(),
                    'selectedDana' => request()->get('dana'),
                    'rekap' => $rekap
                ]);
            } else {
                $report = Report::join('users', 'reports.user_id', '=', 'users.id')
                    ->join('activities', 'reports.activity_id', '=', 'activities.id')
                    ->join('targets', 'reports.target_id', '=', 'targets.id')
                    ->join('t_keuangans', 'reports.t_keuangan_id', '=', 't_keuangans.id')
                    ->join('anggarans', 'reports.activity_id', '=', 'anggarans.activity_id')
                    ->where('t_keuangans.pak_id', session()->get('pak_id'))
                    ->where('reports.pak_id', session()->get('pak_id'))
                    ->where('reports.month_id', request()->get('bulan'))
                    ->where('reports.sumber_dana_id', request()->get('dana'))
                    ->where('users.isAdmin', 0)
                    ->where('users.kode_SKPD', request()->get('user'))
                    ->get();
                // dd($report);
                $anggaran = 0;
                $paket = 0;
                $targetfisik = 0;
                $realisasifisik = 0;
                $targetkeuangan = 0;
                $realisasikeuangan = 0;
                foreach ($report as $key => $value) {
                    $anggaran += $value->anggaran;
                    $paket += $value->user->activity->count();
                    $targetfisik += $value->target->persentase;
                    $realisasifisik += $value->kegiatan_sekarang;
                    $targetkeuangan += $value->t_keuangan->anggaran;
                    $realisasikeuangan += $value->keuangan_sekarang;
                }
                $rekap = [
                    'anggaran' => $anggaran,
                    'paket' => $paket,
                    'tgf' => $targetfisik,
                    'rgf' => $realisasifisik,
                    'tgu' => $targetkeuangan,
                    'rgu' => $realisasikeuangan
                ];
                $bulan = Month::all();
                return view('admin.grafik.rakapAdmin', [
                    'data' => $report ?? [],
                    'bulan' => $bulan,
                    'selected' => request()->get('bulan'),
                    'dana' => SumberDana::all(),
                    'selectedDana' => request()->get('dana'),
                    'rekap' => $rekap
                ]);
            }
        }
    }
    public function getRekapAdmin(Request $request)
    {
        return response()->json([
            'success' => 'Success',
            'dana' => $request->dana,
            'bulan' => $request->bulan,
            'user' => $request->skpd
        ]);
    }

    public function arsip(Request $request)
    {
        if (Auth()->user()->isAdmin != 1) {
            if (request()->get('data') == null) {
                $dana = SumberDana::all();
                $data = Report::where('status', 1)->where('sumber_dana_id', 1)->where('user_id', Auth()->user()->id)->get()->groupBy('month_id');
                if (!$data->isEmpty()) {
                    foreach ($data as $value) {
                        $p = Month::where('id', $value[0]->month_id)->get();
                        $hasil[] = [
                            'bulan' => $p,
                        ];
                    }
                } else {
                    $hasil = '';
                }
                return view('admin.grafik.arsip', [
                    'data' => $hasil,
                    'dana' => $dana,
                    'selected' => 1,
                ]);
            } else {
                $data = Report::where('status', 1)->where('sumber_dana_id', request()->get('data'))->where('user_id', Auth()->user()->id)->get()->groupBy('month_id');
                if (!$data->isEmpty()) {
                    foreach ($data as $value) {
                        $p = Month::where('id', $value[0]->month_id)->get();
                        $hasil[] = [
                            'bulan' => $p,
                        ];
                    }
                    $dana = SumberDana::all();
                    return view('admin.grafik.arsip', [
                        'data' => $hasil,
                        'dana' => $dana,
                        'selected' => request()->get('data'),
                    ]);
                } else {
                    $dana = SumberDana::all();
                    return view('admin.grafik.arsip', [
                        'data' => '',
                        'hasil' => '',
                        'dana' => $dana,
                        'selected' => request()->get('data'),
                    ]);
                }
            }
        } else {
            if (request()->get('data') == null) {
                $dana = SumberDana::all();
                $skpd = User::firstWhere('isAdmin', 0);
                $data = Report::where('status', 1)->where('sumber_dana_id', 1)->where('user_id', $skpd->id)->get()->groupBy('month_id');
                $user = User::where('isAdmin', 0)->get();
                if (!$data->isEmpty()) {
                    foreach ($data as $value) {
                        $p = Month::where('id', $value[0]->month_id)->get();
                        $hasil[] = [
                            'bulan' => $p,
                        ];
                    }
                } else {
                    $hasil = '';
                }
                return view('admin.grafik.arsip', [
                    'data' => $hasil,
                    'dana' => $dana,
                    'skpd' => $user,
                    'selected' => 1,
                ]);
            } else {
                $data = Report::where('status', 1)->where('sumber_dana_id', request()->get('data'))->where('user_id', request()->get('skpd'))->get()->groupBy('month_id');
                $user = User::where('isAdmin', 0)->get();
                if (!$data->isEmpty()) {
                    foreach ($data as $value) {
                        $p = Month::where('id', $value[0]->month_id)->get();
                        $hasil[] = [
                            'bulan' => $p,
                        ];
                    }
                    $dana = SumberDana::all();
                    return view('admin.grafik.arsip', [
                        'data' => $hasil,
                        'dana' => $dana,
                        'skpd' => $user,
                        'selected' => request()->get('data'),
                    ]);
                } else {
                    $dana = SumberDana::all();
                    $user = User::where('isAdmin', 0)->get();
                    return view('admin.grafik.arsip', [
                        'data' => '',
                        'hasil' => '',
                        'dana' => $dana,
                        'skpd' => $user,
                        'selected' => request()->get('data'),
                    ]);
                }
            }
        }
    }

    public function getArsip(Request $request)
    {
        return response()->json([
            'success' => 'Success',
            'dana' => $request->dana,
            'skpd' => $request->skpd
        ]);
    }

    public function getCover(Request $request)
    {
        if (Auth()->user()->isAdmin == 1) {
            $data = request()->get('data') ? request()->get('data') : 1;
            $ac = Report::where('month_id', $request->bulan)->where('sumber_dana_id', $data)->where('status', 1)->where('pak_id', session()->get('pak_id'))->get();
            foreach ($ac as $i) {
                $sumberdana = SumberDana::where('id', $i->sumber_dana_id)->get()->first();
                $opd = User::where('id', $i->user_id)->get()->first();
                $bulan = Month::where('id', $i->month_id)->get()->first();
                $pak = $i->pak;
                $paket = Activity::where('id', $i->activity_id)->get();
                // $relanggaran = $i->sum('keuangan_sekarang');
                $relanggaran = $i->month_id == 1 ? $i->keuangan_sekarang : $i->keuangan_lalu + $i->keuangan_sekarang;
                $relkegiatan = $i->month_id == 1 ? $i->kegiatan_sekarang : $i->kegiatan_lalu + $i->kegiatan_sekarang;
                $anggaran = Anggaran::where('activity_id', $i->activity_id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->first();
                $hasil[] = [
                    'bulan' => $bulan->nama,
                    'realanggaran' => $relanggaran,
                    'relkegiatan' => $relkegiatan,
                    'paket' => $paket->count()
                ];
            }
            $rfk1 = array_sum(array_column($hasil, 'relkegiatan'));
            $rfk2 = number_format(($rfk1 / $paket->count()) * 100, 2);
            foreach ($ac as $val) {
                $data =  ($val->keuangan_sekarang / $anggaran->anggaran) * 100;
                $paketsatu = count($ac) == 0 ? count($ac) : 0;
                $paketdua = count($ac) < 25 ? count($ac) : 0;
                $pakettiga = count($ac) >= 25 ? (count($ac) <= 50 ? count($ac) : count($ac)) : 0;
                $paketempat = count($ac) >= 50 ? (count($ac) <= 75 ? count($ac) : count($ac)) : 0;
                $paketlima = count($ac) >= 75 ? (count($ac) <= 100 ? count($ac) : count($ac)) : 0;
                $paketenam = count($ac) == 100 ? count($ac) : 0;
                $klasifikasi = [
                    'paketsatu' => $paketsatu,
                    'paketdua' => $paketdua,
                    'pakettiga' => $pakettiga,
                    'paketempat' => $paketempat,
                    'paketlima' => $paketlima,
                    'paketenam' => $paketenam,
                ];
            }
            return view('admin.grafik.cover', [
                'data' => $hasil,
                'ag' => $ac,
                'klasifikasi' => $klasifikasi,
                'dana' => $sumberdana->nama,
                'bulan' => $bulan->nama,
                'pak' => $pak->nama,
                'opd' => $opd->nama_SKPD,
                'realkeuangan' => $relanggaran,
                'anggaran' => $anggaran->anggaran,
                'rata' => (int)$rfk2,
            ]);
        }
        $data = request()->get('data') ? request()->get('data') : 1;
        $ac = Report::where('month_id', $request->bulan)->where('sumber_dana_id', $data)->where('status', 1)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        foreach ($ac as $key => $i) {
            $sumberdana = SumberDana::where('id', $i->sumber_dana_id)->get()->first();
            $opd = User::where('id', $i->user_id)->get()->first();
            $bulan = Month::where('id', $i->month_id)->get()->first();
            $pak = $i->pak;
            $paket = Activity::where('id', $i->activity_id)->get();
            // $relanggaran = $i->sum('keuangan_sekarang');
            $relanggaran = $i->month_id == 1 ? $i->keuangan_sekarang : $i->keuangan_lalu + $i->keuangan_sekarang;
            $relkegiatan = $i->month_id == 1 ? $i->kegiatan_sekarang : $i->kegiatan_lalu + $i->kegiatan_sekarang;
            $anggaran = Anggaran::where('activity_id', $i->activity_id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->first();
            $hasil[] = [
                'bulan' => $bulan->nama,
                'paket' => $paket->count()
            ];
        }
        $dt = Report::where('sumber_dana_id', $data)->where('status', 1)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        $relanggaran = 0;
        $relkegiatan = 0;
        for ($i = 0; $i < $request->bulan; $i++) {
            $relanggaran += $dt[$i]->keuangan_sekarang;
            $relkegiatan += $dt[$i]->kegiatan_sekarang;
        }
        $rfk1 = array_sum(array_column($hasil, 'relkegiatan'));
        $rfk2 = number_format(($relkegiatan / $paket->count()) * 100 / 100, 2);
        foreach ($ac as $val) {
            $data =  ($val->keuangan_sekarang / $anggaran->anggaran) * 100;
            $paketsatu = count($ac) == 0 ? count($ac) : 0;
            $paketdua = count($ac) < 25 ? count($ac) : 0;
            $pakettiga = count($ac) >= 25 ? (count($ac) <= 50 ? count($ac) : count($ac)) : 0;
            $paketempat = count($ac) >= 50 ? (count($ac) <= 75 ? count($ac) : count($ac)) : 0;
            $paketlima = count($ac) >= 75 ? (count($ac) <= 100 ? count($ac) : count($ac)) : 0;
            $paketenam = count($ac) == 100 ? count($ac) : 0;
            $klasifikasi = [
                'paketsatu' => $paketsatu,
                'paketdua' => $paketdua,
                'pakettiga' => $pakettiga,
                'paketempat' => $paketempat,
                'paketlima' => $paketlima,
                'paketenam' => $paketenam,
            ];
        }
        return view('admin.grafik.cover', [
            'data' => $hasil,
            'ag' => $ac,
            'klasifikasi' => $klasifikasi,
            'dana' => $sumberdana->nama,
            'bulan' => $bulan->nama,
            'pak' => $pak->nama,
            'opd' => $opd->nama_SKPD,
            'realkeuangan' => $relanggaran,
            'anggaran' => $anggaran->anggaran,
            'rata' => $rfk2,
        ]);
    }

    public function getjadwal(Request $request)
    {
        if (Auth()->user()->isAdmin == 1) {
            $ag = Activity::where('sumber_dana_id', $request->data)->where('pak_id', session()->get('pak_id'))->get();
            foreach ($ag as $key => $val) {
                $dana = $val->sumber_dana->nama;
                $pak = $val->pak->nama;
                $opd = $val->user->nama_SKPD;
                $skpd = $val->user->nama_KPA;
            }
            $anggaran = Activity::join('anggarans', 'anggarans.activity_id', '=', 'activities.id')->where('sumber_dana_id', $request->data)->where('anggarans.pak_id', session()->get('pak_id'))->where('anggarans.kondisi', session()->get('kondisi'))->get()->sum('anggaran');
            $bulan = Month::all();
            return view('admin.grafik.jadwal', [
                'data' => $ag,
                'dana' => $dana,
                'pak' => $pak,
                'opd' => $opd,
                'skpd' => $skpd,
                'bulan' => $bulan,
                'anggaran' => $anggaran,
                'bln' => $request->bulan
            ]);
        }
        $ag = Activity::where('user_id', Auth()->user()->id)->where('sumber_dana_id', $request->data)->where('pak_id', session()->get('pak_id'))->get();
        foreach ($ag as $key => $val) {
            $dana = $val->sumber_dana->nama;
            $pak = $val->pak->nama;
            $opd = $val->user->nama_SKPD;
            $skpd = $val->user->nama_KPA;
        }
        $anggaran = Activity::join('anggarans', 'anggarans.activity_id', '=', 'activities.id')->where('sumber_dana_id', $request->data)->where('anggarans.pak_id', session()->get('pak_id'))->where('anggarans.kondisi', session()->get('kondisi'))->get()->sum('anggaran');
        $bulan = Month::all();
        return view('admin.grafik.jadwal', [
            'data' => $ag,
            'dana' => $dana,
            'pak' => $pak,
            'opd' => $opd,
            'skpd' => $skpd,
            'bulan' => $bulan,
            'anggaran' => $anggaran,
            'bln' => $request->bulan
        ]);
    }
    public function getRFK(Request $request)
    {
        if (Auth()->user()->isAdmin == 1) {
            $ag = Activity::where('sumber_dana_id', $request->data)->where('pak_id', session()->get('pak_id'))->get();
            foreach ($ag as $v) {
                $sumberdana = $v->sumber_dana;
                $pak = $v->pak;
                $opd = $v->user;
                $bulan = Month::where('id', $request->bulan)->first();
                $sub = $v;
                $total = Anggaran::where('activity_id', $v->id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->get()->sum('anggaran');
                $rp = Report::where('activity_id', $v->id)->where('month_id', $request->bulan)->where('status', 1)->where('pak_id', session()->get('pak_id'))->first();
                $schedul = Schedule::where('activity_id', $v->id)->get();
                foreach ($schedul as $val) {
                    $lokasi = $val->location;
                    $scid = $val->id;
                    $ta = Target::where('schedule_id', $scid)->where('month_id', $request->bulan)->get();
                    $target = $ta->sum('persentase');
                    $tku = TKeuangan::where('schedule_id', $scid)->where('month_id', $request->bulan)->first();
                }
                // dd($tku);
                $hasil[] = [
                    'sub' => $sub,
                    'lokasi' => $lokasi,
                    'total' => $total,
                    'target' => $target,
                    'tku' => ($tku->anggaran / $total) * 100,
                    'kglapor' => $rp->kegiatan_sekarang,
                    'kulapor' => ($rp->keuangan_sekarang / $total) * 100,
                    'kulapor2' => $rp->keuangan_sekarang,
                    'sisa' => $total - $rp->keuangan_sekarang,
                ];
            }
            return view('admin.grafik.rfk', [
                'dana' => $sumberdana,
                'pak' => $pak,
                'opd' => $opd,
                'data' => $hasil,
                'bulan' => $bulan,
                'total' => $total,
                'sisa' => $total - $rp->keuangan_sekarang,
            ]);
        }
        $ag = Activity::where('user_id', Auth()->user()->id)->where('sumber_dana_id', $request->data)->where('pak_id', session()->get('pak_id'))->get();
        // dd($ag);
        foreach ($ag as $v) {
            $sumberdana = $v->sumber_dana;
            $pak = $v->pak;
            $opd = $v->user;
            $bulan = Month::where('id', $request->bulan)->first();
            $sub = $v;
            $total = Anggaran::where('activity_id', $v->id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->get()->sum('anggaran');
            $rp = Report::where('activity_id', $v->id)->where('month_id', $request->bulan)->where('status', 1)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->first();
            $schedul = Schedule::where('activity_id', $v->id)->get();
            foreach ($schedul as $val) {
                $scid = $val->id;
                $ta = Target::where('schedule_id', $scid)->where('month_id', $request->bulan)->get();
                $target = $ta->sum('persentase');
                $tku = TKeuangan::where('schedule_id', $scid)->where('month_id', $request->bulan)->first();
            }
            // dd($tku);
            $hasil[] = [
                'sub' => $sub,
                'lokasi' => $scid,
                'total' => $total,
                'target' => $target,
                'tku' => ($tku->anggaran / $total) * 100,
                'kglapor' => $rp->kegiatan_sekarang,
                'kulapor' => ($rp->keuangan_sekarang / $total) * 100,
                'kulapor2' => $rp->keuangan_sekarang,
            ];
        }
        $dt = Report::where('sumber_dana_id', $request->data)->where('status', 1)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        $sisaTotal = 0;
        for ($i = 0; $i < $request->bulan; $i++) {
            $sisaTotal += $dt[$i]->keuangan_sekarang;
        }
        $sisa = $total - $sisaTotal;
        return view('admin.grafik.rfk', [
            'dana' => $sumberdana,
            'pak' => $pak,
            'opd' => $opd,
            'data' => $hasil,
            'bulan' => $bulan,
            'total' => $total,
            'sisa' => $sisa,
        ]);
    }

    public function getgrafik(Request $request)
    {
        if (Auth()->user()->isAdmin == 1) {
            $sumber = $request->data;
            $bulan = $request->bulan;
            $pak = \session()->get('pak_id');
            $kondisi = \session()->get('kondisi');

            // realisasi, sumber dana di report tidak bisa dipercaya
            $report = DB::table('reports')->join('activities', 'reports.activity_id', '=', 'activities.id')
                ->select('activities.id', 'kegiatan_sekarang', 'keuangan_sekarang')
                ->where('activities.sumber_dana_id', $sumber)
                ->where('activities.pak_id', $pak)
                ->where('month_id', $bulan)
                // ->where('kondisi', $kondisi)
                ->where('status', 1)->get()->toArray();
            $activities = \array_column($report, 'id');
            $keuangan = \array_sum(\array_column($report, 'keuangan_sekarang'));
            $kegiatan = count($activities) === 0 ? 0 : \array_sum(\array_column($report, 'kegiatan_sekarang')) / count($activities);

            // target kegiatan
            $target = DB::table('targets')->select(DB::raw('AVG(persentase) AS persentase'))
                ->whereIn('activity_id', $activities)
                ->where('month_id', $bulan)
                ->groupBy('month_id')
                ->get()->toArray();
            $tkegiatan = \floatval($target[0]->persentase);

            // target keuangan
            $query = DB::table('anggarans')->select(DB::raw('SUM(anggaran) AS anggaran'))
                ->whereIn('activity_id', $activities)
                ->where('kondisi', $kondisi)
                ->groupBy('kondisi')
                ->get()->toArray();
            $totalAnggaran = \floatval($query[0]->anggaran);
            $target = DB::table('t_keuangans')->select(DB::raw('SUM(anggaran) AS anggaran'))
                ->whereIn('activity_id', $activities)
                ->where('kondisi', $kondisi)
                ->where('month_id', $bulan)
                ->groupBy('month_id')
                ->get()->toArray();
            // keuangan dan target keuangan jadikan prosentase
            $keuangan = (100 * $keuangan) / $totalAnggaran;
            $tkeuangan = (100 * \floatval($target[0]->anggaran)) / $totalAnggaran;

            $ag = Activity::where('sumber_dana_id', $request->data)->where('pak_id', session()->get('pak_id'))->get();
            foreach ($ag as $v) {
                $sumberdana = $v->sumber_dana;
                $pak = $v->pak;
                $opd = $v->user;
                $bulan = Month::where('id', $request->bulan)->first();
            }
            return view('admin.grafik.grafikarsip', [
                'dana' => $sumberdana,
                'pak' => $pak,
                'opd' => $opd,
                'bulan' => $bulan,
                'kegiatan' => [$tkegiatan, $kegiatan],
                'keuangan' => [$tkeuangan, $keuangan]
            ]);
        }
        $sumber = $request->data;
        $bulan = $request->bulan;
        $user = Auth()->user()->id;
        $pak = \session()->get('pak_id');
        $kondisi = \session()->get('kondisi');

        // realisasi, sumber dana di report tidak bisa dipercaya
        $report = DB::table('reports')->join('activities', 'reports.activity_id', '=', 'activities.id')
            ->select('activities.id', 'kegiatan_sekarang', 'keuangan_sekarang')
            ->where('activities.sumber_dana_id', $sumber)
            ->where('activities.user_id', $user)
            ->where('activities.pak_id', $pak)
            ->where('month_id', $bulan)
            // ->where('kondisi', $kondisi)
            ->where('status', 1)->get()->toArray();
        $activities = \array_column($report, 'id');
        $keuangan = \array_sum(\array_column($report, 'keuangan_sekarang'));
        $kegiatan = count($activities) === 0 ? 0 : \array_sum(\array_column($report, 'kegiatan_sekarang')) / count($activities);

        // target kegiatan
        $target = DB::table('targets')->select(DB::raw('AVG(persentase) AS persentase'))
            ->whereIn('activity_id', $activities)
            ->where('month_id', $bulan)
            ->groupBy('month_id')
            ->get()->toArray();
        $tkegiatan = \floatval($target[0]->persentase);

        // target keuangan
        $query = DB::table('anggarans')->select(DB::raw('SUM(anggaran) AS anggaran'))
            ->whereIn('activity_id', $activities)
            ->where('kondisi', $kondisi)
            ->groupBy('kondisi')
            ->get()->toArray();
        $totalAnggaran = \floatval($query[0]->anggaran);
        $target = DB::table('t_keuangans')->select(DB::raw('SUM(anggaran) AS anggaran'))
            ->whereIn('activity_id', $activities)
            ->where('kondisi', $kondisi)
            ->where('month_id', $bulan)
            ->groupBy('month_id')
            ->get()->toArray();
        // keuangan dan target keuangan jadikan prosentase
        $keuangan = (100 * $keuangan) / $totalAnggaran;
        $tkeuangan = (100 * \floatval($target[0]->anggaran)) / $totalAnggaran;

        $ag = Activity::where('user_id', Auth()->user()->id)->where('sumber_dana_id', $request->data)->where('pak_id', session()->get('pak_id'))->get();
        foreach ($ag as $v) {
            $sumberdana = $v->sumber_dana;
            $pak = $v->pak;
            $opd = $v->user;
            $bulan = Month::where('id', $request->bulan)->first();
        }
        return view('admin.grafik.grafikarsip', [
            'dana' => $sumberdana,
            'pak' => $pak,
            'opd' => $opd,
            'bulan' => $bulan,
            'kegiatan' => [$tkegiatan, $kegiatan],
            'keuangan' => [$tkeuangan, $keuangan]
        ]);
    }
    public function dataGrafik()
    {
        $trkg = Target::where('month_id', request()->get('bulan'))->get()->groupBy('month_id');
        $trku = TKeuangan::where('month_id', request()->get('bulan'))->get()->groupBy('month_id');
        $lpkg = Report::where('month_id', request()->get('bulan'))->where('sumber_dana_id', request()->get('dana'))->where('status', 1)->get()->groupBy('month_id');
        $data = [
            'kegiatan' => $trkg,
            'keuangan' => $trku,
            'laporan' => $lpkg,
        ];
        return response()->json(['data' => $data]);
    }
    public function pengadaan()
    {
        return view('admin.grafik.pengadaan');
    }
    public function pengadaanData()
    {
        if (Auth()->user()->isAdmin != 1) {

            $data = DB::table('activities')->join('pengadaans', 'activities.pengadaan_id', '=', 'pengadaans.id')->where('user_id', auth()->user()->id)->select('pengadaans.*')->get()->groupBy('nama');
            return response()->json(['data' => $data]);
        }
        $data = DB::table('activities')->join('pengadaans', 'activities.pengadaan_id', '=', 'pengadaans.id')->select('pengadaans.*')->get()->groupBy('nama');
        return response()->json(['data' => $data]);
    }
    public function sebaran()
    {
        return view('admin.grafik.sebaran');
    }

    public function getSebaran()
    {
        if (Auth()->user()->isAdmin != 1) {
            $data = DB::table('locations')->join('schedules', 'schedules.id', '=', 'locations.schedule_id')->join('activities', 'schedules.activity_id', '=', 'activities.id')->where('activities.user_id', auth()->user()->id)->where('pak_id', session()->get('pak_id'))->select('locations.*')->get();
            return response()->json(['data' => $data]);
        }
        $data = DB::table('locations')->join('schedules', 'schedules.id', '=', 'locations.schedule_id')->join('activities', 'schedules.activity_id', '=', 'activities.id')->select('locations.*')->where('pak_id', session()->get('pak_id'))->get();
        return response()->json(['data' => $data]);
    }

    public function sumberdana()
    {
        return view('admin.grafik.sumber-dana');
    }
    public function getdana()
    {
        if (Auth()->user()->isAdmin != 1) {
            $data = DB::table('activities')->join('sumber_danas', 'activities.sumber_dana_id', '=', 'sumber_danas.id')->where('activities.user_id', auth()->user()->id)->select('sumber_danas.*')->get()->groupBy('nama');
            return response()->json(['data' => $data]);
        }
        $data = DB::table('activities')->join('sumber_danas', 'activities.sumber_dana_id', '=', 'sumber_danas.id')->select('sumber_danas.*')->get()->groupBy('nama');
        return response()->json(['data' => $data]);
    }
    public function pelaksanaan()
    {
        return view('admin.grafik.pelaksanaan');
    }
    public function getpelaksanaan()
    {
        if (Auth()->user()->isAdmin != 1) {
            $data = DB::table('activities')->join('pelaksanaans', 'activities.pelaksanaan_id', '=', 'pelaksanaans.id')->where('activities.user_id', auth()->user()->id)->select('pelaksanaans.*')->get()->groupBy('nama');
            return response()->json(['data' => $data]);
        }
        $data = DB::table('activities')->join('pelaksanaans', 'activities.pelaksanaan_id', '=', 'pelaksanaans.id')->select('pelaksanaans.*')->get()->groupBy('nama');
        return response()->json(['data' => $data]);
    }

    public function laporan()
    {
        if (Auth()->user()->isAdmin != 1) {
            $data = Report::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->groupBy('month_id');
            return view('admin.grafik.laporan', [
                'data' => $data ? $data : ''
            ]);
        }
        $data = Report::where('pak_id', session()->get('pak_id'))->get()->groupBy('month_id');
        return view('admin.grafik.laporan', [
            'data' => $data ? $data : ''
        ]);
    }

    public function realisasi()
    {
        if (request()->all() == null) {
            // Realisasi Kegiatan no filter
            $target = (Target::where('pak_id', session()->get('pak_id'))->sum('persentase') / 100);
            $rakg = [
                'target' => $target,
                'opdmelapor' => (Report::where('pak_id', session()->get('pak_id'))->where('status', 1)->sum('kegiatan_sekarang') / Target::where('pak_id', session()->get('pak_id'))->sum('persentase')) * 100 ?? 0,
                'opd' => User::where('isAdmin', 0)->get()
            ];

            // Realisasi Keangan no filter
            $report = Report::where('pak_id', session()->get('pak_id'))->where('status', 1)->where('sumber_dana_id', 1)->sum('keuangan_sekarang');
            $target = TKeuangan::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->sum('anggaran');
            $raku = [
                'target' => $target,
                'persenTarget' => $report > 0 ? number_format(($report / $target) * 100, 2) : 0,
                'persentase' => $report > 0 ? number_format(($report / $target) * 100, 2) : 0,
                'realanggaran' => $report,
                'anggaran' => Anggaran::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->sum('anggaran')
            ];

            return view('admin.grafik.realisasiAdmin', [
                'bulan' => Month::all(),
                'selected' => '',
                'dana' => SumberDana::all(),
                'selectedDana' => '',
                'rakg' => $rakg,
                'raku' => $raku
            ]);
        } else {
            // Realisasi Kegiatan with filter
            $cek = Activity::where('sumber_dana_id', request()->get('dana'))->join('t_keuangans', 'activities.id', '=', 't_keuangans.activity_id')->where('t_keuangans.month_id', request()->get('bulan'))->where('t_keuangans.pak_id', session()->get('pak_id'))->where('t_keuangans.kondisi', session()->get('kondisi'))->sum('anggaran');
            // dd($cek);
            $rakg = [
                'target' => Activity::where('sumber_dana_id', request()->get('dana'))->join('targets', 'activities.id', '=', 'targets.activity_id')->where('targets.month_id', request()->get('bulan'))->where('targets.pak_id', session()->get('pak_id'))->sum('persentase'),
                'opdmelapor' => Report::where('pak_id', session()->get('pak_id'))->where('status', 1)->where('sumber_dana_id', request()->get('dana'))->where('month_id', request()->get('bulan'))->sum('kegiatan_sekarang'),
                'opd' => User::where('isAdmin', 0)->get()
            ];
            // Realisasi Anggaran with filter
            $report = Report::where('pak_id', session()->get('pak_id'))->where('status', 1)->where('sumber_dana_id', request()->get('dana'))->where('month_id', request()->get('bulan'))->sum('keuangan_sekarang');
            $target = Activity::where('sumber_dana_id', request()->get('dana'))->join('t_keuangans', 'activities.id', '=', 't_keuangans.activity_id')->where('t_keuangans.month_id', request()->get('bulan'))->where('t_keuangans.pak_id', session()->get('pak_id'))->where('t_keuangans.kondisi', session()->get('kondisi'))->sum('anggaran');
            $raku = [
                'target' => $target,
                'persenTarget' => $report > 0 ? number_format(($report / $target) * 100, 2) : 0,
                'persentase' => $report > 0 ? number_format(($report / $target) * 100, 2) : 0,
                'realanggaran' => $report,
                'anggaran' => Anggaran::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->sum('anggaran')
            ];
            return view('admin.grafik.realisasiAdmin', [
                'bulan' => Month::all(),
                'selected' => request()->get('bulan'),
                'dana' => SumberDana::all(),
                'selectedDana' => request()->get('dana'),
                'rakg' => $rakg,
                'raku' => $raku
            ]);
        }
    }

    public function realPengadaan()
    {
        if (request()->all() == null) {
            $kegiatan = Activity::where('pak_id', session()->get('pak_id'))->get();
            $getpengadaan = Report::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->where('status', 1)->where('sumber_dana_id', 1)->get();
            $data = [
                'kegiatan' => $kegiatan,
                'getpengadaan' => $getpengadaan, //$getpengadaan->activity->pengadaan (ngambil realisasi melalui relasi ke table activity lalu ke table pengadaan)
            ];
            return response()->json($data);
        }
        $kegiatan = Activity::where('pak_id', session()->get('pak_id'))->get();
        $getpengadaan = Report::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->where('status', 1)->where('sumber_dana_id', request()->get('dana'))->where('month_id', request()->get('bulan'))->get();
        $data = [
            'kegiatan' => $kegiatan,
            'getpengadaan' => $getpengadaan, //$getpengadaan->activity->pengadaan (ngambil realisasi melalui relasi ke table activity lalu ke table pengadaan)
        ];
        return response()->json($data);
    }
    public function realDana()
    {
        if (request()->all() == null) {
            $kegiatan = Activity::where('pak_id', session()->get('pak_id'))->get();
            $getpengadaan = Report::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->where('status', 1)->where('sumber_dana_id', 1)->get();
            $data = [
                'kegiatan' => $kegiatan,
                'getpengadaan' => $getpengadaan, //$getpengadaan->activity->sumber_dana (ngambil realisasi melalui relasi ke table activity lalu ke table sumber_dana)
            ];
            return response()->json($data);
        }
        $kegiatan = Activity::where('pak_id', session()->get('pak_id'))->get();
        $getpengadaan = Report::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->where('status', 1)->where('sumber_dana_id', request()->get('dana'))->where('month_id', request()->get('bulan'))->get();
        $data = [
            'kegiatan' => $kegiatan,
            'getpengadaan' => $getpengadaan, //$getpengadaan->activity->sumber_dana (ngambil realisasi melalui relasi ke table activity lalu ke table sumber_dana)
        ];
        return response()->json($data);
    }

    public function cetakRekap()
    {
        return view('admin.print.rekapAdmin');
    }
}
