<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'cajas';

    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function _operacion(){
        return $this->belongsTo(CategoriaGlobal::class, 'operacion', 'id');
    }

    public function _tipo(){
        return $this->belongsTo(CategoriaGlobal::class, 'tipo', 'id');
    }

    public function _subtipo(){
        return $this->belongsTo(CategoriaGlobal::class, 'subtipo', 'id');
    }

    public function _autorizadoPor(){
        return $this->belongsTo(Usuario::class, 'autorizado_por', 'id');
    }

}
