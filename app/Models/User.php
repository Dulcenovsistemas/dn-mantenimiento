<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;


    /**
     * Los atributos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * Atributos ocultos.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Casts.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Sucursales a las que tiene acceso el usuario.
     */
    public function sucursales()
    {
        return $this->belongsToMany(Sucursal::class);
    }


    /**
     * Áreas a las que tiene acceso el usuario.
     */
    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }


    /**
     * Órdenes creadas por el usuario.
     */
    public function ordenesSolicitadas()
    {
        return $this->hasMany(
            OrdenTrabajo::class,
            'solicitante_id'
        );
    }


    /**
     * Órdenes tomadas/asignadas al usuario como técnico.
     */
    public function ordenesAsignadas()
    {
        return $this->hasMany(
            OrdenTrabajo::class,
            'tecnico_id'
        );
    }
}