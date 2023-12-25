<?php

use App\Exports\BDExport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\excelupload;

// Route::get('/', function () { return view('welcome'); });
Route::get('/', function () { return redirect('/login'); });

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    // Vistas welcome
        //asignador
        Route::get('WelcomeAsignador', '\App\Http\Livewire\Vistas\WelcomeAsignador')->name('WelcomeAsignador')->middleware(['auth', 'revisor']);
        Route::any('SubirOrdenesDeCompra', '\App\Http\Livewire\Vistas\SubirOrdenesDeCompra')->name('SubirOrdenesDeCompra')->middleware(['auth', 'revisor']);
        Route::any('SubirExcelGeneral', '\App\Http\Livewire\Debug\SubirExcelGeneral')->name('SubirExcelGeneral')->middleware(['auth', 'revisor']);


        Route::get('SubirUsuarios', '\App\Http\Livewire\Vistas\SubirUsuarios')->name('SubirUsuarios')->middleware(['auth', 'revisor']);
        Route::get('TodasLasOrdenes', '\App\Http\Livewire\Vistas\TodasLasOrdenes')->name('TodasLasOrdenes')->middleware(['auth', 'admin']);
        Route::get('CambioRoles', '\App\Http\Livewire\FormularioSuper\CambioRoles')->name('CambioRoles')->middleware(['auth', 'revisor']);
        // Route::get('CambioRoles', '\App\Http\Livewire\FormularioSuper\CambioRoles')->name('CambioRoles')->middleware(['auth', 'revisor']);
        //asesor
        Route::get('WelcomeAsesor', '\App\Http\Livewire\Vistas\WelcomeAsesor')->name('WelcomeAsesor');

        Route::get('OrdenesNuevas', '\App\Http\Livewire\Vistas\OrdenesNuevas')->name('OrdenesNuevas');
        Route::get('OrdenesPorcorrejir', '\App\Http\Livewire\Vistas\OrdenesPorcorrejir')->name('OrdenesPorcorrejir');
    // fin Vistas welcome
    // 300-mod_evasive.conf disabled -- develmod_evasive
        Route::get('ordenesRechazadas', '\App\Http\Livewire\OrdenesRechazadas')->name('ordenesRechazadas')->middleware(['auth', 'revisor']);

        // Route::post('FormNuevaOrden', '\App\Http\Livewire\FormNuevaOrden');
        Route::get('FormNuevaOrden', '\App\Http\Livewire\FormNuevaOrden')->name('FormNuevaOrden');
        // Route::match(['get','post'], '\App\Http\Livewire\FormNuevaOrden')->name('FormNuevaOrden');

        Route::get('cambiarAsignacion', '\App\Http\Livewire\Tablas\CambiarAsignacion')->name('cambiarAsignacion')->middleware(['auth', 'revisor']);
        Route::get('TablaCambiarAsignacion', '\App\Http\Livewire\Tablas\TablaCambiarAsignacion')->name('TablaCambiarAsignacion')->middleware(['auth', 'revisor']);
        Route::get('ActionEditarAsignacion/{id}', '\App\Http\Livewire\TablaActions\ActionEditarAsignacion')->name('ActionEditarAsignacion')->middleware(['auth', 'revisor']);

        Route::get('TablaReportesAsesorAceptadas', '\App\Http\Livewire\Tablas\TablaReportesAsesorAceptadas')->name('TablaReportesAsesorAceptadas')->middleware(['auth', 'revisor']);

        //revisor | asignador
        Route::get('RechazadosAceptadosRevisor', '\App\Http\Livewire\Tablas\RechazadosAceptadosRevisor')->name('RechazadosAceptadosRevisor')->middleware(['auth', 'revisor']);
        Route::get('tablaRechazadosAceptadosRevisor', '\App\Http\Livewire\Tablas\TablaRechazadosAceptadosRevisor')->name('tablaRechazadosAceptadosRevisor')->middleware(['auth', 'revisor']);
        Route::get('ActionRechazadosAceptadosRevisor/{id}', '\App\Http\Livewire\TablaActions\ActionRechazadosAceptadosRevisor')->name('ActionRechazadosAceptadosRevisor')->middleware(['auth', 'revisor']);
        Route::post('ActionRechazadosAceptadosRevisor/{id}', '\App\Http\Livewire\TablaActions\ActionRechazadosAceptadosRevisor')->middleware(['auth', 'revisor']);

        Route::get('TablaRegistrosAceptados', '\App\Http\Livewire\Tablas\TablaRegistrosAceptados')->name('TablaRegistrosAceptados')->middleware(['auth', 'revisor']);
        Route::get('VerAdjunto/{id}', '\App\Http\Livewire\Ultimasvistas\VerAdjunto')->name('VerAdjunto')->middleware(['auth', 'revisor']);
        //asesor
        Route::get('ActionRechazadosAsesor/{id}', '\App\Http\Livewire\TablaActions\ActionRechazadosAsesor')->name('ActionRechazadosAsesor');


    //exportPDF (version original, y de pruebas)
        Route::get('RangoOrdenesCompra', '\App\Http\Livewire\ExportPdf\RangoOrdenesCompra')->name('RangoOrdenesCompra')->middleware(['auth', 'revisor']);

        Route::get('RangoOrdenesSoporte', '\App\Http\Livewire\ExportPdf\RangoOrdenesSoporte')->name('RangoOrdenesSoporte')->middleware(['auth', 'revisor']);
        Route::get('PendientesAprobadas', '\App\Http\Livewire\Ultimasvistas\PendientesAprobadas')->name('PendientesAprobadas')->middleware(['auth', 'revisor']);
        Route::get('CompletamenteAprobadas', '\App\Http\Livewire\Ultimasvistas\CompletamenteAprobadas')->name('CompletamenteAprobadas')->middleware(['auth', 'revisor']);
        Route::get('Logviez', '\App\Http\Livewire\Ultimasvistas\Logviez')->name('Logviez')->middleware(['auth', 'revisor']);
        Route::get('eliminarOrdenesCompra', '\App\Http\Livewire\Ultimasvistas\EliminarOrdenesCompra')->name('eliminarOrdenesCompra')->middleware(['auth', 'revisor']);

    //super
        Route::get('NuevTarea', '\App\Http\Livewire\Maestros\NuevTarea')->name('NuevTarea')->middleware(['auth', 'admin']);
        Route::get('NuevClasificacion', '\App\Http\Livewire\Maestros\NuevClasificacion')->name('NuevClasificacion')->middleware(['auth', 'admin']);
        Route::get('NuevEmpresa', '\App\Http\Livewire\Maestros\NuevEmpresa')->name('NuevEmpresa')->middleware(['auth', 'admin']);
        Route::get('NuevRol', '\App\Http\Livewire\Maestros\NuevRol')->name('NuevRol')->middleware(['auth', 'admin']);
        Route::get('NuevasFunciones', '\App\Http\Livewire\Practice\NuevasFunciones')->name('NuevasFunciones')->middleware(['auth', 'admin']);


    //# Actualizacion unica
        Route::match(['get','post'],'ActualizacionDBDiciembre', '\App\Http\Livewire\Internal\ActualizacionDBDiciembre')->name('ActualizacionDBDiciembre')->middleware(['auth', 'admin']);
        Route::post('ActualizacionDBDiciembre2', [excelupload::class, 'ActualizacionDBDiciembre2'])
            ->name('upload.desactualizadas')->middleware(['auth', 'admin']);


        //        Route::any('ActualizacionDBDiciembre', '\App\Http\Livewire\Internal\ActualizacionDBDiciembre')->name('ActualizacionDBDiciembre')->middleware(['auth', 'admin']);

        Route::get('todaBD', function(){
            return (new BDExport())->download('todaLaBaseDeDatos.xlsx');
        })->name('todaBD')->middleware(['auth', 'admin']);


    //tutorial
        Route::get('TutorialDash', '\App\Http\Livewire\Tutorial\TutorialDash')->name('TutorialDash');
});


// <editor-fold desc="Artisan">
    Route::get('/foo', function () {
        if (file_exists(public_path('storage'))){
            return 'Ya existe';
        }
        App('files')->link(
            storage_path('App/public'),
            public_path('storage')
        );
        return 'Listo';
    });

    Route::get('/clear-c', function () {
        // Artisan::call('optimize');
        Artisan::call('optimize:clear');
        return "Optimizacion finalizada";
        // throw new Exception('Optimizacion finalizada!');
    });

    Route::get('/tmantenimiento', function () {
        echo Artisan::call('down --secret="token-it"');
        return "Aplicación abajo: token-it";
    });
    Route::get('/Arriba', function () {
        echo Artisan::call('up');
        return "Aplicación funcionando";
    });
    Route::get('/pendiente-pass', function () {
        echo Artisan::call('queue:work --queue=emails');
        return "Aplicación funcionando";
    });
//</editor-fold>
