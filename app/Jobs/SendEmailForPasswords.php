<?php

namespace App\Jobs;

use App\Mail\OrdenesCompraMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailForPasswords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $listaPendiente;
    protected $ContarListaPendiente;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$listaPendiente,$ContarListaPendiente) {
        $this->user = $user;
        $this->listaPendiente = $listaPendiente;
        $this->ContarListaPendiente = $ContarListaPendiente;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        Mail::to('ajelof2@gmail.com')->send(new OrdenesCompraMail(
            'un usuario cambio su contraseña',
            $this->user->email. ' ha cambiado su contrasena. Quedan por cambiar '.$this->ContarListaPendiente.' contrasenas: '.$this->listaPendiente
        ));
    }
}
