<div class="text-gray-600 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-12">

            {{-- como diligenciar una OC --}}
            {{-- como borrar una OC --}}
            {{-- como editar una OC --}}
            {{-- como saber si me aceptaron o rechazaron una OC --}}
            {{-- como  una OC --}}
            @if($isAsignador)
                @foreach ($links as $explicacion => $link)
                    <div class="p-12 md:w-1/2 flex flex-col items-start">
                        <span class="inline-block py-1 px-2 rounded bg-indigo-50 text-indigo-500 text-lg font-medium tracking-widest">Asignador</span>
                        <h2 class="sm:text-3xl text-2xl title-font font-medium text-gray-900 mt-4 mb-4">
                            Repaso general de las funciones del asignador
                        </h2>
                        <p class="leading-relaxed mb-8">{{ $explicacion }}</p>
                        <iframe width="560" height="315" src="{{ $link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                        <a class="inline-flex items-center">

                            <span class="flex-grow flex flex-col my-3 pl-4">
                                <span class="title-font font-medium text-gray-900">Opcional</span>
                                <span class="text-gray-400 text-xs tracking-widest mt-0.5">Sugerencia: Verlo cuando se necesite</span>
                            </span>
                        </a>
                    </div>
                @endforeach
            @endif


            <div class="p-12 md:w-full flex flex-col items-start">
                <span class="inline-block py-1 px-2 rounded bg-indigo-50 text-indigo-500 text-lg font-medium tracking-widest">Asesor</span>
                <h2 class="sm:text-3xl text-2xl title-font font-medium text-gray-900 mt-4 mb-4">
                    Repaso general de todas las funciones
                </h2>
                <p class="leading-relaxed mb-4">En el video tutorial, se hace una exploración de todas las funciones que tiene el rol de <b>asesor</b></p>
                <iframe class="w-full h-96" src="https://www.youtube-nocookie.com/embed/sVardUt7-44" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>


                <a class="inline-flex items-center">

                    <span class="flex-grow flex flex-col my-3 pl-4">
                        <span class="title-font font-medium text-gray-900">Obligatorio</span>
                        <span class="text-gray-400 text-xs tracking-widest mt-0.5">Sugerencia: Verlo 1 vez</span>
                    </span>
                </a>
            </div>

        </div>
    </div>
</div>
