<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    public function productos()
    {
        return $this->belongsToMany(Productos::class, "pedidos_productos", "pedido_id", "producto_id")
            ->withPivot("cantidad");
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, "cliente_id");
    }
}
