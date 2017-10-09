<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Juego;

class juegoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jugar(Request $request)
    {

        //obtenemos los datos del request
        $id = $request->get("userId");

        //Verifica la existencia de jugador, si no, se crea
        if (Juego::existeJugador($id)) {
            $jugador = Juego::existeJugador($id);
        }else{
            $jugador = Juego::crearJugador($id);
        }

        //crea un monstruo
        $monstruo = $this->crearMonstruo();

        //simula la lucha
        $vidaJugador  = $jugador->vida - $monstruo['nivel'];

        //variable predeterminada a ganar
        $gana=true;
        $message ="";

        //si la fuerza de combae de jugador es >= fuerza del monstruo
        if ($jugador->fuerza >= $monstruo['fuerza']) {
            $gana = true;
            $message="El jugador Ha ganado";
        //si el monstruo es de nivel 5
        }elseif ($monstruo['nivel'] == 5) {
            $gana = false;
            $message="El jugador Ha perdido";
        //si pierde todas las vidas
        }elseif ($vidaJugador <= 0) {
            $gana = false;
            $message="El jugador Ha fallecido";
        //cualquier otra coincidencia          
        }else{
            $gana = false;
            $message="El jugador Ha perdido";
        }

        //si el jugador gana
        if ($gana) {
            //suma experiencia
            $jugador->exp = $jugador->exp + 1;
            //si la experiencia actual del jugador es 3
            if ($jugador->exp==3) {
                //sube de nivel
                $jugador->exp=0;
                $jugador->nivel=$jugador->nivel+1;
                $jugador->fuerza= $jugador->nivel+1;
                $jugador->vida= $jugador->nivel+3;

                $message.="  El jugador ha subido a nivel ".$jugador->nivel;
            
            }
            //si jugador fallece
        }else{
            //se reinicia
            if ($vidaJugador <= 0) {
                $jugador->nivel  = 1;
                $jugador->fuerza = 2;
                $jugador->vida   = 4;
            }

        }
        //se actualizan todos los cambios, aprovechamos que es un objeto
        $jugador->update();

        //devolvemos el mensaje de lo que le ocurrió al jugador
        return response()->json(['message' => $message ]);

    }

    /**
     * crea un array aleatorio simulando un mosntruo.
     *
     * 
     * @return array
     */
    public function crearMonstruo()
    {
        $nivel     = rand(1,5);
        $fuerza    = $nivel;
        $monstruo  = ["nivel"=>$nivel,"fuerza"=>$fuerza];
        
        return $monstruo;
    }

    /**
     * Lista de jugadores clasificados por rango.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function leaderBoard(Request $request)
    {
        $id = $request->get("userId");
        return  Juego::listaJugadores($id) ;
    }


}
