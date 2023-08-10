<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaControl extends Model
{
    use HasFactory;

    protected $table = 'control_caja';

    public function _responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id', 'id');
    }
}