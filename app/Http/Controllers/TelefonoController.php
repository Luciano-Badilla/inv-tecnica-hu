<?php

namespace App\Http\Controllers;

use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use App\Models\ComponenteModel;
use App\Models\AreaModel;
use App\Models\TipoComponenteModel;
use App\Models\DepositoModel;
use App\Models\HistoriaModel;
use App\Models\PcModel;
use App\Models\ComponentePcModel;
use App\Models\EstadoComponenteModel;
use App\Models\TelefonoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TelefonoController extends Controller
{

    public function index()
    {
        $componentesModel = new ComponenteModel();

        // Obtener componentes por tipo con conexiones de tipo y depósito
        $telefonos = TelefonoModel::with(['area', 'deposito'])->get();

        // Obtener otras entidades
        $historias = HistoriaModel::where('tipo_id', 8)
            ->orderBy('created_at', 'desc')
            ->get();
        $tipos = TipoComponenteModel::all();
        $depositos = DepositoModel::all();
        $areas = AreaModel::orderBy('nombre', 'asc')
            ->get();

        // Pasar los datos a la vista
        return view('gest_telefonos', [
            'historias' => $historias,
            'depositos' => $depositos,
            'areas' => $areas,
            'telefonos' => $telefonos
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $areaModel = new AreaModel();

        // Validación
        $request->validate([
            'addNombre' => 'required|string|max:255|unique:pc,nombre',
            'addIdentificador' => 'required|string|max:255|unique:pc,identificador'
        ]);

        // Crear un nuevo registro
        $telefono = new TelefonoModel();
        $telefono->nombre = $request->input('addNombre');
        $telefono->identificador = $request->input('addIdentificador');
        $telefono->ip = $request->input('addIp');
        $telefono->deposito_id = $request->input('addDeposito');
        if (!$request->input('addDeposito')) {
            if ($request->input('addNroConsul')) {
                $area = AreaModel::find($request->input('addArea'))->nombre . " " . $request->input('addNroConsul');
            } else {
                $area = AreaModel::find($request->input('addArea'))->nombre;
            }
            if ($areaModel->findByName($area)) {
                $telefono->area_id = $areaModel->findByName($area)->id;
            } else {
                $areaNueva = new AreaModel();
                $areaNueva->nombre = $area;
                $areaNueva->visible = false;
                $areaNueva->save();

                $telefono->area_id = $areaNueva->id;
            }
        }
        $telefono->marca_modelo = $request->input('addMarca');
        $telefono->numero = $request->input('addNumero');
        $telefono->save();

        // Guardar historia
        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "cargo el telefono: " . $request->input('addIdentificador') . " - " . $request->input('addNombre') . " - " . $request->input('addMarca') . ".";
        $historia->motivo = "carga de telefono";
        $historia->componente_id = $telefono->id;
        $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
        $historia->tipo_id = 8;
        $historia->save();

        return redirect()->back()->with('success', 'Telefono guardada correctamente.');
    }


    public function edit(Request $request)
    {
        $user = Auth::user();
        $areaModel = new AreaModel();


        $id = $request->input('editId');
        $pc = PcModel::find($id);
        $telefono = TelefonoModel::find($id);



        if ($request->input("editDetalle") != null || $request->input("editDetalle") != "") {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = $request->input("editDetalle");
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }

        if ($telefono->numero != $request->input('editNumero')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "cambio el numero del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . $telefono->numero . " a " . $request->input('editNumero') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $telefono->numero = $request->input('editNumero');

        // Actualizar información básica del telefono
        if ($telefono->deposito_id != $request->input('editDeposito') && $request->input('editDeposito') != null) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el deposito del Telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . (DepositoModel::find($telefono->deposito_id)->nombre ?? "deposito no asignado") . " a " . DepositoModel::find($request->input('editDeposito'))->nombre ?? "deposito no asignado" . ", se quito del area: " . AreaModel::find($telefono->area_id)->nombre ?? "area no asignada" . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
            $telefono->deposito_id = $request->input('editDeposito');
            $telefono->area_id = null;
        }

        if ($telefono->area_id != $request->input('editArea') && $request->input('editArea') != null) {
            if ($request->input('editArea') == 27) {
                $area = AreaModel::find($request->input('editArea'))->nombre . " " . ($request->input('editNroConsul') ?? '');
            } else {
                $area = AreaModel::find($request->input('editArea'))->nombre;
            }
            
            if ($areaModel->findByName($area)) {
                $historia = new HistoriaModel();
                $historia->tecnico = $user->name;
                $historia->detalle = "editó el area del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . (AreaModel::find($telefono->area_id)->nombre ?? " area no asignada") . " a " . $area ?? " area no asignada" . ", se quito del deposito: " . DepositoModel::find($telefono->deposito_id)->nombre ?? "deposito no asignado" . ".";
                $historia->motivo = $request->input('editMotivo');
                $historia->componente_id = $telefono->id;
                $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
                $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
                $historia->save();

                $telefono->area_id = $areaModel->findByName($area)->id;
                $telefono->deposito_id = null;
            } else {
                $areaNueva = new AreaModel();
                $areaNueva->nombre = $area;
                $areaNueva->visible = false;
                $areaNueva->save();

                $historia = new HistoriaModel();
                $historia->tecnico = $user->name;
                $historia->detalle = "editó el area del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . (AreaModel::find($telefono->area_id)->nombre ?? " area no asignada") . " a " . $area ?? " area no asignada" . ", se quito del deposito: " . DepositoModel::find($telefono->deposito_id)->nombre ?? "deposito no asignado" . ".";
                $historia->motivo = $request->input('editMotivo');
                $historia->componente_id = $telefono->id;
                $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
                $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
                $historia->save();

                $telefono->area_id = $areaNueva->id;
            }
        }

        if ($telefono->ip != $request->input('editIp')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó la IP del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . $telefono->ip . " a " . $request->input('editIp') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $telefono->ip = $request->input('editIp');

        if ($telefono->marca_modelo != $request->input('editMarca')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó la marca y el modelo del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . $telefono->marca_modelo . " a " . $request->input('editMarca') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $telefono->marca_modelo = $request->input('editMarca');

        if ($telefono->nombre != $request->input('editNombre')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el nombre del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . $telefono->nombre . " a " . $request->input('editNombre') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $telefono->nombre = $request->input('editNombre');


        if ($telefono->identificador != $request->input('editIdentificador')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el identificador del telefono: " . $telefono->identificador . " - " . $telefono->nombre . " de " . $telefono->identificador . " a " . $request->input('editIdentificador') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $telefono->id;
            $historia->tipo_dispositivo = 'Telefono'; // Tipo de transferencia
            $historia->tipo_id = 8; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $telefono->identificador = $request->input('editIdentificador');

        $telefono->update();

        return redirect()->back()->with('success', 'Telefono editado correctamente.');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        // Crear un nuevo registro
        $id = $request->input('deleteId');
        $telefono = TelefonoModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino la telefono: " . $telefono->identificador . " - " . $telefono->nombre;
        $historia->motivo = $request->input('removeMotivo');
        $historia->tipo_id = 8;
        $historia->save();

        $telefono->delete();

        return redirect()->back()->with('success', 'Telefono eliminado correctamente.');
    }

    public function getHistoria($id)
    {
        $historias = HistoriaModel::where('componente_id', $id)->get();
        return response()->json(['historia' => $historias]);
    }
}
