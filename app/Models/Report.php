<?php

namespace App\Models;

use App\Models\Pak;
use App\Models\User;
use App\Models\Month;
use App\Models\Target;
use App\Models\Activity;
use App\Models\TKeuangan;
use App\Models\SumberDana;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pak(){
        return $this->belongsTo(Pak::class);
    }

    public function activity(){
        return $this->belongsTo(Activity::class);
    }
    public function activities(){
        return $this->belongsTo(Activity::class, 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function month(){
        return $this->belongsTo(Month::class);
    }
    public function target(){
        return $this->belongsTo(Target::class);
    }
    public function t_keuangan(){
        return $this->belongsTo(TKeuangan::class);
    }
    public function sumber_dana(){
        return $this->belongsTo(SumberDana::class);
    }
}
