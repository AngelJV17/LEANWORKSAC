<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inversion extends Model
{
    use HasFactory;

    protected $table = 'inversiones';

    public function _realizadoPor()
    {
        return $this->belongsTo(User::class, 'realizado_por', 'id');
    }

    public function _proyecto(){
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }
}
