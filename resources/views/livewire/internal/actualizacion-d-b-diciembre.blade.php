<div>
    <section class="text-gray-600 body-font relative">
        <div class="container p-3 mx-auto">
            <div class="flex flex-col text-center w-full my-8">
                <p class="w-full lg:w-2/3 mx-auto leading-relaxed font-bold text-2xl">Actualización BD </p>
                <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-xl">Reportes del 1 diciembre</p>

            </div>

            <div class="mx-auto p-4 sm:w-1/2 w-full">
                {{-- error zone --}}
{{--                <div class="py-1">--}}
{{--                    @if (Session::has('message'))--}}
{{--                        <div class="text-center">--}}
{{--                            <span--}}
{{--                                class="px-1 my-3 inline-flex text-xl leading-5 font-semibold bg-green-200 text-green-800">--}}
{{--                                {{ __(session('message')) }}--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if (Session::has('WarningMessage'))--}}
{{--                        <div class="text-center">--}}
{{--                            <span--}}
{{--                                class="px-1 my-1 text-lg inline-flex leading-5 font-semibold bg-amber-200 text-amber-800">--}}
{{--                                {{ __(session('WarningMessage')) }}--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if (Session::has('messageError'))--}}
{{--                        <div class="text-center">--}}
{{--                            <span class="px-1 my-1 text-lg inline-flex leading-5 font-semibold bg-red-100 text-red-800">--}}
{{--                                {{ __(session('messageError')) }}--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if ($failures != null)--}}
{{--                        <div class="text-center">--}}
{{--                            <span--}}
{{--                                class="px-1 my-1 text-lg inline-flex leading-5 font-semibold bg-orange-100 text-orange-800">--}}
{{--                                {{ $failures }}--}}
{{--                            </span>--}}
{{--                            <ol class="list-decimal">--}}
{{--                                @foreach ($ListaErrores as $fail)--}}
{{--                                    <li class="text-sm ">--}}
{{--                                        {{ $fail }}--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ol>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @if ($errors->any())--}}
{{--                        @foreach ($errors as $err)--}}
{{--                            <p class="px-1 my-1 inline-flex text-lg leading-5 font-semibold bg-amber-500 text-black">--}}
{{--                                {{ $err }}--}}
{{--                            </p>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}

{{--                    @error('archivoExcelSubir')--}}
{{--                    <span class="p-3 my-1 text-lg inline-flex leading-5 font-semibold bg-red-100 text-red-700">--}}
{{--                            {{ $message }}--}}
{{--                        </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}

                {{-- theform --}}
                <div class="grid place-content-center border-2 border-gray-200 px-4 py-6 rounded-lg">
                    <div class="">
                        <h2 class="title-font text-center items-center font-medium text-2xl text-gray-900">Subir archivo(xlsx)</h2>
                        <form
{{--                            wire:submit.prevent="importarOCDesactualizadas"--}}
                            action="{{route('upload.desactualizadas')}}"
                            enctype='multipart/form-data'>
                            @method('POST')
                            @csrf
                            <div class="relative items-center text-center p-4 hover:bg-sky-200">
                                <label
                                    for="archivoExcelSubirFor"class="leading-7 mx-auto text-md text-indigo-600 underline">
                                    <svg class="px-3 mx-auto h-12 w-12" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    {{ $nombreArchivo }}
                                </label>
                                <input type="file" wire:model="archivoExcelSubir" id="archivoExcelSubirFor"
                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                       class="w-full invisible">
                            </div>

                            <div class="grid place-content-center justify-center">
                                {{-- wire:target="importarUsuariosPrueba" --}}
                                <div wire:loading.delay.long class="my-4">
                                    <button disabled type="button"
                                            class="text-centerinline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Por favor, Espere...
                                    </button>


                                    {{--inicio librin                                    --}}
                                    <div class="loader mx-auto mt-8 ">
                                        <div>
                                            <ul>
                                                <li>
                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                    </svg>
                                                </li>
                                                <li>
                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                    </svg>
                                                </li>
                                                <li>
                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                    </svg>
                                                </li>
                                                <li>
                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                    </svg>
                                                </li>
                                                <li>
                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                    </svg>
                                                </li>
                                                <li>
                                                    <svg fill="currentColor" viewBox="0 0 90 120">
                                                        <path d="M90,0 L90,120 L11,120 C4.92486775,120 0,115.075132 0,109 L0,11 C0,4.92486775 4.92486775,0 11,0 L90,0 Z M71.5,81 L18.5,81 C17.1192881,81 16,82.1192881 16,83.5 C16,84.8254834 17.0315359,85.9100387 18.3356243,85.9946823 L18.5,86 L71.5,86 C72.8807119,86 74,84.8807119 74,83.5 C74,82.1745166 72.9684641,81.0899613 71.6643757,81.0053177 L71.5,81 Z M71.5,57 L18.5,57 C17.1192881,57 16,58.1192881 16,59.5 C16,60.8254834 17.0315359,61.9100387 18.3356243,61.9946823 L18.5,62 L71.5,62 C72.8807119,62 74,60.8807119 74,59.5 C74,58.1192881 72.8807119,57 71.5,57 Z M71.5,33 L18.5,33 C17.1192881,33 16,34.1192881 16,35.5 C16,36.8254834 17.0315359,37.9100387 18.3356243,37.9946823 L18.5,38 L71.5,38 C72.8807119,38 74,36.8807119 74,35.5 C74,34.1192881 72.8807119,33 71.5,33 Z"></path>
                                                    </svg>
                                                </li>
                                            </ul>
                                        </div><span class="text-sm font-extrabold">Leyendo filas</span></div>
                                    {{--finlibrin                                    --}}





                                </div>
                            </div>

                            @if ($archivoExcelSubir)
                                <div
                                    wire:loading.remove
                                    class="grid place-content-center">
                                    <button type="submit"
                                            class="place-content-center text-white bg-indigo-700 border-0 py-2 px-8 rounded text-lg focus:outline-none hover:bg-indigo-400">
                                        Subir OC Desactualizadas
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

            </div>
                <div class="mx-auto">
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg">La columna A (numero) = ID</p>
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg">La columna D (numero) = horas aprobadas</p>
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg">La columna E (numero) = Horas disponibles</p>
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg">La columna H (numero) = Valor a subir</p>
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg">La columna I (texto) = Subir este valor a la BD para igualar el  valor del micrositio con el valor ejecutado en AZA</p>
                </div>
        </div>
    </section>

    <style>
        .loader {
            --background: linear-gradient(135deg, #23C4F8, #275EFE);
            --shadow: rgba(39, 94, 254, 0.28);
            --text: #6C7486;
            --page: rgba(255, 255, 255, 0.36);
            --page-fold: rgba(255, 255, 255, 0.52);
            --duration: 3s;
            width: 200px;
            height: 140px;
            position: relative;
        }

        .loader:before, .loader:after {
            --r: -6deg;
            content: "";
            position: absolute;
            bottom: 8px;
            width: 120px;
            top: 80%;
            box-shadow: 0 16px 12px var(--shadow);
            transform: rotate(var(--r));
        }

        .loader:before {
            left: 4px;
        }

        .loader:after {
            --r: 6deg;
            right: 4px;
        }

        .loader div {
            width: 100%;
            height: 100%;
            border-radius: 13px;
            position: relative;
            z-index: 1;
            perspective: 600px;
            box-shadow: 0 4px 6px var(--shadow);
            background-image: var(--background);
        }

        .loader div ul {
            margin: 0;
            padding: 0;
            list-style: none;
            position: relative;
        }

        .loader div ul li {
            --r: 180deg;
            --o: 0;
            --c: var(--page);
            position: absolute;
            top: 10px;
            left: 10px;
            transform-origin: 100% 50%;
            color: var(--c);
            opacity: var(--o);
            transform: rotateY(var(--r));
            -webkit-animation: var(--duration) ease infinite;
            animation: var(--duration) ease infinite;
        }

        .loader div ul li:nth-child(2) {
            --c: var(--page-fold);
            -webkit-animation-name: page-2;
            animation-name: page-2;
        }

        .loader div ul li:nth-child(3) {
            --c: var(--page-fold);
            -webkit-animation-name: page-3;
            animation-name: page-3;
        }

        .loader div ul li:nth-child(4) {
            --c: var(--page-fold);
            -webkit-animation-name: page-4;
            animation-name: page-4;
        }

        .loader div ul li:nth-child(5) {
            --c: var(--page-fold);
            -webkit-animation-name: page-5;
            animation-name: page-5;
        }

        .loader div ul li svg {
            width: 90px;
            height: 120px;
            display: block;
        }

        .loader div ul li:first-child {
            --r: 0deg;
            --o: 1;
        }

        .loader div ul li:last-child {
            --o: 1;
        }

        .loader span {
            display: block;
            left: 0;
            right: 0;
            top: 100%;
            margin-top: 20px;
            text-align: center;
            color: var(--text);
        }

        @keyframes page-2 {
            0% {
                transform: rotateY(180deg);
                opacity: 0;
            }

            20% {
                opacity: 1;
            }

            35%, 100% {
                opacity: 0;
            }

            50%, 100% {
                transform: rotateY(0deg);
            }
        }

        @keyframes page-3 {
            15% {
                transform: rotateY(180deg);
                opacity: 0;
            }

            35% {
                opacity: 1;
            }

            50%, 100% {
                opacity: 0;
            }

            65%, 100% {
                transform: rotateY(0deg);
            }
        }

        @keyframes page-4 {
            30% {
                transform: rotateY(180deg);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            65%, 100% {
                opacity: 0;
            }

            80%, 100% {
                transform: rotateY(0deg);
            }
        }

        @keyframes page-5 {
            45% {
                transform: rotateY(180deg);
                opacity: 0;
            }

            65% {
                opacity: 1;
            }

            80%, 100% {
                opacity: 0;
            }

            95%, 100% {
                transform: rotateY(0deg);
            }
        }

    </style>
</div>
