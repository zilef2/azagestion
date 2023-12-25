<?php

namespace App\helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// use Hamcrest\Type\IsInteger;

class Myhelp{


    public static function AuthU() {
        $TheUser = Auth::user();
        if($TheUser){
            return $TheUser;
        }
        return redirect()->to('/');
    }
     public static function EscribirEnLog($thiis, $mensaje = '', $critico = 0,$mensajeth = '') {
         $thisuser = Myhelp::AuthU();

        if(is_string($thiis)){
            $nombreC = $thiis;
            $nombreP = 'nuse';
        }else{
            $ListaControladoresYnombreClase = (explode('\\', get_class($thiis)));
            $nombreC = end($ListaControladoresYnombreClase);
            $Elpapa = (explode('\\', get_parent_class($thiis)));
            $nombreP = end($Elpapa);
        }

        if ($critico === 0) {
            if($thisuser->is_admin > 0) {
                Log::channel('eladmin')->info('Vista:' . $nombreC. '| Clase: '.$nombreP. '|  U:'.Auth::user()->name.'');
            }else{
                if($thisuser->rol_id === 3) {
                    Log::channel('asesores')->info('Vista:  ' . $nombreC. '| Clase: '.$nombreP. '  Usuario -> '.Auth::user()->name );
                }
                if($thisuser->rol_id === 2) {
                    Log::channel('asignadores')->info('Vista:  ' . $nombreC. '| Clase: '.$nombreP. '  Usuario -> '.Auth::user()->name );
                }
            }
        }else{
            if($critico == 1 && $mensajeth !== ''){
                $mesanjeFinal = $mensajeth->getMessage(). ' | '.$mensajeth->getFile(). ' | '.$mensajeth->getLine();
                Log::critical('Vista: ' . $nombreC . ' U:' . $thisuser->name . ' | Clase: '.$nombreP. '|| ' . ' MensajeCritico1: ' . $mesanjeFinal);
            }else{
                if($critico == 1){
                    Log::critical('Vista: ' . $nombreC . ' U:' . $thisuser->name . ' | Clase: '.$nombreP. '|| ' . ' MensajeCritico2: ' . $mensaje);
                }else{
                    if($thisuser->is_admin > 0) {
                        Log::channel('eladmin')->alert('Vista:' . $nombreC. '| Clase: '.$nombreP. '|  U:'.Auth::user()->name.' | ' .$mensaje );
                    }else{
                        if($thisuser->rol_id === 3) {
                            Log::channel('asesores')->alert('Vista:  ' . $nombreC. '| Clase: '.$nombreP. '  Usuario -> '.Auth::user()->name.' | ' .$mensaje );
                        }
                        if($thisuser->rol_id === 2) {
                            Log::channel('asignadores')->alert('Vista:  ' . $nombreC. '| Clase: '.$nombreP. '  Usuario -> '.Auth::user()->name.' | ' .$mensaje );
                        }
                    }
                }
            }
        }
    }

    public function redirect($ruta,$seconds = 0)
    {
        sleep($seconds);
        return redirect()->to($ruta);
    }

    function cortarFrase($frase, $maxPalabras = 3) {
        $noTerminales = [
            "de","a","para",
            "of","by","for"
        ];

        $palabras = explode(" ", $frase);
        $numPalabras = count($palabras);
        if ($numPalabras > $maxPalabras) {
            $offset = $maxPalabras - 1;
            while (in_array($palabras[$offset], $noTerminales) && $offset < $numPalabras) {
                $offset++;
            }
            $ultimaPalabra = $palabras[$offset];
            if((intval($ultimaPalabra)) != 0){
                session(['ultimaPalabra' => $ultimaPalabra]);
            }
            return implode(" ", array_slice($palabras, 0, $offset + 1));
        }
        return $frase;
    }
    public function erroresExcel($errorFeo){
        // $fila = session('ultimaPalabra');
        $error1 ="PDOException: SQLSTATE[22007]: Invalid datetime format: 1292 Incorrect date";
        if($errorFeo == $error1){
            return 'Existe una fecha inválida';
        }
        return 'Error desconocido';
    }
    public function ValidarFecha($laFecha){
        if(strtotime($laFecha)){
            return $laFecha;
        }
        return '';
    }

} ?>
