<?php

namespace App\Http\Livewire;

use App\Models\Clasificacion;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

use App\Models\Empresa;
use App\Models\Municipios;
use App\Models\OrdenCompra;
use App\Models\Tarea;
use App\Models\OrdenCompra_User;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;

class FormNuevaOrden extends Component
{
    use WithFileUploads;
    //vars
        public $adjunto, $codigo, $observaciones,$horas,$fechaOrden,$siOno,$siNoMensaje,$bancohoras; //inputs
        public $laOC_user,$ordenSeleccionada,$ordenSeleccionadaid;
        public $UltimoRegistro;
        //pure models
        public $losSelect,$codigosPendientes,$OrdencodigosPendientes,$fecha_ejecucion;
        public $tareas,$empresas,$clasificacions,$municipios;
        public $tareaid,$empresasid,$clasificacionid,$municipio; //selects
        public $esCapacitacion; //necesita pdf
        //reporte
        public $horasAcumuladas = 0,$MaxHoras;
        //mensajes
        public $mensajeError ='';

        //admin
        public $elUsuario,$NameUserSeleccionado,$isDisabled;
        public $userSeleccionadoid,$ordenBuscada,$UserBuscada; //IDs
        public $UsuariosAsesores,$filtroPendientes=[]; //arrays


    // public $method = ['get', 'post'];

    public function mount(){

        $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);

        $this->elUsuario = Auth::user();

        $UsersAsesor = OrdenCompra_User::All()->pluck('user_id');
        $this->UsuariosAsesores = User::WhereIn('id',$UsersAsesor)->orderby('name')->get();

        if(count($this->UsuariosAsesores) === 0){
            Log::alert('U -> '.Auth::user()->name .'Intento entrar a '.get_class($this).' estando las OC/OS relacionadas a ningun usuario.');
            session()->flash('message', 'No hay usuarios con OC/OS asociados.');
            return redirect()->to('dashboard');
        }
        
        if($this->elUsuario->is_admin){
            log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name );

            $this->userSeleccionadoid = $this->UsuariosAsesores->first()->id;
            $this->NameUserSeleccionado = User::find($this->userSeleccionadoid)->name;
        }else{
            log::info('Vista: ' . $nombreC. ' U: '.Auth::user()->name );

            $this->userSeleccionadoid = $this->elUsuario->id;
            $this->OrdencodigosPendientes = OrdenCompra_User::Where('user_id',$this->elUsuario->id)->pluck('orden_compra_id');
        }

        $this->empresas = Empresa::all();
        $this->tareas = Tarea::all();
        $this->clasificacions = Clasificacion::all();
        $this->municipios = Municipios::all()->sortBy(function ($municipio) {
            return $municipio->nombre == 'Medellín' ? 0 : 1;
        });

        $this->fechaOrden = Carbon::now()->format('Y-m-d');
        $this->siOno = false;
        /*
            aprobado = 0 no se ha diligenciado 
            aprobado = 1 se dilingencio 
            aprobado = 2 se aprobo por el revisor
            aprobado = 3 rechazo por el revisor
            aprobado = 4 aprobado por completo
         */
    }
    public function updateUs() { $this->userSeleccionadoid = intval($this->userSeleccionadoid); }

    //functions user asesor
        public function updatedOrdenSeleccionadaid($propertyName){
            if($this->ordenSeleccionadaid){
                $this->ordenSeleccionada = OrdenCompra::find($this->ordenSeleccionadaid);
                $this->tareaid = $this->ordenSeleccionada->tarea_id;
                $this->empresasid = $this->ordenSeleccionada->empresa_id;
                $this->clasificacionid = $this->ordenSeleccionada->clasificacion_id;
                
                $this->fechaOrden = $this->ordenSeleccionada->fecha;
                $this->siOno = false;
                
                $this->esCapacitacion = $this->ordenSeleccionada->clasificacion_id == 2;
                
                //reporte
                $reporte = Reporte::where('orden_compra_id',$this->ordenSeleccionadaid);
                $this->horasAcumuladas = $reporte->sum('horas');
                if($this->horasAcumuladas == 0) $this->horasAcumuladas = '0';

                $this->MaxHoras = floatval($this->ordenSeleccionada->{'horasaprobadas'}) - floatval($this->horasAcumuladas);
                if(floatval($this->MaxHoras) <= 0){
                    $this->mensajeError = 'Esta orden, ya cumplió con las horas aprobadas';
                }


                if (config('app.env') !== 'production') {
                    $this->fecha_ejecucion = '2023-06-12';
                    $this->municipio = 1;
                    $this->horas = 1;
                    $this->observaciones = 'esto es una prueba '.Carbon::now();
                }
            }
        }

        public function updatedclasificacionid($propertyName) {
            $this->esCapacitacion = $this->clasificacionid == 2;
        }

        public function updated($propertyName) {
            if($this->ordenSeleccionadaid)
                $this->validateOnly($propertyName, [
                    'horas' => 'numeric|max:'.$this->MaxHoras,
                    'fecha_ejecucion' => 'date|before_or_equal:today',

                ]);
        }
        public function updatedAdjunto($propertyName) {
            if ($this->adjunto) {
                $this->validate([
                    'adjunto' => 'file|mimes:pdf' //8MB
                ]);
            }
        }
    //fin functions user asesor

        protected $rules = [
            'ordenSeleccionadaid' => 'required',
            'fecha_ejecucion' => 'required|date|before_or_equal:today',
            'horas' => 'required',
            'municipio' => 'required',
            'observaciones' => 'required|min:1|max:255',
        ];

        public function justBack() { return redirect()->to('dashboard'); }
        public function submitformnueva() {
            $ListaControladoresYnombreClase = (explode('\\',get_class($this))); $nombreC = end($ListaControladoresYnombreClase);
            $this->validate();
            $this->validate([
                'horas' => 'numeric|max:'.$this->MaxHoras,
            ]);
            $horasDisponibles = floatval($this->MaxHoras) - ( floatval($this->horas) );
            // $horasDisponibles = floatval($this->MaxHoras) - ( floatval($this->horas) + floatval($this->horasAcumuladas));
            try{
                if ($this->esCapacitacion) {
                    if ($this->adjunto) {
                        $adj = $this->adjunto->store('filesOrdenesCompra', 'public');
                        // dd($adj);
                        $this->ordenSeleccionada->update([
                            'horasdisponibles' => $horasDisponibles,
                        ]);
                        Reporte::create([
                            'municipio_id' => $this->municipio,
                            'horas' => $this->horas,
                            'fecha_reporte' => Carbon::now(),
                            'fecha_ejecucion' => $this->fecha_ejecucion,
                            'observaciones' => $this->observaciones,
                            'requiere_transporte' => $this->siOno,
                            'aprobado' => 1,//0:recien creado | 1: diligenciado | 2:aceptado | 3: rechazad => $this->o
                            'adjunto' => $adj,
                            'orden_compra_id' => $this->ordenSeleccionada->id,
                            'user_id' => $this->userSeleccionadoid,
                            'bancohoras' => $this->bancohoras,

                            'aprobadas' => 0,
                        ]);

                        Log::debug('En la vista ' . $nombreC . ' El Usuario -> '.Auth::user()->name. ' Diligenció una orden CON adjunto');
                        session()->flash('message', 'Orden de compra y archivo guardados correctamente.');
                        $this->reset();$this->mount();
                    }else{
                        session()->flash('messageError', 'Archivo adjunto es requerido');
                    }
                } else {
                    $this->ordenSeleccionada->update([
                        'horasdisponibles' => $horasDisponibles,
                    ]);
                    Reporte::create([
                        'municipio_id' => $this->municipio,
                        'horas' => $this->horas,
                        'fecha_reporte' => Carbon::now(),
                        'fecha_ejecucion' => $this->fecha_ejecucion,
                        'observaciones' => $this->observaciones,
                        'requiere_transporte' => $this->siOno,
                        'aprobado' => 1,//0:recien creado | 1: diligenciado | 2:aceptado | 3: rechazad => $this->o
                        'orden_compra_id' => $this->ordenSeleccionada->id,
                        'user_id' => $this->userSeleccionadoid,
                        'bancohoras' => $this->bancohoras,
                        'aprobadas' => 0,
                    ]);
                    Log::debug('En la vista ' . $nombreC . ' El Usuario -> '.Auth::user()->name. ' Diligenció una orden SIN adjunto');
                    $this->reset();$this->mount();

                    session()->flash('message', 'Orden de compra guardada correctamente.');
                }
            } catch (\Throwable $th) {
                Log::critical('En la vista ' . $nombreC . ' hay un error. Usuario -> '.Auth::user()->name. $th->getMessage());
                session()->flash('messageError', 'Orden de compra no guardada, error inesperado');
                session()->flash('message', substr($th,6,100));
            }
        }
    //fin - functions user asesor

    public function OrdenBuscadaFunc() {
        if (Cache::has('OrdenBuscadaFunc')) {
            // Button already clicked within the last second
            session()->flash('messageError', 'Muchas peticiones por segundo.');
            return;
        }

        $this->filtroPendientes = OrdenCompra::Where('codigo','LIKE','%'.$this->ordenBuscada.'%')->pluck('id');
        $this->isDisabled = false;

        Cache::put('OrdenBuscadaFunc', true, 4); // 1 second expiration time

    }

    public function funcUserBuscada() {
        $this->UsuariosAsesores = User::Where('name','LIKE','%'.$this->UserBuscada.'%')
            ->whereNotIn('name',['Superadmin','Admin','operator'])->orderby('name')
            ->get();
        $this->NameUserSeleccionado = User::find($this->userSeleccionadoid)->name;
    }

    public function UpdatedUserSeleccionadoid() {
        $this->NameUserSeleccionado = User::find($this->userSeleccionadoid)->name;
    }

    public function render() {
        if($this->elUsuario->is_admin){
            $QueryPendientes = OrdenCompra::Where('estado_tarea',0);
        }else{
            $QueryPendientes = OrdenCompra::WhereIn('id',$this->OrdencodigosPendientes)->where('estado_tarea',0);
        }
        $QueryPendientes->WhereNot('horasdisponibles',0);

        if(!empty($this->filtroPendientes)){
            $QueryPendientes->WhereIn('id',$this->filtroPendientes);
        }else{
            $QueryPendientes->limit(30);
        }
        $this->codigosPendientes = $QueryPendientes->orderby('updated_at','DESC')->get();
        /*
            aprobado = 0 no se ha diligenciado 
            aprobado = 1 se dilingencio
            aprobado = 2 se aprobo por el revisor
            aprobado = 3 rechazo por el revisor
            aprobado = 4 aprobado por completo
         */
        return view('livewire.form-nueva-orden');
    }
}
