<?php use App\Models\ComponenteModel; ?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Telefonos') }}
            <button type="button" class="small-box-footer show" id="show" data-bs-toggle="modal"
                data-bs-target="#infoModal" style="margin-left: 0.5%">
                <i class="fa-solid fa-circle-info"></i>
            </button>
        </h2>

        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Telefonos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Aqui debes agregar los telefonos y asignarlos a un area o deposito.
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="infoTelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content bg-primaty" style="border-radius: 15px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Información del telefono</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="flex" style="display: flex; flex-direction: column; gap:10px">
                            <div class="flex" style="display: flex; flex-direction: column; gap:5px">
                                <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                    <h2><b>Nº Inventario: </b></h2>
                                    <p id="idenInfo"></p>
                                </div>
                                <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                    <h2><b>Nombre: </b></h2>
                                    <p id="nombreInfo"></p>
                                </div>
                                <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                    <h2><b>Marca y Modelo: </b></h2>
                                    <p id="marcaInfo"></p>
                                </div>
                                <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                    <h2><b>Numero: </b></h2>
                                    <p id="numeroInfo"></p>
                                </div>
                                <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                    <h2><b>IP: </b></h2>
                                    <p id="ipInfo"></p>
                                </div>
                                <div class="flex" style="display: flex; flex-direction: column; gap:5px">
                                    <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                        <b>
                                            <h2 id="titleAsig"></h2>
                                        </b>
                                        <p id="infoAsig"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar telefono</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex;">
                        <form action="{{ route('store_telefonos') }}" method="POST" id="addModal"
                            style="display: flex; flex-direction: column; gap: 20px; ">
                            @csrf
                            <!-- Mostrar errores de validación generales -->
                            <div class="form-check d-flex align-items-top">
                                <input class="form-check-input" type="checkbox" id="en-uso">
                                <label class="form-check-label" for="en-uso">
                                    En uso
                                </label>
                            </div>
                            <div style="display: flex; flex-direction: row;">
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="addIdentificador" class="form-label">Nº Inventario:</label>
                                    <input type="text"
                                        class="form-control @error('addIdentificador') is-invalid @enderror"
                                        id="addIdentificador" name="addIdentificador" placeholder="Nº Inventario"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="addNombre" class="form-label">Nombre:</label>
                                    <input type="text"
                                        class="form-control @error('addNombre') is-invalid @enderror" id="addNombre"
                                        name="addNombre" placeholder="Nombre"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="addMarca" class="form-label">Marca y Modelo:</label>
                                    <input type="text" class="form-control @error('addMarca') is-invalid @enderror"
                                        id="addMarca" name="addMarca" placeholder="Marca y Modelo"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="addIp" class="form-label">IP:</label>
                                    <input type="text" class="form-control @error('addIp') is-invalid @enderror"
                                        id="addIp" name="addIp" placeholder="Direccion IPv4"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>

                            </div>

                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div style="display: flex; flex-direction: column; gap: 20px;">
                                    <div style="display: flex; flex-direction: row; gap: 20px;">
                                        <div class="mb-3" style="flex: 1;">
                                            <label for="addNumero" class="form-label">Numero:</label>
                                            <input type="text"
                                                class="form-control @error('addNumero') is-invalid @enderror"
                                                id="addNumero" name="addNumero" placeholder="Numero de telefono"
                                                style="border: 1px solid gray; border-radius: 5px; max-width: 165px;"
                                                required>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div id="content-container">
                                    <div class="mb-3" id="area-select" style="flex: 1;">
                                        <label for="addArea" class="form-label">Area:</label>
                                        <select class="form-control @error('addArea') is-invalid @enderror"
                                            id="addArea" name="addArea"
                                            style="border: 1px solid gray; border-radius: 5px; min-width:165px; max-width: 165px;"
                                            required>
                                            <option value="" disabled selected>Selecciona un área</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div class="mb-3" style="margin-top: 2.5%; display:none"
                                            id="addNroConsul_div">
                                            <label for="addNroConsul" class="form-label">Nº:</label>
                                            <input type="text"
                                                class="form-control @error('addNroConsul') is-invalid @enderror"
                                                id="addNroConsul" name="addNroConsul" placeholder="Nº de consultorio"
                                                style="border: 1px solid gray; border-radius: 5px; max-width: 165px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" id="deposito-select" style="flex: 1;">
                                    <label for="addDeposito" class="form-label">Deposito:</label>
                                    <select class="form-control @error('addDeposito') is-invalid @enderror"
                                        id="addDeposito" name="addDeposito"
                                        style="border: 1px solid gray; border-radius: 5px; min-width:165px; max-width: 165px;"
                                        required>
                                        <option value="" disabled selected>Selecciona un depósito</option>
                                        @foreach ($depositos as $deposito)
                                            <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Cargar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editTelModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mantenimiento telefono</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex;">
                        <form action="{{ route('edit_telefonos') }}" method="POST" id="editImpModal"
                            style="display: flex; flex-direction: column; gap: 20px; ">
                            @method('PATCH')
                            @csrf
                            <!-- Mostrar errores de validación generales -->
                            <div class="form-check d-flex align-items-top">
                                <input type="hidden" name="editId" id="editId">
                                <input class="form-check-input" type="checkbox" id="editEn-uso" name="en-uso">
                                <label class="form-check-label" for="editEn-uso">
                                    En uso
                                </label>
                            </div>
                            <div style="display: flex; flex-direction: row;">
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="editIdentificador" class="form-label">Nº Inventario:</label>
                                    <input type="text"
                                        class="form-control @error('editIdentificador') is-invalid @enderror"
                                        id="editIdentificador" name="editIdentificador" placeholder="Nº Inventario"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="editNombre" class="form-label">Nombre:</label>
                                    <input type="text"
                                        class="form-control @error('editNombre') is-invalid @enderror" id="editNombre"
                                        name="editNombre" placeholder="Nombre"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="editMarca" class="form-label">Marca y Modelo:</label>
                                    <input type="text"
                                        class="form-control @error('editMarca') is-invalid @enderror" id="editMarca"
                                        name="editMarca" placeholder="Marca y modelo"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>
                                <div class="mb-3" style="margin-right: 2.5%">
                                    <label for="editIp" class="form-label">IP:</label>
                                    <input type="text" class="form-control @error('editIp') is-invalid @enderror"
                                        id="editIp" name="editIp" placeholder="Direccion IPv4"
                                        style="border: 1px solid gray; border-radius: 5px; max-width: 165px;" required>
                                </div>

                            </div>

                            <div style="display: flex; flex-direction: row; gap: 20px;"> <!-- ROW PRINCIPAL -->
                                <div style="display: flex; flex-direction: column; gap: 20px;">
                                    <div style="display: flex; flex-direction: row; gap: 20px;">
                                        <div class="mb-3" style="flex: 1;">
                                            <label for="editNumero" class="form-label">Numero:</label>
                                            <input type="text"
                                                class="form-control @error('editNumero') is-invalid @enderror"
                                                id="editNumero" name="editNumero" placeholder="Numero de telefono"
                                                style="border: 1px solid gray; border-radius: 5px; max-width: 165px;"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div id="content-container">
                                    <div class="mb-3" id="area-select" style="flex: 1;">
                                        <label for="editArea" class="form-label">Area:</label>
                                        <select class="form-control @error('editArea') is-invalid @enderror"
                                            id="editArea" name="editArea"
                                            style="border: 1px solid gray; border-radius: 5px; min-width:165px; max-width: 165px;"
                                            required>
                                            <option value="" disabled selected>Selecciona un área</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div class="mb-3" style="margin-top: 2.5%; display:none"
                                            id="editNroConsul_div">
                                            <label for="editNroConsul" class="form-label">Nº:</label>
                                            <input type="text"
                                                class="form-control @error('editNroConsul') is-invalid @enderror"
                                                id="editNroConsul" name="editNroConsul"
                                                placeholder="Nº de consultorio"
                                                style="border: 1px solid gray; border-radius: 5px; max-width: 165px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" id="deposito-select" style="flex: 1;">
                                    <label for="editDeposito" class="form-label">Deposito:</label>
                                    <select class="form-control @error('editDeposito') is-invalid @enderror"
                                        id="editDeposito" name="editDeposito"
                                        style="border: 1px solid gray; border-radius: 5px; min-width:165px; max-width: 165px;"
                                        required>
                                        <option value="" disabled selected>Selecciona un depósito</option>
                                        @foreach ($depositos as $deposito)
                                            <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-check d-flex align-items-top">
                                <input class="form-check-input" type="checkbox" id="en-uso-mantenimineto">
                                <label class="form-check-label" for="en-uso-mantenimineto">
                                    Se realizo manteniminto
                                </label>
                            </div>
                            <div id="div-detalle-mant">
                                <div class="mb-3" style="flex: 1; display:none">
                                    <label for="editDetalle" class="form-label">Detalle:</label>
                                    <input type="text"
                                        class="form-control @error('editDetalle') is-invalid @enderror"
                                        id="editDetalle" name="editDetalle"
                                        style="border: 1px solid gray; border-radius: 5px;">
                                </div>
                            </div>
                            <div class="mb-3" style="flex: 1;">
                                <label for="editMotivo" class="form-label">Motivo:</label>
                                <input type="text" class="form-control @error('editMotivo') is-invalid @enderror"
                                    id="editMotivo" name="editMotivo"
                                    style="border: 1px solid gray; border-radius: 5px;" required>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Realizado</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('delete_telefonos') }}" method="POST" id="addModal">
                            @csrf
                            <!-- Mostrar errores de validación generales -->

                            <div class="mb-3">
                                <input type="hidden" id="deleteId" name="deleteId">
                                <label for="removeMotivo" class="form-label">Motivo:</label>
                                <input type="text"
                                    class="form-control @error('removeMotivo') is-invalid @enderror"
                                    id="removeMotivo" name="removeMotivo"
                                    style="border: 1px solid gray; border-radius:5px" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                            aria-label="Close">No</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="historyPcModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Historia del telefono:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="container mt-4">
                        <table id="table_historias_pc" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tecnico</th>
                                    <th>Detalle</th>
                                    <th>Motivo</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="table_historias_tbody">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @error('addNombre')
                    <div class="alert-danger" style="text-align: center">
                        {{ $message }}
                    </div>
                @enderror
                @if (session('success'))
                    <div class="alert-success">
                        <p style="padding: 0.3%; text-align: center">{{ session('success') }}</p>
                    </div>
                @endif
                <div class="d-flex justify-content-left p-3 bg-light rounded shadow-sm">




                    <!--
                    <div class="small-box bg-danger" style="margin: 5px;">
                        <div class="inner">
                            <h3 class="text-lg">Eliminar</h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"><i class="fas fa-trash-alt"></i></a>
                    </div>
                -->
                    <div class="container mt-4">
                        <div style="display: flex; justify-content: space-between;">
                            @if (Auth::user()->rol->nombre == 'Administrador' || Auth::user()->rol->nombre == 'Super administrador' || Auth::user()->rol->nombre == 'Tecnico')
                            <div>
                                <button id="addButton" class="btn btn-dark mr-2" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="fas fa-plus"></i> Cargar telefono
                                </button>
                            </div>
                            @endif
                            <div>
                                <input class="search_input" id="search_tel" type="text" placeholder="Buscar">
                            </div>
                        </div>
                        <div class="flex" id="div-telefono"
                            style="margin-top:5%;margin-bottom:5%; flex-wrap:wrap; gap: 9px; justify-content:center">

                            @foreach ($telefonos as $telefono)
                                <div class="card telefono-card" data-bs-toggle="modal" data-bs-target="#infoTelModal"
                                    data-nombre="{{ strtolower($telefono->nombre) }}"
                                    data-id="{{ strtolower($telefono->identificador) }}"
                                    style="margin-top: -1.5%;max-width: 16%; display: flex; flex-direction: column; justify-content: space-between; height: auto;">
                                    <!-- Ajusta la altura según tus necesidades -->
                                    <span class="icon">
                                        <img src="https://simpleicon.com/wp-content/uploads/phone-6.png"
                                            alt="PC Icon" style="filter:invert(100%)">
                                    </span>
                                    <div style="display: flex; align-items:center;">
                                        <h4>{{ $telefono->nombre }}</h4>
                                        @if ($telefono->area_id != null)
                                            <span class="icon">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQodw79SG-RYSnRDBNISWEFfF2qZJ9V80TELg&s"
                                                    alt="Status Icon"
                                                    style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                            </span>
                                        @endif
                                        @if ($telefono->area_id == null)
                                            <span class="icon">
                                                <img src="https://freesvg.org/img/1286146771.png" alt="Status Icon"
                                                    style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                            </span>
                                        @endif
                                    </div>
                                    <p>{{ 'N° inv: ' . $telefono->identificador }}</p>
                                    <p>{{ 'IPv4: ' . $telefono->ip }}</p>
                                    @if ($telefono->area_id != null || $telefono->deposito_id != null)
                                        @if ($telefono->area_id != null)
                                            <p>{{ 'Area: ' . ($telefono->area->nombre ?? 'no asignado') }}</p>
                                        @endif
                                        @if ($telefono->area_id == null)
                                            <p>{{ 'Deposito: ' . ($telefono->deposito->nombre ?? 'no asignado') }}</p>
                                        @endif
                                    @endif

                                    <div style="margin-top: auto;">
                                        <div class="flex" style="gap: 1px; justify-content: center;">

                                            <button class="btn btn-dark icon infoBtn" data-bs-toggle="modal"
                                                data-bs-target="#infoTelModal" data-id="{{ $telefono->id }}"
                                                data-identificador="{{ $telefono->identificador }}"
                                                data-nombre="{{ $telefono->nombre }}" data-ip="{{ $telefono->ip }}"
                                                data-area="{{ $telefono->area->nombre ?? 'Área no asignada' }}"
                                                data-deposito="{{ $telefono->deposito->nombre ?? 'Depósito no asignado' }}"
                                                data-enuso="{{ $telefono->area && $telefono->area->nombre ? 'true' : 'false' }}"
                                                data-numero="{{ $telefono->numero }}"
                                                data-marca="{{ $telefono->marca_modelo ?? '' }}">
                                                <i class="fas fa-circle-info"></i>
                                            </button>
                                            @if (Auth::user()->rol->nombre == 'Administrador' || Auth::user()->rol->nombre == 'Super administrador' || Auth::user()->rol->nombre == 'Tecnico')
                                            <button class="btn btn-dark icon maintenanceBtn" data-bs-toggle="modal"
                                                data-bs-target="#editTelModal" data-id="{{ $telefono->id }}"
                                                data-identificador="{{ $telefono->identificador }}"
                                                data-nombre="{{ $telefono->nombre }}" data-ip="{{ $telefono->ip }}"
                                                data-area="{{ $telefono->area->id ?? 'Área no asignada' }}"
                                                data-deposito="{{ $telefono->deposito->id ?? 'Depósito no asignado' }}"
                                                data-enuso="{{ $telefono->area && $telefono->area->nombre ? 'true' : 'false' }}"
                                                data-numero="{{ $telefono->numero }}"
                                                data-marca="{{ $telefono->marca_modelo ?? '' }}">
                                                <i class="fa-solid fa-wrench"></i>
                                            </button>
                                            @endif
                                            <button class="btn btn-dark icon historyBtn" data-bs-toggle="modal"
                                                data-bs-target="#historyPcModal" data-id="{{ $telefono->id }}"
                                                data-nro_inv="{{ $telefono->identificador }}"
                                                data-nombre="{{ $telefono->nombre }}"
                                                data-tipo="{{ 'Telefono' }}">
                                                <i class="fa-solid fa-book"></i>
                                            </button>
                                            @if (Auth::user()->rol->nombre == 'Super administrador')
                                                <button class="btn btn-dark icon" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-id="{{ $telefono->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>



</x-app-layout>
<script>
    $(document).ready(function() {

        $('#en-uso').on('change', function() {
            var isChecked = $(this).is(':checked');

            // Ajustar habilitación/deshabilitación en función del estado del checkbox
            if (!isChecked) {
                $('#addNroConsul_div').css('display', 'none');
                $('#addNroConsul_div').attr('required', false);
                $('#editNroConsul_div').css('display', 'none');
                $('#editNroConsul_div').attr('required', false);
            }
        });

        $('#editEn-uso').on('change', function() {
            var isChecked = $(this).is(':checked');

            // Ajustar habilitación/deshabilitación en función del estado del checkbox
            if (!isChecked) {
                $('#addNroConsul_div').css('display', 'none');
                $('#addNroConsul_div').attr('required', false);
                $('#editNroConsul_div').css('display', 'none');
                $('#editNroConsul_div').attr('required', false);
            }
        });

        $('#search_tel').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();

            // Filtrar las tarjetas de PC
            $('.card').each(function() {
                var nombre = String($(this).data('nombre'));
                var id = String($(this).data('id')); // Convertir id a cadena

                // Mostrar la tarjeta si el nombre o la IP contiene el término de búsqueda
                if (nombre.includes(searchTerm) || id.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $('#addArea').on('change', function() {
            if ($(this).val() == 27) {
                $('#addNroConsul_div').css('display', 'block');
                $('#addNroConsul_div').attr('required', true);

            } else {
                $('#addNroConsul_div').css('display', 'none');
                $('#addNroConsul_div').attr('required', false);
            }
        });

        $('#editArea').on('change', function() {
            if ($(this).val() == 27) {
                $('#editNroConsul_div').css('display', 'block');
                $('#editNroConsul_div').css('required', true);
            } else {
                $('#editNroConsul_div').css('display', 'none');
                $('#editNroConsul_div').css('required', false);
            }
        });

        var modalHandlerAttached = false;
        var nro_inv = "";
        var nombre = "";

        $('#historyPcModal').on('show.bs.modal', function(event) {
            if (modalHandlerAttached) return;
            modalHandlerAttached = true;
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var componenteId = button.data('id'); // Obtener el ID del componente
            var componenteTipo = button.data('tipo'); // Obtener el ID del componente
            nro_inv = button.data('nro_inv');
            nombre = button.data('nombre');

            // Limpiar cualquier dato previo en la tabla
            var table = $('#table_historias_pc').DataTable();
            table.order([3, 'desc']).draw();
            table.clear().draw();

            var historiaUrl = '{{ route('historia.get', ['tipo' => ':tipo', 'id' => ':id']) }}';
            historiaUrl = historiaUrl.replace(':tipo', componenteTipo);
            historiaUrl = historiaUrl.replace(':id', componenteId);

            // Realizar la solicitud AJAX para obtener los registros de historia
            $.ajax({
                url: historiaUrl, // Cambia la URL a la ruta de tu controlador
                method: 'GET',
                success: function(response) {
                    var data = [];

                    response.historia.forEach(function(historia) {
                        var fechaFormateada = new Date(historia.created_at)
                            .toLocaleDateString('es-ES', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                        var motivo = historia.motivo || '';

                        data.push([
                            `<b>${historia.tecnico}</b>`,
                            `<b>${historia.detalle}</b>`,
                            `<b>${motivo}</b>`,
                            `<b>${fechaFormateada}</b>`
                        ]);
                    });

                    // Añadir los datos a la tabla y refrescarla
                    table.rows.add(data).draw();
                },
                error: function() {
                    alert('Error al cargar las historias.');
                }
            });
        });

        $('#historyPcModal').on('hide.bs.modal', function() {
            modalHandlerAttached = false;
        });

        $('#editTelModal').on('show.bs.modal', function(event) {
            var modal = $(this);
            var container = modal.find('#input-container-2');

            var button = $(event.relatedTarget); // Botón que abrió el modal
            var Id = button.data('id'); // Extraer ID del atributo 'data-id'
            var Identificador = button.data('identificador');
            var Nombre = button.data('nombre'); // Extraer nombre del atributo 'data-nombre'
            var Marca = button.data('marca'); // Extraer nombre del atributo 'data-nombre'
            var Deposito = button.data('deposito');
            var Ip = button.data('ip');
            var Area_id = button.data('area');
            var Deposito_id = button.data('deposito');
            var enUso = button.data('enuso');
            var Numero = button.data('numero');

            modal.find('#editEn-uso').prop('checked', enUso);
            if (!enUso) {
                modal.find('#editDeposito').prop('disabled', false);
                modal.find('#editArea').prop('disabled', true);
                modal.find('#editDeposito').val(Deposito_id);
            } else {
                modal.find('#editDeposito').prop('disabled', true);
                modal.find('#editArea').prop('disabled', false);
                modal.find('#editArea').val(Area_id);
            }

            modal.find('#editNombre').val(Nombre);
            modal.find('#editId').val(Id);
            modal.find('#editIdentificador').val(Identificador);
            modal.find('#editIp').val(Ip);
            modal.find('#editNumero').val(Numero);
            modal.find('#editMarca').val(Marca);

        });

        $('#editEn-uso').on('change', function() {
            var modal = $('#editImpModal');
            var isChecked = $(this).is(':checked');

            // Ajustar habilitación/deshabilitación en función del estado del checkbox
            if (!isChecked) {
                modal.find('#editDeposito').prop('disabled', false);
                modal.find('#editArea').prop('disabled', true);
                modal.find('#editDeposito').val(null);
                modal.find('#editArea').val(null);
            } else {
                modal.find('#editDeposito').prop('disabled', true);
                modal.find('#editArea').prop('disabled', false);
                modal.find('#editArea').val(null);
                modal.find('#editDeposito').val(null);
            }
        });

        const checkbox = document.getElementById('en-uso-mantenimineto');
        const detalleInput = document.getElementById('div-detalle-mant');

        checkbox.addEventListener('change', function() {
            const div = detalleInput.querySelector('div');
            const input = div.querySelector(
                'input'); // Suponiendo que es un input el que quieres hacer requerido

            if (checkbox.checked) {
                div.style.display = "block"; // Muestra el div
                input.setAttribute('required', 'required'); // Hace el campo requerido
            } else {
                div.style.display = "none"; // Oculta el div
                input.removeAttribute('required'); // Quita el atributo requerido
            }
        });

        $('#infoTelModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var Id = button.data('id');
            var Ip = button.data('ip');
            var Identificador = button.data('identificador');
            var Nombre = button.data('nombre');
            var Area = button.data('area');
            var Deposito = button.data('deposito');
            var enUso = button.data('enuso');
            var Numero = button.data('numero');
            var Marca = button.data('marca');

            var modal = $(this);
            modal.find('#idenInfo').text(Identificador);
            modal.find('#nombreInfo').text(Nombre);
            modal.find('#marcaInfo').text(Marca);
            modal.find('#ipInfo').text(Ip);
            modal.find('#numeroInfo').text(Numero);

            if (enUso == true) {
                modal.find('#titleAsig').text("Area:");
                modal.find('#infoAsig').text(Area);
            } else {
                modal.find('#titleAsig').text("Deposito:");
                modal.find('#infoAsig').text(Deposito);
            }
        });

        // Manejador para el click en el div con la clase 'card'
        $('.card').on('click', function() {
            // Dispara el click en el botón infoBtn dentro del div
            $(this).find('.infoBtn').trigger('click');
        });

        // Manejador para el click en el botón infoBtn
        $('.infoBtn').on('click', function(event) {
            // Evita que el modal se abra inmediatamente
            event.preventDefault();

            // Cargar los datos en el modal
            const modal = $('#infoTelModal');
            modal.find('#idenInfo').text($(this).data('identificador'));
            modal.find('#nombreInfo').text($(this).data('nombre'));
            modal.find('#marcaInfo').text($(this).data('marca'));
            modal.find('#numeroInfo').text($(this).data('numero'));
            modal.find('#ipInfo').text($(this).data('ip'));
            if ($(this).data('enuso')) {
                modal.find('#titleAsig').text("Area:");
                modal.find('#infoAsig').text($(this).data('area'));

            } else {
                modal.find('#titleAsig').text("Deposito:");
                modal.find('#infoAsig').text($(this).data('deposito'));

            }

            // Mostrar el modal
            modal.modal('show');
        });

        // Manejador para el click en el botón de mantenimiento
        $('.maintenanceBtn').on('click', function(event) {
            event.stopPropagation();
            // Código específico para el botón de mantenimiento
        });

        // Manejador para el click en el botón de historial
        $('.historyBtn').on('click', function(event) {
            event.stopPropagation();
            // Código específico para el botón de historial
        });


        $("#table_historias_pc").DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                className: 'btn btn-dark custom-export-btn',
                title: function() {

                    return "Historia de " + nro_inv + " - " + nombre;

                }
            }],
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": " _MENU_ ",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna ascendente",
                    "sortDescending": ": activar para ordenar la columna descendente"
                }
            }
        });

    });
</script>
