<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositoModel extends Model
{
    use HasFactory;
    protected $fillable = ['identificador','nombre'];

    protected $table = 'deposito';
    public $timestamps = false;
    
    public function nombres()
    {
        return $this->hasMany(ComponenteModel::class, 'deposito_id');
    }

    public function pc_deposito()
    {
        return $this->hasMany(PcModel::class, 'deposito_id');
    }
}
