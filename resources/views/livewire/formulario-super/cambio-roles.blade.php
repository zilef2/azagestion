<div>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-5 mx-auto" >
            <div class="flex flex-col text-center w-full mb-8" >
                <h1 class="sm:text-3xl text-2xl font-medium title-font my-4 text-gray-900">
                    Cambio de roles para los usuarios del sistema
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
                    Esta página muestra los usuarios registrados en el sitio web y proporciona la única funcionalidad
                    para eliminarlos si no tienen órdenes asociadas.
                </p>
                <div class="mx-auto my-1 relative flex flex-wrap justify-center items-center">
                    <svg class="w-6 h-6 mr-2 mt-2 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>
                    <input type="text" wire:model.defer="searchTerm" wire:keydown.enter="actualizarUsuarios" placeholder="Buscar por correo o nombre..."
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
                                Nombre / Correo
                            </th>
                            {{-- <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Ordenes asiganadas </th> --}}
                            {{-- <th scope="col" class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Cedula / Celular </th> --}}
                            <th scope="col"
                                class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rol </th>
                            <th scope="col"
                                class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Editar Rol </th>
                            <th scope="col"
                                class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Editar Admin </th>
                            <th scope="col"
                                class="px-6 md:px-2 sm:px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Guardar/Eliminar </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $key => $value)
                            <tr wire:loading.class="opacity-50 bg-200">
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $value['name'] }}
                                                @if ($value['is_admin'])
                                                    {{ $value['is_admin'] == 1 ? '✅' : '' }}
                                                @endif
                                            </div>
                                            <div class="hover:bg-slate-300 text-sm text-gray-500">
                                                {{ $value['email'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $value['rol']['nombre'] }}</div>
                                </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="p-1 w-full">
                                        <div class="relative">
                                            <select wire:model.lazy="rolSeleccionado.{{ $value['id'] }}"
                                                id="s{{ $value['id'] }}"
                                                class="form-select form-select-md mt-2 appe arance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                aria-label="form-select-lg">
                                                <option>Cambiar</option>
                                                @forelse($TodosLosRoles as $generico)
                                                    @if ($generico['id'] === $value['rol_id'])
                                                        <option value="{{ $generico['id'] }}" class="capitalize"
                                                            selected>
                                                            {{ $generico['nombre'] }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $generico['id'] }}" class="capitalize">
                                                            {{ $generico['nombre'] }}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option class="capitalize" value="" selected>No hay
                                                        registros
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="p-1 w-full">
                                        <div class="relative">
                                            <select wire:model.lazy="adminSeleccionado.{{ $value['id'] }}"
                                                class="form-select form-select-md mt-2 appe arance-none block w-full px-4 py-2 text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                aria-label="form-select-lg">
                                                <option selected class="capitalize"> Cambiar </option>
                                                <option value="0" class="capitalize"> No Admin </option>
                                                <option value="1" class="capitalize"> Admin </option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 md:px-2 sm:px-1 py-4 whitespace-nowrap">
                                    <div class="mt-4 flex px-1 content-center justify-center">
                                        @if ($adminSeleccionado)
                                            <button
                                                wire:click="adminActualizado({{ $value['id'] }}, {{ reset($adminSeleccionado) }})"
                                                class="hover:bg-blue-500 text-black text-lg border-4 p-1 rounded-full focus:outline-none focus:border-gray-300 transition">
                                                Guardar
                                            </button>
                                        @endif
                                        @if ($rolSeleccionado)
                                            <button
                                                wire:click="rolActualizado({{ $value['id'] }}, {{ reset($rolSeleccionado) }})"
                                                class="hover:bg-blue-500 text-black text-lg border-4 p-1 rounded-full focus:outline-none focus:border-gray-300 transition">
                                                Guardar
                                            </button>
                                        @else
                                            @if (!$adminSeleccionado)
                                                <button wire:click="eliminarUser({{ $value['id'] }})"
                                                    class="hover:bg-blue-500 text-black text-lg border-4 p-1 rounded-full focus:outline-none focus:border-gray-300 transition">
                                                    Eliminar
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 md:px-2 sm:px-1 py-4">
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
