<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'precio',
        'stock',
        'descripcion',
        'imagen',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
