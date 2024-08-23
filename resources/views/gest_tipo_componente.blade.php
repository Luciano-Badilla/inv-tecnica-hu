<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Categorias') }}
            <button type="button" class="small-box-footer show" id="show" data-bs-toggle="modal"
                data-bs-target="#infoModal" style="margin-left: 0.5%">
                <i class="fa-solid fa-circle-info"></i>
            </button>
        </h2>

        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Categorias</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Aqui debes agregar las categorias de componentes (RAM, Motherboard, Procesador, Perifericos,
                        etc)
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar nueva categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('store_tipo') }}" method="POST" id="addModal">
                            @csrf
                            <!-- Mostrar errores de validación generales -->

                            <div class="mb-3">
                                <label for="addNombre" class="form-label">Categoria:</label>
                                <input type="text" class="form-control @error('addNombre') is-invalid @enderror"
                                    id="addNombre" name="addNombre" style="border: 1px solid gray; border-radius:5px"
                                    required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Agregar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('edit_tipo') }}" method="POST" id="addModal">
                            @method('PATCH')
                            @csrf
                            <!-- Mostrar errores de validación generales -->

                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Categoria:</label>
                                <input type="hidden" id="editId" name="editId">
                                <input type="text" class="form-control @error('editNombre') is-invalid @enderror"
                                    id="editNombre" name="editNombre" style="border: 1px solid gray; border-radius:5px"
                                    required>
                            </div>
                            <div class="mb-3" style="flex: 1;">
                                <label for="editMotivo" class="form-label">Motivo:</label>
                                <input type="text" class="form-control @error('editMotivo') is-invalid @enderror"
                                    id="editMotivo" name="editMotivo"
                                    style="border: 1px solid gray; border-radius: 5px;" required>
                            </div>
                            
                            <p
                                style="color: #d94f4f; background-color: #f9e2e2; border: 1px solid #d43f3a; padding: 10px; border-radius: 5px;">
                                Al cambiar el nombre de la categoria, no podras encontrar los componentes vinculados a ella, en el armado de una PC o Impresora.
                            </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('delete_tipo') }}" method="POST" id="addModal">
                            @csrf
                            <!-- Mostrar errores de validación generales -->

                            <div class="mb-3">
                                <input type="hidden" id="deleteId" name="deleteId">
                                <label for="removeMotivo" class="form-label">Motivo:</label>
                                <input type="text" class="form-control @error('removeMotivo') is-invalid @enderror"
                                    id="removeMotivo" name="removeMotivo"
                                    style="border: 1px solid gray; border-radius:5px" required>
                            </div>
                            <p
                                style="color: #d9534f; background-color: #f9e2e2; border: 1px solid #d43f3a; padding: 10px; border-radius: 5px;">
                                Todos los componentes asociados a esta categoria se desvincularan de la misma.
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
                    <div class="small-box bg-dark" style="margin: 5px;">
                        <div class="inner">
                            <h3 class="text-lg">‎ ‎Agregar‎ ‎ </h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"><i class="fas fa-plus-circle"></i></a>
                    </div>
                    <div class="small-box bg-dark" style="margin: 5px;">
                        <div class="inner">
                            <h3 class="text-lg">Modificar</h3>

                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"> <i class="fas fa-edit"></i></i></a>
                    </div>
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
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $tipo)
                                    <tr>
                                        <td><b>{{ $tipo->nombre }}</b></td>

                                        <td>
                                            <div style="display: flex; justify-content: right;">
                                                <button class="btn btn-dark mr-2" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" data-id="{{ $tipo->id }}"
                                                    data-nombre="{{ $tipo->nombre }}">
                                                    <i class="fas fa-pencil"></i>
                                                </button>


                                                @if (Auth::user()->rol->nombre == 'Super administrador')
                                                    <input type="hidden" value="{{ $tipo->id }}"
                                                        name="deleteId">
                                                    <button class="btn btn-dark mr-2" data-id="{{ $tipo->id }}"
                                                        data-nombre="{{ $tipo->nombre }}" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif

                                            </div>
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
