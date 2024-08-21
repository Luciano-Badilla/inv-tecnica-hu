<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouterModel extends Model
{
    use HasFactory;
    protected $fillable = ['identificador', 'nombre', 'area_id', 'deposito_id', 'ip', 'marca_modelo','area_detalle'];

    protected $table = 'router';
    public $timestamps = false;

    public function deposito()
    {
        return $this->belongsTo(DepositoModel::class, 'deposito_id');
    }

    // Definir la relación con TipoComponenteModel
    public function area()
    {
        return $this->belongsTo(AreaModel::class, 'area_id');
    }
}
