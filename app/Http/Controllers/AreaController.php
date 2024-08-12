<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaModel;
use App\Models\HistoriaModel;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{   
    

    public function index(){
        $areas = AreaModel::all();
        $historias = HistoriaModel::where('tipo_id', 3)
            ->orderBy('created_at', 'desc')
            ->get();


        // Pasar los datos a la vista
        return view('gest_areas', ['areas' => $areas, 'historias' => $historias]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'addNombre' => 'required|string|max:255|unique:area,nombre',
        ]);

        // Crear un nuevo registro
        $area = new AreaModel();
        $area->nombre = $request->input('addNombre');
        $area->save();

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "creo el area: ".$request->input('addNombre');
        $historia->tipo_id = 3;
        $historia->save();

        return redirect()->back()->with('success', 'Area guardado correctamente.');
    }
    public function edit(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'editNombre' => 'required|string|max:255|unique:area,nombre',
        ]);
        
        $id = $request->input('editId');
        $area = AreaModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "edito el area: ".$area->nombre." a ".$request->input('editNombre');
        $historia->motivo = $request->input('editMotivo');
        $historia->tipo_id = 3;
        $historia->save();

        $area->nombre = $request->input('editNombre');
        $area->update();

        

        return redirect()->back()->with('success', 'Area editado correctamente.');
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        // Crear un nuevo registro
        $id = $request->input('deleteId');
        $area = AreaModel::find($id);
        
        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino el area: ".$area->nombre;
        $historia->motivo = $request->input('removeMotivo');
        $historia->tipo_id = 3;
        $historia->save();

        $area->delete();

        return redirect()->back()->with('success', 'Area eliminado correctamente.');
    }
}
