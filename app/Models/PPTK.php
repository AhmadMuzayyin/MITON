<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\UserPPTK;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PPTK extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

    public function user_pptk(){
        return $this->belongsTo(UserPPTK::class);
    }
}
