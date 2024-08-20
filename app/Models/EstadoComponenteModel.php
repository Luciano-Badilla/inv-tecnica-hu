<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoComponenteModel extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    protected $table = 'estado_componente';
    public $timestamps = false;

}
