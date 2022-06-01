<?php

namespace App\Models;

use App\Models\PPTK;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPPTK extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pptk(){
        return $this->hasMany(PPTK::class);
    }
}
