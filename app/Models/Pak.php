<?php

namespace App\Models;

use App\Models\LockPak;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pak extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function lockpak(){
        return $this->hasMany(LockPak::class);
    }
}
