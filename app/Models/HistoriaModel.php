<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaModel extends Model
{
    use HasFactory;

    protected $fillable = ['tecnico','detalle','componente_id','created_at','updated_at', 'tipo_id','motivo'];

    protected $table = 'historia';
}
