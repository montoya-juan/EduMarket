<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class persona extends Model
{
    use HasFactory;

    public function documento(){
        return $this->belongsTo(documento::class);
    }
    public function proveedore(){
        return $this->hasOne(proveedore::class);
    }
}
