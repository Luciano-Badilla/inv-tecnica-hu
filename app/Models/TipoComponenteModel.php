<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComponenteModel extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    protected $table = 'tipo_componente';
    public $timestamps = false;
    
}
