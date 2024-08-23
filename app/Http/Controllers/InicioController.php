<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriaModel;
use App\Models\User;

class InicioController extends Controller
{
    public function index(){
        $historia = New HistoriaModel();
        $historias = HistoriaModel::orderBy('created_at', 'desc')->limit(4)->get();
        $users = User::all();
        $lastDevicesUpdated = $historia->getLastDevicesUpdated();



        // Pasar los datos a la vista
        return view('inicio', ['lastDevicesUpdated' => $lastDevicesUpdated, 'users'=> $users, 'historias' => $historias]);
    }
}
