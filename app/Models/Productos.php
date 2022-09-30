<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    public function inventario()
    {
        return $this->belongsToMany(Proveedores::class, "inventarios", "producto_id", "proveedor_id")
            ->withPivot("cantidad");
    }
    public function pedido()
    {
        return $this->belongsToMany(Pedido::class, "pedidos_productos", "pedido_id", 'producto_id')
            ->withPivot("cantidad");
    }
}
