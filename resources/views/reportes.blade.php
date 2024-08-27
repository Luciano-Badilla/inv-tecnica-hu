<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-3" style="flex: 1;">
                        <label for="addTipo" class="form-label">Sobre que sera el reporte:</label>
                        <select type="text" class="form-control" id="addTipo" name="addTipo"
                            style="border: 1px solid gray; border-radius: 5px;" required>
                            <option value="null">Seleccione:</option>
                            <option value="">Dispositivos</option>
                            <option value="">Stock</option>
                            <option value="">Areas</option>
                            <option value="">Historia</option>
                            <option value="">Depositos</option>
                            <option value="">Categorias</option>
                            <option value="">Estados</option>
                        </select>
                    </div>
                </div>
                <div>
                    
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
