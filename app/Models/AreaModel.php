<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','visible'];

    protected $table = 'area';
    public $timestamps = false;

    public function pc_area()
    {
        return $this->hasMany(PcModel::class, 'area_id');
    }

    public function findByName($name)
    {
        // Realiza una consulta a la base de datos para encontrar un área por nombre
        return $this->where('nombre', $name)->first();
    }
}
