<div class="mt-12">
    @push('styles')
        @import (css) "swi.css";
    @endpush

    @if ($mensajeError == '')
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-2 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    {{-- <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Correjir orden de compra </h1> --}}
                    <p class="lg:w-2/3 mx-auto leading-relaxed text-2xl sm:text-md xs:text-md">La orden fue rechazada debido a:</p>
                    <p class="lg:w-2/3 mx-auto text-red-600 font-bold leading-relaxed text-2xl xs:text-md">{{ $mensajeRevisor }}</p>
                </div>
                <div class="w-5/6 mx-auto">
                    <form wire:submit.prevent="submitAsesor">
                        <div>
                            @if (Session::has('message'))
                                <div class="bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3"
                                    role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session()->has('messageError'))
                                <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-black mb-3" role="alert">
                                    {{ session('messageError') }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <label for="codigoid"
                                        class="block text-sm font-medium text-gray-700 capitalize">OC/OS</label>
                                    <select disabled wire:model.lazy="codigoid"
                                        class="form-select form-select-md mt-2 appe arance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        aria-label="form-select-lg example">
                                        @forelse($codigosPendientes as $generico)
                                            @if ($loop->first)
                                                <option class="capitalize" value="" selected>Seleccione OC/OS
                                                </option>
                                            @endif
                                            <option wire:key="codigo-{{ $generico->id }}" value="{{ $generico->id }}"
                                                class="capitalize"> {{ $generico->codigo }}
                                                {{-- - {{ $generico->id }} --}}
                                            </option>
                                        @empty
                                            <option class="capitalize" value="" selected>No hay registros</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <label for="empresaid"
                                        class="block text-sm font-medium text-gray-700 capitalize">Empresa</label>
                                    <select disabled
                                        class="form-select form-select-md mt-2
                                    appearance-none block w-full px-4 py-2
                                    text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                           
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <label for="clasificacionid"
                                        class="block text-sm font-medium text-gray-700 capitalize">clasificacion</label>
                                    <select disabled
                                        class="form-select form-select-md mt-2
                                    appearance-none block w-full px-4 py-2
                                    text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
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
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/4">
                                <div class="relative">
                                    <label for="municipio"
                                        class="block text-sm font-medium text-gray-700 capitalize">municipio</label>
                                    <select aria-label=".form-select-lg example" wire:model.lazy="municipio"
                                        class="form-select form-select-md mt-2 appearance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                        @forelse($municipios as $generico)
                                            @if ($loop->first)
                                                <option class="capitalize" value="" selected>Seleccione municipio
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

                            <div class="p-2 w-full">
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

                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/3">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <label for="horas" class="flex text-sm font-medium text-gray-700">
                                            Horas Acumuladas: <b>{{ $horasAcumuladas }}</b> | Horas restantes:
                                            <b>{{ $MaxHoras }}</b>
                                        </label>
                                        <div class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <input type="number" min="0" max="900" wire:model="horas" step="0.1"
                                                name="horas" id="horas" placeholder="" class="peer w-full rounded-r-lg border border-slate-400 px-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none" />
                                            <label for="horas" class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                Horas
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/3 mt-5">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <div
                                            class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <input disabled
                                                class="peer w-full rounded-r-lg border border-slate-400 px-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none"
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
                            <div class="p-2 w-full xs:w-full sm:w-full md:w-1/3">
                                <div class="relative">
                                    <div class="mx-auto w-screen-sm mt-6 px-4 py-2">
                                        <div
                                            class="relative flex h-10 w-full flex-row-reverse overflow-clip rounded-lg">
                                            <input
                                                class="peer w-full rounded-r-lg border border-slate-400 px-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none"
                                                type="date" wire:model="fecha_ejecucion" name="fecha_ejecucion"
                                                id="fecha_ejecucion" placeholder="" />
                                            <label for="fecha_ejecucion"
                                                class="flex items-center rounded-l-lg border border-slate-400 bg-slate-50 px-2 text-sm text-slate-400 transition-colors duration-300 peer-focus:border-sky-400 peer-focus:bg-sky-400 peer-focus:text-white">
                                                Fecha ejecucion
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center mt-6 xs:w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2">
                                <p class="p-2 mx-4">¿Requiere transporte?</p>
                                <label class="switch cursor-pointer">
                                    <input wire:model="siOno" type="checkbox">
                                    <span
                                        class="slider rounded-full bg-white shadow-md w-40 h-12 flex items-center justify-center">
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

                            @if ($esCapacitacion)
                                <div class="mx-2 my-4 w-full">
                                    <div class="max-w-2xl mx-auto">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-500" for="">
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

                                    <div wire:loading wire:target="adjunto" class="text-lg text-center bg-green-100 text-green-600">Subiendo...</div>
                                </div>
                            @endif

                            {{ $original_filename }}
                            @if ($esCapacitacion)
                                @if ($adjuntoListo)
                                    <iframe src="{{ $original_filename }}" class="h-96 w-full py-12 object-cover object-center"></iframe>
                                @endif
                            @endif
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="message"
                                        class="leading-7 text-sm text-gray-600">Observaciones</label>
                                    <textarea wire:model.lazy.defer="observaciones" id="message" name="message" rows="2"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-800 focus:border-indigo-600 focus:bg-white focus:ring-2 h-22
                                          text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out focus:ring-blue-500 placeholder-sky-700
                                          placeholder="Una observacion...""></textarea>
                                </div>
                            </div>

                            @if ($reporte->photo)
                                <img src="{{ $fotoRechazo }}"
                                    class="object-cover w-full py-6 object-center" />
                            @endif

                            @if (Session::has('message'))
                                <div class="bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3"
                                    role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (session()->has('messageError'))
                                <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-black mb-3" role="alert">
                                    {{ session('messageError') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="py-8 w-full">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="p-2 text-red-500 first:text-xl">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div wire:loading.remove wire:target="submitAsesor" class="p-2 w-1/2">
                                <button type="submit"
                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Guardar</button>
                            </div>
                            <div wire:loading.remove wire:target="submitAsesor" class="p-2 w-1/2">
                                <button wire:click="justBack" type="button"
                                    class="flex mx-auto text-white bg-black border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">Atrás</button>
                            </div>
                        </div>
                    </form>
                    <div wire:loading wire:target="submitAsesor" class="text-green-500 my-2 text-lg">Subiendo...</div>


                </div>
            </div>
        </section>
    @else
        <h2>{{ $mensajeError }}</h2>
    @endif
</div>
