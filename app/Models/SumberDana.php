<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SumberDana extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function activity(){
        return $this->hasMany(Activity::class);
    }
}
