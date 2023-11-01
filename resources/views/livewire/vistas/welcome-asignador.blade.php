<div>
  <section class="text-gray-600 body-font">
    <div class="container px-5 py-2 mx-auto">
      <div class="text-center mb-2">
        <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4"></h1>
        <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s"></p>
        <div class="flex mt-6 justify-center">
          <div class="w-16 h-1 rounded-full bg-indigo-500 inline-flex"></div>
        </div>
      </div>
      <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6 ">
        <div class="p-4 xs:w-full md:w-1/3 flex flex-col text-center items-center">
            <a href="{{ route('SubirOrdenesDeCompra') }}" class="hover:bg-sky-50 dark:hover:bg-sky-700 ">
                <div  class=" w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"> <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" /> </svg>
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900  dark:font-semibold text-lg title-font font-medium mb-3">Subir archivo excel principal</h2>
                    <p class="leading-relaxed text-base">Permite Registrar/actualizar las órdenes de compra mediante la comparativa de un archivo de excel y la base de datos de este aplicativo.</p>
                    <p class="leading-relaxed text-base">Debe estar en el formato adecuado.</p>
                </div>
            </a>
        </div>
        {{-- tabla de órdenes diligenciadas --}}
        <div class="p-4 xs:w-full md:w-1/3 flex flex-col text-center items-center">
            <a href="{{ route('RechazadosAceptadosRevisor') }}" class="hover:bg-sky-50 dark:hover:bg-sky-700 ">
                <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"> <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /> </svg>
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900  dark:font-semibold text-lg title-font font-medium mb-3">Ordenes de compras diligenciadas</h2>
                    <p class="leading-relaxed text-base">
                      Luego de subir el archivo con las órdenes de compras (excel) y sean diligenciadas por el respectivo asesor, estarán aquí para la aprobación del revisor/asignador
                    </p>
                </div>
            </a>
        </div>
        {{-- Subir usuarios --}}
        <div class="p-4 xs:w-full md:w-1/3 flex flex-col text-center items-center">
            <a href="{{ route('SubirUsuarios') }}" class="hover:bg-sky-50 dark:hover:bg-sky-700 ">
                <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"> <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /> </svg>
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900  dark:font-semibold text-lg title-font font-medium mb-3">Usuarios que usaran el aplicativo</h2>
                    <p class="leading-relaxed text-base">Los usuarios que se inserten aquí, tendrán como contraseña la cédula seguida de un asterisco(*)</p>
                </div>
            </a>
        </div>
      </div>
    </div>
  </section>




  <section class="text-gray-600 mt-8 body-font">
    <div class="container px-5 py-2 mx-auto">
      <div class="text-center mb-2">
        <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4"></h1>
        <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s"></p>
        <div class="flex mt-6 justify-center">
          <div class="w-16 h-1 rounded-full bg-indigo-500 inline-flex"></div>
        </div>
      </div>
      <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6 ">
        <div class="p-4 xs:w-full md:w-1/3 flex flex-col text-center items-center">
            <a href="{{ route('RangoOrdenesCompra') }}" class="hover:bg-sky-50 dark:hover:bg-sky-700 ">
                <div  class=" w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /> </svg>

                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900  dark:font-semibold text-lg title-font font-medium mb-3">Descargar órdenes de compra</h2>
                    <p class="leading-relaxed text-base">
                      Usando el formato relación de entrega y con un rango definido por el usuario, se descargarán todas las órdenes de compra que cumplan con dicho rango.
                    </p>
                    {{-- <p class="leading-relaxed text-base">Debe estar en el formato adecuado.</p> --}}
                </div>
            </a>
        </div>
        {{-- tabla de órdenes diligenciadas --}}
        <div class="p-4 xs:w-full md:w-1/3 flex flex-col text-center items-center">
            <a href="{{ route('RangoOrdenesSoporte') }}" class="hover:bg-sky-50 dark:hover:bg-sky-700 ">
                <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" /> </svg>
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900  dark:font-semibold text-lg title-font font-medium mb-3">Descargar soportes de cada orden</h2>
                    <p class="leading-relaxed text-base">Solo descargará los soportes en el rango de fechas especificado</p>
                </div>
            </a>
        </div>
        {{-- tabla de con todas las órdenes --}}
        <div class="p-4 xs:w-full md:w-1/3 flex flex-col text-center items-center">
            <a class="">
            {{-- <a href="{{ route('TodasLasOrdenes') }}" class="hover:bg-sky-50 dark:hover:bg-sky-700 "> --}}
                <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12"> <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /> </svg>
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900  dark:font-semibold text-lg title-font font-medium mb-3">Ver los todas las órdenes de compra</h2>
                    <p class="leading-relaxed text-base">Se han registrado un total de <b>{{ $numOrdenes }} órdenes de compra</b>.</p>
                    {{-- <p class="leading-relaxed text-base">Permite visualizar las <b>{{ $numOrdenes }} órdenes de compra</b> (Tarda en cargar). </p> --}}
                </div>
            </a>
        </div>
      </div>
    </div>
  </section>

    
  <section class="text-gray-600 body-font relative mt-8">
      <div class="container px-8 py-3 mx-auto">
          <div class="flex flex-col text-center w-full mb-1">
              <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-2xl">
                Usuarios Asignadores
              </p>
              <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-lg my-2">
                Tienen la capacidad de validar las ordenes de compra
              </p>
          </div>
      <div class="grid grid-cols-1">
        <livewire:tabla.usuarios-asignadores />
      </div>
  </section>

  {{-- <section class="text-gray-600 body-font">
    <div class="container px-5 py-12 mx-auto">
      <div class="text-center mb-8">
        <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4">Indicadores</h1>
        <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">Estados de los reportes.</p>
        <div class="flex mt-6 justify-center">
          <div class="w-16 h-1 rounded-full bg-indigo-500 inline-flex"></div>
        </div>
      </div>
      <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6">
        <div class="p-4 md:w-1/4 flex flex-col text-center items-center">
          <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"> <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /> </svg>
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Numero de reportes recien subidos</h2>
            <p class="leading-relaxed text-base">
                Los reportes que apenas fueron cargados del archivo en excel, enviado por sura.
            </p>
            <a wire:poll.2000ms class="mt-3 text-indigo-500 inline-flex items-center text-2xl">{{ $NumReportesSubidos }}
            </a>
          </div>
        </div>
        <div class="p-4 md:w-1/4 flex flex-col text-center items-center">
          <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-5 flex-shrink-0">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24"> <circle cx="6" cy="6" r="3"></circle> <circle cx="6" cy="18" r="3"></circle> <path d="M20 4L8.12 15.88M14.47 14.48L20 20M8.12 8.12L12 12"></path> </svg>
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Numero de reportes diligenciados</h2>
            <p class="leading-relaxed text-base">
                Reportes que ya fueron tramitados por un <b>asesor</b> y esperan su validacion por parte de un <b>asesor</b>
            </p>
            <a class="mt-3 text-indigo-500 inline-flex items-center text-2xl">{{ $NumReportesDiligenciados }}
            </a>
          </div>
        </div>

        <div class="p-4 md:w-1/4 flex flex-col text-center items-center">
          <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-red-100 text-red-500 mb-5 flex-shrink-0">
            <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Numero de reportes rechazados</h2>
            <p class="leading-relaxed text-base">
                Luego de validar la informacion, se consideró, con su debida justificación, que el reporte era invalido.
            </p>
            <a class="mt-3 text-indigo-500 inline-flex items-center text-2xl">{{ $NumReportesRechazados }}
            </a>
          </div>
        </div>

        <div class="p-4 md:w-1/4 flex flex-col text-center items-center">
          <div class="w-20 h-20 inline-flex items-center justify-center rounded-full bg-green-100 text-green-500 mb-5 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
            </svg>
            
          </div>
          <div class="flex-grow">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">Numero de reportes aceptados</h2>
            <p class="leading-relaxed text-base">
                Luego de todo el proceso, y ser aprobados por el asignador/validador exitosamente.
            </p>
            <div class="inline-flex">
              <a class="mt-3 text-indigo-500  block items-center w-64 text-2xl">{{ $NumReportesAceptados }}
            </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
</div>