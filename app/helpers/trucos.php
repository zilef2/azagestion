# se retiro del archivo resource/views/layout/app.blade
<script src="{{ mix('/js/livewire.js') }}" defer></script>


<!--  env -> enviroment -->
if (app()->environment() !== 'production') {

<!--  npm -->
<!-- You'll need to install this package globally as it manages the Node versions at the root. -->
npm install -g npm@latest
npm install -g n

Install a new version of Node
n lts

<!-- linux -->
    <!-- borrar -->
        rm -r "direccion"
    <!-- permisos recursivamente -->
        chmod a+rwx folder_name -R
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/storage
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/public
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/config
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/routes
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/resources/views/livewire/vistas
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/app/http/Livewire/Vistas
        chmod -R 775 /home/aplicativoswebco/public_html/azasegu/app/Http/Livewire/Vistas

        chmod -R o+w /home/aplicativoswebco/public_html/azasegu/storage
        chmod -R o+w /home/aplicativoswebco/public_html/azasegu/public
        
        chmod -R 775 /home/aplicativoswebco/public_html/registron/storage
        chmod -R 775 /home/aplicativoswebco/public_html/registron/public
        chmod -R 775 /home/aplicativoswebco/public_html/registron/bootstrap
        chmod -R 775 /home/aplicativoswebco/public_html/registron/app