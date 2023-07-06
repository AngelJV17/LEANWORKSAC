<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGlobal extends Model
{
    use HasFactory;

    protected $table = 'categorias_globales';

    public function categoria_padre()
    {
        return $this->belongsTo(CategoriaGlobal::class, 'parent_id');
    }
}
