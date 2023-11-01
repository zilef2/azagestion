
HTML CSS:(TAILWIND)
    //el welcome de jetstream

        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <x-jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome to your Jetstream application!
            </div>

            <div class="mt-6 text-gray-500">
                Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
                to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
                you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
                ecosystem to be a breath of fresh air. We hope you love it.
            </div>
        </div>

        <!-- ocultar cel y mostrar en landscape -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div class="-mr-2 flex items-center sm:hidden">

BLADE
    <!-- datatable -->
        <div class="p-2 sm:px-10 bg-white border-b border-gray-200">
            <div class="p-2 sm:px-10 bg-white border-b border-gray-200">
                <livewire:datatable model="App\Models\OrdenCompra" exclude="created_at, updated_at,aprobado,adjunto,empresa_id,tarea_id,clasificacion_id,municipio_id" />
            </div>
        </div>





