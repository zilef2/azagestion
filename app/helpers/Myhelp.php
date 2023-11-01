<?php

namespace App\helpers;

// use Hamcrest\Type\IsInteger;

class Myhelp{

    public function redirect($ruta,$seconds = 1)
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