<?php

namespace App\Jobs;

use App\helpers\Myhelp;
use App\Mail\OrdenesCompraMail;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DailyFunctionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Myhelp::EscribirEnLog($this);
        Mail::to('alejofg2@gmail.com')->send(new OrdenesCompraMail(
            "Funcion diaria correcta",
            "Funcion diaria funcionando correctamente"
        ));

        // $backupFileName = 'backup_' . Carbon::now()->format('YmdHis') . '.sql';
        // $backupFilePath = storage_path('app/' . $backupFileName);

        // // Realizar la copia de seguridad de la base de datos
        // exec("mysqldump -u {nombre_de_usuario} -p{contraseña} {nombre_de_la_base_de_datos} > {$backupFilePath}");

        // // Enviar el correo electrónico con la copia de seguridad adjunta
        // Mail::raw('Adjunto encontrarás la copia de seguridad de la base de datos.', function ($message) use ($backupFilePath) {
        //     $message->to('destinatario@example.com')->subject('Copia de seguridad de la base de datos');
        //     $message->attach($backupFilePath);
        // });

        // // Eliminar el archivo de copia de seguridad después de enviarlo por correo
        // unlink($backupFilePath);

        // $this->info('Database backup created and sent successfully.');
    }
}
