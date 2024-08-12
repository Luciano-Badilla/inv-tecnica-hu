<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentePcModel extends Model
{
    use HasFactory;
    protected $fillable = ['componente_id','pc_id'];

    protected $table = 'componente_pc';
    public $timestamps = false;
    
}
