<?php
namespace App\Http\Livewire\Vistas;

use App\Exports\DesconocidosExport;
use App\helpers\Myhelp;
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

    public function mount(){
        Myhelp::EscribirEnLog($this,__FUNCTION__);
        $this->haydesconocidos = count(User::Where('email','like','%UsuarioDescono%')->get()) > 0;
    }

    public function EditarUsdesconocidos(){ return redirect()->to('dashboard'); }

    public function updatedArchivoExcelSubir() {
        $Kilobytes = (int)($this->archivoExcelSubir->getSize())/1024;
        if($Kilobytes > 2048){
            session()->flash('messageError', 'El Archivo es demasiado pesado, debe ser menor a 2MB');
            $this->reset();
        };
    }



    public function exportDes() {
        Myhelp::EscribirEnLog($this,'Se comenzo el proceso para descargar los usuarios desconocidos');

        return Excel::download(new DesconocidosExport, 'Asesores_Desconocidos.xlsx');
    }

    public function importUs() {
        $this->validate([
            'archivoExcelSubir' => 'max:2048', // 2MB Max
        ]);
        set_time_limit(180);//2min
        DB::beginTransaction();
        try {
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
                Myhelp::EscribirEnLog($this);
                session()->flash('message', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado correctamente. Refresque la página para visualizar los usuarios nuevos');
            } else {
                Myhelp::EscribirEnLog($this,'subio usuarios y quedaron '.$conteo.' repetidos',2);
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
                        Myhelp::EscribirEnLog($this," un usuario desafio el codigo id: ".$usuarioDeleted->id." y las ordenes fueron: ".$listaOrdenes_user->toArray(),2);
                        DB::rollBack();
                        session()->flash('messageError', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado incorrectamente.');
                    }
                }
                Myhelp::EscribirEnLog($this,'Fueron eliminados los siguientes usuarios '. $listaUs);
            }
            DB::commit();
            session()->flash('message', $this->archivoExcelSubir->getClientOriginalName().' se ha cargado correctamente. Refresque la página para visualizar los usuarios nuevos');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            foreach ($e->failures() as $failu) {
                $this->ListaErrores = $failu->errors();
                $this->failures = "Ocurrio un error en la fila ".$failu->row();
                Myhelp::EscribirEnLog($this,'',1);
            }
            DB::rollBack();

        } catch (\Throwable $th) {
            $countfilas = session('CountFilas',0);
            $codigoFallo = 0;
            Myhelp::EscribirEnLog($this,'',1,$th);

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
