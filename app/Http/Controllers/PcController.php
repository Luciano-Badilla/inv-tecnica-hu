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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PcController extends Controller
{


    public function index()
    {
        $componentesModel = new ComponenteModel();

        // Obtener todos los componentes con tipo y depósito
        $componentes = ComponenteModel::with(['tipo', 'deposito', 'estado'])->get();

        // Obtener componentes por tipo con conexiones de tipo y depósito
        $motherboards = $componentesModel->getComponenteByTipo('Placa madre', '');
        $procesadores = $componentesModel->getComponenteByTipo('Procesador', '');
        $fuentes = $componentesModel->getComponenteByTipo('Fuente', '');
        $placasvid = $componentesModel->getComponenteByTipo('Placa de video', '');
        $rams = $componentesModel->getComponenteByTipo('RAM', '');
        $discos = $componentesModel->getComponenteByTipo('HDD', 'SDD');

        $motherboardsEnUso = $componentesModel->getComponenteByTipoBystate('Placa madre', '');
        $procesadoresEnUso = $componentesModel->getComponenteByTipoBystate('Procesador', '');
        $fuentesEnUso = $componentesModel->getComponenteByTipoBystate('Fuente', '');
        $placasvidEnUso = $componentesModel->getComponenteByTipoBystate('Placa de video', '');
        $ramsEnUso = $componentesModel->getComponenteByTipoBystate('RAM', '');
        $discosEnUso = $componentesModel->getComponenteByTipoBystate('HDD', 'SDD');

        $motherboardsWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('Placa madre', '');
        $procesadoresWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('Procesador', '');
        $fuentesWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('Fuente', '');
        $ramsWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('RAM', '');
        $discosWithoutStock = $componentesModel->getComponenteByTipoWithoutStock('HDD', 'SDD');
        $pcs = PcModel::with(['area', 'deposito', 'componentes.tipo'])->get();

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
            'motherboardsEnUso' => $motherboardsEnUso,
            'procesadoresEnUso' => $procesadoresEnUso,
            'fuentesEnUso' => $fuentesEnUso,
            'ramsEnUso' => $ramsEnUso,
            'discosEnUso' => $discosEnUso,
            'motherboardsWithoutStock' => $motherboardsWithoutStock,
            'procesadoresWithoutStock' => $procesadoresWithoutStock,
            'fuentesWithoutStock' => $fuentesWithoutStock,
            'ramsWithoutStock' => $ramsWithoutStock,
            'discosWithoutStock' => $discosWithoutStock,
            'pcs' => $pcs,
            'placasvidEnUso' => $placasvidEnUso,
            'placasvid' => $placasvid
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
            $request->input('addFuente'),
            $request->input('addPlacavid')
        ];

        // Insertar los componentes
        foreach ($componentes as $componente_id) {
            if ($componente_id) { // Verificar que el ID no sea nulo
                $componenteController = new ComponenteController();
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $componenteController->transferStateByPc($componente_id, 1, 5, "creacion de PC", $pc->identificador, $pc->nombre, true);
                $componente_pc->save();
            }
        }

        // Insertar discos del primer modal
        $discos1 = $request->input('discos1', []);
        $stockToTransfer = 0;
        $discosAgrupados = [];

        foreach ($discos1 as $componente_id) {
            if ($componente_id) {
                $componente = ComponenteModel::find($componente_id);

                // Agrupar los discos por nombre
                if (isset($discosAgrupados[$componente->nombre])) {
                    $discosAgrupados[$componente->nombre]['cantidad'] += 1;
                } else {
                    $discosAgrupados[$componente->nombre] = [
                        'componente_id' => $componente_id,
                        'cantidad' => 1
                    ];
                }

                // Realizar la transferencia del estado
                $componenteController = new ComponenteController();
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $componenteController->transferStateByPc($componente_id, 1, 5, "creacion de PC", $pc->identificador, $pc->nombre, false);
                $componente_pc->save();
            }
        }

        // Guardar la historia por cada grupo de discos
        foreach ($discosAgrupados as $nombre => $datos) {
            $stockToTransfer = $datos['cantidad'];

            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "uso " . $stockToTransfer . " " . $nombre . "/s para el armado de la PC: " . $pc->identificador . " - " . $pc->nombre . ".";
            $historia->motivo = "creacion de PC";
            $historia->tipo_id = 4; // Tipo de transferencia
            $historia->save();
        }


        // Insertar RAMs del primer modal
        $rams1 = $request->input('rams1', []);
        $stockToTransfer = 0;
        $ramsAgrupados = [];

        foreach ($rams1 as $componente_id) {
            if ($componente_id) {
                $componente = ComponenteModel::find($componente_id);

                // Agrupar las RAMs por nombre
                if (isset($ramsAgrupados[$componente->nombre])) {
                    $ramsAgrupados[$componente->nombre]['cantidad'] += 1;
                } else {
                    $ramsAgrupados[$componente->nombre] = [
                        'componente_id' => $componente_id,
                        'cantidad' => 1
                    ];
                }

                // Realizar la transferencia del estado
                $componenteController = new ComponenteController();
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $componenteController->transferStateByPc($componente_id, 1, 5, "creacion de PC", $pc->identificador, $pc->nombre, false);
                $componente_pc->save();
            }
        }

        foreach ($ramsAgrupados as $nombre => $datos) {
            $stockToTransfer = $datos['cantidad'];

            // Crear una nueva entrada en la historia
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "uso " . $stockToTransfer . " " . $nombre . "/s para el armado de la PC: " . $pc->identificador . " - " . $pc->nombre . ".";
            $historia->motivo = "creacion de PC";
            $historia->tipo_id = 4; // Tipo de transferencia
            $historia->save();
        }



        // Guardar historia
        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "creó la PC: " . $request->input('addIdentificador') . " - " . $request->input('addNombre') . ".";
        $historia->motivo = "creacion de PC";
        $historia->componente_id = $pc->id;
        $historia->tipo_id = 5;
        $historia->save();

        return redirect()->back()->with('success', 'PC guardada correctamente.');
    }


    public function edit(Request $request)
    {
        $user = Auth::user();

        // Validación de entrada
        $request->validate([
            'discos2' => 'nullable|array',
            'discos2.*' => 'nullable|string|max:255',
            'rams2' => 'nullable|array',
            'rams2.*' => 'nullable|string|max:255',
        ]);

        $id = $request->input('editId');
        $pc = PcModel::find($id);

        $motherActual = ComponentePcModel::getMotherboardIdByPc($id);
        $proceActual = ComponentePcModel::getProcesadorIdByPc($id);
        $fuenteActual = ComponentePcModel::getFuenteIdByPc($id);
        $placavidActual = ComponentePcModel::getPlacavidIdByPc($id);



        if ($request->input("editDetalle") != null || $request->input("editDetalle") != "") {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = $request->input("editDetalle");
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }

        // Actualizar información básica de la PC
        if ($pc->deposito_id != $request->input('editDeposito') && $request->input('editDeposito') != null) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el deposito de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . (DepositoModel::find($pc->deposito_id)->nombre ?? "deposito no asignado") . " a " . DepositoModel::find($request->input('editDeposito'))->nombre . ", se quito del area: " . AreaModel::find($pc->area_id)->nombre . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
            $pc->deposito_id = $request->input('editDeposito');
            $pc->area_id = null;
        }

        if ($pc->area_id != $request->input('editArea') && $request->input('editArea') != null) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el area de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . (AreaModel::find($pc->area_id)->nombre ?? "area no asignada") . " a " . AreaModel::find($request->input('editArea'))->nombre . ", se quito del deposito: " . DepositoModel::find($pc->deposito_id)->nombre . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
            $pc->area_id = $request->input('editArea');
            $pc->deposito_id = null;
        }

        if ($pc->ip != $request->input('editIp')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó la IP de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . $pc->ip . " a " . $request->input('editIp') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $pc->ip = $request->input('editIp');
        if ($pc->nombre != $request->input('editNombre')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el nombre de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . $pc->nombre . " a " . $request->input('editNombre') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $pc->nombre = $request->input('editNombre');


        if ($pc->identificador != $request->input('editIdentificador')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el identificador de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . $pc->identificador . " a " . $request->input('editIdentificador') . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
        }
        $pc->identificador = $request->input('editIdentificador');

        $pc->update();

        $transferecia = new ComponenteController();

        // Insertar nuevos componentes

        if ($motherActual != $request->input('editMotherboard')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó la placa madre de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . ComponenteModel::find($motherActual)->nombre . " a " . ComponenteModel::find($request->input('editMotherboard'))->nombre . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
            //Elimino mother vieja
            $transferecia->transferStateByPc($motherActual, 1, 4, "", $pc->id, $pc->nombre, false);

            //Elimino relacion vieja
            ComponentePcModel::where('pc_id', $id)
                ->Where('componente_id', $motherActual)
                ->delete();

            //Agrego relacion nueva //Agrego mother nueva
            $componente_pc = new ComponentePcModel();
            $componente_pc->pc_id = $pc->id;
            $componente_pc->componente_id = $transferecia->transferStateByPc($request->input('editMotherboard'), 1, 5, "", $pc->id, $pc->nombre, false);
            $componente_pc->save();
        }

        if ($proceActual != $request->input('editProcesador')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó el procesador de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . ComponenteModel::find($proceActual)->nombre . " a " . ComponenteModel::find($request->input('editProcesador'))->nombre . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
            //Elimino mother vieja
            $transferecia->transferStateByPc($proceActual, 1, 4, "", $pc->id, $pc->nombre, false);

            //Elimino relacion vieja
            ComponentePcModel::where('pc_id', $id)
                ->Where('componente_id', $proceActual)
                ->delete();

            //Agrego relacion nueva //Agrego mother nueva
            $componente_pc = new ComponentePcModel();
            $componente_pc->pc_id = $pc->id;
            $componente_pc->componente_id = $transferecia->transferStateByPc($request->input('editProcesador'), 1, 5, "", $pc->id, $pc->nombre, false);
            $componente_pc->save();
        }

        if ($fuenteActual != $request->input('editFuente')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó la fuente de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . ComponenteModel::find($fuenteActual)->nombre . " a " . ComponenteModel::find($request->input('editFuente'))->nombre . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
            //Elimino mother vieja
            $transferecia->transferStateByPc($fuenteActual, 1, 4, "", $pc->id, $pc->nombre, false);

            //Elimino relacion vieja
            ComponentePcModel::where('pc_id', $id)
                ->Where('componente_id', $fuenteActual)
                ->delete();

            //Agrego relacion nueva //Agrego mother nueva
            $componente_pc = new ComponentePcModel();
            $componente_pc->pc_id = $pc->id;
            $componente_pc->componente_id = $transferecia->transferStateByPc($request->input('editFuente'), 1, 5, "", $pc->id, $pc->nombre, false);
            $componente_pc->save();
        }

        if ($placavidActual != $request->input('editPlacavid')) {
            $historia = new HistoriaModel();
            $historia->tecnico = $user->name;
            $historia->detalle = "editó la placa de video de la PC: " . $pc->identificador . " - " . $pc->nombre . " de " . (ComponenteModel::find($placavidActual)->nombre ?? 'Placa de video no asignada') . " a " . ComponenteModel::find($request->input('editPlacavid'))->nombre . ".";
            $historia->motivo = $request->input('editMotivo');
            $historia->componente_id = $pc->id;
            $historia->tipo_id = 5; // Ajusta el tipo_id según sea necesario
            $historia->save();
            //Elimino mother vieja
            $transferecia->transferStateByPc($placavidActual, 1, 4, "", $pc->id, $pc->nombre, false);

            //Elimino relacion vieja
            ComponentePcModel::where('pc_id', $id)
                ->Where('componente_id', $placavidActual)
                ->delete();

            //Agrego relacion nueva //Agrego mother nueva
            $componente_pc = new ComponentePcModel();
            $componente_pc->pc_id = $pc->id;
            $componente_pc->componente_id = $transferecia->transferStateByPc($request->input('editPlacavid'), 1, 5, "", $pc->id, $pc->nombre, false);
            $componente_pc->save();
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Obtener discos actuales
        $discosActuales = ComponentePcModel::getDiscosByPc($id);
        $discosSeleccionados = $request->input('discos2', []);

        // Contar las ocurrencias de cada disco en los arrays
        $conteoDiscosActuales = array_count_values($discosActuales);
        $conteoDiscosSeleccionados = array_count_values($discosSeleccionados);

        $discosNuevos = [];
        $discosEliminados = [];

        // Identificar discos eliminados y nuevos basados en las diferencias de conteo
        foreach ($conteoDiscosActuales as $disco => $count) {
            if (isset($conteoDiscosSeleccionados[$disco])) {
                if ($count > $conteoDiscosSeleccionados[$disco]) {
                    for ($i = 0; $i < $count - $conteoDiscosSeleccionados[$disco]; $i++) {
                        $discosEliminados[] = $disco;
                    }
                }
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $discosEliminados[] = $disco;
                }
            }
        }

        foreach ($conteoDiscosSeleccionados as $disco => $count) {
            if (isset($conteoDiscosActuales[$disco])) {
                if ($count > $conteoDiscosActuales[$disco]) {
                    for ($i = 0; $i < $count - $conteoDiscosActuales[$disco]; $i++) {
                        $discosNuevos[] = $disco;
                    }
                }
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $discosNuevos[] = $disco;
                }
            }
        }

        if (!empty($discosNuevos)) {
            foreach ($discosNuevos as $disco) {
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $transferecia->transferStateByPc($disco, 1, 5, "", $pc->id, $pc->nombre, false);
                $componente_pc->save();
            }
        }

        if (!empty($discosEliminados)) {
            foreach ($discosEliminados as $disco) {
                $transferecia->transferStateByPc($disco, 1, 4, "", $pc->id, $pc->nombre, false);
                ComponentePcModel::where('pc_id', $id)
                    ->Where('componente_id', $disco)
                    ->first()->delete();
            }
        }

        // Obtener las RAMs actuales
        $ramsActuales = ComponentePcModel::getRamsByPc($id);
        $ramsSeleccionados = $request->input('rams2', []);

        // Contar las ocurrencias de cada RAM en los arrays
        $conteoRamsActuales = array_count_values($ramsActuales);
        $conteoRamsSeleccionados = array_count_values($ramsSeleccionados);

        $ramsNuevos = [];
        $ramsEliminados = [];

        // Identificar RAMs eliminadas y nuevas basadas en las diferencias de conteo
        foreach ($conteoRamsActuales as $ram => $count) {
            if (isset($conteoRamsSeleccionados[$ram])) {
                if ($count > $conteoRamsSeleccionados[$ram]) {
                    for ($i = 0; $i < $count - $conteoRamsSeleccionados[$ram]; $i++) {
                        $ramsEliminados[] = $ram;
                    }
                }
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $ramsEliminados[] = $ram;
                }
            }
        }

        foreach ($conteoRamsSeleccionados as $ram => $count) {
            if (isset($conteoRamsActuales[$ram])) {
                if ($count > $conteoRamsActuales[$ram]) {
                    for ($i = 0; $i < $count - $conteoRamsActuales[$ram]; $i++) {
                        $ramsNuevos[] = $ram;
                    }
                }
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $ramsNuevos[] = $ram;
                }
            }
        }

        // Si hay nuevas RAMs seleccionadas, realizar la transferencia y guardar la relación
        if (!empty($ramsNuevos)) {
            foreach ($ramsNuevos as $ram) {
                $componente_pc = new ComponentePcModel();
                $componente_pc->pc_id = $pc->id;
                $componente_pc->componente_id = $transferecia->transferStateByPc($ram, 1, 5, "", $pc->id, $pc->nombre, false);
                $componente_pc->save();
            }
        }

        // Si hay RAMs eliminadas, realizar la transferencia inversa y eliminar la relación
        if (!empty($ramsEliminados)) {
            foreach ($ramsEliminados as $ram) {
                $transferecia->transferStateByPc($ram, 1, 4, "", $pc->id, $pc->nombre, false);
                ComponentePcModel::where('pc_id', $id)
                    ->Where('componente_id', $ram)
                    ->first()->delete();
            }
        }

        return redirect()->back()->with('success', 'PC editada correctamente.');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        // Crear un nuevo registro
        $id = $request->input('deleteId');
        $pc = PcModel::find($id);

        $actualComps = ComponentePcModel::where('pc_id', $id)->get();

        foreach ($actualComps as $actualComp) {
            $componente = ComponenteModel::find($actualComp->componente_id);
            $componente->stock += 1;
            $componente->update();
        }
        $actualComps = ComponentePcModel::where('pc_id', $id)->delete();

        $historia = new HistoriaModel();
        $historia->tecnico = $user->name;
        $historia->detalle = "elimino la PC: " . $pc->identificador . " - " . $pc->nombre;
        $historia->motivo = $request->input('removeMotivo');
        $historia->tipo_id = 5;
        $historia->save();

        $pc->delete();

        return redirect()->back()->with('success', 'Pc eliminado correctamente.');
    }

    public function getHistoria($id)
    {
        $historias = HistoriaModel::where('componente_id', $id)->get();
        return response()->json(['historia' => $historias]);
    }
}
