<?php

namespace App\Models;

use App\Models\Pak;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LockPak extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pak(){
        return $this->belongsTo(Pak::class);
    }

    public static function getdate($v){
        $data = Pak::firstWhere('id', $v);
        return $data->nama;
    }
}
