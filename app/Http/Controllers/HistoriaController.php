<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriaModel;

class HistoriaController extends Controller
{
    public function index(){
        $historias = HistoriaModel::orderBy('created_at', 'desc')->get();



        // Pasar los datos a la vista
        return view('historia', ['historias' => $historias]);
    }
}
