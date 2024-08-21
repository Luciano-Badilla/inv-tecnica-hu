<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriaModel;

class DispositivosController extends Controller
{
    public function index(){
        // Pasar los datos a la vista
        return view('dispositivos');
    }
}
