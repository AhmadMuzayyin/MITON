<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Anggaran;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    public function printDAU(){
        if (Auth()->user()->isAdmin != 1) { 
            $ac = Activity::where('dau', "1")->where('pak_id', session()->get('pak_id'))->where('user_id', Auth()->user()->id)->get();
        
            if (!$ac->isEmpty()) {
                foreach($ac as $lp){
                    $dana = $lp->dau;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => 'dau',
                    'data' => $ac ? $ac : [],
                    'dana' => $dana ? "DAU" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                    
                ]);
            }

            return view('admin.print.index', [
                'print' => "dau",
                'data' => [],
                'data' => $ac ? $ac : [],
                'dana' => "DAU",
                'pak' => [],
                'skpd' => []
            ]);
        }

        $ac = Activity::where('dau', "1")->where('pak_id', session()->get('pak_id'))->get();
        
        if (!$ac->isEmpty()) {
            foreach($ac as $lp){
                $dana = $lp->dau;
                $pak = $lp->pak->nama;
                $skpd = $lp->user->nama_SKPD;
            }
            return view('admin.print.index', [
                'print' => 'dau',
                'data' => $ac ? $ac : [],
                'dana' => $dana ? "DAU" : [],
                'pak' => $pak ? $pak : [],
                'skpd' => $skpd ? $skpd : []
                
            ]);
        }

        return view('admin.print.index', [
            'print' => "dau",
            'data' => [],
            'data' => $ac ? $ac : [],
            'dana' => "DAU",
            'pak' => [],
            'skpd' => []
        ]);
    }

    public function printDAK(){
        if (Auth()->user()->isAdmin != 1) {
            $ac = Activity::where('dak', "1")->where('pak_id', session()->get('pak_id'))->where('user_id', Auth()->user()->id)->get();
        
                if (!$ac->isEmpty()) {foreach($ac as $lp){
                        $dana = $lp->dak;
                        $pak = $lp->pak->nama;
                        $skpd = $lp->user->nama_SKPD;
                    }
                    return view('admin.print.index', [
                        'print' => 'dak',
                        'data' => $ac ? $ac : [],
                        'dana' => $dana ? "DAK" : [],
                        'pak' => $pak ? $pak : [],
                        'skpd' => $skpd ? $skpd : []
                    ]);
                    
                }
                return view('admin.print.index', [
                    'print' => "dak",
                    'data' => [],
                    'dana' => "DAK",
                    'pak' => [],
                    'skpd' => []
                ]);
            }

            $ac = Activity::where('dak', "1")->where('pak_id', session()->get('pak_id'))->get();
        
                if (!$ac->isEmpty()) {foreach($ac as $lp){
                        $dana = $lp->dak;
                        $pak = $lp->pak->nama;
                        $skpd = $lp->user->nama_SKPD;
                    }
                    return view('admin.print.index', [
                        'print' => 'dak',
                        'data' => $ac ? $ac : [],
                        'dana' => $dana ? "DAK" : [],
                        'pak' => $pak ? $pak : [],
                        'skpd' => $skpd ? $skpd : []
                    ]);
                    
                }
                return view('admin.print.index', [
                    'print' => "dak",
                    'data' => [],
                    'dana' => "DAK",
                    'pak' => [],
                    'skpd' => []
                ]);
        }
        

    public function printDBHC(){
        if (Auth()->user()->isAdmin != 1) {
            $ac = Activity::where('dbhc', "1")->where('pak_id', session()->get('pak_id'))->where('user_id', Auth()->user()->id)->get();
        
            if (!$ac->isEmpty()) {
                foreach($ac as $lp){
                    $dana = $lp->dau;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => 'dbhc',
                    'data' => $ac ? $ac : [],
                    'dana' => $dana ? "DBHC" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                    
                ]);
            }
            return view('admin.print.index', [
                'print' => "dbhc",
                'data' => [],
                'dana' => "DBHC",
                'pak' => [],
                'skpd' => []
            ]);
        }

        $ac = Activity::where('dbhc', "1")->where('pak_id', session()->get('pak_id'))->get();
        
        if (!$ac->isEmpty()) {
            foreach($ac as $lp){
                $dana = $lp->dau;
                $pak = $lp->pak->nama;
                $skpd = $lp->user->nama_SKPD;
            }
            return view('admin.print.index', [
                'print' => 'dbhc',
                'data' => $ac ? $ac : [],
                'dana' => $dana ? "DBHC" : [],
                'pak' => $pak ? $pak : [],
                'skpd' => $skpd ? $skpd : []
                
            ]);
        }
        return view('admin.print.index', [
            'print' => "dbhc",
            'data' => [],
            'dana' => "DBHC",
            'pak' => [],
            'skpd' => []
        ]);
    }

    public function PrintKontruksi(){
        if (Auth()->user()->isAdmin != 1) {
            $data = Activity::where('pengadaan_id', 1)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "KONSTRUKSI" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "KONSTRUKSI",
                'pak' => [],
                'skpd' => []
            ]);
        }

        $data = Activity::where('pengadaan_id', 1)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "KONSTRUKSI" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "KONSTRUKSI",
                'pak' => [],
                'skpd' => []
            ]);

    }

    public function PrintBarang(){
        if (Auth()->user()->isAdmin != 1) {
            $data = Activity::where('pengadaan_id', 2)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "BARANG" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "BARANG",
                'pak' => [],
                'skpd' => []
            ]);
        }

        $data = Activity::where('pengadaan_id', 2)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "BARANG" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "BARANG",
                'pak' => [],
                'skpd' => []
            ]);
    }
    
    public function PrintKonsultasi(){
        if (Auth()->user()->isAdmin != 1) {
            $data = Activity::where('pengadaan_id', 3)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "KONSULTASI" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "KONSULTASI",
                'pak' => [],
                'skpd' => []
            ]);
        }

        $data = Activity::where('pengadaan_id', 3)->where('pak_id', session()->get('pak_id'))->get();
        
        if (!$data->isEmpty()) {
            foreach($data as $lp){
                $dana = $lp->pengadaan;
                $pak = $lp->pak->nama;
                $skpd = $lp->user->nama_SKPD;
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => $data ? $data : [],
                'dana' => $dana ? "KONSULTASI" : [],
                'pak' => $pak ? $pak : [],
                'skpd' => $skpd ? $skpd : []
            ]);
        }
        return view('admin.print.index', [
            'print' => "pengadaan",
            'data' => [],
            'dana' => "KONSULTASI",
            'pak' => [],
            'skpd' => []
        ]);
    }
    
    public function PrintLain(){
        if (Auth()->user()->isAdmin != 1) {
            $data = Activity::where('pengadaan_id', 4)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "JASA LAINNYA" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "JASA LAINNYA",
                'pak' => [],
                'skpd' => []
            ]);
        }
        $data = Activity::where('pengadaan_id', 4)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "JASA LAINNYA" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "JASA LAINNYA",
                'pak' => [],
                'skpd' => []
            ]);
    }
    public function prinprioritas(){
        if (Auth()->user()->isAdmin != 1) {
            $data = Activity::where('program', 'Ya')->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "PRIORITAS BUPATI" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "PRIORITAS BUPATI",
                'pak' => [],
                'skpd' => []
            ]);
        }
        $data = Activity::where('program', "Ya")->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $dana = $lp->pengadaan;
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                }
                return view('admin.print.index', [
                    'print' => "pengadaan",
                    'data' => $data ? $data : [],
                    'dana' => $dana ? "PRIORITAS BUPATI" : [],
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : []
                ]);
            }
            return view('admin.print.index', [
                'print' => "pengadaan",
                'data' => [],
                'dana' => "PRIORITAS BUPATI",
                'pak' => [],
                'skpd' => []
            ]);
    }
    public function prinkendala(){
        if (Auth()->user()->isAdmin != 1) {
            $data = Report::where('kendala', '!=', null)->where('status', 1)->where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        
            if (!$data->isEmpty()) {
                foreach($data as $lp){
                    $pak = $lp->pak->nama;
                    $skpd = $lp->user->nama_SKPD;
                    $anggaran = Anggaran::where('activity_id', $lp->activity_id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->first();
                }
                return view('admin.print.index', [
                    'print' => "kendala",
                    'data' => $data ? $data : [],
                    'dana' => "TERKENDALA",
                    'pak' => $pak ? $pak : [],
                    'skpd' => $skpd ? $skpd : [],
                    'anggaran' => $anggaran ?? 0
                ]);
            }
            return view('admin.print.index', [
                'print' => "kendala",
                'data' => [],
                'dana' => "TERKENDALA",
                'pak' => [],
                'skpd' => []
            ]);
        }
        $data = Report::where('kendala', '!=', null)->where('status', 1)->where('pak_id', session()->get('pak_id'))->get();
        if (!$data->isEmpty()) {
            foreach($data as $lp){
                $pak = $lp->pak->nama;
                $skpd = $lp->user->nama_SKPD;
                $anggaran = Anggaran::where('activity_id', $lp->activity_id)->where('pak_id', session()->get('pak_id'))->where('kondisi', session()->get('kondisi'))->first();
            }
            return view('admin.print.index', [
                'print' => "kendala",
                'data' => $data ? $data : [],
                'dana' => "TERKENDALA",
                'pak' => $pak ? $pak : [],
                'skpd' => $skpd ? $skpd : [],
                'anggaran' => $anggaran ?? 0
            ]);
        }
            return view('admin.print.index', [
                'print' => "kendala",
                'data' => [],
                'dana' => "TERKENDALA",
                'pak' => [],
                'skpd' => []
            ]);
    }

}
