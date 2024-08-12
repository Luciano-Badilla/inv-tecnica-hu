<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RolModel extends Model
{
    protected $table = 'roles';
    // Otros métodos y propiedades del modelo

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
