<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-2 mx-auto">
            <div class="text-center mb-2">
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4"></h1>
                <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s"></p>
                {{-- <div class="flex mt-6 justify-center">
                    <div class="w-full grid grid-cols-1 mx-auto place-items-center rounded-full">
                        @if (session()->has('messageError'))
                            <div class="text-center bg-red-100 rounded-lg py-5 px-6 text-xl text-black mb-3" role="alert">
                                {{ session('messageError') }}
                            </div>
                        @endif
                    </div>
                </div> --}}
            </div>
            <div class="flex flex-wrap mx-4 my-10 items-center">
                {{-- OrdenesNuevas --}}
                <div class="p-4 md:w-1/2 xs:w-full sm:w-full flex flex-col text-center items-center">
                    <a @if($ordenesPendientesWelcome != 0 || $isadmin) href="{{ route('FormNuevaOrden') }}" class="hover:bg-gray-100" @else class="cursor-not-allowed" @endif >
                        <div class=" w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                            <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" > <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" /> </svg>
                        </div>
                        <div class="flex-grow">
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">
                                Diligenciar órdenes de compra
                            </h2>
                            <p class="text-base mb-12"> 
                                Actualmente, usted tiene <b>{{ $ordenesPendientesWelcome }}</b> órdenes pendientes </p>
                            <p class="leading-relaxed text-sm">
                                Paso inicial para el trámite de cada orden de compra, después de la carga de las órdenes vía Excel, las órdenes sin tramitar estarán en la tabla mostrada aquí
                            </p>
                        </div>
                    </a>
                </div>
                {{-- tabla de ordenes diligenciadas --}}
                <div class="p-4 md:w-1/2 xs:w-full sm:w-full flex flex-col text-center items-center">
                    <a @if($ordenesRechazadasWelcome != 0 || $isadmin) href="{{ route('OrdenesPorcorrejir') }}" class="hover:bg-gray-100" @else class="cursor-not-allowed" @endif>
                        <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"> <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /> </svg>
                        </div>
                        <div class="flex-grow">
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">
                                Órdenes de compras Rechazadas
                            </h2>
                            <p class="text-base mb-12"> 
                                Actualmente, usted tiene <b>{{ $ordenesRechazadasWelcome }}</b> órdenes rechazadas
                             </p>
                            <p class="leading-relaxed text-sm">
                                Luego de la revisión, las órdenes de compra que sean rechazadas estarán aquí
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="nomostraradmin">
        <div class="container px-8 my-2 mx-auto">
            <div class="flex flex-col text-center w-full my-2">
                <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-xl">
                    Actividades diligenciadas
                </p>
            </div>
        </div>
        <section class="text-gray-600 body-font my-8">
            <div class="container px-1 xl:px-10 py-3 mx-auto">
                <livewire:tablas.tabla-reportes-asesor-aceptadas aceptadas="0" />
            </div>
        </section>
        <div class="flex mt-6 justify-center">
            <div class="w-full grid grid-cols-1 mx-auto place-items-center rounded-full">
                @if (session()->has('messageError'))
                    <div class="text-center bg-red-100 rounded-lg py-5 px-6 text-xl text-red-600 mb-3" role="alert">
                        {{ session('messageError') }}
                    </div>
                @endif
            </div>
        </div>

        @if($isadmin == 0)
            <div class="container px-8 mt-8 mb-1 mx-auto">
                <div class="flex flex-col text-center w-full my-2">
                    <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-xl"> Actividades aprobadas ✅ </p>
                </div>
            </div>
            <section class="text-gray-600 body-font my-8">
                <div class="container px-1 xl:px-10 py-3 mx-auto">
                    <livewire:tablas.tabla-reportes-asesor-aceptadas aceptadas="1" />
                </div>
            </section>
        @endif
    </div>
</div>
