<div>

    <section class="text-gray-600 body-font relative">
        <div class="container px-8 py-3 mx-auto">
            <div class="flex flex-col text-center w-full mb-1">
                <p class="w-full lg:w-2/3 mx-auto leading-relaxed text-2xl">Usuarios y Órdenes de compra en el sistema
                </p>
            </div>
            <div class="grid grid-cols-1">
                <livewire:tablas.tabla-usuario-y-orden limitante=0 />
            </div>
        </div>
    </section>


    @if(auth()->user()->is_admin > 0)
        <div class="p-2 w-full pt-8 mt-8 border-t border-gray-200 text-center" >
            <p class="leading-normal my-5"><b class="text-lg font-semibold">Recuerde</b> que la informacion borrada no podrá ser recuperada </p>
            <div class="mx-auto p-2">
                <a href="{{ route('eliminarOrdenesCompra') }}"
                    class="w-32 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                    Eliminar OC/OS
                </a>
            </div>
        </div>
    @endif
</div>
