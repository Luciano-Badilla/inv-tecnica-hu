<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaModel;
use App\Models\HistoriaModel;
use App\Models\EstadoComponenteModel;
use App\Models\TipoComponenteModel;
use App\Models\DepositoModel;
use App\Models\ComponenteModel;
use App\Models\RouterModel;
use App\Models\TelefonoModel;
use App\Models\ImpresoraModel;
use App\Models\PcModel;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{   
    

    public function index(){
        $estados = EstadoComponenteModel::all();
        $tipos = TipoComponenteModel::all();
        $depositos = DepositoModel::all();
        $areas = AreaModel::all();
        $historias = HistoriaModel::all();
        $componentes = ComponenteModel::all();
        $routers = RouterModel::all();
        $telefonos = TelefonoModel::all();
        $impresoras = ImpresoraModel::all();
        $pcs = PcModel::all();

        // Pasar los datos a la vista
        return view('nuevo_reporte', ['areas' => $areas, 'historias' => $historias, 'estados' => $estados, 'tipos' => $tipos, 'depositos'=>$depositos, 'componentes'=>$componentes, 'routers'=>$routers, 'telefonos'=>$telefonos, 'impresoras'=>$impresoras, 'pcs'=>$pcs]);
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
        $historia->detalle = "creo el area: ".$request->input('addNombre').".";
        $historia->motivo = "creacion de area.";
        $historia->tipo_id = 3;
        $historia->save();

        return redirect()->back()->with('success', 'Area guardada correctamente.');
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
        $historia->detalle = "edito el nombre del area: ".$area->nombre." a ".$request->input('editNombre').".";
        $historia->motivo = $request->input('editMotivo');
        $historia->tipo_id = 3;
        $historia->save();

        $area->nombre = $request->input('editNombre');
        $area->update();

        

        return redirect()->back()->with('success', 'Area editada correctamente.');
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        // Crear un nuevo registro
        $id = $request->input('deleteId');
        $area = AreaModel::find($id);
        
        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino el area: ".$area->nombre.".";
        $historia->motivo = $request->input('removeMotivo');
        $historia->tipo_id = 3;
        $historia->save();

        $area->delete();

        return redirect()->back()->with('success', 'Area eliminada correctamente.');
    }
}
