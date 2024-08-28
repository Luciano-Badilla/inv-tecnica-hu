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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ReportesController extends Controller
{


    public function index()
    {
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
        $users = User::all();

        // Pasar los datos a la vista
        return view('reportes', ['areas' => $areas, 'historias' => $historias, 'estados' => $estados, 'tipos' => $tipos, 'depositos' => $depositos, 'componentes' => $componentes, 'routers' => $routers, 'telefonos' => $telefonos, 'impresoras' => $impresoras, 'pcs' => $pcs, 'users' => $users]);
    }

    public function filterReportes(Request $request)
    {
        $query = HistoriaModel::query(); // Cambia esto si el modelo se llama diferente

        if ($request->filled('tecnico')) {
            $query->where('tecnico', $request->input('tecnico'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Convertir fechas a instancias de DateTime
            $startDate = new \DateTime($request->input('start_date'));
            $endDate = new \DateTime($request->input('end_date'));

            // Ajustar la fecha de finalización para incluir todo el día
            $endDate->setTime(23, 59, 59);

            // Formatear las fechas para la consulta
            $startDateFormatted = $startDate->format('Y-m-d H:i:s');
            $endDateFormatted = $endDate->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
        } elseif ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $historias = $query->get();

        return response()->json($historias);
    }

    public function filterStock(Request $request)
{
    $query = ComponenteModel::with(['tipo', 'deposito', 'estado']);

    if ($request->filled('deposito')) {
        $query->whereHas('deposito', function($q) use ($request) {
            $q->where('nombre', $request->input('deposito'));
        });
    }

    if ($request->filled('estado')) {
        $query->whereHas('estado', function($q) use ($request) {
            $q->where('nombre', $request->input('estado'));
        });
    }

    if ($request->filled('categoria')) {
        $query->whereHas('tipo', function($q) use ($request) {
            $q->where('nombre', $request->input('categoria'));
        });
    }

    if ($request->filled('stock')) {
        if ($request->input('stock') === 'poco-stock') {
            $query->where('stock', '<', 10); // Ajusta el umbral según sea necesario
        } elseif ($request->input('stock') === 'sin-stock') {
            $query->where('stock', '=', 0);
        }
    }

    $componentes = $query->get([
        'id', 'tipo_id', 'nombre', 'stock', 'deposito_id', 'estado_id'
    ]);

    return response()->json($componentes->map(function($componente) {
        return [
            'id' => $componente->id,
            'nombre' => $componente->nombre,
            'categoria' => $componente->tipo->nombre ?? 'Sin categoría',
            'deposito' => $componente->deposito->nombre ?? 'Sin depósito',
            'estado' => $componente->estado->nombre ?? 'Sin estado',
            'stock' => $componente->stock
        ];
    }));
}

}
