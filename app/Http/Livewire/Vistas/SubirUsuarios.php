<?php
namespace App\Http\Livewire\Vistas;

use App\Exports\DesconocidosExport;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\RegistrarUsuariosImport;
use App\Models\OrdenCompra_User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SubirUsuarios extends Component
{
    use WithFileUploads;

    public $errora = 0,$failures,$ListaErrores;//manejo de errores
    public $archivoExcelSubir;
    public $haydesconocidos, $nombreArchivoRegisterUser ="No hay archivo";

    public function elLog($nombreFuncion, $comentario = '',$tipo = ''){
        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);
        if(Auth::User()->is_admin > 0) {
            Log::channel('eladmin')->info('Vista:' . $nombreC. '|  U:'.Auth::user()->name.'');
        }else{
            if ($comentario === '') {
                log::info('Vista -> ' . $nombreC . ' U:'.Auth::user()->name . ' Funcion ->'. $nombreFuncion);
            } else {
                if($tipo == 'alert') {
                    log::alert('Vista -> ' . $nombreC . ' U:'.Auth::user()->name . ' Funcion ->'. $nombreFuncion. ' :: '.$comentario);
                } else {
                    if($tipo == 'critical') {
                        log::critical('Vista -> ' . $nombreC . ' U:'.Auth::user()->name . ' Funcion ->'. $nombreFuncion. ' :: '.$comentario);
                    } else {
                        log::info('Vista -> ' . $nombreC . ' U:'.Auth::user()->name . ' Funcion ->'. $nombreFuncion. ' :: '.$comentario);
                    }
                }
            }
        }
    }

    public function mount(){
        $this->elLog(__FUNCTION__);

        $this->haydesconocidos = count(User::Where('email','like','%UsuarioDescono%')->get()) > 0;
    }

    public function EditarUsdesconocidos(){ return redirect()->to('dashboard'); }

    public function updatedArchivoExcelSubir() {
        $Kilobytes = intval(($this->archivoExcelSubir->getSize())/1024);
        if($Kilobytes > 2048){
            session()->flash('messageError', 'El Archivo es demasiado pesado, debe ser menor a 2MB');
            $this->reset();
        };
    }



    public function exportDes() {
        $this->elLog(__FUNCTION__, 'Se comenzo el proceso para descargar los usuarios desconocidos','info');
        
        return Excel::download(new DesconocidosExport, 'Asesores_Desconocidos.xlsx');
    }

    public function importUs() {
        $this->validate([
            'archivoExcelSubir' => 'max:2048', // 2MB Max
        ]);
        $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
        $nombreC = end($ListaControladoresYnombreClase);

        set_time_limit(120);//2min
        DB::beginTransaction();
        try {
            $ListaControladoresYnombreClase = (explode('\\',get_class($this)));
            
            $import = new RegistrarUsuariosImport();
            $import->import($this->archivoExcelSubir);
            $this->ListaErrores = [];
            $this->failures = "";


            $users = User::all();
            $usersUnique = $users->unique(['name']);
            $userDuplicates = $users->diff($usersUnique);
            $conteo = count($userDuplicates);

            if ($conteo === 0) {
                DB::commit();
                $this->elLog(__FUNCTION__, 'subio usuarios sin duplicados','info');

                Log::info($nombreC. ' U:'.Auth::user()->name. ' subio usuarios sin duplicados' );
                session()->flash('message', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado correctamente. Refresque la página para visualizar los usuarios nuevos');
            } else {

                Log::alert($nombreC. ' U:'.Auth::user()->name. ' subio usuarios y quedaron '.$conteo.' repetidos' );
                $listaUs = '';

                foreach ($userDuplicates as $value) {
                    $esDesconocido = stristr($value->email, 'UsuarioDesconocido'); //asegurarse que sea el desconocido con las OC
                    if($esDesconocido){

                        //value => desconocido  | usuarioDeleted => a borrar
                        $usuarioDeleted = User::where('name_no_spaces',$value->name_no_spaces)
                            ->wherenot('id',$value->id)
                            // ->wherenot('email','like','%'.$value->email.'%')
                            ->first();
                        $elBueno = $value;
                    }else{
                        //value => el deleted  | elbueno => a borrar 
                        $elBueno = User::where('name_no_spaces',$value->name_no_spaces)
                            ->wherenot('id',$value->id)
                            // ->wherenot('email','like','%'.$value->email.'%')
                            ->first();
                        $usuarioDeleted = $value;
                    }

                    // if( $value->name_no_spaces == 'MACHADOPELAEZSARA')
                    // dd($elBueno, $usuarioDeleted);

                    //!procede a borrar del todo
                    $listaUs .= $elBueno->name . ' cc:' .$elBueno->cedula2 . ' id:'. $usuarioDeleted->id;

                    DB::table('orden_compra_users')->where('user_id',$usuarioDeleted->id)->update([ 'user_id' => $elBueno->id ]);

                    DB::table('reportes')->where('user_id',$usuarioDeleted->id)->update([ 'user_id' => $elBueno->id ]);

                    $sumcheck = DB::table('orden_compra_users')->where('user_id',$usuarioDeleted->id);
                    $listaOrdenes_user = $sumcheck;
                    $listaOrdenes_user->pluck('orden_compra_id');
                    if($sumcheck->count() === 0){
                        $temporal = $usuarioDeleted->replicate();
                        $losBuenos[$elBueno->id] = $temporal;


                        $usuarioDeleted->Delete();
                        // $usuarioDeleted->forceDelete();
                        $elBueno->update([
                            'name' => $temporal->name,
                            'name_no_spaces' => $temporal->name_no_spaces,
                            'email' => preg_replace('/[^A-Za-z0-9\-_@.]/', '', $temporal->email),
                            'cedula' => $temporal->cedula,
                            'cel' => $temporal->cedula2,
                            // 'password' => $temporal->password,
                        ]);

                        DB::commit();
                    }else{
                        //hay una orden_compra_users que no se "paso" al nuevo usuario
                        Log::critical($nombreC. ' U-> '.Auth::user()->name. " un usuario desafio el codigo id: ".$usuarioDeleted->id." y las ordenes fueron: ".$listaOrdenes_user->toArray());
                        DB::rollBack();
                        session()->flash('messageError', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado incorrectamente.');
                    }
                }
                Log::warning('Fueron eliminados los siguientes usuarios '. $listaUs);
            }
            DB::commit();
            session()->flash('message', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado correctamente. Refresque la página para visualizar los usuarios nuevos');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            foreach ($e->failures() as $failu) {
                $this->ListaErrores = $failu->errors();
                $this->failures = "Ocurrio un error en la fila ".$failu->row();
                Log::critical($nombreC. ' U-> '.Auth::user()->name. " Ocurrio un error en el archivo de excel (SubirUsuarios), en la fila ".$failu->row());
            }
            DB::rollBack();

        } catch (\Throwable $th) {
            $countfilas = session('CountFilas',0);
            $codigoFallo = 0;
            Log::critical($nombreC. ' U:'.Auth::user()->name. ' subio usuarios incorrectamente. Mensaje error:'. $th->getMessage());

            if(session('debug') != null) $codigoFallo = session('debug')->codigo;

            if (config('app.env') === 'production') {
                session()->flash('messageError', 'OC del fallo: '.$codigoFallo. ' Fila#'.$countfilas. ' --- '.$th->getMessage());
            }else{
                session()->flash('messageError', 'OC la cual fallo: '.$codigoFallo. ' Fila#'.$countfilas. ' --'.$th->getMessage());
                session()->flash('messageWarning', 'Error completo: '.substr($th,0,950));
            }
            $this->reset();// $this->mount();
            DB::rollBack();
        }
        session(['CountFilas' => 0]);
    }


    public function render() {
        if($this->archivoExcelSubir){
            $this->nombreArchivoRegisterUser = $this->archivoExcelSubir->getClientOriginalName();
        }else{
            $this->nombreArchivoRegisterUser = 'No hay archivo cargado';
        }
        return view('livewire.vistas.subir-usuarios');
    }
}
