<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Descargar los soportes de los rangos de fecha</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base"> Solo descargará los soportes en el rango de fechas especificado. </p>
            </div>
            {{-- messages --}}
            <div>
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
            </div>
            <div class="grid xs:grid-cols-1 grid-cols-2 w-full flex-wrap mx-auto px-8 gap-12">
                <div class="w-full mx-12 px-2">
                    <label for="ini" class="leading-7 text-sm text-gray-600">Fecha inicial</label>
                    <input type="date" wire:model="fechaini" id="ini" name="ini"
                       class="w-full pr-6 bg-gray-100 bg-opacity-50 text-lg border border-gray-300 rounded-lg
                        outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out
                        focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-blue-500
                    ">
                </div>
                <div class="w-full mx-12 px-2">
                    <label for="Fin" class="leading-7 text-sm text-gray-600">Fecha final</label>
                    <input type="date" wire:model="fechafin" id="Fin" name="Fin"
                       class="w-full pr-6 bg-gray-100 bg-opacity-50 rounded border border-gray-300
                        text-lg outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out
                        focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200
                     ">
                </div>
            </div>
            <div wire:loading>
                Por favor espere...
            </div>
            <div wire:loading.remove class="flex my-6">
                <button type="button" wire:click="DescargarOrdenes"
                    @if($validate)
                        class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                    @else
                        class="flex mx-auto text-white bg-gray-500 border-0 py-2 px-8 text-lg cursor-not-allowed"
                    @endif
                    >
                    Descargar
                </button>
            </div>
            <div class="flex my-4">
                <p class="mx-auto">Numero de Archivos a descargar en el rango seleccionado: {{ $totalArchivos }}</p>
            </div>
        </div>
    </section>
</div>
