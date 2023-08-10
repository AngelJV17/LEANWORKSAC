<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viatico extends Model
{
    use HasFactory;

    protected $table = 'viaticos';

    public function _proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function _autorizado_por()
    {
        return $this->belongsTo(User::class, 'autorizado_por', 'id');
    }

    public function _responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id', 'id');
    }
}
