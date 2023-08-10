<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'codigo',
        'dni_ce',
        'foto',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'sexo',
        'celular',
        'direccion',
        'email',
        'password',
        'rol_id',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */

    public function rol(){
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }
}
