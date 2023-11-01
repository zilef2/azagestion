<div class="mt-12">
    {{-- @push('styles') @import (css) "swi.css"; @endpush --}}

    @if ($mensajeError == '')
        <section class="text-gray-600 body-font relative pb-40">
            <div class="container px-5 py-1 mx-auto w-full">
                <div class="flex flex-col text-center w-full mb-2">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Correjir orden de compra
                    </h1>
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-sm">
                        Solo es posible modificar el siguiente campo: Justificación o Novedad
                    </p>
                </div>
                <div class="w-5/6 mx-auto">
                    <div>
                        {{-- error zone --}}
                        <div>
                            @if (Session::has('message'))
                                <div class="text-center bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3"
                                    role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session()->has('messageError'))
                                <div class="text-center bg-red-100 rounded-lg py-5 px-6 text-base text-black mb-3" role="alert">
                                    {{ session('messageError') }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/3">
                                <div class="relative">
                                    <label for="codigoid" class="block text-sm font-medium text-gray-700 capitalize">OC/OS</label>
                                    <select disabled wire:model.lazy="codigoid"
                                        class="form-select form-select-md mt-2 appe arance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        aria-label="form-select-lg example">
                                        @forelse($codigosPendientes as $generico)
                                            <option wire:key="codigo-{{ $generico->id }}" value="{{ $generico->id }}" class="capitalize"> 
                                                {{ $generico->codigo }}
                                            </option>
                                        @empty
                                            <option class="capitalize" value="" selected>No hay registros</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/3">
                                <div class="relative">
                                    <label for="empresaid" class="block text-sm font-medium text-gray-700 capitalize">Empresa</label>
                                    <select disabled
                                        class="form-select form-select-md mt-2 appearance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                aria-label=".form-select-lg example" wire:model.lazy="empresasid">
                                        @forelse($empresas as $generico)
                                            @if ($loop->first)
                                                <option class="capitalize" value="" selected>Seleccione empresa
                                                </option>
                                            @endif
                                            <option class="capitalize" value="{{ $generico->id }}">
                                                {{ $generico->nombre }} </option>
                                        @empty
                                            <option class="capitalize" value="" selected>No hay registros</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/3">
                                <div class="relative">
                                    <label for="clasificacionid" class="block text-sm font-medium text-gray-700 capitalize">clasificacion</label>
                                    <select disabled
                                        class="form-select form-select-md mt-2 appearance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        aria-label=".form-select-lg example" wire:model.lazy="clasificacionid">
                                        @forelse($clasificacions as $generico)
                                            @if ($loop->first)
                                                <option class="capitalize" value="" selected>Seleccione
                                                    clasificacion</option>
                                            @endif
                                            <option class="capitalize" value="{{ $generico->id }}">
                                                {{ $generico->nombre }} </option>
                                        @empty
                                            <option class="capitalize" value="" selected>No hay registros</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="p-2 w-full xs:w-full">
                                <div class="relative">
                                    <label for="tareaid"
                                        class="block text-sm font-medium text-gray-700 capitalize">tarea</label>
                                    <select disabled
                                        class="form-select form-select-md mt-2
                                    appearance-none block w-full px-4 py-2
                                    text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        aria-label=".form-select-lg example" wire:model.lazy="tareaid">
                                        @forelse($tareas as $generico)
                                            @if ($loop->first)
                                                <option class="capitalize" value="" selected>Seleccione tarea
                                                </option>
                                            @endif
                                            <option class="capitalize" value="{{ $generico->id }}">
                                                {{ $generico->nombre }} </option>
                                        @empty
                                            <option class="capitalize" value="" selected>No hay registros</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <select disabled aria-label=".form-select-lg example" wire:model.lazy="municipio"
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
                            
                            <div wire.loading.remove class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <input disabled
                                                class="peer w-full rounded-r-lg border bg-gray-100 border-slate-400 px-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none"
                                                type="date" wire:model="fechaOrden" name="fechaOrden"
                                                id="fechaOrden" placeholder="" />
                                            <label for="fechaOrden"
                                                class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                Fecha
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire.loading.remove class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <input disabled
                                                class="bg-gray-100 peer w-full rounded-r-lg border border-slate-400 px-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none"
                                                type="date" wire:model="fecha_ejecucion" name="fecha_ejecucion"
                                                id="fecha_ejecucion" placeholder="" />
                                            <label for="fecha_ejecucion"
                                                class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                Ejecución
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire.loading.remove class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <div
                                            class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <input disabled
                                                class="bg-gray-100 peer w-full rounded-r-lg border border-slate-400 px-2 text-slate-900 placeholder-slate-400
                                                 focus:outline-none focus:shadow-outline focus:border-indigo-500 transition-all duration-150 ease-in-out focus:scale-105"
                                                type="number" min="0" max="900" wire:model="horas"
                                                name="horas" id="horas" placeholder="" />
                                            <label for="horas"
                                                class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300
                                                peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                Horas
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="p-2 inline-block w-1/4">
                                <p class="p-2 mx-4">
                                    ¿Requiere transporte?
                                    @if ($siOno)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                     - Banco de horas
                                    @if ($bancohoras)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                </p>
                            </div>

                            @if ($esCapacitacion)
                                <div class="m-2 w-full my-4">
                                    <div class="mt-5">
                                        @if ($isImage)
                                            <img src="{{ asset($elPDF) }}" width='200px;'>
                                        @else
                                            <iframe src="{{ $original_filename }}"
                                                class="h-96 w-full object-cover object-center"></iframe>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if ($HayObservaciones)
                                <div class="p-2 w-full">
                                    <div class="relative grow-wrap">
                                        <label for="message" class="leading-7 text-sm text-gray-600">Observaciones
                                            (Escritas por el asesor)</label>
                                        <p id="message" name="message"
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                            {{ $observaciones }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                            <hr class="border-t-2 my-2 mx-auto w-full border-cyan-400">
                            {{-- nuevo --}}
                            <div class="w-full my-4 p-4 bg-gray-200 rounded shadow-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-lg font-bold text-gray-900">Horas de los reportes</h2>
                                </div>
                                
                                <div class="overflow-hidden max-h-0 transition-all duration-500">
                                    @if ($mensajeError2 === '')
                                        <p for="horas" class="flex text-sm font-medium text-gray-100 my-2">
                                            Acumuladas: <b>{{ $horasAcumuladas }}</b> 
                                        </p>
                                        <p for="horas" class="flex text-sm font-medium text-gray-100">
                                            Restantes:  <b>{{ $MaxHoras }}</b>
                                        </p>
                                    @else
                                        <label for="horas" class="flex text-sm font-medium text-red-800">
                                            {{ $mensajeError2 }}</b> 
                                        </label>
                                    @endif
                                </div>
                            </div>

                    @if($pendiente == 0)
                        <div wire:loading.remove class="mt-6 px-4 py-2 w-full">
                            <div class="flex mx-auto w-full text-center">
                                <div class="m-1">
                                    <button wire:click="isAPendiente"
                                        type="button" class="flex mx-auto text-white bg-black border-0 my-5 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">
                                        Pendiente
                                    </button>
                                </div>
                                <div class="m-1">
                                    <button wire:click="isARechazo"
                                        type="button" class="flex mx-auto text-white bg-black border-0 my-5 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">
                                        Rechazar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="w-full">
                        @if($pendiente == 1)
                            <div class="">
                                <div class="p-2 w-full">
                                    <div class="grid grid-cols-2">
                                        <div class="relative">
                                            <label for="novedad" class="leading-7 text-sm text-gray-600">
                                                Horas aprobadas
                                            </label>
                                            <input class="w-32 px-2 ml-6 rounded-lg border border-slate-400 p-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none"
                                                type="number" name="horasaprov" id="horasaprov" min="0"
                                                wire:model.defer="horasAprobadas"
                                            >
                                        </div>
                                        <div class="relative">
                                            <label for="novedad" class="leading-7 text-sm text-gray-600">
                                                Novedad: ¿Porque no cumple con las horas?
                                            </label>
                                            <textarea wire:model.defer="novedad" id="novedad" name="novedad"
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-24 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" wire:click="novedadOrden" wire:loading.remove
                                    class="flex mx-auto text-white bg-black border-0 my-5 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">
                                    Enviar novedad
                                </button>
                                <p class="text-center mx-auto text-md">La información se enviará a <b>{{ $correoDelUsuario }}</b></p>
                                <div wire:loading wire:target="novedadOrden"
                                    class="text-xl text-green-400 font-bold mx-auto text-center">
                                    Enviando correo...
                                </div>
                            </div>
                        @endif
                        
                        {{-- rechazo --}}
                        @if($pendiente == 2)
                            <div class="">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="justificacion"
                                            class="leading-7 text-sm text-gray-600">
                                            Justificación: ¿Porque se esta rechazando?</label>
                                        <textarea wire:model.lazy.defer="justificacion" id="justificacion" name="justificacion"
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>
                                <div class="p-1 w-full">
                                    <div class="relative">
                                        <div class="p-1 md:w-full xs:w-full xl:w-full">
                                            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                                                <h2 class="title-font font-medium text-3xl text-gray-900">
                                                    Subir la imagen correspondiente (opcional)</h2>
                                                @if ($photo)
                                                    Vista Previa:
                                                    <img src="{{ $photo->temporaryUrl() }}">
                                                @endif
                                                <label
                                                    for="photofor"class="leading-7 text-md text-indigo-600 underline">
                                                    @if ($photo)
                                                        {{ $photo->getClientOriginalName() }}
                                                    @else
                                                        Suba imagen aquí
                                                    @endif
                                                </label>
                                                <input type="file" wire:model="photo" class="invisible"
                                                    id="photofor" accept="image/png, image/jpeg">
                                                @error('photo')
                                                    <span class="text-red-600">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" wire:click="RechazarEstaOrden"
                                    wire:loading.remove
                                    class="flex mx-auto text-white bg-black border-0 my-5 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">
                                    Enviar
                                </button>
                                <p class="text-center mx-auto text-md">La información se enviará a <b>{{ $correoDelUsuario }}</b></p>
                                
                            </div>
                        @endif
                    </div>
                    
                    <div wire:loading
                        class="text-xl text-green-400 font-bold mx-auto text-center">
                        Por favor, espere...
                    </div>

{{-- fin --}}

                    @if (Session::has('message'))
                        <div class="flex flex-col text-center bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3"
                            role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session()->has('messageError'))
                        <div class="flex flex-col text-center bg-red-100 rounded-lg py-5 px-6 text-base text-black mb-3" role="alert">
                            <p class="text-center">{{ session('messageError') }}</p>
                        </div>
                        @endif

                    @if (!empty($errors->all()))

                        <div class=" text-center bg-red-200 border border-red-300 text-red-700 px-4 py-3 rounded w-full">
                            <strong class="font-bold">¡Error de validación!</strong>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li class="ml-5">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </section>
        
    @else
        <h2>{{ $mensajeError }}</h2>
    @endif

</div>
