<?php

namespace App\Http\Livewire\TablaActions;

use App\helpers\Myhelp;
use App\Mail\OrdenesCompraMail;
use Livewire\Component;
use App\Models\Clasificacion;

use App\Models\Empresa;
use App\Models\Municipios;
use App\Models\OrdenCompra;
use App\Models\Tarea;
use Livewire\WithFileUploads;
use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ActionRechazadosAceptadosRevisor extends Component {

    use WithFileUploads;

    public $adjunto, $codigo, $observaciones,$horas,$fechaOrden,$siOno,$siNoMensaje,$fecha_ejecucion,$bancohoras; //inputs
        public $reporte,$ordenRevisar,$Array_usuario_AND_Mail;
        //pure models
        public $losSelect,$codigoid,$codigosPendientes;
        public $tareas,$empresas,$clasificacions,$municipios;
        public $tareaid,$empresasid,$clasificacionid,$municipio;
        public $esCapacitacion; //necesita pdf
        public $HayObservaciones = true; //necesita pdf
        public $photo,$correoDelUsuario;

        //solo de aceptadosRevisor
        public $isImage, $elPDF,$original_filename,$justificacion;

        //mensajes
        public $mensajeError ='',$progress = 0,$mensajeError2 = '';
    //horas acumuladas y restantes
    public $horasAcumuladas,$MaxHoras,$novedad,$horasAprobadas;
    public $pendiente = 0;

    public function mount($id){
        Myhelp::EscribirEnLog($this);

        $this->reporte = Reporte::find($id);
        $ordenId = $this->reporte->orden_compra_id;
        $this->ordenRevisar = OrdenCompra::find($ordenId);
        $OrdenUser = OrdenCompra_User::Where('orden_compra_id',$ordenId)->pluck('user_id');
        $Array_usuario_AND_Mail = User::find($OrdenUser->first());
        $this->Array_usuario_AND_Mail = [$Array_usuario_AND_Mail->name, $Array_usuario_AND_Mail->email];
        $this->correoDelUsuario = $Array_usuario_AND_Mail->email;
        if($this->reporte->aprobado == 1 || $this->reporte->aprobado == 2){ //la orden tiene que ser diligenciada
                /* aprobado = 0 no se ha diligenciado
                    aprobado = 1 se dilingencio
                    aprobado = 2 se aprobo por el revisor
                    aprobado = 3 rechazo por el revisor
                    aprobado = 4 aprobado por completo
                 */
            $this->empresas = Empresa::all();
            $this->tareas = Tarea::all();
            $this->clasificacions = Clasificacion::all();
            $this->municipios = Municipios::all();

            $this->codigoid = $this->ordenRevisar->id;
            $this->tareaid = $this->ordenRevisar->tarea_id;
            $this->empresasid = $this->ordenRevisar->empresa_id;
            $this->clasificacionid = $this->ordenRevisar->clasificacion_id;

            $this->fechaOrden =  $this->ordenRevisar->fecha;

            //reporte
            $this->municipio = $this->reporte->municipio_id;
            $this->HayObservaciones = true;
            if($this->reporte->observaciones == ''){
                $this->HayObservaciones = false;
            }
            $this->observaciones = $this->reporte->observaciones;

            $this->siOno =  $this->reporte->{"requiere_transporte"};
            $this->horas = $this->reporte->horas;
            $this->bancohoras = $this->reporte->bancohoras;
            $this->fecha_ejecucion = $this->reporte->fecha_ejecucion;
            $this->esCapacitacion = $this->ordenRevisar->clasificacion_id == 2;

            $this->isImage=false;
            $this->elPDF = 'public/filesOrdenesCompra/'.$this->reporte->adjunto;
            $this->original_filename =  $this->reporte->getPDF();
            // ->getClientOriginalName();

            //reporte
            $reporte = Reporte::where('orden_compra_id',$ordenId);
            $this->horasAcumuladas = $reporte->sum('horas');
            $this->MaxHoras = floatval($this->ordenRevisar->horasaprobadas - $this->horasAcumuladas);
            if($this->horasAcumuladas == 0) $this->horasAcumuladas = '0';
            if(floatval($this->MaxHoras) <= 0){
                $this->mensajeError2 = 'Esta orden, ya cumplió con las horas aprobadas';
            }
        }else{
            $this->mensajeError= 'La orden ya fue enviada para su corrección';
        }
    }


    public function RechazarEstaOrden(){
        Validator::make(['justificacion' => $this->justificacion],[
            'justificacion' => 'required|min:1|max:254',
        ])->validate();

        $this->validate([ 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);//2MB
        $EstadoRechazo = 0;
        try{
            $destino = $this->Array_usuario_AND_Mail[1];
            Myhelp::EscribirEnLog($this);
            $esdeTest = substr($destino, -9) === "@test.com";
            if($esdeTest){
                session()->flash('messageError', 'No fue posible realizar la operación. '.$destino.' no es una dirección de correo valida');
                Myhelp::EscribirEnLog($this, ' se intento enviar un correo electronico a '.$destino);
            }else{
                $domain = substr(strrchr($destino, "@"), 1);
                if (strpos($domain, '.') === false || substr($domain, -1) === '.') {
                    session()->flash('messageError', 'No fue posible realizar la operación. '.$destino.' no es una dirección de correo valida');
                    Myhelp::EscribirEnLog($this, 'se intento enviar un correo electronico a que temrina en punto o no tiene un dominio valido '.$destino);
                }else{

                    if($this->photo){
                        $laFoto = $this->photo->store('imagenesSubidas','public');
                        $this->reporte->update([
                            'aprobado' => 3, //rechazado
                            'justificacion' => $this->justificacion,
                            'photo' => $laFoto,
                        ]);

                    }else{
                        $this->reporte->update([
                            'aprobado' => 3, //rechazado
                            'justificacion' => $this->justificacion,
                        ]);

                    }
                    $EstadoRechazo = 1;
                    Myhelp::EscribirEnLog($this,' Se rechazó la orden correctamente, falta enviar el correo');
                }
            }
        } catch (\Throwable $th) {
            Myhelp::EscribirEnLog($this,'',1,$th);
            session()->flash('messageError', 'No fue posible realizar la operación');
        }

        try{

            if (app()->environment() === 'production') {
                Mail::to($destino)->send(new OrdenesCompraMail(
                    "Orden #" . $this->ordenRevisar->codigo . " ha sido rechazada",
                    "Señor(a) " . $this->Array_usuario_AND_Mail[0] . ", la orden #" . $this->ordenRevisar->codigo . " ha sido rechazada",
                ));
            }

            if($EstadoRechazo === 1){
                if (app()->environment() === 'test') {
                    session()->flash('message', 'Operacion correcta, no se envio correo '.$destino);

    //                Mail::to($destino)->send(new OrdenesCompraMail(
    //                    "Prueba con la orden #" . $this->ordenRevisar->codigo . " ",
    //                    "Esto es una prueba, Señor(a) " . $this->Array_usuario_AND_Mail[0] . ", la orden #" . $this->ordenRevisar->codigo . " ",
    //                ));
                }else{
                    session()->flash('message', 'Correo enviado a la dirección '.$destino);

                }
                (new Myhelp)->redirect('/RechazadosAceptadosRevisor');
            }
        } catch (\Throwable $th) {
            Myhelp::EscribirEnLog($this,'',1,$th);
            session()->flash('messageError', 'No fue posible enviar el correo');
        }
    }

    public function novedadOrden(){
        Validator::make(
            [
                'novedad' => $this->novedad,
                'horasAprobadas' => $this->horasAprobadas,
            ],
            [
                'novedad' => 'required|min:1|max:254',
                'horasAprobadas' => 'required',
            ]
        )->validate();

        try{
            $envioDePrueba = false;
            $destino = $this->Array_usuario_AND_Mail[1];
            Myhelp::EscribirEnLog($this,' Se intento enviar correo. Destinatario: '.$destino);
            $esdeTest = substr($destino, -9) === "@test.com";
            if($esdeTest){
                // session()->flash('messageError', 'No fue posible realizar la operación. '.$destino.' no es una dirección de correo valida');
                $envioDePrueba = true;
            }
            // else{
                $domain = substr(strrchr($destino, "@"), 1);
                if (strpos($domain, '.') === false || substr($domain, -1) === '.') {
                    // session()->flash('messageError', 'No fue posible realizar la operación. '.$destino.' no es una dirección de correo valida');
                    $envioDePrueba = true;
                }
                // else{
                    $this->reporte->update([
                        'aprobado' => 2, //pendiente
                        'justificacion' => 'Novedad: '.$this->novedad,
                        'aprobadas' => $this->horasAprobadas
                    ]);

                    if(!$envioDePrueba){
                        Mail::to($destino)->send(new OrdenesCompraMail(
                            "Orden #".$this->ordenRevisar->codigo." se ha puesto como pendiente",
                            "Señor(a) ".$this->Array_usuario_AND_Mail[0].", la orden #".$this->ordenRevisar->codigo." tiene una novedad. ".
                            $this->novedad
                        ));
                        Myhelp::EscribirEnLog($this);
                        session()->flash('message', 'Novedad enviada a '.$destino);
                    }else{
                        session()->flash('message', 'Novedad no se envio a '.$destino. ' ya que es un correo inexistente');
                    }

                    (new Myhelp)->redirect('/RechazadosAceptadosRevisor');
                // }
            // }
        } catch (\Throwable $th) {
            Myhelp::EscribirEnLog($this,'',1,$th);
            session()->flash('messageError', 'No fue posible realizar la operación');
        }
    }

    protected $rules = [
        // 'codigo' => 'required|unique:orden_compras',
        // 'adjunto' => 'file|mimes:pdf',
        'horas' => 'integer|required',
        'fechaOrden' => 'required',
        'municipio' => 'required',
        'justificacion' => 'required|min:1|max:254'
    ];

    public function justBack() { return redirect()->to('dashboard'); }

    public function isAPendiente(){
        $this->pendiente = 1;
    }
    public function isARechazo(){
        $this->pendiente = 2;
    }

    public function render()
    {
        $this->codigosPendientes = OrdenCompra::all();
        return view('livewire.tabla-actions.action-rechazados-aceptados-revisor');
    }
}
