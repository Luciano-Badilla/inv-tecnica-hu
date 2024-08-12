<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    protected $table = 'area';
    public $timestamps = false;

    public function pc_area()
    {
        return $this->hasMany(PcModel::class, 'area_id');
    }
}
