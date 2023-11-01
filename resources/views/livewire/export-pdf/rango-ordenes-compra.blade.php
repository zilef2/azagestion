<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">FORMATO RELACION DE ENTREGA</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                Con un rango definido por el usuario, se desacargaran todas las ordenes de compra que cumplan con dicho rango.    
            </p>
            </div>
            @if (Session::has('message'))
                <div class="bg-yellow-100 rounded-lg py-5 px-6 text-base text-yellow-700 mb-3" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @if (Session::has('messageError'))
                <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-red-700 mb-3" role="alert">
                    {{ session('messageError') }}
                </div>
            @endif
            <div class="flex lg:w-2/3 w-full flex-wrap mx-auto px-8">
                <div class="w-1/2 mx-5 px-2">
                    <label for="ini" class="leading-7 text-sm text-gray-600">Fecha inicial</label>
                    <input type="datetime-local" wire:model="fechaini" id="ini" name="ini" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
                <div class="w-1/2 mx-5 px-2">
                    <label for="Fin" class="leading-7 text-sm text-gray-600">Fecha final</label>
                    <input type="datetime-local" wire:model="fechafin" id="Fin" name="Fin" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            </div>
            <div class="flex my-6">
                @if($totalHoras == 0)
                @else
                    <button type="button" wire:click="DescargarOrdenes"
                        @if($validate) 
                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" 
                        @else
                            class="flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 text-lg cursor-not-allowed"
                        @endif
                        >
                        Descargar
                    </button>
                @endif
            </div>
            @if($fechafin)
                <div class="flex my-4">
                    <p class="mx-auto">Horas comprendidas en el rango seleccionado: {{ $totalHoras }}</p>
                </div>
                <div class="flex my-4">
                    <p class="mx-auto">Reportes comprendidos en el rango seleccionado: {{ $totalReportes }}</p>
                </div>
                <div class="flex my-4">
                    <p class="mx-auto"><b>Primer reporte:</b> {{ $primerR }}</p>
                </div>
                <div class="flex my-4">
                    <p class="mx-auto"><b>Ultimo reporte:</b> {{ $ultimoR }}</p>
                </div>
            @endif
        </div>
    </section>
</div>
