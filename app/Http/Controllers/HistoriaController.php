<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriaModel;
use App\Models\User;

class HistoriaController extends Controller
{
    public function index(){
        $historias = HistoriaModel::orderBy('created_at', 'desc')->get();
        $users = User::all();



        // Pasar los datos a la vista
        return view('historia', ['historias' => $historias, 'users'=> $users]);
    }
}
