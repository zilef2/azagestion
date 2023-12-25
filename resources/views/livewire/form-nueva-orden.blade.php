<div class="my-style">
    @if ($mensajeError == '')
        <section class="text-gray-600 body-font w-full">
            <div class="container px-4 py-1 mx-auto w-full">
                <div class="flex flex-col text-center w-full mb-8">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font my-4 text-gray-900">
                        Tramitar orden de compra
                    </h1>
                    @if (!$ordenSeleccionadaid)
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Primero seleccione una orden pendiente</p>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Recuerde: la primera orden de compra es la ultima que se modificó</p>
                    @else
                        @if($elUsuario->is_admin)
                            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">El usuario seleccionado es <b>{{ $NameUserSeleccionado }}</b></p>
                        @endif
                    @endif
                    @if (Session::has('message'))
                        <div class="bg-green-100 rounded-lg p-5 text-base text-green-700 my-3" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                {{-- <div class="xl:w-1/3 lg:w-full md:w-5/6 sm:w-full xs:w-full mx-auto"> --}}
                <div class="grid grid-flow-row auto-rows-max">
                    <form wire:submit.prevent="submitformnueva" method="POST">
                        @csrf
                        <div class="flex flex-wrap -m-2">
                            @if($elUsuario->is_admin && !$ordenSeleccionadaid)

                                {{-- busca usuarios --}}
                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2 mt-1">
                                    <label for="userSeleccionadoid" class="block text-sm font-medium text-gray-700 mt-0">
                                        Buscar asesor por nombre
                                    </label>
                                    <div class="mt-1 relative flex h-12 w-full flex-row-reverse overflow-clip rounded-lg">
                                        <input wire:model.defer="UserBuscada"
                                            type="text" id="UserBuscad" placeholder="Digite el nombre"
                                            class="peer w-full rounded-r-lg border border-slate-400 p-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none" />
                                        <label for="UserBuscad" wire:click.debounce.700ms="funcUserBuscada" wire:keydown.enter="funcUserBuscada"
                                            class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2">
                                    <div class="relative">
                                        <label for="userSeleccionadoid" class="block text-sm font-medium text-gray-700">
                                            Asesor que ejecuta la actividad  ({{ count($UsuariosAsesores) }})
                                        </label>
                                        <select wire:model="userSeleccionadoid"  wire:change="updateUs"
                                                aria-label="form-select-lg example"
                                                class="form-select form-select-md mt-2 appe arance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        >
                                            @forelse($UsuariosAsesores as $generico)
                                                <option wire:key="useri-{{ $generico->id }}" value="{{ $generico->id }}"
                                                        class="capitalize"> {{ $generico->name }}
                                                </option>
                                            @empty
                                                <option class="capitalize" value="" selected>No hay usuarios</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            @endif


                            {{-- buscador de ordenes --}}
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2 mt-1">
                                <p class="mx-1">Escriba la OC/OS y luego click en la lupa</p>
                                <p class="mx-auto leading-relaxed text-base">La primera OC será la última que se modificó</p>
                                <div class="mt-6 relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                    <input wire:model.defer="ordenBuscada" {{ $ordenSeleccionadaid ? 'disabled' : '' }} wire:keydown.enter="OrdenBuscadaFunc"
                                           onkeydown="return onlyNumbers(event)"
                                           type="text" id="ordenBusca" placeholder="Digite los numeros de la OC/OS"
                                           class="peer w-full rounded-r-lg border border-slate-400 p-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none" />
                                    <label for="ordenBusca" wire:click.debounce.700ms="OrdenBuscadaFunc"  wire:loading.attr="disabled" wire:target="OrdenBuscadaFunc"
                                           class="disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                        <svg wire:loading.remove wire:target="OrdenBuscadaFunc" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 deni"> <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /> </svg>
                                    </label>
                                </div>
                            </div>
                            {{-- Selec OC/OS--}}
                            <div class="p-2 mt-6 w-full xs:w-full sm:w-full">
                                <div class="relative">
                                    <label for="ordenSeleccionadaid" class="block text-sm font-medium text-gray-700 capitalize">
                                        OC/OS ({{ count($codigosPendientes) }} resultados)
                                    </label>
                                    <select wire:model="ordenSeleccionadaid" aria-label="form-select-lg example"
                                        class="form-select form-select-md mt-2 appe arance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        >
                                        @forelse($codigosPendientes as $generico)
                                            @if ($loop->first)
                                                <option class="capitalize" value="" selected>
                                                    Seleccione OC/OS
                                                </option>
                                            @endif
                                            <option wire:key="codigo-{{ $generico->id }}" value="{{ $generico->id }}"
                                                class="capitalize">
                                                {{ $generico->codigo }} | horasaprobadas: {{ $generico->{'horasaprobadas'} }}
                                            </option>
                                        @empty
                                            <option class="capitalize" value="" selected>No hay registros</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>



                            {{-- la parte de abajo se trae cuando se selecciona una orden --}}

                            @if ($ordenSeleccionadaid)
                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2 mt-4">
                                    <div class="relative">
                                        <label for="empresaid"
                                            class="block text-sm font-medium text-gray-700 capitalize">Empresa</label>
                                        <select disabled aria-label=".form-select-lg example"
                                            wire:model.lazy="empresasid"
                                            class="form-select form-select-md mt-4 appearance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                            @forelse($empresas as $generico)
                                                @if ($loop->first)
                                                    <option class="capitalize" value="" selected>Seleccione
                                                        empresa </option>
                                                @endif
                                                <option class="capitalize" value="{{ $generico->id }}">
                                                    {{ $generico->nombre }}
                                                </option>
                                            @empty
                                                <option class="capitalize" value="" selected>No hay registros
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 w-full xs:w-1/2 xs:w-full sm:w-full md:w-1/2">
                                    <div class="relative">
                                        <label for="clasificacionid"
                                            class="mt-6 block text-sm font-medium text-gray-700 capitalize">clasificación</label>
                                        <select disabled
                                            class="form-select form-select-md mt-2
                                                appearance-none block w-full px-4 py-2
                                                text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            aria-label=".form-select-lg example" wire:model.lazy="clasificacionid">
                                            @forelse($clasificacions as $generico)
                                                <option class="capitalize" value="{{ $generico->id }}">
                                                    {{ $generico->nombre }} </option>
                                            @empty
                                                <option class="capitalize" value="" selected>No hay registros
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2 w-full xs:w-full">
                                    <div class="relative">
                                        <label for="tareaid"
                                            class="block text-sm font-medium text-gray-700 capitalize">tarea</label>
                                        <select disabled
                                            class="form-select form-select-md mt-2 appearance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg example"
                                            wire:model.lazy="tareaid">
                                            @forelse($tareas as $generico)
                                                <option class="capitalize" value="{{ $generico->id }}">
                                                    {{ $generico->nombre }} </option>
                                            @empty
                                                <option class="capitalize" value="" selected>No hay registros
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>


                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2">
                                    <div class="relative">
                                        <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                            <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                                <input disabled
                                                type="date" wire:model="fechaOrden" name="fechaOrden"
                                                id="fechaOrden" placeholder=""
                                                class="cursor-not-allowed peer w-full rounded-r-lg border border-gray-400 px-2 text-slate-900 bg-gray-100"
                                                    />
                                                <label for="fechaOrden"
                                                    class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                    Fecha aprobación
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2">
                                    <div class="relative">
                                        <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                            <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                                {{-- todo: cambiar a
                                                    datetime-local
                                                    pero los usuarios podran colocar cualquier fecha para que les paguen
                                                    --}}
                                                <input
                                                type="date" wire:model="fecha_ejecucion" name="fecha_ejecucion"
                                                id="fecha_ejecucion" placeholder="fecha ejecucion"
                                                class="peer w-full rounded-r-lg border border-gray-400 px-2 text-slate-900 "
                                                    />
                                                <label for="fecha_ejecucion"
                                                    class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                    Fecha ejecución
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2">
                                    <div class="relative">
                                        <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                            <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                                <select aria-label=".form-select-lg example" wire:model.lazy="municipio"
                                                class="peer w-full rounded-r-lg border border-gray-400 px-2 text-slate-900 ">
                                                @forelse($municipios as $generico)
                                                    @if ($loop->first)
                                                        <option class="capitalize" value="" selected>Seleccione
                                                            municipio
                                                        </option>
                                                    @endif
                                                    <option class="capitalize" value="{{ $generico->id }}">
                                                        {{ $generico->nombre }} </option>
                                                @empty
                                                    <option class="capitalize" value="" selected>No hay registros
                                                    </option>
                                                @endforelse
                                            </select>
                                                <label for="fecha_ejecucion"
                                                    class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                    Municipio
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 w-full xs:w-full sm:w-full md:w-1/2">
                                    <div class="relative">
                                        <div class="mx-auto w-screen-sm px-4 py-2">
                                            <label for="horas" class="flex text-sm font-medium text-gray-700">
                                                Horas Acumuladas: <b>{{ $horasAcumuladas }}</b> | Horas restantes:
                                                <b>{{ $MaxHoras }}</b>
                                            </label>
                                            <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                                <input type="number" min="0" max="900" wire:model.defer="horas" step="0.1"
                                                    name="horas" id="horas" placeholder=""
                                                    class="peer w-full rounded-r-lg border border-slate-400 px-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none" />
                                                <label for="horas"
                                                    class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                    Horas
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center mt-6 xs:w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2">
                                    <p class="p-2 mx-4">¿Requiere transporte?</p>
                                    <label class="switch cursor-pointer">
                                        <input wire:model.defer="siOno" type="checkbox">
                                        <span class="slider rounded-full bg-white shadow-md w-40 h-12 flex items-center justify-center">
                                            <span class="yes">No</span>
                                            <span class="no">Sí</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="flex items-center mt-6 xs:w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2">
                                    <p class="p-2 mx-4">Banco de horas</p>
                                    <label class="switch cursor-pointer">
                                        <input wire:model.defer="bancohoras" type="checkbox">
                                        <span class="slider rounded-full bg-white shadow-md w-40 h-12 flex items-center justify-center">
                                            <span class="yes">No</span>
                                            <span class="no">Sí</span>
                                        </span>
                                    </label>
                                </div>

                                @if ($errors->any())
                                    <div class="py-8 w-full">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="p-2 text-red-500 first:text-xl">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session()->has('messageError'))
                                    {{-- solo imprime para el archivo adjunto --}}
                                    <div class="py-8 w-full">
                                        <div class="p-2 text-red-500 first:text-xl" role="alert">
                                            ¡{{ session('messageError') }}!
                                        </div>
                                    </div>
                                @endif

                                @if ($esCapacitacion)
                                    <div class="mx-2 my-4 w-full">
                                        <div class="max-w-2xl mx-auto">
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-500"
                                                for="">
                                                Adjunto
                                            </label>
                                            <input wire:model="adjunto" accept="application/pdf" id="file_input"
                                                type="file"
                                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                            <p class="mt-5">
                                                <!-- <a class="text-blue-600 hover:underline" href="#" target="_blank">Flowbite Documentation</a>. -->
                                            </p>
                                        </div>
                                        @error('adjunto')
                                            <span class="p-2 bg-red-300 text-black">{{ $message }}</span>
                                        @enderror

                                        <div wire:loading wire:target="adjunto">Subiendo...</div>
                                    </div>
                                @endif
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="message"
                                            class="leading-7 text-sm text-gray-600">Observaciones</label>
                                        <textarea wire:model.lazy.defer="observaciones" id="message" name="message"
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>
                                <div class="p-2 w-1/2">
                                    <button type="submit" wire:loading.class="opacity-50 bg-black disabled cursor-not-allowed" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Guardar</button>
                                </div>
                                <div class="p-2 w-1/2">
                                    <button wire:click="justBack" type="button"
                                        class="flex mx-auto text-white bg-black border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">Atrás</button>
                                </div>
                                {{-- endif -- ordenSeleccionadaid --}}
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @else
        <section class="text-gray-600 body-font relative my-12">
            <div class="container px-5 py-2 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                        {{ $mensajeError }}
                    </h1>
                </div>
            </div>
        </section>
    @endif

    <script>
        function onlyNumbers(event) {
            var key = event.key;
            var allowedKeys = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','-'];
            var specialKeys = ['Backspace', 'Delete','Control','v','V'];

            if (!allowedKeys.includes(key) && !specialKeys.includes(key)) {
                event.preventDefault();
                return false;
            }
        }
    </script>
</div>
