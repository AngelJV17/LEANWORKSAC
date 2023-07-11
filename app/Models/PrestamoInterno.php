<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoInterno extends Model
{
    use HasFactory;

    protected $table = 'prestamos_internos';

    public function _autorizadoPor()
    {
        return $this->belongsTo(Usuario::class, 'autorizado_por', 'id');
    }

    public function _proyectoPrestador(){
        return $this->belongsTo(Proyecto::class, 'proyecto_prestador', 'id');
    }

    public function _proyectoAcreedor(){
        return $this->belongsTo(Proyecto::class, 'proyecto_acreedor', 'id');
    }

}
