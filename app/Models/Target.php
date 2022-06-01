<?php

namespace App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

}
