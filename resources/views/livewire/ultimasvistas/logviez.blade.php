<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-8 mx-auto">
            <div class="container px-5 py-4 mx-auto">
                <div class="flex flex-col text-center w-full mb-2">
                  <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-1">ROOF PARTY POLAROID</h2>
                  <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Master Cleanse Reliac Heirloom</h1>
                  <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them man bun deep jianbing selfies heirloom prism food truck ugh squid celiac humblebrag.</p>
                </div>
            </div>


            <div class="flex flex-wrap -mx-4 -mb-10 text-center">


                <div class="sm:w-1/2 mb-10 px-4">
                    <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">Horas log</h2>
                    <div class="flex lg:w-2/3 w-full flex-wrap mx-auto px-8">
                        <div class="w-full m-2 px-2">
                            <label for="ini" class="leading-7 text-sm text-gray-600">Fecha inicial</label>
                            <input type="date" wire:model="fechaini" id="ini" name="ini" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                    </div>
                    <p class="leading-relaxed text-base">
                        <b>{{ $minHour }}</b> - {{ $minLine }}
                    </p>
                    <p class="leading-relaxed text-base">
                        <b>{{ $maxHour }}</b> - {{ $maxLine }}
                    </p>
                    <button
                        class="flex mx-auto mt-6 text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded">
                        Button
                    </button>
                    <ul>
                        @foreach($todosLosDeHoy as $key => $value)
                            <li class="my-2 text-sm">
                                {{ $value }}
                            </li>
                        @endforeach
                    </ul>
                </div>


                <div class="sm:w-1/2 mb-10 px-4">
                    <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">Solo formnuevaorden</h2>
                    <p class="leading-relaxed text-base">Lectura de los usuarios que reportan</p>
                    <ul>
                        @forelse($nuevaOrden as $key => $value)
                            <li class="my-2 text-sm">
                                {{ $value }}
                            </li>
                            @empty
                            <p class="text-lg">Sin registros con la palabra "Diligenció"</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
