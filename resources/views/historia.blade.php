<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Historia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-4">
                        <div class="row mb-3">
                            <div>
                                <button id="filterButton" class="btn btn-dark " style="max-width: 8%">
                                    <i class="fa-solid fa-filter"></i> Filtrar</button>
                                <button id="deleteFilters" style="margin-left: 10px; display:none"><i
                                        class="fa-solid fa-circle-xmark"></i></button>
                            </div>
                            <div id="filter-div" style="display: none; flex-direction: row; gap: 15px; margin-top: 1%">
                                <!-- Filtro por Técnicos -->
                                <div>
                                    <label for="filtro-tecnicos" style="margin-bottom: 0.5rem;">Técnico:</label>
                                    <select id="filtro-tecnicos" class="form-select" style="width: 200px;">
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
                                            <input class="form-check-input" type="checkbox" id="filter-range">
                                            <label class="form-check-label" for="filter-range">Rango</label>
                                        </div>
                                    </div>

                                    <div id="date-filters" style="margin-top: -12%;">
                                        <input class="form-control" type="date" id="date"
                                            style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                    </div>

                                    <div id="range-filters"
                                        style="display: none; flex-direction:row; margin-top: -5.8%; gap:10px">
                                        <input class="form-control" type="date" id="start-date"
                                            style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                        <input class="form-control" type="date" id="end-date"
                                            style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                    </div>
                                </div>
                            </div>



                        </div>
                        <table id="table_historias_local" class="table table-bordered table-striped">
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

</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
        // Toggle between single date and range filters
        $('#filter-range').on('change', function() {
            if ($(this).is(':checked')) {
                $('#date-filters').hide();
                $('#range-filters').css('display', 'flex');
            } else {
                $('#range-filters').css('display', 'none');
                $('#date-filters').show();
            }
        });

        // Initialize DataTable
        var his_table = $("#table_historias_local").DataTable({
            "order": [
                [3, 'desc']
            ],
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

        // Normalize date to start of day
        function normalizeDate(dateString) {
            return moment(dateString, 'YYYY-MM-DD').startOf('day');
        }

        // Custom filter for single date or range of dates and técnicos
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var filterType = $('#filter-range').is(':checked') ? 'range' : 'single';
                var dateStr = data[3]; // Column index 3
                var date = normalizeDate(dateStr);

                // Filter by técnico
                var tecnicoFilter = $('#filtro-tecnicos').val();
                if (tecnicoFilter && data[0] !== tecnicoFilter) {
                    return false;
                }

                if (filterType === 'single') {
                    var singleDate = normalizeDate($('#date').val());
                    if (!singleDate.isValid()) {
                        return true; // If no date is selected, show all records
                    }
                    return date.isSame(singleDate, 'day');
                } else if (filterType === 'range') {
                    var startDate = normalizeDate($('#start-date').val());
                    var endDate = normalizeDate($('#end-date').val());
                    if (
                        (!startDate.isValid() && !endDate.isValid()) ||
                        (!startDate.isValid() && date.isSameOrBefore(endDate)) ||
                        (startDate.isSameOrBefore(date) && !endDate.isValid()) ||
                        (startDate.isSameOrBefore(date) && date.isSameOrBefore(endDate))
                    ) {
                        return true;
                    }
                    return false;
                }
                return true; // If no filter is selected, show all records
            }
        );

        // Apply filters
        $('#date, #start-date, #end-date, #filter-range, #filtro-tecnicos').on('change', function() {
            his_table.draw();
        });

        // Initialize with default view
        $('#date-filters').show();
        $('#range-filters').hide();

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
            $('#filtro-tecnicos, #filter-range, #date, #start-date, #end-date').val(null).trigger(
                'change');
        });
    });
</script>
