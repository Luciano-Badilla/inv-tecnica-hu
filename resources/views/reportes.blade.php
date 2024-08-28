<?php

use App\Models\ComponenteModel;
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Nuevo reporte') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex" style="justify-content:start; gap:15px">
                    <div class="mb-3" style="flex: 1;">
                        <label for="addTipo" class="form-label">Contenido del Informe:</label>
                        <select class="form-control" id="addTipo" name="addTipo"
                            style="border: 1px solid gray; border-radius: 5px;" required>
                            <option value="null" disabled selected>Seleccione:</option>
                            <option value="null" disabled>Dispositivos:</option>
                            <option value=1>‎ - PCs</option>
                            <option value=2>‎ - Impresoras</option>
                            <option value=3>‎ - Telefonos IP</option>
                            <option value=4>‎ - Routers</option>
                            <option value=5>Stock</option>
                            <option value=6>Historia</option>
                            <option value=7>Areas</option>
                            <option value=8>Depositos</option>
                            <option value=9>Categorias</option>
                            <option value=10>Estados</option>
                        </select>
                    </div>
                    <div class="mb-3" style="flex: 1;">
                        <label for="addTitulo" class="form-label">Titulo del reporte:</label>
                        <input type="text" class="form-control @error('addTitulo') is-invalid @enderror"
                            id="addTitulo" name="addTitulo" style="border: 1px solid gray; border-radius: 5px;"
                            required>
                    </div>

                </div>

                <div style="padding-left: 15px; padding-right: 15px; margin-top: -2%" id="div-table">
                    <template id="estados_template">
                        <table id="table-estados" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estados as $estado)
                                    <tr>
                                        <td><b>{{ $estado->nombre }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                    <template id="categorias_template">
                        <table id="table-categorias" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $tipo)
                                    <tr>
                                        <td><b>{{ $tipo->nombre }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </template>
                    <template id="depositos_template">
                        <table id="table-depositos" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depositos as $deposito)
                                    <tr>
                                        <td><b>{{ $deposito->nombre }}</b></td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </template>
                    <template id="areas_template">
                        <table id="table-areas" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td><b>{{ $area->nombre }}</b></td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </template>
                    <template id="historias_template">
                        <div class="row mb-3" style="margin-top: -3%">
                            <div id="filter-div-hs"
                                style="display: flex; flex-direction: row; gap: 15px; margin-top: 1%">
                                <!-- Filtro por Técnicos -->
                                <div>
                                    <label for="filtro-tecnicos-hs" style="margin-bottom: 0.5rem;">Técnico:</label>
                                    <select id="filtro-tecnicos-hs" class="form-select" style="width: 200px;">
                                        <option value="">Todos</option>
                                        @foreach ($users as $user)
                                            {
                                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                                            }
                                        @endforeach
                                        <!-- Agrega más opciones según sea necesario -->
                                    </select>
                                </div>

                                <!-- Filtro por Fecha -->
                                <div style="display: flex; flex-direction: column; gap: 15px;">
                                    <div style="display: flex; flex-direction: row; gap: 15px;">
                                        <label>Fecha:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="filter-range-hs">
                                            <label class="form-check-label" for="filter-range-hs">Rango</label>
                                        </div>
                                    </div>

                                    <div id="date-filters-hs" style="margin-top: -12%;">
                                        <input class="form-control" type="date" id="date-hs"
                                            style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                    </div>

                                    <div id="range-filters-hs"
                                        style="display: none; flex-direction:row; margin-top: -5.8%; gap:10px">
                                        <input class="form-control" type="date" id="start-date-hs"
                                            style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                        <input class="form-control" type="date" id="end-date-hs"
                                            style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap:15px; padding-left: 1%; padding-bottom: 1%">
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-tecnico"
                                    data-column="0" checked>
                                <label class="form-check-label" for="column-tecnico">Tecnico</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-detalle"
                                    data-column="1" checked>
                                <label class="form-check-label" for="column-detalle">Detalle</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-motivo"
                                    data-column="2" checked>
                                <label class="form-check-label" for="column-motivo">Motivo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-fecha"
                                    data-column="3" checked>
                                <label class="form-check-label" for="column-fecha">Fecha</label>
                            </div>
                        </div>
                        <button id="exportHistorias" class="btn btn-dark custom-export-btn exportHistorias">Exportar
                            Excel</button>
                        <table id="table-historias" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tecnico</th>
                                    <th>Detalle</th>
                                    <th>Motivo</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historias as $historia)
                                    <tr>
                                        <td><b>{{ $historia->tecnico }}</b></td>
                                        <td><b>{{ $historia->detalle }}</b></td>
                                        <td><b>{{ $historia->motivo }}</b></td>
                                        <td><b>{{ $historia->created_at }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                    <template id="stock_template">
                        <div id="filter-div" style="display: flex; gap:15px">
                            <div>
                                <label for="filtro-deposito">Deposito:</label>
                                <select id="filtro-deposito" class="form-control">
                                    <option value="">Todos los depósitos</option>
                                    @foreach ($depositos as $deposito)
                                        <option value="{{ $deposito->nombre }}">{{ $deposito->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filtro-estado">Estado:</label>
                                <select id="filtro-estado" class="form-control">
                                    <option value="">Todos los estados</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->nombre }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filtro-categoria">Categoria:</label>
                                <select id="filtro-categoria" class="form-control">
                                    <option value="">Todas las categorías</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->nombre }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="filtro-stock">Stock:</label>
                                <select id="filtro-stock" class="form-control">
                                    <option value="">Todas las categorías</option>
                                    <option value="poco-stock">Poco stock</option>
                                    <option value="sin-stock">Sin stock</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; gap:15px; padding-left: 1%; padding-bottom: 1%; margin-top: 2%;">
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-categoria"
                                    data-column="0" checked>
                                <label class="form-check-label" for="column-categoria">Categoria</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nombre"
                                    data-column="1" checked>
                                <label class="form-check-label" for="column-nombre">Nombre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-deposito"
                                    data-column="2" checked>
                                <label class="form-check-label" for="column-deposito">Deposito</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-stock"
                                    data-column="3" checked>
                                <label class="form-check-label" for="column-stock">Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-estado"
                                    data-column="4" checked>
                                <label class="form-check-label" for="column-estado">Estado</label>
                            </div>
                        </div>
                        <button id="exportHistorias" class="btn btn-dark custom-export-btn exportHistorias">Exportar
                            Excel</button>
                        <table id="table-componentes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Nombre</th>
                                    <th>Deposito</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($componentes as $componente)
                                    <tr>
                                        <td><b>{{ $componente->tipo->nombre ?? 'Categoria no asignada' }}</b></td>
                                        <td><b>{{ $componente->nombre }}</b></td>
                                        <td><b>{{ $componente->deposito->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>{{ $componente->stock }}</b></td>
                                        <td><b>{{ $componente->estado->nombre ?? 'No asignado' }}</b></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                    <template id="routers_template">
                        <div style="display: flex; gap:15px; padding-left: 1%; padding-bottom: 1%">
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nro_inv"
                                    data-column="0" checked>
                                <label class="form-check-label" for="column-nro_inv">Nº de inventario</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nombre"
                                    data-column="1" checked>
                                <label class="form-check-label" for="column-nombre">Nombre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox"
                                    id="column-marca_modelo" data-column="2" checked>
                                <label class="form-check-label" for="column-marca_modelo">Marca y modelo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-ip"
                                    data-column="3" checked>
                                <label class="form-check-label" for="column-ip">IP</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-deposito"
                                    data-column="4" checked>
                                <label class="form-check-label" for="column-deposito">Deposito</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-area"
                                    data-column="5" checked>
                                <label class="form-check-label" for="column-area">Area</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox"
                                    id="column-area_detalle" data-column="6" checked>
                                <label class="form-check-label" for="column-area_detalle">Ubicacion detallada</label>
                            </div>
                        </div>
                        <button id="exportHistorias" class="btn btn-dark custom-export-btn exportHistorias">Exportar
                            Excel</button>
                        <table id="table-routers" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº de inventario</th>
                                    <th>Nombre</th>
                                    <th>Marca y modelo</th>
                                    <th>IP</th>
                                    <th>Deposito</th>
                                    <th>Area</th>
                                    <th>Ubicacion detallada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routers as $router)
                                    <tr>
                                        <td><b>{{ $router->identificador }}</b></td>
                                        <td><b>{{ $router->nombre }}</b></td>
                                        <td><b>{{ $router->marca_modelo }}</b></td>
                                        <td><b>{{ $router->ip }}</b></td>
                                        <td><b>{{ $router->deposito->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>{{ $router->area->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>{{ $router->area_detalle }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                    <template id="telefonos_template">
                        <div style="display: flex; gap:15px; padding-left: 1%; padding-bottom: 1%">
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nro_inv"
                                    data-column="0" checked>
                                <label class="form-check-label" for="column-nro_inv">Nº de inventario</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nombre"
                                    data-column="1" checked>
                                <label class="form-check-label" for="column-nombre">Nombre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox"
                                    id="column-marca_modelo" data-column="2" checked>
                                <label class="form-check-label" for="column-marca_modelo">Marca y modelo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-ip"
                                    data-column="3" checked>
                                <label class="form-check-label" for="column-ip">IP</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-numero"
                                    data-column="4" checked>
                                <label class="form-check-label" for="column-numero">Numero</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-deposito"
                                    data-column="5" checked>
                                <label class="form-check-label" for="column-deposito">Deposito</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-area"
                                    data-column="6" checked>
                                <label class="form-check-label" for="column-area">Area</label>
                            </div>
                        </div>
                        <button id="exportHistorias" class="btn btn-dark custom-export-btn exportHistorias">Exportar
                            Excel</button>
                        <table id="table-telefonos" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº de inventario</th>
                                    <th>Nombre</th>
                                    <th>Marca y modelo</th>
                                    <th>IP</th>
                                    <th>Numero</th>
                                    <th>Deposito</th>
                                    <th>Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($telefonos as $telefono)
                                    <tr>
                                        <td><b>{{ $telefono->identificador }}</b></td>
                                        <td><b>{{ $telefono->nombre }}</b></td>
                                        <td><b>{{ $telefono->marca_modelo }}</b></td>
                                        <td><b>{{ $telefono->ip }}</b></td>
                                        <td><b>{{ $telefono->numero }}</b></td>
                                        <td><b>{{ $telefono->deposito->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>{{ $telefono->area->nombre ?? 'No asignado' }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                    <template id="impresoras_template">
                        <div style="display: flex; gap:15px; padding-left: 1%; padding-bottom: 1%">
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nro_inv"
                                    data-column="0" checked>
                                <label class="form-check-label" for="column-nro_inv">Nº de inventario</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nombre"
                                    data-column="1" checked>
                                <label class="form-check-label" for="column-nombre">Nombre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox"
                                    id="column-marca_modelo" data-column="2" checked>
                                <label class="form-check-label" for="column-marca_modelo">Marca y modelo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-ip"
                                    data-column="3" checked>
                                <label class="form-check-label" for="column-ip">IP</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-toner"
                                    data-column="4" checked>
                                <label class="form-check-label" for="column-toner">Toner</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-deposito"
                                    data-column="5" checked>
                                <label class="form-check-label" for="column-deposito">Deposito</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-area"
                                    data-column="6" checked>
                                <label class="form-check-label" for="column-area">Area</label>
                            </div>
                        </div>
                        <button id="exportHistorias" class="btn btn-dark custom-export-btn exportHistorias">Exportar
                            Excel</button>
                        <table id="table-impresoras" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº de inventario</th>
                                    <th>Nombre</th>
                                    <th>Marca y modelo</th>
                                    <th>IP</th>
                                    <th>Toner</th>
                                    <th>Deposito</th>
                                    <th>Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($impresoras as $impresora)
                                    <tr>
                                        <td><b>{{ $impresora->identificador }}</b></td>
                                        <td><b>{{ $impresora->nombre }}</b></td>
                                        <td><b>{{ $impresora->marca_modelo }}</b></td>
                                        <td><b>{{ $impresora->ip }}</b></td>
                                        <td><b>{{ ComponenteModel::find($impresora->toner_id)->nombre }}</b></td>
                                        <td><b>{{ $impresora->deposito->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>{{ $impresora->area->nombre ?? 'No asignado' }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                    <template id="pcs_template">
                        <div style="display: flex; gap:15px; padding-left: 1%; padding-bottom: 1%">
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nro_inv"
                                    data-column="0" checked>
                                <label class="form-check-label" for="column-nro_inv">Nº de inventario</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-nombre"
                                    data-column="1" checked>
                                <label class="form-check-label" for="column-nombre">Nombre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-ip"
                                    data-column="2" checked>
                                <label class="form-check-label" for="column-ip">IPv4</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-deposito"
                                    data-column="3" checked>
                                <label class="form-check-label" for="column-deposito">Deposito</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input column-toggle" type="checkbox" id="column-area"
                                    data-column="4" checked>
                                <label class="form-check-label" for="column-area">Area</label>
                            </div>
                        </div>
                        <button id="exportHistorias" class="btn btn-dark custom-export-btn exportHistorias">Exportar
                            Excel</button>
                        <table id="table-pcs" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº de inventario</th>
                                    <th>Nombre</th>
                                    <th>IPv4</th>
                                    <th>Deposito</th>
                                    <th>Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pcs as $pc)
                                    <tr>
                                        <td><b>{{ $pc->identificador }}</b></td>
                                        <td><b>{{ $pc->nombre }}</b></td>
                                        <td><b>{{ $pc->ip }}</b></td>
                                        <td><b>{{ $pc->deposito->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>{{ $pc->area->nombre ?? 'No asignado' }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        let table, titulo;

        // Plantillas de contenido
        const estadosTemplate = $('#estados_template').html();
        const categoriasTemplate = $('#categorias_template').html();
        const depositosTemplate = $('#depositos_template').html();
        const areasTemplate = $('#areas_template').html();
        const historiasTemplate = $('#historias_template').html();
        const stockTemplate = $('#stock_template').html();
        const routersTemplate = $('#routers_template').html();
        const telefonosTemplate = $('#telefonos_template').html();
        const impresorasTemplate = $('#impresoras_template').html();
        const pcsTemplate = $('#pcs_template').html();
        const pcsCompTemplate = $('#pcs_comp_template').html();

        function initializeTable(templateToUse) {
            // Destruir la tabla existente si existe
            if (table) {
                table.destroy();
                $('#div-table').empty(); // Limpiar el contenedor de la tabla
            }

            $('#div-table').html(templateToUse);
            $('#addTitulo').val(titulo);

            // Inicializar la tabla
            var simpleTables = [7, 8, 9, 10];
            if (simpleTables.includes(parseInt($('#addTipo').val()))) {
                table = $('#table-' + getTableId()).DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Exportar a Excel',
                        className: 'btn btn-dark custom-export-btn',
                        title: function() {
                            return $('#addTitulo').val() || titulo;
                        }
                    }],
                    paging: false,
                    searching: false,
                    info: false,
                    autoWidth: true
                });
            } else {
                table = $('#table-' + getTableId()).DataTable({
                    paging: false,
                    searching: false,
                    info: false,
                    autoWidth: true
                });
            }


            // Configurar eventos para cambiar visibilidad de columnas
            $('.column-toggle').off('change').on('change', function() {
                const column = table.column($(this).data('column'));
                column.visible(!column.visible());
                $("#table-" + getTableId()).css("min-width", "100%");
            });
        }

        function getTableId() {
            switch ($('#addTipo').val()) {
                case "10":
                    return 'estados';
                case "9":
                    return 'categorias';
                case "8":
                    return 'depositos';
                case "7":
                    return 'areas';
                case "6":
                    return 'historias';
                case "5":
                    return 'componentes';
                case "4":
                    return 'routers';
                case "3":
                    return 'telefonos';
                case "2":
                    return 'impresoras';
                case "1":
                    return 'pcs';
                default:
                    return '';
            }
        }

        $('#addTipo').on('change', function() {
            let templateToUse;
            switch ($(this).val()) {
                case "11":
                    templateToUse = pcsCompTemplate;
                    titulo = "Informe de PCs - Componentes";
                    break;
                case "10":
                    templateToUse = estadosTemplate;
                    titulo = "Listado de estados";
                    break;
                case "9":
                    templateToUse = categoriasTemplate;
                    titulo = "Listado de categorias";
                    break;
                case "8":
                    templateToUse = depositosTemplate;
                    titulo = "Listado de depositos";
                    break;
                case "7":
                    templateToUse = areasTemplate;
                    titulo = "Listado de areas";
                    break;
                case "6":
                    templateToUse = historiasTemplate;
                    titulo = "Informe de movimientos";
                    break;
                case "5":
                    templateToUse = stockTemplate;
                    titulo = "Informe de componentes";
                    break;
                case "4":
                    templateToUse = routersTemplate;
                    titulo = "Informe de routers";
                    break;
                case "3":
                    templateToUse = telefonosTemplate;
                    titulo = "Informe de telefonos IP";
                    break;
                case "2":
                    templateToUse = impresorasTemplate;
                    titulo = "Informe de impresoras";
                    break;
                case "1":
                    templateToUse = pcsTemplate;
                    titulo = "Informe de PCs";
                    break;
                default:
                    templateToUse = null;
            }

            if (templateToUse) {
                initializeTable(templateToUse);
            }
        });

        $(document).on('click', '#exportHistorias', function() {
            var data = table.rows().data().toArray();

            // Obtener los nombres de las columnas
            var columnNames = table.columns().header().toArray().map(header => $(header).text());

            // Obtener las columnas seleccionadas
            var selectedColumns = [];
            $('.column-toggle:checked').each(function() {
                selectedColumns.push($(this).data('column'));
            });

            // Limpiar HTML de los datos
            var cleanedData = data.map(row =>
                row.map(cell => $('<div>').html(cell).text()) // Eliminar etiquetas HTML
            );

            $.ajax({
                url: 'scripts/export_histories.php',
                method: 'POST',
                data: {
                    titulo: $('#addTitulo').val(),
                    columnNames: JSON.stringify(
                        columnNames), // Envía los nombres de las columnas
                    selectedColumns: JSON.stringify(
                        selectedColumns), // Envía las columnas seleccionadas
                    data: JSON.stringify(cleanedData) // Envía los datos limpios al servidor
                },
                xhrFields: {
                    responseType: 'blob' // Para manejar la respuesta como un blob
                },
                success: function(response) {
                    var url = window.URL.createObjectURL(response);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = $('#addTitulo').val() + '.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error al exportar el excel");
                }
            });
        });

        $(document).on('change', '#filter-range-hs', function() {
            $('#date-hs, #start-date-hs, #end-date-hs').val(null);
            if ($(this).is(':checked')) {
                $('#date-filters-hs').hide();
                $('#range-filters-hs').css('display', 'flex');
            } else {
                $('#range-filters-hs').css('display', 'none');
                $('#date-filters-hs').show();
            }
        });

        function formatDate(dateString) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            const date = new Date(dateString);
            return date.toLocaleDateString(undefined, options) + ' ' + date.toLocaleTimeString();
        }

        // Apply filters
        $(document).on('change',
            '#date-hs, #start-date-hs, #end-date-hs, #filter-range-hs, #filtro-tecnicos-hs',
            function() {
                $('.column-toggle').prop('checked', true);
                $.ajax({
                    url: '/inv-tecnica/public/filter-reportes',
                    method: 'GET',
                    data: {
                        tecnico: $('#filtro-tecnicos-hs').val(),
                        date: $('#date-hs').val(),
                        start_date: $('#start-date-hs').val(),
                        end_date: $('#end-date-hs').val(),
                    },
                    success: function(data) {
                        // Destruir la DataTable actual
                        if (table) {
                            table.destroy();
                        }
                        $('#table-historias tbody').empty();

                        $.each(data, function(index, historia) {
                            $('#table-historias tbody').append(`
                        <tr>
                            <td><b>${historia.tecnico}</b></td>
                            <td><b>${historia.detalle}</b></td>
                            <td><b>${historia.motivo}</b></td>
                            <td><b>${formatDate(historia.created_at)}</b></td>
                        </tr>
                    `);
                        });

                        // Reinicializar la DataTable
                        table = $('#table-historias').DataTable({
                            paging: false,
                            searching: false,
                            info: false,
                            autoWidth: true
                        });
                    }
                });
            });

        $(document).on('change', '#filtro-deposito, #filtro-estado, #filtro-categoria, #filtro-stock',
        function() {
            $('.column-toggle').prop('checked', true);
            $.ajax({
                url: '/inv-tecnica/public/filter-stock',
                method: 'GET',
                data: {
                    deposito: $('#filtro-deposito').val(),
                    estado: $('#filtro-estado').val(),
                    categoria: $('#filtro-categoria').val(),
                    stock: $('#filtro-stock').val(),
                },
                success: function(data) {
                    // Destruir la DataTable actual
                    if (table) {
                        table.destroy();
                    }
                    $('#table-componentes tbody').empty();

                    $.each(data, function(index, componente) {
                        $('#table-componentes tbody').append(`
                    <tr>
                        <td><b>${componente.categoria}</b></td>
                        <td><b>${componente.nombre}</b></td>
                        <td><b>${componente.deposito}</b></td>
                        <td><b>${componente.stock}</b></td>
                        <td><b>${componente.estado}</b></td>
                    </tr>
                `);
                    });

                    // Reinicializar la DataTable
                    table = $('#table-componentes').DataTable({
                        paging: false,
                        searching: false,
                        info: false,
                        autoWidth: true
                    });
                }
            });
        });
    });
</script>
