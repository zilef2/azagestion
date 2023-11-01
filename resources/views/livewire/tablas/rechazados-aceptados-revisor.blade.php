<div>
    <div class="container px-8 pb-3 mx-auto">
        <div class="flex flex-col text-center w-full mt-10">
            <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-2xl">
                Ordenes de compra diligenciadas
            </p>
        </div>
    </div>
    {{-- error zone --}}
    <div class="mx-auto text-center">
        @if(session()->has('message'))
            <div class="text-center bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3" role="alert">
                {{ session('message') }}
            </div>
            @endif
        @if(session()->has('messageError'))
            <div class="text-center bg-red-100 rounded-lg py-5 px-6 text-base text-red-700 mb-3" role="alert">
                {{ session('messageError') }}
            </div>
        @endif
    </div>

    <div class="container px-8 pb-3 mx-auto">
        <div class="flex flex-col text-center w-full my-2">
            <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-xl">
                Registros pendiente revisión
            </p>
        </div>
    </div>

    <section class="text-gray-600 body-font mx-4 px-6">
        <livewire:tablas.tabla-rechazados-aceptados-revisor />
    </section>

    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-2 mx-auto">
            <div class="my-8 divide-y-2 divide-gray-100">
                <div class="py-8 flex flex-wrap md:flex-nowrap">
                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                        <span class="font-semibold title-font text-gray-700">Última actualización</span>
                        <span class="mt-1 text-gray-500 text-sm">{{ $ahora }}</span>
                    </div>
                    <div class="md:flex-grow">
                        <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">
                            Registros pendientes de aceptación ({{ $pendientes }})
                        </h2>
                        <p class="leading-relaxed">
                            Es importante asegurarse de que la comunicación entre los empleados y el personal encargado
                            del registro de horas sea fluida y clara. De esta manera, se podrán solucionar rápidamente
                            cualquier discrepancia o problema que pueda surgir en relación con los registros de horas.
                        </p>
                        <a href="{{ route('PendientesAprobadas') }}"
                            class="text-indigo-500 inline-flex items-center mt-4">Ver la tabla
                            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="py-8 flex flex-wrap md:flex-nowrap">
                    <div class="md:flex-grow">
                        <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">Registros aceptados ({{ $completos }})
                        </h2>
                        <p class="leading-relaxed">
                            Es importante asegurarse de que los registros de horas que se incluyan en el reporte en el
                            formato de relación de entrega sean precisos y estén aprobados por las asignadoras
                            encargadas. De esta forma, se podrán tomar decisiones informadas basadas en la información
                            contenida en el reporte y se podrán identificar posibles áreas de mejora en la gestión del
                            tiempo de trabajo de los empleados.
                        </p>
                        <a href="{{ route('CompletamenteAprobadas') }}"
                            class="text-indigo-500 inline-flex items-center mt-4">Ver la tabla
                            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
