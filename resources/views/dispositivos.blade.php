<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Dispositivos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center items-center" style="margin-top: -3%;">
            <div class="p-6 text-gray-900 flex justify-center flex-wrap" style="gap:10px">
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
                    <!-- Ajusta la altura según tus necesidades -->
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

</x-app-layout>
