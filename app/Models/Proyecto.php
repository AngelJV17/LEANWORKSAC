<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }
    
    public function provincia(){
        return $this->belongsTo(Provincia::class, 'provincia_id', 'id');
    }

    public function distrito(){
        return $this->belongsTo(Distrito::class, 'distrito_id', 'id');
    }
}
