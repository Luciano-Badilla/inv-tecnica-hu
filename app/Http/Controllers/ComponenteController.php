<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComponenteModel;
use App\Models\TipoComponenteModel;
use App\Models\DepositoModel;
use App\Models\HistoriaModel;
use App\Models\HDD;
use App\Models\SDD;
use Illuminate\Support\Facades\Auth;

class ComponenteController extends Controller
{


    public function index()
    {
        $componentes = ComponenteModel::with(['tipo', 'deposito'])->get();
        $historias = HistoriaModel::where('tipo_id', 4)
            ->orderBy('created_at', 'desc')
            ->get();
        $tipos = TipoComponenteModel::all();
        $depositos = DepositoModel::all();
        $nombresDepositos = DepositoModel::pluck('nombre');


        // Pasar los datos a la vista
        return view('gest_componentes', ['componentes' => $componentes, 'historias' => $historias, 'tipos' => $tipos, 'depositos' => $depositos, 'nombresDepositos' => $nombresDepositos]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'addNombre' => 'required|string|max:255|unique:componente,nombre',
            'addTipo' => 'required|integer',
            'addDeposito' => 'required|integer',
        ]);

        // Crear un nuevo registro
        $componente = new ComponenteModel();
        $componente->nombre = $request->input('addNombre');
        $componente->tipo_id = $request->input('addTipo');
        $componente->deposito_id = $request->input('addDeposito');
        //$componente->stock = $request->input('addStock');
        $componente->save();

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "creo el componente: " . $request->input('addNombre');
        $historia->tipo_id = 4;
        $historia->save();

        return redirect()->back()->with('success', 'Componente guardado correctamente.');
    }
    public function edit(Request $request)
    {
        $user = Auth::user();

        $id = $request->input('editId');
        $componente = ComponenteModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "edito el componente: (" . $componente->nombre . ", tipo: " . ($componente->tipo->nombre ?? 'no asignado') . ", deposito: " . ($componente->deposito->nombre ?? 'no asignado') . ", stock: " . $componente->stock . ")";
        $historia->tipo_id = 4;

        $componente->tipo_id = $request->input('editTipo');
        //$componente->deposito_id = $request->input('editDeposito');
        // $componente->stock = $request->input('editStock');
        $componente->nombre = $request->input('editNombre');

        $historia->detalle = $historia->detalle . " a (" . $componente->nombre . ", tipo: " . ($componente->tipo->nombre ?? 'no asignado') . ", deposito: " . ($componente->deposito->nombre ?? 'no asignado') . ", stock: " . $componente->stock . ")";
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
        $historia->tipo_id = 4;
        $historia->save();

        $componente->stock = ($componente->stock + $request->input('editAddStock'));
        $componente->update();



        return redirect()->back()->with('success', 'Stock agregado correctamente.');
    }
    public function remove_stock(Request $request)
    {
        $user = Auth::user();

        $id = $request->input('removeNombreStock');
        $componente = ComponenteModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino " . $request->input('removeStock') . " " . $componente->nombre . "/s";
        $historia->motivo = $request->input('removeStockMotivo');
        $historia->tipo_id = 4;
        $historia->save();

        $componente->stock = ($componente->stock - $request->input('removeStock'));
        $componente->update();



        return redirect()->back()->with('success', 'Stock eliminado correctamente.');
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        // Crear un nuevo registro
        $id = $request->input('deleteId');
        $componente = ComponenteModel::find($id);

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino el componente: " . $componente->nombre;
        $historia->motivo = $request->input('removeMotivo');
        $historia->tipo_id = 4;
        $historia->save();

        $componente->delete();

        return redirect()->back()->with('success', 'Componente eliminado correctamente.');
    }

    public function transfer(Request $request)
    {
        $user = Auth::user();

        // Obtener el ID del componente y otros datos del formulario
        $id = $request->input('transferNombre');
        $stockToTransfer = $request->input('transferStock');
        $depositoDestino = $request->input('transferDeposito');
        $motivo = $request->input('transferMotivo');

        // Encontrar el componente actual
        $componente = ComponenteModel::find($id);

        // Reducir el stock del componente original
        if ($componente->stock >= $stockToTransfer) {
            $componente->stock -= $stockToTransfer;
            $componente->save();
        } else {
            return redirect()->back()->with('error', 'Stock insuficiente en el depósito de origen.');
        }

        // Verificar si el depósito destino existe
        $depositoExiste = DepositoModel::find($componente->deposito_id);

        if ($componente->deposito_id == null || $depositoExiste == null) {
            // Si el depósito no está asignado o no existe, modificar el deposito_id del componente actual
            $componente->deposito_id = $depositoDestino;
            $componente->stock += $stockToTransfer; // Revertir la reducción de stock
            $componente->save();
        } else {
            // Buscar el componente en el depósito destino
            $componenteDestino = ComponenteModel::where('nombre', $componente->nombre)
                ->where('deposito_id', $depositoDestino)
                ->first();

            if ($componenteDestino) {
                // Si el componente ya existe en el depósito destino, actualizar su stock
                $componenteDestino->stock += $stockToTransfer;
                $componenteDestino->save();
            } else {
                // Si el componente no existe en el depósito destino, crear uno nuevo
                $newComponente = new ComponenteModel();
                $newComponente->nombre = $componente->nombre;
                $newComponente->tipo_id = $componente->tipo_id;
                $newComponente->deposito_id = $depositoDestino;
                $newComponente->stock = $stockToTransfer;
                $newComponente->save();
            }
        }

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "Transfirio " . $stockToTransfer . " unidades del componente " . $componente->nombre;
        $historia->motivo = $motivo;
        $historia->tipo_id = 6; // Tipo de transferencia
        $historia->save();

        return redirect()->back()->with('success', 'Componente transferido correctamente.');
    }
}
