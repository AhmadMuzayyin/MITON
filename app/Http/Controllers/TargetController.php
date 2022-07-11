<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Month;
use App\Models\Report;
use App\Models\Target;
use App\Models\Schedule;
use App\Models\TKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    public function store(Request $request)
    {
        try {
            $target = Anggaran::where('activity_id', $request->ac)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->first();
            $keuangan = $request->keuangan;

            $ku = 0;
            foreach ($keuangan as $key => $item) {
                $ku += preg_replace("/[^0-9]/", "", $item[1]);
            }

            if (session()->get('kondisi') == 0) {
                $tg = 0;
                $targett = $request->target;
                foreach ($targett as $key => $item) {
                    $tg += $item[1];
                }

                $inp = (int)$ku;
                $tgrt = $target->anggaran;
                if ($inp < $tgrt) {
                    return response()->json(['error' => 'Nominal target keuangan tidak boleh kurang dari anggaran!']);
                } else {
                    if ($inp > $tgrt) {
                        return response()->json(['error' => 'Nominal target keuangan tidak boleh lebih dari anggaran!']);
                    } else {
                        if ($tg > ($tgrt / $tgrt) * 100) {
                            return response()->json(['error' => 'Persentase target kegiatan tidak boleh lebih dari 100%!']);
                        } else {
                            if ($tg < ($tgrt / $tgrt) * 100) {
                                return response()->json(['error' => 'Persentase target kegiatan tidak boleh kurang dari 100%!']);
                            } else {
                                $data = $request->all();
                                if (session()->get('kondisi') == 0) {
                                    foreach ($data['target'] as $key => $value) {
                                        $l = array(
                                            'schedule_id' => $request->id,
                                            'activity_id' => $request->ac,
                                            'pak_id' => session()->get('pak_id'),
                                            'user_id' => Auth()->user()->id,
                                            'month_id' => $value[0],
                                            'persentase' => $value[1],
                                            'progres' => ($ku / $tgrt) * 100,
                                        );
                                        $cek = Target::where('schedule_id', $request->id)->where('activity_id', $request->ac)->where('pak_id', session()->get('pak_id'))->where('month_id', $value[0])->first();
                                        !isset($cek) ? Target::create($l) : '';
                                    }
                                    foreach ($data["keuangan"] as $k => $item) {
                                        $k = array(
                                            'schedule_id' => $request->id,
                                            'activity_id' => $request->ac,
                                            'pak_id' => session()->get('pak_id'),
                                            'kondisi' => session()->get('kondisi'),
                                            'user_id' => Auth()->user()->id,
                                            'month_id' => $item[0],
                                            'anggaran' => $item[1],
                                            'progres' => ($ku / $tgrt) * 100,
                                        );
                                        $cek = TKeuangan::where('schedule_id', $request->id)->where('activity_id', $request->ac)->where('pak_id', session()->get('pak_id'))->where('month_id', $item[0])->where('kondisi', session()->get('kondisi'))->first();
                                        if (!isset($cek)) {
                                            $k = TKeuangan::create($k);
                                            $tr = Target::where('schedule_id', $request->id)->where('month_id', $item[0])->first();
                                            $r = new Report();
                                            $r->activity_id = $request->ac;
                                            $r->user_id = Auth()->user()->id;
                                            $r->pak_id = $target->pak_id;
                                            $r->month_id = $item[0];
                                            $dana = Activity::firstWhere('id', $request->ac);
                                            $r->sumber_dana_id = $dana->sumber_dana_id;
                                            $r->t_keuangan_id = $k->id;
                                            $r->target_id = $tr->id;
                                            $r->save();
                                        }
                                    }
                                } else {
                                    foreach ($data["keuangan"] as $k => $item) {
                                        $k = array(
                                            'schedule_id' => $request->id,
                                            'activity_id' => $request->ac,
                                            'pak_id' => session()->get('pak_id'),
                                            'kondisi' => session()->get('kondisi'),
                                            'user_id' => Auth()->user()->id,
                                            'month_id' => $item[0],
                                            'anggaran' => preg_replace("/[^0-9]/", "", $item[1]),
                                            'progres' => ($ku / $tgrt) * 100,
                                        );
                                        $cek = TKeuangan::where('schedule_id', $request->id)->where('activity_id', $request->ac)->where('pak_id', session()->get('pak_id'))->where('month_id', $item[0])->where('kondisi', session()->get('kondisi'))->first();
                                        !isset($cek) ? TKeuangan::create($k) : '';
                                    }
                                }

                                $s = Schedule::find($request->id);
                                if ($s->persentase == true) {
                                    $s->persentase = $s->persentase + 40;
                                    $s->save();
                                } else {
                                    $s->persentase = 40;
                                    $s->save();
                                }
                                return response()->json(['success', 'Data berhasil disimpan!']);
                            }
                        }
                    }
                }
            } else {
                $inp = (int)$ku;
                $tgrt = $target->anggaran;
                if ($inp < $tgrt) {
                    return response()->json(['error' => 'Nominal target keuangan tidak boleh kurang dari anggaran!']);
                } else {
                    if ($inp > $tgrt) {
                        return response()->json(['error' => 'Nominal target keuangan tidak boleh lebih dari anggaran!']);
                    } else {
                        $data = $request->all();
                        foreach ($data["keuangan"] as $k => $item) {
                            $k = array(
                                'schedule_id' => $request->id,
                                'activity_id' => $request->ac,
                                'pak_id' => session()->get('pak_id'),
                                'kondisi' => session()->get('kondisi'),
                                'user_id' => Auth()->user()->id,
                                'month_id' => $item[0],
                                'anggaran' => preg_replace("/[^0-9]/", "", $item[1]),
                                'progres' => ($ku / $tgrt) * 100,
                            );
                            $k = TKeuangan::create($k);
                        }

                        $s = Schedule::find($request->id);
                        if ($s->persentase == true) {
                            $s->persentase = $s->persentase + 40;
                            $s->save();
                        } else {
                            $s->persentase = 40;
                            $s->save();
                        }
                        return response()->json(['success', 'Data target kegiatan dan keuangan berhasil disimpan!']);
                    }
                }
            }
            return response()->json(['error', 'Data tidak dapat disimpan!']);
        } catch (\Illuminate\Database\QueryException $th) {
            return response()->json(['error', $th->errorInfo]);
        }
    }
    public function update(Request $request)
    {
        try {
            $target = Activity::find($request->ac)->anggaran()->where('kondisi', session()->get('kondisi'))->first();
            $keuangan = $request->keuangan;

            $ku = 0;
            foreach ($keuangan as $key => $item) {
                $ku += preg_replace("/[^0-9]/", "", $item[1]);
            }
            if (session()->get('kondisi') == 0) {
                $tg = 0;
                $targett = $request->target;
                foreach ($targett as $key => $item) {
                    $tg += $item[1];
                }
                $inp = (int)$ku;
                $tgrt = $target->anggaran;
                if ($inp < $tgrt) {
                    return response()->json(['error' => 'Nominal target keuangan tidak boleh kurang dari anggaran!']);
                } else {
                    if ($inp > $tgrt) {
                        return response()->json(['error' => 'Nominal target keuangan tidak boleh lebih dari anggaran!']);
                    } else {
                        if ($tg > ($tgrt / $tgrt) * 100) {
                            return response()->json(['error' => 'Nominal target tidak boleh lebih !']);
                        } else {
                            if ($tg < ($tgrt / $tgrt) * 100) {
                                return response()->json(['error' => 'Nominal target tidak boleh kurang !']);
                            } else {
                                $data = $request->all();
                                foreach ($data['target'] as $key => $value) {
                                    $l = array(
                                        'schedule_id' => $request->id,
                                        'month_id' => $value[0],
                                        'activity_id' => $request->ac,
                                        'paket_id' => session()->get('pak_id'),
                                        'user_id' => Auth()->user()->id,
                                        'persentase' => $value[1],
                                        'progres' => ($ku / $tgrt) * 100,
                                    );
                                    $getid = Target::where('schedule_id', $request->id)->where('month_id', $value[0])->first();
                                    $target = Target::find($getid->id);
                                    $l = $target->update($l);
                                }
                                foreach ($data["keuangan"] as $key => $item) {
                                    $k = array(
                                        'schedule_id' => $request->id,
                                        'month_id' => $item[0],
                                        'activity_id' => $request->ac,
                                        'paket_id' => session()->get('pak_id'),
                                        'kondisi' => session()->get('kondisi'),
                                        'user_id' => Auth()->user()->id,
                                        'anggaran' => preg_replace("/[^0-9]/", "", $item[1]),
                                        'progres' => ($ku / $tgrt) * 100,
                                    );
                                    $getidk = TKeuangan::where('schedule_id', $request->id)->where('month_id', $item[0])->where('kondisi', session()->get('kondisi'))->first();
                                    $keuangan = TKeuangan::find($getidk->id);
                                    $k = $keuangan->update($k);
                                }
                                return response()->json(['success', 'Data berhasil disimpan!']);
                            }
                        }
                    }
                }
            } else {
                $inp = (int)$ku;
                $tgrt = $target->anggaran;
                if ($inp < $tgrt) {
                    return response()->json(['error' => 'Nominal target keuangan tidak boleh kurang dari anggaran!']);
                } else {
                    if ($inp > $tgrt) {
                        return response()->json(['error' => 'Nominal target keuangan tidak boleh lebih dari anggaran!']);
                    } else {
                        $data = $request->all();
                        foreach ($data["keuangan"] as $key => $item) {
                            $k = array(
                                'schedule_id' => $request->id,
                                'month_id' => $item[0],
                                'activity_id' => $request->ac,
                                'paket_id' => session()->get('pak_id'),
                                'user_id' => Auth()->user()->id,
                                'anggaran' => preg_replace("/[^0-9]/", "", $item[1]),
                                'progres' => ($ku / $tgrt) * 100,
                            );
                            $getidk = TKeuangan::where('schedule_id', $request->id)->where('month_id', $item[0])->where('kondisi', session()->get('kondisi'))->first();
                            $keuangan = TKeuangan::find($getidk->id);
                            $k = $keuangan->update($k);
                        }
                        return response()->json(['success', 'Data berhasil disimpan!']);
                    }
                }
            }
            return response()->json(['error', 'Data tidak dapat disimpan!']);
        } catch (\Illuminate\Database\QueryException $th) {
            return response()->json(['error', $th->errorInfo]);
        }
    }
}
