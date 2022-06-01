<?php

namespace App\Models;

use App\Models\PPTK;
use App\Models\Target;
use App\Models\Activity;
use App\Models\Location;
use App\Models\TKeuangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function activity(){
        return $this->belongsTo(Activity::class);
    }

    public function target(){
        return $this->hasMany(Target::class);
    }
    public function t_keuangan(){
        return $this->hasMany(TKeuangan::class);
    }
    public function location(){
        return $this->hasMany(Location::class);
    }
    public function pptk(){
        return $this->hasMany(PPTK::class);
    }
}
