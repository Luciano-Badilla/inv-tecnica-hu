<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentePcModel extends Model
{
    use HasFactory;
    protected $fillable = ['componente_id', 'pc_id'];

    protected $table = 'componente_pc';
    public $timestamps = false;

    public static function findCompByPc($Id)
    {
        return self::where('pc_id', $Id)->pluck('componente_id')->toArray();
    }

    public static function findComp($Id)
    {
        return self::where('componente_id', $Id)->first();
    }

    public function componente()
    {
        return $this->belongsTo(ComponenteModel::class, 'componente_id');
    }

    public static function getMotherboardIdByPc($pcId)
    {
        // Suponiendo que el tipo_id para "motherboard" es 1
        $motherboardTipoId = 5;

        // Obtener el ID del componente de tipo "motherboard" asociado a una PC
        $motherboardId = self::where('pc_id', $pcId)
            ->whereHas('componente', function ($query) use ($motherboardTipoId) {
                $query->where('tipo_id', $motherboardTipoId);
            })
            ->pluck('componente_id')
            ->first();

        return $motherboardId;
    }

    public static function getProcesadorIdByPc($pcId)
    {
        $processorTipoId = 4; // Ajusta según el tipo_id para "procesador"

        $processorId = self::where('pc_id', $pcId)
            ->whereHas('componente', function ($query) use ($processorTipoId) {
                $query->where('tipo_id', $processorTipoId);
            })
            ->pluck('componente_id')
            ->first();

        return $processorId;
    }

    // Obtener ID del componente de tipo "fuente" asociado a una PC específica
    public static function getFuenteIdByPc($pcId)
    {
        $powerSupplyTipoId = 2; // Ajusta según el tipo_id para "fuente"

        $powerSupplyId = self::where('pc_id', $pcId)
            ->whereHas('componente', function ($query) use ($powerSupplyTipoId) {
                $query->where('tipo_id', $powerSupplyTipoId);
            })
            ->pluck('componente_id')
            ->first();

        return $powerSupplyId;
    }

    public static function getPlacavidIdByPc($pcId)
    {
        $placavidTipoId = 7; // Ajusta según el tipo_id para "fuente"

        $placavidId = self::where('pc_id', $pcId)
            ->whereHas('componente', function ($query) use ($placavidTipoId) {
                $query->where('tipo_id', $placavidTipoId);
            })
            ->pluck('componente_id')
            ->first();

        return $placavidId;
    }

    public static function getRamsByPc($pcId)
    {
        $ramTipoId = 1; // Ajusta según el tipo_id para "RAM"

        // Obtener todos los ID de componentes de tipo "RAM" asociados a una PC
        $ramIds = self::where('pc_id', $pcId)
            ->whereHas('componente', function ($query) use ($ramTipoId) {
                $query->where('tipo_id', $ramTipoId);
            })
            ->pluck('componente_id')
            ->toArray();

        return $ramIds;
    }

    public static function getDiscosByPc($pcId)
    {
        $discoTipoIds = [3, 6]; // Ajusta según los tipo_id para "discos"

        // Obtener todos los ID de componentes de tipo "disco" asociados a una PC
        $discoIds = self::where('pc_id', $pcId)
            ->whereHas('componente', function ($query) use ($discoTipoIds) {
                $query->whereIn('tipo_id', $discoTipoIds);
            })
            ->pluck('componente_id')
            ->toArray();

        return $discoIds;
    }
}
