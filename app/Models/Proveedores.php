<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;

    public function productos()
    {
        return $this->belongsToMany(Productos::class, "inventarios", "proveedor_id", "producto_id");
    }
}
