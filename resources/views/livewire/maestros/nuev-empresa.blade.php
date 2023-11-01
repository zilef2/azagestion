<div>
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-gray-900">{{ $mensajeTitular }}</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base"></p>
            </div>
            <form wire:submit.prevent="submit">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div>
                        @if (Session::has('message'))
                            <div class="bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if (session()->has('messageError'))
                            <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-green-700 mb-3" role="alert">
                                {{ session('messageError') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap -m-2">
                        @foreach ($losInputs as $generico)
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="{{ $generico['variable'] }}"
                                        class="leading-7 text-sm text-gray-600">{{ $generico['variableLegible'] }}</label>
                                    <input wire:model="{{ $generico['variable'] }}"
                                        type="{{ $generico['tipoVariable'] }}" id="{{ $generico['variable'] }}"
                                        name="{{ $generico['variable'] }}"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-wrap mt-12">
                        <div class="p-2 w-1/2">
                            <button type="submit"
                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Guardar</button>
                        </div>
                        <div class="p-2 w-1/2">
                            <button wire:click="justBack" type="button"
                                class="flex mx-auto text-white bg-black border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">Atrás</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="text-gray-600 body-font relative">
        <div class="grid container px-5 py-6 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="place-content-center sm:text-3xl text-2xl font-medium title-font mb-1 text-gray-900">
                    {{ $mensajeTabla }}</h1>
            </div>
            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <tr>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-300 rounded-tl rounded-bl">
                            nombre</th>
                    </tr>
                    @forelse ($todas as $imprimiendo)
                        <tr>
                            @foreach ($losAtributos as $item)
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{ $imprimiendo->$item }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td>No hay registros</td>
                        </tr>
                    @endforelse
                </table>
                <button wire:click="justBack" type="button"
                    class="text-white bg-black border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">Atrás</button>
            </div>
        </div>
    </section>
</div>
