    /home/aplicativoswebco/public_html

//mark: uso constante -->
        php artisan migrate:fresh --seed
        composer dump-autoload
        php artisan key:generate

        composer global require laravel/installer
        composer require laravel/jetstream
        composer install && npm install
        //memory limit
            C:\laragon\bin\php\php-7.4.30-Win32-vc15-x64\php.ini
    //fin  install laravel


    //mark: Empezar proyecto --


    // heramientas
        composer require laraveles/spanish
        php artisan laraveles:install-lang
        composer require psr/simple-cache:^1.0 maatwebsite/excel
        composer require mediconesystems/livewire-datatables
        //probando herramientas
            composer require opcodesio/log-viewer
        // npm install @tailwindcss/forms

        // INICIO REQUIRED
            composer global require laravel/installer
            composer require laravel/jetstream
            // laravel new Azasegu --jet
            laravel new Aza7 --jet
        // FIN REQUIRED
        // correr para los assets de livewire
            php artisan livewire:publish --assets (no necesario)
            php artisan vendor:publish --tag=jetstream-views
// FIN
//mark:models
    Php artisan make:model OrdenCompra -mf
    Php artisan make:model OrdenCompra_User -mf
    Php artisan make:model Empresa -mf
    Php artisan make:model Tarea -mf
    Php artisan make:model Clasificacion -mf
    Php artisan make:model Municipios -mf
    Php artisan make:model Roles -mf
    Php artisan make:model Reporte -mf
    Php artisan make:model Historicoc -mf

//middleware
    php artisan make:middleware IsAdmin
    php artisan make:middleware IsRevisor
//vistas livewire

    php artisan make:livewire ElWelcome
    php artisan make:livewire usoGeneral.TodosLosErrores
    php artisan make:livewire OrdenesRechazadas
    php artisan make:livewire TablaOrdenesRechazadas
    php artisan make:livewire FormNuevaOrden
    php artisan make:livewire Practice.NuevasFunciones

    //new maestros
        php artisan make:livewire maestros.NuevClasificacion
        php artisan make:livewire maestros.NuevEmpresa
        php artisan make:livewire maestros.NuevRol
        php artisan make:livewire maestros.NuevTarea
        php artisan make:livewire Logica.Asignacion

    // tablas
        php artisan make:livewire tablaActions
        //SUPERADMIN : cambiar la asociacion entre user y ordenes
        php artisan make:livewire tablas.cambiarAsignacion //la vista
        php artisan make:livewire tablas.tablaCambiarAsignacion //la tabla
        php artisan make:livewire tablaActions.ActionEditarAsignacion //formulario para editar
        //rol: asesor
        php artisan make:livewire tablas.tablaRechazadosAsesor //la tabla
        php artisan make:livewire tablaActions.ActionRechazadosAsesor //formulario para correjir las observaciones


        //rol: asignador
        php artisan make:livewire tablas.RechazadosAceptadosRevisor //la vista
        php artisan make:livewire tablas.tablaRechazadosAceptadosRevisor //la tabla
        {
            php artisan make:livewire tablas.tablaRegistrosAceptados
            php artisan make:livewire tablaActions.ActionRechazadosAceptadosRevisor //formulario para correjir las observaciones
        }

        php artisan make:livewire tablas.tablaUsuarioYOrden //la tabla
        php artisan make:livewire tablas.tablaReportesAsesorAceptadas
        php artisan make:livewire tablas.cambiarHorasAprobadas

        //botones
        php artisan make:livewire Tablas.AceptarOrden
        php artisan make:livewire Tablas.RechazarOrden
        php artisan livewire:delete Tablas.VerPDFOrden
        php artisan make:livewire Tablas.pdfOrden

    //fin tablas

    //vistas iniciales
        //superadmin
        php artisan make:livewire tablas.usuariosAsesores //usuarios-asesores
        php artisan make:livewire formularioSuper.CambioRoles
        //asignador (casi admin )

        php artisan make:livewire vistas.WelcomeAsignador
            php artisan make:livewire vistas.SubirOrdenesDeCompra
            php artisan make:livewire vistas.SubirUsuarios
            php artisan make:livewire vistas.TodasLasOrdenes
            php artisan make:livewire tabla.UsuariosAsignadores

        php artisan make:livewire ultimasvistas.PendientesAprobadas
        php artisan make:livewire ultimasvistas.CompletamenteAprobadas
        php artisan make:livewire ultimasvistas.VerAdjunto
        php artisan make:livewire ultimasvistas.Logviez
        php artisan make:livewire ultimasvistas.eliminarOrdenesCompra


        php artisan make:livewire tutorial.TutorialDash


        //asesor (usuario ordinario)
        php artisan make:livewire vistas.WelcomeAsesor
            php artisan make:livewire vistas.OrdenesNuevas
            php artisan make:livewire vistas.OrdenesPorcorrejir
            //descarga PDF
            php artisan make:livewire exportPdf.RangoOrdenesCompra
            {
                php artisan make:export ReportesExport --model=Reporte
            }
            php artisan make:livewire exportPdf.RangoOrdenesSoporte
            {

            }


    //debugging
    php artisan make:livewire debug.subirExcelGeneral
    //borrados
    <livewire:tablas.rechazados-asesor />

//#--  correo - EXPORT AND IMPORTS
    //CORREO
    php artisan make:mail OrdenesCompraMail

    //#-- excel export

    php artisan make:export EmpresasExport --model=Empresa
    php artisan make:export ReportesExport --model=Reporte
    php artisan make:export SoportesExport --model=Reporte
    php artisan make:export DesconocidosExport --model=User
    php artisan make:export BDExport
    //#-- excel import
    php artisan make:0import OrdenesImport --model=User //usado para importar todo menos los usuarios
    php artisan make:0import RegistrarUsuariosImport --model=User



    // internal
    php artisan make:livewire internal.ActualizacionDBDiciembre




//2 PASOOOOOOOOOOO
    //rol: asesor
    null
    //rol: asignador
        php artisan make:livewire Revisor.usuariosDesconocidos //no se esta usando actualmente
        php artisan make:livewire tablas.tabladesconocidosRevisor //la tabla


