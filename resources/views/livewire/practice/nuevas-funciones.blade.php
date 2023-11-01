<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-8 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                    Nuevas funciones
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Texto generico</p>
            </div>
            <div class="flex flex-col text-center w-full mb-2">
                <div class="my-0">
                    <button wire:loading.delay.longer disabled type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"> <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle> <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"> </path> </svg>
                        Cargando...
                    </button>
                </div>
            </div>
            <div class="flex flex-wrap -m-4 text-center">
                <div wire:click="exportarEmpresas" class="hover:bg-slate-200 p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M8 17l4 4 4-4m-4-5v9"></path>
                            <path d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"></path>
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-gray-900">2.7K</h2>
                        <span class="leading-relaxed">empresas</span>
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    @if (Session::has('message'))
                        <div class="">
                            <span
                                class="px-1 mt-4 ml-4 inline-flex text-lg leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ session('message') }}
                            </span>
                        </div>
                    @endif

                    <div class="grid place-content-center border-2 border-gray-200 px-4 py-6 rounded-lg">
                        <div class="">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="place-content-center text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24"> <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path> <circle cx="9" cy="7" r="4"></circle> <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path> </svg>
                            <h2 class="title-font font-medium text-3xl text-gray-900">Subir archivo excel (necesita formato)</h2>
                            <form wire:submit.prevent="importarUsuariosPrueba">
                                <div class="relative">
                                    <label for="archivoExcelSubir"class="leading-7 text-md text-indigo-600 underline">
                                         X columnas</label>
                                    <input type="file" wire:model="archivoExcelSubir" id="archivoExcelSubir"
                                        name="archivoExcelSubir"
                                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        class="w-full invisible">
                                </div>
                                @error('archivoExcelSubir')
                                    <span class="text-red-700 text-xl">{{ $message }}</span>
                                @enderror
                                <div class="place-content-center justify-center">
                                    <div wire:loading.delay.longer wire:target="importarUsuariosPrueba" class="my-4">
                                        <button disabled type="button"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"> <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle> <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"> </path> </svg>
                                            Por favor, Espere...
                                        </button>
                                    </div>
                                </div>
                                @if ($archivoExcelSubir)
                                    <button type="submit"
                                        class="place-content-center text-white bg-indigo-700 border-0 py-2 px-8 rounded text-lg focus:outline-none hover:bg-indigo-400">
                                        Subir archivo
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>



                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24"> <path d="M3 18v-6a9 9 0 0118 0v6"></path> <path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"> </path> </svg>
                        <h2 class="title-font font-medium text-3xl text-gray-900">Subir la imagen correspondiente</h2>
                        @if ($photo)
                            Vista Previa:
                            <img src="{{ $photo->temporaryUrl() }}">
                        @endif
                        <label for="photofor"class="leading-7 text-md text-indigo-600 underline">
                            @if ($photo)
                                {{ $photo->getClientOriginalName() }}
                            @else
                                Suba su imagen aqui
                            @endif
                        </label>
                        <input type="file" wire:model="photo" class="invisible" id="photofor" accept="image/png, image/jpeg">

                        @error('photo')
                            <span class="error">{{ $message }}</span>
                        @enderror

                        @if ($photo)
                            <button wire:loading.attr="disabled" wire:target="photo" wire:click="subirIMG"
                                type='button' class='my-4 flex break-inside bg-white text-black border-2 border-black rounded-3xl px-6 py-3 mb-4 w-full dark:bg-slate-800 dark:text-white'>
                                <div class='m-auto'>
                                    <div class='flex items-center justify-start flex-1 space-x-4'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /> </svg>
                                        <span class='font-medium mb-[-2px]'>
                                            Subir imagen
                                        </span>
                                    </div>
                                </div>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-gray-900">No hay aviso!!!!!!!!!!!</h2>
                        <a wire:click="mandarCorreo" class="leading-relaxed underline text-sky-600">mandar correo a alejofg2@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="flex my-12">
        @forelse($ordenesSinasignar as $index => $OrdenSA)
            <div class="m-3 hover:bg-gray-200">
                <input wire:model.lazy="ordenesSeleccionadas.{{ $index }}" id="a{{$index}}" value="{{ $OrdenSA->id }}"
                    class="form-checkbox h-4 w-4 m-2" type="checkbox">
                    <label for="a{{$index}}" class="my-4 pt-5 text-xl items-start inline font-medium text-gray-700 capitalize">
                        {{$OrdenSA->codigo}}
                    </label>
            </div>
        @empty
            <h1 class="text-xl m-4 text-center">No hay ninguna orden</h1>
        @endforelse
    </div>
    <button wire:click="asignarDueno" class="self-center bg-blue-500 hover:opacity-75 text-white rounded-full mt-4 px-8 py-1 h-10">
        Asociar al usuario 1
    </button>

    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
        <table class="table-auto w-full text-left whitespace-no-wrap">
          <thead>
            <tr>
              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl">Plan</th>
              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Speed</th>
              <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Storage</th>
              <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tr rounded-br"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="px-4 py-3">Start</td>
              <td class="px-4 py-3">5 Mb/s</td>
              <td class="px-4 py-3 text-lg text-gray-900">Free</td>
            </tr>
          </tbody>
        </table>
      </div>



</div>
