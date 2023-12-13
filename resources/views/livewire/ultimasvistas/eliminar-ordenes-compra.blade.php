<div>
    <section class="text-gray-600 body-font">
        <div class="container w-full px-1 py-5 mx-auto" >
            <div class="flex flex-col text-center w-full mb-8" >
                <h1 class="sm:text-3xl text-2xl font-medium title-font my-4 text-gray-900">
                    Borrado de reportes
                </h1>
                @if (Session::has('message'))
                    <div class="bg-green-100 rounded-lg py-5 px-6 md:px-2 sm:px-1 text-base text-green-800 mb-3"
                        role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('messageError'))
                    <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-red-700 mb-3" role="alert">
                        {{ session('messageError') }}
                    </div>
                @endif

                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    Esta tabla muestra los reportes que se han realizado hoy.
                </p>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                    Presione enter para buscar
                </p>
                <div class="mx-auto my-1 relative flex flex-wrap justify-center items-center">
                    <svg class="w-6 h-6 mr-2 mt-2 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>
                    <input type="text" wire:model.defer="searchTerm" wire:keydown.enter="actualizarReportes" placeholder="Buscar por código..."
                        class="w-full bg-cyan-100 hover:bg-cyan-200 focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block
                                appearance-none rounded-lg border border-solid border-gray-300 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none ">
                </div>
            </div>

            <div class=" w-full mx-auto overflow-auto" >
                <table class="table-auto w-full text-left whitespace-no-wrap overflow-x-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                            class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Eliminar 
                            </th>

                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> orden compra </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> observaciones </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> justificacion </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> horas </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> fecha reporte </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> req trans </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> aprobado</th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> fecha ejecucion </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Asesor </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> bancohoras </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> municipio </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> novedad </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Horas aprobadas </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reporteshoy as $key => $value)
                            <tr >
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="mt-4 flex px-1 content-center justify-center">
                                        <button wire:click="eliminarUser({{ $value['id'] }})"
                                            class="hover:bg-blue-500 text-black text-lg border-4 p-1 rounded-full focus:outline-none focus:border-gray-300 transition">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['orden']['codigo'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['observaciones'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['justificacion'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['horas'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['fecha_reporte'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['requiere_transporte'] == 1 ? 'Si' : 'No' }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ ($value['aprobado'] == 4 ? 'Si' : '') }} {{ ($value['aprobado'] == 2 ? 'Pre' : '') }} {{ ($value['aprobado'] == 3 ? 'No' : '') }}</div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['fecha_ejecucion'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['usuario']['name'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['bancohoras'] ? 'Si' : 'No' }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['muni']['nombre'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['novedad'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['aprobadas'] }} </div> </div> </div> </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="px-6 md:px-2 sm:px-1 py-4">
                                    <div class="flex items-center">
                                        <div class="mx-auto">
                                            <div class="text-xl font-medium text-cyan-600">
                                                No hay resultados
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col text-center w-full my-12 py-1" >
                <p class="lg:w-2/3 mx-auto leading-relaxed text-xl text-sky-600">
                    Reportes anteriores
                </p>
            </div>

            <div class=" w-full mx-auto overflow-auto" >
                <table class="table-auto w-full text-left whitespace-no-wrap overflow-x-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                            class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Eliminar 
                            </th>

                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> orden compra </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> observaciones </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> justificacion </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> horas </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> fecha reporte </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> req trans </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> aprobado</th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> fecha ejecucion </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Asesor </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> bancohoras </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> municipio </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> novedad </th>
                            <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Horas aprobadas </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reportes as $key => $value)
                            <tr >
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="mt-4 flex px-1 content-center justify-center">
                                        <button wire:click="eliminarUser({{ $value['id'] }})"
                                            class="hover:bg-blue-500 text-black text-lg border-4 p-1 rounded-full focus:outline-none focus:border-gray-300 transition">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['orden']['codigo'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['observaciones'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['justificacion'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['horas'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['fecha_reporte'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['requiere_transporte'] == 1 ? 'Si' : 'No' }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ ($value['aprobado'] == 4 ? 'Si' : '') }} {{ ($value['aprobado'] == 2 ? 'Pre' : '') }} {{ ($value['aprobado'] == 3 ? 'No' : '') }}</div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['fecha_ejecucion'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['usuario']['name'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['bancohoras'] ? 'Si' : 'No' }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['muni']['nombre'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['novedad'] }} </div> </div> </div> </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap"> <div class="flex items-center"> <div class="ml-4"> <div class="text-sm font-medium text-gray-900"> {{ $value['aprobadas'] }} </div> </div> </div> </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="px-6 md:px-2 sm:px-1 py-4">
                                    <div class="flex items-center">
                                        <div class="mx-auto">
                                            <div class="text-xl font-medium text-cyan-600">
                                                No hay resultados
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-2 content-between pl-4 w-full mx-auto" >
                <div class="my-4 space-x-5">
                    {{ $reportes->links() }}
                </div>
            </div>
        </div>
    </section>
</div>