<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaModel extends Model
{
    use HasFactory;

    protected $fillable = ['tecnico', 'detalle', 'componente_id', 'created_at', 'updated_at', 'tipo_id', 'motivo', 'tipo_dispositivo'];

    protected $table = 'historia';

    public function getLastDevicesUpdated()
    {
        // Subconsulta para obtener la última fecha de actualización por componente_id
        $subquery = HistoriaModel::select('componente_id', DB::raw('MAX(created_at) as max_created_at'))
            ->whereNotNull('componente_id')
            ->groupBy('componente_id');

        // Consulta principal con JOIN para obtener los registros más recientes
        return HistoriaModel::joinSub($subquery, 'latest', function ($join) {
            $join->on('historia.componente_id', '=', 'latest.componente_id')
                ->on('historia.created_at', '=', 'latest.max_created_at');
        })
            ->select('historia.componente_id', 'historia.tipo_dispositivo', 'historia.created_at')
            ->distinct() // Aplicar distinct
            ->orderBy('historia.created_at', 'DESC') // Ordenar por created_at
            ->limit(3)
            ->get();
    }
}
