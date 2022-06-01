<?php
namespace App\Helpers;

use App\Models\Anggaran;
use App\Models\Location;
use App\Models\Month;
use App\Models\Report;
use App\Models\Schedule;
use App\Models\UserPPTK;
use Illuminate\Support\Facades\Auth;

class FormatUang{

  public static function format($expression){
    return number_format($expression,0,',','.');
  }
  public static function persen($value, $total){
    $data =  $value && $total ? ($value/$total)*100 : 0;
    return $data;
  }
  public static function tanggal($value){
      $bulan = array (1 =>   'Januari',
          'Februari',
          'Maret',
          'April',
          'Mei',
          'Juni',
          'Juli',
          'Agustus',
          'September',
          'Oktober',
          'November',
          'Desember'
        );
    $split = explode('-', $value);
    return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
  }

  public static function getlokasi($value){
    $sc = Schedule::firstWhere('activity_id', $value);
    foreach ($sc->location as $key => $value) {
      $value = $value->lokasi;
    }
    return $value;
  }
  public static function getanggaran($value){
    foreach ($value as $item) {
      $val = Anggaran::where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->where('activity_id', $item->activity_id)->first();
    }
    return $val->anggaran;
  }
  public static function getLocation($value){
    foreach($value as $val){
      return $val->lokasi;
    }
  }
  public static function gettarget($val, $bulan){
    $sc = Schedule::firstWhere('activity_id', $val);
    foreach ($sc->target as $key => $value) {
      if($value->month_id == $bulan){
        return $value->persentase;
      }
    }
  }
  public static function jdwlTarget($val){
    $sc = Schedule::firstWhere('activity_id', $val);
    return $sc->target;
  }
  public static function getLkg($val, $dana, $bulan){
    $rp = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('month_id', $bulan)->where('activity_id', $val)->where('user_id', auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
    $rp2 = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('month_id', $bulan)->where('activity_id', $val)->where('pak_id', session()->get('pak_id'))->get();
    // $val = ($rp / 100) * 100 / 100;
    foreach ($rp as $key => $value) {
      $val = $value->kegiatan_sekarang;
    }
    foreach ($rp2 as $key => $value) {
      $val2 = $value->kegiatan_sekarang;
    }
    return Auth()->user()->isAdmin == 1 ? $val2 : $val;
  }
  public static function gettku($val, $data, $bulan){
    $sc = Schedule::firstWhere('activity_id', $val);
    foreach ($sc->t_keuangan as $key => $value) {
      if($value->month_id == $bulan){
        return ($value->anggaran / $data) * 100;
      }
    }
  }
  public static function getLP($val, $data, $dana, $bulan){
    $rp = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('month_id', $bulan)->where('activity_id', $val)->where('user_id', auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->sum('keuangan_sekarang');
    $rp2 = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('month_id', $bulan)->where('activity_id', $val)->where('pak_id', session()->get('pak_id'))->get()->sum('keuangan_sekarang');
    $dt = Auth()->user()->isAdmin == 1 ? $rp2 : $rp ;
    $val = ($dt / $data) * 100;
    return (int)$val;
  }
  public static function getLPR($val, $dana, $bulan){
    $data = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('month_id', $bulan)->where('activity_id', $val)->where('user_id', auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->sum('keuangan_sekarang');
    $data2 = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('month_id', $bulan)->where('activity_id', $val)->where('pak_id', session()->get('pak_id'))->get()->sum('keuangan_sekarang');
    return Auth()->user()->isAdmin == 1 ? $data2 : $data;
  }
  public static function getsisa($val, $data, $dana, $bulan){
    $rp = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('user_id', auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
    $rp2 = Report::where('status', 1)->where('sumber_dana_id', $dana)->where('activity_id', $val)->where('pak_id', session()->get('pak_id'))->get();
    $relanggaran = 0;
    for ($i=0; $i < $bulan; $i++) { 
      if (Auth()->user()->isAdmin != 1) {
        $relanggaran += $rp[$i]->keuangan_sekarang;
      }else{
        $relanggaran += $rp2[$i]->keuangan_sekarang;
      }
    }
    $val = $data - $relanggaran;
    return $val;
  }
  public static function getbobot($val, $data){
    $val = ($val / array_sum(array_column($data, 'total'))) * 100 / 100;
    return $val;
  }
  public static function getpptk($val){
    $sc = Schedule::firstWhere('activity_id', $val);
    foreach ($sc->pptk as $key => $value) {
      $val = UserPPTK::firstWhere('id', $value->user_p_p_t_k_id);
      $val = $val->nama;
    }
    return $val;
  }
  public static function getbulan($val){
    $val = Month::where('id', $val)->get();
    foreach ($val as $value) {
      $val = $value->nama;
    }
    return $val;
  }

  public static function getupdate($val){
    foreach ($val as $value){
      $val = $value->updated_at;
    }
    return $val;
  }
}