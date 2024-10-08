<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Componentes') }}
            <button type="button" class="small-box-footer show" id="show" data-bs-toggle="modal"
                data-bs-target="#infoModal" style="margin-left: 0.5%">
                <i class="fa-solid fa-circle-info"></i>
            </button>
        </h2>

        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Componentes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Aqui debes agregar los componentes para llevar un control del stock.
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="infoAddStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        El stock ingresado se sumara al stock existente.
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="infoRemoveStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        El stock ingresado se restara al stock existente.
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="infoTransferModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Transferir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        El componente se transferira al deposito seleccionado, modificando los stocks
                    </div>
                </div>
            </div>
        </div>

        <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <p id="toast_selection_text">Test</p>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo componente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center;">
                        <form action="{{ route('store_componentes') }}" method="POST" id="addModal"
                            style="display: flex; flex-direction: column; gap: 20px;">
                            @csrf
                            <!-- Mostrar errores de validación generales -->
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="addNombre" class="form-label">Nombre:</label>
                                    <input type="text"
                                        class="form-control @error('addNombre') is-invalid @enderror" id="addNombre"
                                        name="addNombre" style="border: 1px solid gray; border-radius: 5px;" required>
                                </div>
                                <!--
                                <div class="mb-3" style="flex: 1;">
                                    <label for="addStock" class="form-label">Stock:</label>
                                    <input type="text" class="form-control @error('addStock') is-invalid @enderror"
                                        id="addStock" name="addStock"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                </div>-->

                            </div>
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="addTipo" class="form-label">Categoria:</label>
                                    <select class="form-control @error('addTipo') is-invalid @enderror" id="addTipo"
                                        name="addTipo" style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Seleccionar una categoria</option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            <!-- Agrega más opciones según sea necesario -->
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label for="addDeposito" class="form-label">Deposito:</label>
                                    <select class="form-control @error('addDeposito') is-invalid @enderror"
                                        id="addDeposito" name="addDeposito"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Seleccionar un deposito</option>
                                        @foreach ($depositos as $deposito)
                                            <option value="{{ $deposito->id }}">
                                                {{ $deposito->nombre }}</option>
                                            <!-- Agrega más opciones según sea necesario -->
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center;">
                        <form action="{{ route('add_stock_componentes') }}" method="POST" id="addStockForm"
                            style="display: flex; flex-direction: column; gap: 20px;">
                            @csrf
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="editNombreStock" class="form-label">Componente:</label>
                                    <select class="form-control @error('editNombreStock') is-invalid @enderror"
                                        id="editNombreStock" name="editNombreStock"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Selecciona un componente</option>
                                        @foreach ($componentes as $componente)
                                            <option value="{{ $componente->id }}"
                                                data-addStock="{{ $componente->stock }}">
                                                {{ $componente->nombre . ' - ' . $componente->estado->nombre . ' - ' . ($componente->deposito->nombre ?? 'no asignado') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label for="editAddStock" class="form-label">Stock:</label>
                                    <input type="number"
                                        class="form-control @error('editAddStock') is-invalid @enderror"
                                        id="editAddStock" name="editAddStock"
                                        style="border: 1px solid gray; border-radius: 5px;" min="0" required>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="editAddStockMotivo" class="form-label">Motivo:</label>
                                    <input type="text"
                                        class="form-control @error('editAddStockMotivo') is-invalid @enderror"
                                        id="editAddStockMotivo" name="editAddStockMotivo"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="removeStockModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 5px;">
                    <div class="modal-header" style="border-bottom: 1px solid #dee2e6;">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center; padding: 20px;">
                        <form action="{{ route('remove_stock_componentes') }}" method="POST" id="removeStockForm"
                            style="display: flex; flex-direction: column; gap: 20px; width: 100%;">
                            @csrf
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="removeNombreStock" class="form-label"
                                        style="display: block; margin-bottom: 0.5rem;">Componente:</label>
                                    <select class="form-control @error('removeNombreStock') is-invalid @enderror"
                                        id="removeNombreStock" name="removeNombreStock"
                                        style="border: 1px solid gray; border-radius: 5px; width: 100%;" required>
                                        <option value="">Selecciona un componente</option>
                                        @foreach ($componentes as $componente)
                                            <option value="{{ $componente->id }}"
                                                data-removeStock="{{ $componente->stock }}">
                                                {{ $componente->nombre . ' - ' . $componente->estado->nombre . ' - ' . ($componente->deposito->nombre ?? 'no asignado') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label for="removeStock" class="form-label"
                                        style="display: block; margin-bottom: 0.5rem;">Stock:</label>
                                    <input type="number"
                                        class="form-control @error('removeStock') is-invalid @enderror"
                                        id="removeStock" name="removeStock"
                                        style="border: 1px solid gray; border-radius: 5px; width: 100%;"
                                        min="0" required readonly>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="mb-3">
                                    <label for="removeStockMotivo" class="form-label"
                                        style="display: block; margin-bottom: 0.5rem;">Motivo:</label>
                                    <input type="text"
                                        class="form-control @error('removeStockMotivo') is-invalid @enderror"
                                        id="removeStockMotivo" name="removeStockMotivo"
                                        style="border: 1px solid gray; border-radius: 5px; width: 100%;" required>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid #dee2e6;">
                                <button type="submit" class="btn btn-dark"
                                    style="border-radius: 5px;">Eliminar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>






        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar componente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center;">
                        <form action="{{ route('edit_componentes') }}" method="POST" id="editModal"
                            style="display: flex; flex-direction: column; gap: 20px;">
                            @method('PATCH')
                            @csrf
                            <!-- Mostrar errores de validación generales -->
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <input type="hidden" name="editId" id="editId">
                                    <label for="editNombre" class="form-label">Nombre:</label>
                                    <input type="text"
                                        class="form-control @error('editNombre') is-invalid @enderror"
                                        id="editNombre" name="editNombre"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label for="editTipo" class="form-label">Categoria:</label>
                                    <select class="form-control @error('editTipo') is-invalid @enderror"
                                        id="editTipo" name="editTipo"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option>Seleccione una categoria</option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            <!-- Agrega más opciones según sea necesario -->
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div style="display: flex; flex-direction: row; gap: 20px;">

                            </div>
                            <div class="mb-3" style="flex: 1;">
                                <label for="editMotivo" class="form-label">Motivo:</label>
                                <input type="text" class="form-control @error('editMotivo') is-invalid @enderror"
                                    id="editMotivo" name="editMotivo"
                                    style="border: 1px solid gray; border-radius: 5px;" required>
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Editar</button>
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
                        <form action="{{ route('delete_componentes') }}" method="POST" id="addModal">
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

                            <p
                                style="color: #d9534f; background-color: #f9e2e2; border: 1px solid #d43f3a; padding: 10px; border-radius: 5px;">
                                Este componente se desvinculara de todos los dispositivos al que esta asociado.
                            </p>
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

        <div class="modal fade" id="TransferModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Transferir componentes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center;">
                        <form action="{{ route('transfer_componentes') }}" method="POST" id="transferForm"
                            style="display: flex; flex-direction: column; gap: 20px;">
                            @csrf
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferNombre" class="form-label">Componente:</label>
                                    <select class="form-control @error('transferNombre') is-invalid @enderror"
                                        id="transferNombre" name="transferNombre"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Selecciona un componente</option>
                                        @foreach ($componentes as $componente)
                                            <option value="{{ $componente->id }}"
                                                data-stock="{{ $componente->stock }}">
                                                {{ $componente->nombre . ' - ' . $componente->estado->nombre . ' - ' . ($componente->deposito->nombre ?? 'no asignado') }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferDeposito" class="form-label">Deposito:</label>
                                    <select class="form-control @error('transferDeposito') is-invalid @enderror"
                                        id="transferDeposito" name="transferDeposito"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Selecciona un deposito</option>
                                        @foreach ($depositos as $deposito)
                                            <option value="{{ $deposito->id }}">
                                                {{ $deposito->nombre }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferStock" class="form-label">Stock a transferir:</label>
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control @error('transferStock') is-invalid @enderror"
                                            id="transferStock" name="transferStock"
                                            style="border: 1px solid gray; border-top-left-radius: 5px; border-bottom-left-radius: 5px;"
                                            min="0" required readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary all-button" type="button"
                                                style="border: 1px solid gray;" disabled>Todo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferMotivo" class="form-label">Motivo:</label>
                                    <input type="text"
                                        class="form-control @error('transferMotivo') is-invalid @enderror"
                                        id="transferMotivo" name="transferMotivo"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Transferir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="TransferStateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cambiar estado componentes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: flex; justify-content: center;">
                        <form action="{{ route('state_componentes') }}" method="POST" id="transferStateForm"
                            style="display: flex; flex-direction: column; gap: 20px;">
                            @csrf
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferStateNombre" class="form-label">Componente:</label>
                                    <select class="form-control @error('transferStateNombre') is-invalid @enderror"
                                        id="transferStateNombre" name="transferStateNombre"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Selecciona un componente</option>
                                        @foreach ($componentes as $componente)
                                            <option value="{{ $componente->id }}"
                                                data-statestock="{{ $componente->stock }}">
                                                {{ ($componente->nombre ?? 'No asignado') . ' - ' . ($componente->estado->nombre ?? 'No asignado') . ' - ' . ($componente->deposito->nombre ?? 'No asignado') }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferStateEstado" class="form-label">Estado:</label>
                                    <select class="form-control @error('transferStateEstado') is-invalid @enderror"
                                        id="transferStateEstado" name="transferStateEstado"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                        <option value="">Selecciona un deposito</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->id }}">
                                                {{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div style="display: flex; flex-direction: row; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferStateStock" class="form-label">Stock a cambiar estado:</label>
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control @error('transferStateStock') is-invalid @enderror"
                                            id="transferStateStock" name="transferStateStock"
                                            style="border: 1px solid gray; border-top-left-radius: 5px; border-bottom-left-radius: 5px;"
                                            min="0" required readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary all-state-button" type="button"
                                                style="border: 1px solid gray;" disabled>Todo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label for="transferStateMotivo" class="form-label">Motivo:</label>
                                    <input type="text"
                                        class="form-control @error('transferStateMotivo') is-invalid @enderror"
                                        id="transferStateMotivo" name="transferStateMotivo"
                                        style="border: 1px solid gray; border-radius: 5px;" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Transferir</button>
                        </form>
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
                <div class="alert-primary" id="selected_info" style="display: none; justify-content:center">
                    <p style="padding: 0.3%; text-align: center" id="selected_comp"></p>
                    <button style="margin-left: 0.5%" id="unselect_comp"><i
                            class="fa-solid fa-circle-xmark"></i></button>

                </div>

                <div class="d-flex justify-content-left p-3 bg-light rounded shadow-sm">

                    <div class="container mt-4">
                        <div class="row mb-3" style="display: flex; flex-direction: column">
                            <div>
                                <button id="filterButton" class="btn btn-dark " style="max-width: 8%;">
                                    <i class="fa-solid fa-filter"></i> Filtrar</button>
                                <button id="deleteFilters" style="margin-left: 10px; display:none"><i
                                        class="fa-solid fa-circle-xmark"></i></button>
                            </div>
                            <div id="filter-div" style="display: none; margin-top: 1%; gap:15px">
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
                        </div>

                        <table id="table_componentes" class="table table-bordered table-striped" style="min-width: 100%">
                            <thead style="display: none">
                                <tr>
                                    <th>Categoria</th>
                                    <th>Nombre</th>
                                    <th>Deposito</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($componentes as $componente)
                                    <tr>
                                        <td><b>{{ $componente->tipo->nombre ?? 'Categoria no asignada' }}</b></td>
                                        <td><b>{{ $componente->nombre }}</b></td>

                                        <td><b>Deposito: {{ $componente->deposito->nombre ?? 'No asignado' }}</b></td>
                                        <td><b>Stock: {{ $componente->stock }}</b></td>
                                        <td><b>Estado: {{ $componente->estado->nombre ?? 'No asignado' }}</b></td>


                                        <td>
                                            @if (Auth::user()->rol->nombre == 'Administrador' || Auth::user()->rol->nombre == 'Super administrador' || Auth::user()->rol->nombre == 'Tecnico')
                                            <div style="display: flex; justify-content: right;">
                                                <button class="btn btn-dark mr-2 select-button"
                                                    data-id="{{ $componente->id }}"
                                                    data-nombre="{{ $componente->nombre }}">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                                <button class="btn btn-dark mr-2" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" data-id="{{ $componente->id }}"
                                                    data-nombre="{{ $componente->nombre }}"
                                                    data-tipo="{{ $componente->tipo_id }}">
                                                    <i class="fas fa-pencil"></i>
                                                </button>
                                                @if (Auth::user()->rol->nombre == 'Super administrador')
                                                    <input type="hidden" value="{{ $componente->id }}"
                                                        name="deleteId">
                                                    <button class="btn btn-dark mr-2" data-id="{{ $componente->id }}"
                                                        data-nombre="{{ $componente->nombre }}"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif

                                            </div>
                                            @endif
                                        </td>
                    </div>
                    </tr>
                    @endforeach
                    </tbody>

                    </table>

                    <h2 class="font-semibold text-lg text-gray-800 leading-tight" style="margin-bottom: 1.5%">
                        {{ __('Historial de cambios:') }}
                    </h2>

                    <div class="container mt-4">
                        <table id="table_historias" class="table table-bordered table-striped">
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
                                        <td><b>{{ $historia->tecnico }}</b>
                                        <td><b>{{ $historia->detalle }}</b>
                                        <td><b>{{ $historia->motivo }}</b>
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

    </div>

    </div>
    </div>


</x-app-layout>
<script>
    $(document).ready(function() {

        componente_seleccionado = null;

        $('#table_componentes tbody').on('click', '.select-button', function() {
            componente_seleccionado = $(this).data('id');
            var selected_nombre = $(this).data('nombre');
            $('#selected_comp').text("Componente seleccionado: " + selected_nombre);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            $('#selected_info').css('display', 'flex');
        });


        $('#unselect_comp').on('click', function() {
            componente_seleccionado = null;
            $('#selected_info').css('display', 'none');
        })

        $('#addStockModal').on('show.bs.modal', function(event) {
            var modal = $(this);
            modal.find('#editNombreStock').trigger('change');
            modal.find('#editNombreStock').val(componente_seleccionado);
            modal.find('#editNombreStock').attr('readonly', true);
        });

        $('#removeStockModal').on('show.bs.modal', function(event) {
            var modal = $(this);
            modal.find('#removeNombreStock').val(componente_seleccionado);
            modal.find('#removeNombreStock').trigger('change');
            modal.find('#removeNombreStock').attr('readonly', true);
        });

        $('#TransferModal').on('show.bs.modal', function(event) {
            var modal = $(this);
            modal.find('#transferNombre').trigger('change');
            modal.find('#transferNombre').val(componente_seleccionado);
            modal.find('#transferNombre').attr('readonly', true);
        });

        $('#TransferStateModal').on('show.bs.modal', function(event) {
            var modal = $(this);
            modal.find('#transferStateNombre').trigger('change');
            modal.find('#transferStateNombre').val(componente_seleccionado);
            modal.find('#transferStateNombre').attr('readonly', true);
        });

        $('#filterButton').on('click', function() {
            var $filterDiv = $('#filter-div');
            var $deleteFilters = $('#deleteFilters');

            if ($filterDiv.css('display') === 'none') {
                $filterDiv.css('display', 'flex');
                $deleteFilters.css('display', 'inline');
            } else {
                $filterDiv.css('display', 'none');
                $deleteFilters.css('display', 'none');
            }
        });

        $('#deleteFilters').on('click', function() {
            $('#filtro-deposito, #filtro-estado, #filtro-categoria, #filtro-stock').val(null).trigger('change');
        });







    });

    $('#removeNombreStock').on('change', function() {
        const transferStockInput = document.getElementById('removeStock');
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-removeStock');
        const transferNombre = document.getElementById('transferNombre');
        const transferStock = document.getElementById('transferStock');

        if (this.value) {
            transferStockInput.removeAttribute('readonly');
            transferStockInput.max = stock; // Opcionalmente, puedes establecer un valor máximo
        } else {
            transferStockInput.setAttribute('readonly', true);
        }

        transferNombre.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            transferStock.value = selectedOption.getAttribute('data-stock');
        });
    });


    $('#transferNombre').on('change', function() {
        const transferStockInput = document.getElementById('transferStock');
        const addButton = document.querySelector('.all-button');
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-statestock');

        if (this.value) {
            transferStockInput.removeAttribute('readonly');
            addButton.removeAttribute('disabled');
            transferStockInput.max = stock; // Opcionalmente, puedes establecer un valor máximo
        } else {
            transferStockInput.setAttribute('readonly', true);
            addButton.setAttribute('disabled', true);
        }
    });

    document.querySelector('.all-button').addEventListener('click', function() {
        if (!this.hasAttribute('disabled')) {
            const transferStockInput = document.getElementById('transferStock');
            const selectedOption = document.getElementById('transferNombre').options[document.getElementById(
                'transferNombre').selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            transferStockInput.value = stock; // Establecer el valor al stock máximo
        }
    });

    $('#transferStateNombre').on('change', function() {
        const transferStockInput = document.getElementById('transferStateStock');
        const addButton = document.querySelector('.all-state-button');
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-statestock');

        if (this.value) {
            transferStockInput.removeAttribute('readonly');
            addButton.removeAttribute('disabled');
            transferStockInput.max = stock; // Opcionalmente, puedes establecer un valor máximo
        } else {
            transferStockInput.setAttribute('readonly', true);
            addButton.setAttribute('disabled', true);
        }
    });

    document.querySelector('.all-state-button').addEventListener('click', function() {
        if (!this.hasAttribute('disabled')) {
            const transferStockInput = document.getElementById('transferStateStock');
            const selectedOption = document.getElementById('transferStateNombre').options[document
                .getElementById(
                    'transferStateNombre').selectedIndex];
            const stock = selectedOption.getAttribute('data-statestock');
            transferStockInput.value = stock; // Establecer el valor al stock máximo
        }


    });
</script>
