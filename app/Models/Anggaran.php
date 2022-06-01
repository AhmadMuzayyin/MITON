<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function activity(){
        return $this->belongsTo(Activity::class);
    }
}
