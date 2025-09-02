<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    use HasFactory;

        public function cliente(){
            return $this->belongsTo(cliente::class);

    }

         public function user(){
             return $this->belongsTo(user::class);
   
    }

        public function comprobante(){
            return $this->belongsTo(comprobante::class);

    }

        public function productos(){
            return $this->belongsToMany(producto::class)->withTimestamps()
        ->withPivot('cantidad','precio_venta','descuento');
    }
}
