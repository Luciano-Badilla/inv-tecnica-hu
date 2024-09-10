<?php use App\Models\PcModel; ?>
<?php use App\Models\ImpresoraModel; ?>
<?php use App\Models\TelefonoModel; ?>
<?php use App\Models\RouterModel; ?>
<?php use App\Models\ComponenteModel; ?>

<x-app-layout>
    @if (Auth::user()->pass_changed == false)
        <div class="modal fade" id="infoPassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-primaty" style="border-radius: 15px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recordatorio cambio de contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p
                            style="color: #d94f4f; background-color: #f9e2e2; border: 1px solid #d43f3a; padding: 10px; border-radius: 5px;">
                            Para mantener la seguridad de su cuenta se recomienda que cambie su contraseña.
                        </p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-dark" style="margin-top:3%">Cambiar
                            contraseña</a>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="infoPcModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content bg-primaty" style="border-radius: 15px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información de la PC</h5>
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
                                <h2><b>IPv4: </b></h2>
                                <p id="ipInfo"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="flex" style="display: flex; flex-direction: column; gap:5px">
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <b>
                                    <h2 id="titleAsig"></h2>
                                </b>
                                <p id="infoAsig"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="flex" style="display: flex; flex-direction: column; gap:5px">
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>Placa Madre: </b></h2>
                                <p id="motherInfo"></p>
                            </div>
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>Procesador: </b></h2>
                                <p id="proceInfo"></p>
                            </div>
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>Discos: </b></h2>
                                <p id="discosInfo"></p>
                            </div>
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>RAMs: </b></h2>
                                <p id="ramsInfo"></p>
                            </div>
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>Fuente: </b></h2>
                                <p id="fuenteInfo"></p>
                            </div>
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>Placa de video: </b></h2>
                                <p id="placavidInfo"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoImpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content bg-primaty" style="border-radius: 15px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información de la Impresora</h5>
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
                            <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                <h2><b>Toner: </b></h2>
                                <p id="tonerInfo"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoTelModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <div class="modal fade" id="infoRouterModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-auto">
            <div class="modal-content bg-primaty" style="border-radius: 15px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información del router</h5>
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
                                <div class="flex" style="display: flex; flex-direction: row; gap:5px">
                                    <b>
                                        <h2 id="title2Asig"></h2>
                                    </b>
                                    <p id="info2Asig"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; box-sizing: border-box; padding: 0% 5%;">
        <div>
            <div
                style="
                font-size: 1.3rem;
                font-weight: 600;
                color: #1F2937;
                padding: 1% 0%;
                
                margin-top: 10px;
                flex: 1; /* Ocupa el espacio disponible */
                margin-right: 10px; /* Espacio entre los divs */
                margin-left: 10px; /* Espacio entre los divs */
            ">
                <p style="margin-left: 2%">Gestión de dispositivos:</p>
                <div class="p-6 text-gray-900 flex justify-start flex-wrap" style="gap:10px">
                    <a class="card pc-card" href="{{ route('gest_pc') }}"
                        style="max-width: 16%; display: flex; flex-direction: column; justify-content: flex-start; height: auto;">
                        <!-- Ajusta la altura según tus necesidades -->
                        <span class="icon">
                            <img src="https://simpleicon.com/wp-content/uploads/pc.png" alt="PC Icon"
                                style="filter:invert(100%)">
                        </span>
                        <div>
                            <h4>PCs</h4>
                        </div>
                        <p>Administrar PCs</p>
                    </a>
                    <a class="card pc-card" href="{{ route('gest_impresoras') }}"
                        style="max-width: 16%; display: flex; flex-direction: column; justify-content: flex-start; height: auto;">
                        <!-- Ajusta la altura según tus necesidades -->
                        <span class="icon">
                            <img src="https://simpleicon.com/wp-content/uploads/printer-11.png" alt="PC Icon"
                                style="filter:invert(100%)">
                        </span>
                        <div style="display: flex; align-items:center;">
                            <h4>Impresoras</h4>
                        </div>
                        <p>Administrar Impresoras</p>
                    </a>
                    <a class="card pc-card" href="{{ route('gest_telefonos') }}"
                        style="max-width: 16%; display: flex; flex-direction: column; justify-content: flex-start; height: auto;">
                        <!-- Ajusta la altura según tus necesidades -->
                        <span class="icon">
                            <img src="https://simpleicon.com/wp-content/uploads/phone-6.png" alt="PC Icon"
                                style="filter:invert(100%)">
                        </span>
                        <div style="display: flex; align-items:center;">
                            <h4>Telefonos IP</h4>
                        </div>
                        <p>Administrar Telefonos IP</p>
                    </a>
                    <a class="card pc-card" href="{{ route('gest_routers') }}"
                        style="max-width: 16%; display: flex; flex-direction: column; justify-content: flex-start; height: auto;">
                       
                        <span class="icon">
                            <img src="https://i.postimg.cc/kXNyhjyT/image-removebg-preview.png" alt="PC Icon"
                                style="filter:invert(100%)">
                        </span>
                        <div style="display: flex; align-items:center;">
                            <h4>Routers</h4>
                        </div>
                        <p>Administrar Routers wifi</p>
                    </a>
                </div>
            </div>
        </div>
        <div style="display: flex; flex-direction: row; box-sizing: border-box; padding: 0% 0.8%; margin-top: -6%">
            <div
                style="
                    font-size: 1.3rem;
                    font-weight: 600;
                    color: #1F2937;
                    padding: 1% 2%;
                    
                    margin-top: 3%;
                    flex: 2; /* Ocupa el espacio disponible */
                    margin-right: 10px; /* Espacio entre los divs */
                    height: 100%;
                    ">
                {{ __('Ultimos dispositivos modificados:') }}
                <div class="flex" id="div-pc"
                    style="margin-top:5%;margin-bottom:5%; flex-wrap:wrap; gap: 9px; justify-content:center">

                    @foreach ($lastDevicesUpdated as $lastDeviceUpdated)
                        @if ($lastDeviceUpdated->tipo_dispositivo == 'PC')
                            <div class="card pc-card"
                                data-nombre="{{ strtolower(PcModel::find($lastDeviceUpdated->componente_id)->nombre) }}"
                                data-id="{{ strtolower(PcModel::find($lastDeviceUpdated->componente_id)->identificador) }}"
                                data-tipo="{{ $lastDeviceUpdated->tipo_dispositivo }}"
                                style="margin-top: -1.5%;max-width: 32%; display: flex; flex-direction: column; justify-content: space-between; max-height: 20%;">
                                <!-- Ajusta la altura según tus necesidades -->
                                <span class="iconHome">
                                    <img src="https://simpleicon.com/wp-content/uploads/pc.png" alt="PC Icon"
                                        style="filter:invert(100%)">
                                </span>
                                <div style="display: flex; align-items:center;">
                                    <h4>{{ PcModel::find($lastDeviceUpdated->componente_id)->nombre }}</h4>
                                    @if (PcModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <span class="icon">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQodw79SG-RYSnRDBNISWEFfF2qZJ9V80TELg&s"
                                                alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                    @if (PcModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <span class="icon">
                                            <img src="https://freesvg.org/img/1286146771.png" alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                </div>
                                <p>{{ 'N° inv: ' . PcModel::find($lastDeviceUpdated->componente_id)->identificador }}
                                </p>
                                <p>{{ 'IPv4: ' . PcModel::find($lastDeviceUpdated->componente_id)->ip }}</p>
                                @if (PcModel::find($lastDeviceUpdated->componente_id)->area_id != null ||
                                        PcModel::find($lastDeviceUpdated->componente_id)->deposito_id != null)
                                    @if (PcModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <p>{{ 'Area: ' . (PcModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                    @if (PcModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <p>{{ 'Deposito: ' . (PcModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                @endif

                                <div style="margin-top: auto;">
                                    <div class="flex" style="gap: 1px; justify-content: center;">
                                        <button class="btn btn-dark icon infoBtnPc" data-bs-toggle="modal"
                                            style="display: none" data-bs-target="#infoPcModal"
                                            data-id="{{ PcModel::find($lastDeviceUpdated->componente_id)->id }}"
                                            data-identificador="{{ PcModel::find($lastDeviceUpdated->componente_id)->identificador }}"
                                            data-nombre="{{ PcModel::find($lastDeviceUpdated->componente_id)->nombre }}"
                                            data-ip="{{ PcModel::find($lastDeviceUpdated->componente_id)->ip }}"
                                            data-area="{{ PcModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'Área no asignada' }}"
                                            data-deposito="{{ PcModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'Depósito no asignado' }}"
                                            data-enuso="{{ PcModel::find($lastDeviceUpdated->componente_id)->area && PcModel::find($lastDeviceUpdated->componente_id)->area->nombre ? 'true' : 'false' }}"
                                            data-mother="{{ PcModel::find($lastDeviceUpdated->componente_id)->componentes->firstWhere('tipo_id', 5)->nombre ?? '' }}"
                                            data-proce="{{ PcModel::find($lastDeviceUpdated->componente_id)->componentes->firstWhere('tipo_id', 4)->nombre ?? '' }}"
                                            data-fuente="{{ PcModel::find($lastDeviceUpdated->componente_id)->componentes->firstWhere('tipo_id', 2)->nombre ?? '' }}"
                                            data-placavid="{{ PcModel::find($lastDeviceUpdated->componente_id)->componentes->firstWhere('tipo_id', 7)->nombre ?? 'Sin placa de video' }}"
                                            data-discos="{{ PcModel::find($lastDeviceUpdated->componente_id)->componentes->whereIn('tipo_id', [6, 3])->pluck('nombre')->implode(', ') }}"
                                            data-rams="{{ PcModel::find($lastDeviceUpdated->componente_id)->componentes->where('tipo_id', 1)->pluck('nombre')->implode(', ') }}">
                                            <i class="fas fa-circle-info"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($lastDeviceUpdated->tipo_dispositivo == 'Impresora')
                            <div class="card imp"
                                data-nombre="{{ strtolower(ImpresoraModel::find($lastDeviceUpdated->componente_id)->nombre) }}"
                                data-id="{{ strtolower(ImpresoraModel::find($lastDeviceUpdated->componente_id)->identificador) }}"
                                data-tipo="{{ $lastDeviceUpdated->tipo_dispositivo }}"
                                style="margin-top: -1.5%;max-width: 32%; display: flex; flex-direction: column; justify-content: space-between; height: auto;">
                                <!-- Ajusta la altura según tus necesidades -->
                                <span class="iconHome">
                                    <img src="https://simpleicon.com/wp-content/uploads/printer-11.png" alt="PC Icon"
                                        style="filter:invert(100%)">
                                </span>
                                <div style="display: flex; align-items:center;">
                                    <h4>{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->nombre }}</h4>
                                    @if (ImpresoraModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <span class="icon">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQodw79SG-RYSnRDBNISWEFfF2qZJ9V80TELg&s"
                                                alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                    @if (ImpresoraModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <span class="icon">
                                            <img src="https://freesvg.org/img/1286146771.png" alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                </div>
                                <p>{{ 'N° inv: ' . ImpresoraModel::find($lastDeviceUpdated->componente_id)->identificador }}
                                </p>
                                <p>{{ 'IPv4: ' . ImpresoraModel::find($lastDeviceUpdated->componente_id)->ip }}</p>
                                @if (ImpresoraModel::find($lastDeviceUpdated->componente_id)->area_id != null ||
                                        ImpresoraModel::find($lastDeviceUpdated->componente_id)->deposito_id != null)
                                    @if (ImpresoraModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <p>{{ 'Area: ' . (ImpresoraModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                    @if (ImpresoraModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <p>{{ 'Deposito: ' . (ImpresoraModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                @endif

                                <div style="margin-top: auto;">
                                    <div class="flex" style="gap: 1px; justify-content: center;">
                                        <button class="btn btn-dark icon infoBtnImp" data-bs-toggle="modal"
                                            style="display: none" data-bs-target="#infoImpModal"
                                            data-id="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->id }}"
                                            data-identificador="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->identificador }}"
                                            data-nombre="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->nombre }}"
                                            data-ip="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->ip }}"
                                            data-area="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'Área no asignada' }}"
                                            data-deposito="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'Depósito no asignado' }}"
                                            data-enuso="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->area && ImpresoraModel::find($lastDeviceUpdated->componente_id)->area->nombre ? 'true' : 'false' }}"
                                            data-toner="{{ ComponenteModel::find(ImpresoraModel::find($lastDeviceUpdated->componente_id)->toner_id)->nombre ?? 'Toner no asignado' }}"
                                            data-marca="{{ ImpresoraModel::find($lastDeviceUpdated->componente_id)->marca_modelo ?? '' }}">
                                            <i class="fas fa-circle-info"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($lastDeviceUpdated->tipo_dispositivo == 'Telefono')
                            <div class="card telefono-card" data-bs-toggle="modal" data-bs-target="#infoTelModal"
                                data-nombre="{{ strtolower(TelefonoModel::find($lastDeviceUpdated->componente_id)->nombre) }}"
                                data-id="{{ strtolower(TelefonoModel::find($lastDeviceUpdated->componente_id)->identificador) }}"
                                data-tipo="{{ $lastDeviceUpdated->tipo_dispositivo }}"
                                style="margin-top: -1.5%;max-width: 32%; display: flex; flex-direction: column; justify-content: space-between; height: auto;">
                                <!-- Ajusta la altura según tus necesidades -->
                                <span class="iconHome">
                                    <img src="https://simpleicon.com/wp-content/uploads/phone-6.png" alt="PC Icon"
                                        style="filter:invert(100%)">
                                </span>
                                <div style="display: flex; align-items:center;">
                                    <h4>{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->nombre }}</h4>
                                    @if (TelefonoModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <span class="icon">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQodw79SG-RYSnRDBNISWEFfF2qZJ9V80TELg&s"
                                                alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                    @if (TelefonoModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <span class="icon">
                                            <img src="https://freesvg.org/img/1286146771.png" alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                </div>
                                <p>{{ 'N° inv: ' . TelefonoModel::find($lastDeviceUpdated->componente_id)->identificador }}
                                </p>
                                <p>{{ 'IPv4: ' . TelefonoModel::find($lastDeviceUpdated->componente_id)->ip }}</p>
                                @if (TelefonoModel::find($lastDeviceUpdated->componente_id)->area_id != null ||
                                        TelefonoModel::find($lastDeviceUpdated->componente_id)->deposito_id != null)
                                    @if (TelefonoModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <p>{{ 'Area: ' . (TelefonoModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                    @if (TelefonoModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <p>{{ 'Deposito: ' . (TelefonoModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                @endif

                                <div style="margin-top: auto;">
                                    <div class="flex" style="gap: 1px; justify-content: center;">

                                        <button class="btn btn-dark icon infoBtnTel" data-bs-toggle="modal"
                                            style="display: none" data-bs-target="#infoTelModal"
                                            data-id="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->id }}"
                                            data-identificador="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->identificador }}"
                                            data-nombre="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->nombre }}"
                                            data-ip="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->ip }}"
                                            data-area="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'Área no asignada' }}"
                                            data-deposito="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'Depósito no asignado' }}"
                                            data-enuso="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->area && TelefonoModel::find($lastDeviceUpdated->componente_id)->area->nombre ? 'true' : 'false' }}"
                                            data-numero="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->numero }}"
                                            data-marca="{{ TelefonoModel::find($lastDeviceUpdated->componente_id)->marca_modelo ?? '' }}">
                                            <i class="fas fa-circle-info"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($lastDeviceUpdated->tipo_dispositivo == 'Router')
                            <div class="card router-card"
                                data-nombre="{{ strtolower(RouterModel::find($lastDeviceUpdated->componente_id)->nombre) }}"
                                data-id="{{ strtolower(RouterModel::find($lastDeviceUpdated->componente_id)->identificador) }}"
                                data-tipo="{{ $lastDeviceUpdated->tipo_dispositivo }}"
                                style="margin-top: -1.5%;max-width: 32%; display: flex; flex-direction: column; justify-content: space-between; height: auto;">
                                <!-- Ajusta la altura según tus necesidades -->
                                <span class="iconHome">
                                    <img src="https://i.postimg.cc/kXNyhjyT/image-removebg-preview.png  "
                                        alt="PC Icon" style="filter:invert(100%)">
                                </span>
                                <div style="display: flex; align-items:center;">
                                    <h4>{{ RouterModel::find($lastDeviceUpdated->componente_id)->nombre }}</h4>
                                    @if (RouterModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <span class="icon">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQodw79SG-RYSnRDBNISWEFfF2qZJ9V80TELg&s"
                                                alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                    @if (RouterModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <span class="icon">
                                            <img src="https://freesvg.org/img/1286146771.png" alt="Status Icon"
                                                style="width:10px; border-radius: 50%; align-items: center; margin-top: 15%">
                                        </span>
                                    @endif
                                </div>
                                <p>{{ 'N° inv: ' . RouterModel::find($lastDeviceUpdated->componente_id)->identificador }}
                                </p>
                                <p>{{ 'IPv4: ' . RouterModel::find($lastDeviceUpdated->componente_id)->ip }}</p>
                                @if (RouterModel::find($lastDeviceUpdated->componente_id)->area_id != null ||
                                        RouterModel::find($lastDeviceUpdated->componente_id)->deposito_id != null)
                                    @if (RouterModel::find($lastDeviceUpdated->componente_id)->area_id != null)
                                        <p>{{ 'Area: ' . (RouterModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                    @if (RouterModel::find($lastDeviceUpdated->componente_id)->area_id == null)
                                        <p>{{ 'Deposito: ' . (RouterModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'no asignado') }}
                                        </p>
                                    @endif
                                @endif

                                <div style="margin-top: auto;">
                                    <div class="flex" style="gap: 1px; justify-content: center;">

                                        <button class="btn btn-dark icon infoBtnRou" data-bs-toggle="modal"
                                            style="display: none" data-bs-target="#infoRouterModal"
                                            data-id="{{ RouterModel::find($lastDeviceUpdated->componente_id)->id }}"
                                            data-identificador="{{ RouterModel::find($lastDeviceUpdated->componente_id)->identificador }}"
                                            data-nombre="{{ RouterModel::find($lastDeviceUpdated->componente_id)->nombre }}"
                                            data-ip="{{ RouterModel::find($lastDeviceUpdated->componente_id)->ip }}"
                                            data-area="{{ RouterModel::find($lastDeviceUpdated->componente_id)->area->nombre ?? 'Área no asignada' }}"
                                            data-deposito="{{ RouterModel::find($lastDeviceUpdated->componente_id)->deposito->nombre ?? 'Depósito no asignado' }}"
                                            data-enuso="{{ RouterModel::find($lastDeviceUpdated->componente_id)->area && RouterModel::find($lastDeviceUpdated->componente_id)->area->nombre ? 'true' : 'false' }}"
                                            data-numero="{{ RouterModel::find($lastDeviceUpdated->componente_id)->numero }}"
                                            data-marca="{{ RouterModel::find($lastDeviceUpdated->componente_id)->marca_modelo ?? '' }}"
                                            data-area_detalle="{{ RouterModel::find($lastDeviceUpdated->componente_id)->area_detalle ?? '' }}">
                                            <i class="fas fa-circle-info"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div
                style="
                font-size: 1.3rem;
                font-weight: 600;
                color: #1F2937;
                
                margin-top: 3%;
                margin-bottom: 3%;
                flex: 2; /* Ocupa el espacio disponible */
                margin-left: 10px; /* Espacio entre los divs */
                height: 100%
            ">
                <p style="padding-top: 2.1%; padding-left: 3%;">Ultimos movimientos:</p>
                <div class="container mt-4">
                    <table class="table table-borderless" style="font-size: 14px;">
                        <thead style="display: none;">
                            <tr>
                                <th>Tecnico</th>
                                <th>Detalle</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historias as $historia)
                                <tr>
                                    <td><b>{{ $historia->tecnico }}</b>
                                    <td><b>{{ $historia->detalle }}</b>
                                    <td><b>{{ $historia->created_at }}</b>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
            
        </div>

    </div>

</x-app-layout>
<script>
    $(document).ready(function() {

        var passModal = new bootstrap.Modal(document.getElementById('infoPassModal'));

        // Para abrir el modal
        passModal.show();

        $('.card').on('click', function() {
            // Dispara el click en el botón infoBtnPc dentro del div
            if ($(this).data('tipo') == 'PC') {
                $(this).find('.infoBtnPc').trigger('click');

            }
            if ($(this).data('tipo') == 'Impresora') {
                $(this).find('.infoBtnImp').trigger('click');

            }
            if ($(this).data('tipo') == 'Telefono') {
                $(this).find('.infoBtnTel').trigger('click');

            }
            if ($(this).data('tipo') == 'Router') {
                $(this).find('.infoBtnRou').trigger('click');

            }

        });

        // Manejador para el click en el botón infoBtnPc
        $('.infoBtnPc').on('click', function(event) {
            // Evita que el modal se abra inmediatamente
            event.preventDefault();


            // Cargar los datos en el modal
            const modal = $('#infoPcModal');
            modal.find('#idenInfo').text($(this).data('identificador'));
            modal.find('#nombreInfo').text($(this).data('nombre'));
            modal.find('#ipInfo').text($(this).data('ip'));
            if ($(this).data('enuso')) {
                modal.find('#titleAsig').text('Area:');
                modal.find('#infoAsig').text($(this).data('area'));
            } else {
                modal.find('#titleAsig').text('Deposito:');
                modal.find('#infoAsig').text($(this).data('deposito'));
            }
            modal.find('#motherInfo').text($(this).data('mother'));
            modal.find('#proceInfo').text($(this).data('proce'));
            modal.find('#discosInfo').text($(this).data('discos'));
            modal.find('#ramsInfo').text($(this).data('rams'));
            modal.find('#fuenteInfo').text($(this).data('fuente'));
            modal.find('#placavidInfo').text($(this).data('placavid'));

            // Mostrar el modal
            modal.modal('show');
        });

        $('.infoBtnImp').on('click', function(event) {
            // Evita que el modal se abra inmediatamente
            event.preventDefault();

            // Cargar los datos en el modal
            const modal = $('#infoImpModal');
            modal.find('#idenInfo').text($(this).data('identificador'));
            modal.find('#nombreInfo').text($(this).data('nombre'));
            modal.find('#marcaInfo').text($(this).data('marca'));
            modal.find('#ipInfo').text($(this).data('ip'));
            if ($(this).data('enuso')) {
                modal.find('#titleAsig').text("Area:");
                modal.find('#infoAsig').text($(this).data('area'));

            } else {
                modal.find('#titleAsig').text("Deposito:");
                modal.find('#infoAsig').text($(this).data('deposito'));

            }
            modal.find('#tonerInfo').text($(this).data('toner'));

            // Mostrar el modal
            modal.modal('show');
        });

        $('.infoBtnTel').on('click', function(event) {
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

        $('.infoBtnRou').on('click', function(event) {
            // Evita que el modal se abra inmediatamente
            event.preventDefault();

            // Cargar los datos en el modal
            const modal = $('#infoRouterModal');
            modal.find('#idenInfo').text($(this).data('identificador'));
            modal.find('#nombreInfo').text($(this).data('nombre'));
            modal.find('#marcaInfo').text($(this).data('marca'));
            modal.find('#ipInfo').text($(this).data('ip'));
            if ($(this).data('enuso')) {
                modal.find('#titleAsig').text("Area:");
                modal.find('#infoAsig').text($(this).data('area'));

            } else {
                modal.find('#titleAsig').text("Deposito:");
                modal.find('#infoAsig').text($(this).data('deposito'));

            }
            modal.find('#title2Asig').text('Detalle de la ubicacion:');
            modal.find('#info2Asig').text($(this).data('area_detalle'));

            // Mostrar el modal
            modal.modal('show');
        });



    });
</script>
