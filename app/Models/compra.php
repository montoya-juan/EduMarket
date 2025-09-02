<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compra extends Model
{
    use HasFactory;

    public function proveedore(){
        return $this->belongsTo(proveedore::class);
    }
    public function comprobante(){
        return $this->belongsTo(comprobante::class);
    }
    public function productos(){
        return $this->belongsToMany(producto::class)->withTimestamps()->withPivot('cantidad','precio_compra','precio_venta');
    }
}
