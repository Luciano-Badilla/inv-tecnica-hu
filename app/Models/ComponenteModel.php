<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComponenteModel extends Model
{
    use HasFactory;
    protected $fillable = ['tipo_id', 'nombre', 'stock', 'deposito_id'];

    protected $table = 'componente';
    public $timestamps = false;

    public function deposito()
    {
        return $this->belongsTo(DepositoModel::class, 'deposito_id');
    }

    // Definir la relación con TipoComponenteModel
    public function tipo()
    {
        return $this->belongsTo(TipoComponenteModel::class, 'tipo_id');
    }


    public function getComponentes()
    {
        return DB::table('componente')
            ->select('componente.*')
            ->get();
    }

    // En ComponenteModel.php
    // En ComponenteModel.php
    public function getComponenteByTipo($tipoNombre, $tipoNombre2)
    {
        return self::whereHas('tipo', function ($query) use ($tipoNombre, $tipoNombre2) {
            $query->where('nombre', $tipoNombre)
                ->orWhere('nombre', $tipoNombre2);
        })
            ->where('stock', '>', 0) // Filtrar por stock mayor a 0
            ->with(['tipo', 'deposito'])
            ->get();
    }

    public function getComponenteByTipoWithoutStock($tipoNombre, $tipoNombre2)
    {
        return self::whereHas('tipo', function ($query) use ($tipoNombre, $tipoNombre2) {
            $query->where('nombre', $tipoNombre)
                ->orWhere('nombre', $tipoNombre2);
        })
            ->with(['tipo', 'deposito'])
            ->get();
    }

    public function pcs()
    {
        return $this->belongsToMany(PcModel::class, 'componente_pc', 'componente_id', 'pc_id');
    }
}
