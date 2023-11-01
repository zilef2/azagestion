<div>
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-8 mx-auto">
          <div class="flex flex-col text-center w-full mb-12">
            <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-base">El formato del archivo debe coincidir con el expuesto en pantalla.</p>
          </div>

          <div class="mx-auto p-4 md:w-1/4 sm:w-1/2 w-full">
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
                  
                    <h2 class="title-font font-medium text-3xl text-gray-900">Subir archivo de excel</h2>
                    <form wire:submit.prevent="importarUsuariosPrueba">
                        <div class="relative">
                            <label for="archivoExcelSubir"class="leading-7 text-md text-indigo-600 underline">
                              <svg class="p-3 m-6 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /> </svg>     
                              {{  $nombreArchivo }}
                            </label>
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


          <div class="mx-auto">
            <div class="w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                  <thead>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">FECHA APROBACION OC</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">FECHA NTREGA INICIAL DE LA OC</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">FECHA ENTREGA FINAL DE LA OC</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CONTRATO</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">MES DE LA EJECUCION </th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">EMPRESA</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">TAREA</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">PRODUCTO</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CLASIFICACION</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">PROFESIONAL</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">PRESTADOR</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD PEDIDA</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD SIN PROGRAMAR</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD PROGRAMADA</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD CUMPLIDA</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD PENDIENTE POR EJECUTAR</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD FACTURADA DISTRIBUIDOR</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD PENIENTES POR FACTURAR</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">CANTIDAD PAGADA ARL SURA</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ESTADO DE LA TAREA</th>
                      <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="px-4 py-3">1234567</td>
                      <td class="px-4 py-3">2023/01/01</td>
                      <td class="px-4 py-3">2023/11/01</td>
                      <td class="px-4 py-3">2023/11/30</td>
                      <td class="px-4 py-3">094911263</td>
                      <td class="px-4 py-3">noviembre</td>
                      <td class="px-4 py-3">EXXE LOGISTICA SAS</td>
                      <td class="px-4 py-3">ELEMENTOS DE PROTECCION PERSONAL</td>
                      <td class="px-4 py-3">INTERVENCIÓN DEL  AT Y EL</td>
                      <td class="px-4 py-3">ASESORÍA</td>
                      <td class="px-4 py-3">OLARTE VELASQUEZ  MONICA MARIA</td>
                      <td class="px-4 py-3">JARAMILLO RAMIREZ  MATEO DE JESUS</td>
                      <td class="px-4 py-3">8</td>
                      <td class="px-4 py-3">8</td>
                      <td class="px-4 py-3">0</td>
                      <td class="px-4 py-3">0</td>
                      <td class="px-4 py-3">8,00</td>
                      <td class="px-4 py-3">0</td>
                      <td class="px-4 py-3">0,00</td>
                      <td class="px-4 py-3">0</td>
                      <td class="px-4 py-3">TAREA PENDIENTE POR GESTION</td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </section>
</div>
