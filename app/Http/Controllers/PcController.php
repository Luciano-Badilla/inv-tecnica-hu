<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComponenteModel;
use App\Models\AreaModel;
use App\Models\TipoComponenteModel;
use App\Models\DepositoModel;
use App\Models\HistoriaModel;
use App\Models\PcModel;
use App\Models\ComponentePcModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PcController extends Controller
{


    public function index()
    {
        $componentesModel = new ComponenteModel();

        // Obtener todos los componentes con tipo y depósito
        $componentes = ComponenteModel::with(['tipo', 'deposito'])->get();

        // Obtener componentes por tipo con conexiones de tipo y depósito
        $motherboards = $componentesModel->getComponenteByTipo('Placa madre', '');
        $procesadores = $componentesModel->getComponenteByTipo('Procesador', '');
        $fuentes = $componentesModel->getComponenteByTipo('Fuente', '');
        $rams = $componentesModel->getComponenteByTipo('RAM', '');
        $discos = $componentesModel->getComponenteByTipo('HDD', 'SDD');

        $motherboardsWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('Placa madre', '');
        $procesadoresWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('Procesador', '');
        $fuentesWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('Fuente', '');
        $ramsWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('RAM', '');
        $discosWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('HDD', 'SDD');
        $pcs = PcModel::with(['area', 'deposito', 'componentes'])->get();

        // Obtener otras entidades
        $historias = HistoriaModel::where('tipo_id', 5)
            ->orderBy('created_at', 'desc')
            ->get();
        $tipos = TipoComponenteModel::all();
        $depositos = DepositoModel::all();
        $areas = AreaModel::all();

        // Pasar los datos a la vista
        return view('gest_pc', [
            'componentes' => $componentes,
            'historias' => $historias,
            'tipos' => $tipos,
            'depositos' => $depositos,
            'areas' => $areas,
            'motherboards' => $motherboards,
            'procesadores' => $procesadores,
            'fuentes' => $fuentes,
            'rams' => $rams,
            'discos' => $discos,
            'motherboardsWithoutStock' => $motherboardsWithoutStock,
            'procesadoresWithoutStock' => $procesadoresWithoutStock,
            'fuentesWithoutStock' => $fuentesWithoutStock,
            'ramsWithoutStock' => $ramsWithoutStock,
            'discosWithoutStock' => $discosWithoutStock,
            'pcs' => $pcs
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        // Validación
        $request->validate([
            'addNombre' => 'required|string|max:255|unique:pc,nombre',
            'addIdentificador' => 'required|string|max:255|unique:pc,identificador',
            'discos1' => 'nullable|array',
            'discos1.*' => 'nullable|string|max:255',
            'rams1' => 'nullable|array',
            'rams1.*' => 'nullable|string|max:255',
        ]);

        // Crear un nuevo registro
        $pc = new PcModel();
        $pc->nombre = $request->input('addNombre');
        $pc->identificador = $request->input('addIdentificador');
        $pc->ip = $request->input('addIp');
        $pc->deposito_id = $request->input('addDeposito');
        $pc->area_id = $request->input('addArea');
        $pc->save();

        // Guardar componentes
        $componentes = [
            $request->input('addMotherboard'),
            $request->input('addProcesador'),
            $request->input('addFuente')
        ];

        // Insertar los componentes
        foreach ($componentes as $componente_id) {
            if ($componente_id) { // Verificar que el ID no sea nulo
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $componente_id;
                $componente_pc->save();

                $componente = ComponenteModel::find($componente_id);
                $componente->stock = ($componente->stock - 1);
                $componente->update();
            }
        }

        // Insertar discos del primer modal
        $discos1 = $request->input('discos1', []);
        foreach ($discos1 as $componente_id) {
            if ($componente_id) { // Verificar que el ID no sea nulo
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $componente_id;
                $componente_pc->save();

                $componente = ComponenteModel::find($componente_id);
                $componente->stock = ($componente->stock - 1);
                $componente->update();
            }
        }

        // Insertar RAMs del primer modal
        $rams1 = $request->input('rams1', []);
        foreach ($rams1 as $componente_id) {
            if ($componente_id) { // Verificar que el ID no sea nulo
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $componente_id;
                $componente_pc->save();

                $componente = ComponenteModel::find($componente_id);
                $componente->stock = ($componente->stock - 1);
                $componente->update();
            }
        }

        // Guardar historia
        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "Creó la PC: " . $request->input('addIdentificador') . " - " . $request->input('addNombre');
        $historia->componente_id = $pc->id;
        $historia->tipo_id = 5;
        $historia->save();

        return redirect()->back()->with('success', 'PC guardada correctamente.');
    }


    public function edit(Request $request)
    {
        $user = Auth::user();

        $id = $request->input('editId');
        $componente = ComponenteModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "edito el componente: (" . $componente->nombre . ", tipo: " . $componente->tipo->nombre . ", deposito: " . $componente->deposito->nombre . ", stock: " . $componente->stock . ")";
        $historia->tipo_id = 5;

        $componente->tipo_id = $request->input('editTipo');
        $componente->deposito_id = $request->input('editDeposito');
        $componente->stock = $request->input('editStock');
        $componente->nombre = $request->input('editNombre');

        $historia->detalle = $historia->detalle . " a (" . $componente->nombre . ", tipo: " . $componente->tipo->nombre . ", deposito: " . $componente->deposito->nombre . ", stock: " . $componente->stock . ")";
        $historia->motivo = $request->input('editMotivo');
        $historia->save();
        $componente->update();



        return redirect()->back()->with('success', 'Componente editado correctamente.');
    }

    public function add_stock(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'editAddStock' => 'required',
        ]);

        $id = $request->input('editNombreStock');
        $componente = ComponenteModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "agrego " . $request->input('editAddStock') . " nuevos: " . $componente->nombre . "/s";
        $historia->motivo = $request->input('editAddStockMotivo');
        $historia->tipo_id = 5;
        $historia->save();

        $componente->stock = ($componente->stock + $request->input('editAddStock'));
        $componente->update();



        return redirect()->back()->with('success', 'Stock agregado correctamente.');
    }
    public function remove_stock(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'editRemoveStock' => 'required',
        ]);

        $id = $request->input('editNombreStock');
        $componente = ComponenteModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino " . $request->input('editRemoveStock') . " " . $componente->nombre . "/s";
        $historia->motivo = $request->input('editRemoveStockMotivo');
        $historia->tipo_id = 5;
        $historia->save();

        $componente->stock = ($componente->stock - $request->input('editRemoveStock'));
        $componente->update();



        return redirect()->back()->with('success', 'Stock eliminado correctamente.');
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        // Crear un nuevo registro
        $id = $request->input('deleteId');
        $pc = PcModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino el componente: " . $pc->nombre;
        $historia->motivo = $request->input('removeMotivo');
        $historia->tipo_id = 5;
        $historia->save();

        $pc->delete();

        return redirect()->back()->with('success', 'Pc eliminado correctamente.');
    }

    public function getHistoria($id)
    {
        $historias = HistoriaModel::where('componente_id', $id)->get();
        Log::info('Registros de historia obtenidos: ' . $historias);
        return response()->json(['historia' => $historias]);
    }
}
