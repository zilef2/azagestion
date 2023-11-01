<div>
     @if($haydesconocidos)
        <section class="text-gray-600 body-font relative">
            <div class="container px-8 py-3 my-2 mx-auto">
                <div class="flex flex-col text-center w-full mb-6">
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-2xl font-bold">
                        Usuarios desconocidos
                    </p>
                </div>
                <div class="flex flex-col text-center w-full mb-2">
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg bg-red-100">
                        <b class="text-red-700 text-2xl">Atencion</b>
                    </p>
                </div>
                <div class="flex flex-col text-left w-full ml-4 mb-6">
                        <ol class="list-disc text-lg font-serif">
                            <li>La contraseña solo la puede cambiar el usuario, si se cambia la cedula del usuario descargue el siguiente archivo para saber la contraseña que se le asignó. 
                                <button wire:click="exportDes" :active="request()->routeIs('SubirUsuarios')" class="text-blue-600">
                                    Descargar desconocidos
                                </button>
                            </li>
                            <li>El último campo a editar debe ser el correo electrónico (email)</li>
                        </ol>
                </div>
                        
                <div class="w-full">
                    <livewire:tablas.tabladesconocidos-revisor />
                </div>
            </div>
        </section>
    @endif


    <section class="text-gray-600 body-font relative">
        <div div class="container p-3 mx-auto">
            <div class="flex flex-col text-center w-full mt-2">
                <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-2xl">
                    Subir Usuarios
                </p>
            </div>

            <div class="mx-auto p-4 xs:w-1/2 md:w-full">
                {{-- error zone --}}
                <div class="py-1">
                    @if (Session::has('message'))
                        <div class="text-center">
                            <span class="px-1 my-3 inline-flex text-xl leading-5 font-semibold bg-green-200 text-green-800">
                                {{ __(session('message')) }}
                            </span>
                        </div>
                    @endif
                    @if (Session::has('messageError'))
                        <div class="text-center">
                            <span class="px-1 my-1 text-lg inline-flex leading-5 font-semibold bg-red-100 text-red-800">
                                {{ __(session('messageError')) }}
                            </span>
                        </div>
                    @endif
                    @if (Session::has('messageWarning'))
                        <div class="text-center">
                            <span class="px-1 my-1 text-lg inline-flex leading-5 font-semibold bg-yellow-100 text-amber-400">
                                {{ __(session('messageWarning')) }}
                            </span>
                        </div>
                    @endif
                    @if ($failures != null)
                        <div class="">
                            <span class="px-1 my-1 text-lg inline-flex leading-5 font-semibold bg-orange-100 text-orange-800">
                                {{ $failures }}
                            </span>
                            <ol class="list-decimal">
                                @foreach ($ListaErrores as $fail)
                                    <li class="text-sm ">
                                        {{  $fail }}
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                    @if($errors->any())
                        @foreach ($errors as $err)
                            <p class="px-1 my-1 inline-flex text-lg leading-5 font-semibold bg-amber-500 text-black">
                                {{ $err }}
                            </p>
                        @endforeach
                    @endif

                    @error('archivoExcelSubir') 
                        <span class="p-3 my-1 text-lg inline-flex leading-5 font-semibold bg-red-100 text-red-700">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    <section class="text-gray-600 body-font relative">
        <div class="container px-8 py-1 mx-auto">
            <div class="">
                <div class="grid place-content-center border-2 border-gray-200 px-4 py-6 rounded-lg">
                    <div class="">
                        <h2 class="title-font text-center items-center font-medium text-2xl text-gray-900">Subir archivo con usuarios (xlsx)</h2>

                        <form wire:submit.prevent="importUs" method="post" enctype="multipart/form-data">
                            <div class="relative items-center text-center p-4 hover:bg-sky-200">
                                <label for="archivoExcelSubirFor"class="leading-7 mx-auto text-md text-indigo-600 underline">
                                    <svg class="px-3 mx-auto h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /> </svg>     
                                    {{ $nombreArchivoRegisterUser }}
                                </label>
                                <input type="file" wire:model="archivoExcelSubir"
                                    id="archivoExcelSubirFor"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                    class="w-full invisible">
                            </div>
                            <div class="grid place-content-center justify-center">
                                {{-- wire:target="importUs" --}}
                                <div wire:loading.delay.long class="my-4">
                                    <button disabled type="button"
                                        class="text-centerinline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"> <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle> <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"> </path> </svg>
                                        Por favor, Espere...
                                    </button>
                                </div>
                            </div>
                            @if ($archivoExcelSubir)
                                <div wire:loading.remove class="grid place-content-center">
                                    <button type="submit"
                                        class="place-content-center text-white bg-indigo-700 border-0 py-2 px-8 rounded text-lg focus:outline-none hover:bg-indigo-400">
                                        Subir archivo
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="w-full mt-6">
                    <livewire:tablas.usuarios-asesores />
                </div>
            </div>
        </div>
    </section>
   
</div>