<?php

namespace App\Models;

use App\Models\Pak;
use App\Models\User;
use App\Models\Report;
use App\Models\Anggaran;
use App\Models\Schedule;
use App\Models\Pengadaan;
use App\Models\SumberDana;
use App\Models\Pelaksanaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function schedule(){
        return $this->hasMany(Schedule::class);
    }

    public function report(){
        return $this->hasMany(Report::class);
    }

    public function pak(){
        return $this->belongsTo(Pak::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sumber_dana(){
        return $this->belongsTo(SumberDana::class);
    }

    public function pengadaan(){
        return $this->belongsTo(Pengadaan::class);
    }

    public function pelaksanaan(){
        return $this->belongsTo(Pelaksanaan::class);
    }
    public function anggaran(){
        return $this->hasMany(Anggaran::class);
    }
}
