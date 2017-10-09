<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Juego extends Model
{
	//Table definition
    protected $table='juegos';
    protected $primaryKey='id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId','fuerza','vida','nivel'
    ];

    public $timestamps = false;

    //Metodo para corroborar existencia de jugador
    //Params: Id: userId
    //retorna: booleano
    public static function existeJugador($id){
  
        $jugador =  Juego::where('userId',$id)->first();

        if (count($jugador) > 0) {
        	return $jugador;
        }else{
        	return false;
        }
    }

    //Metodo para crear un jugador
    //Params: Id: userId
    //retorna: booleano, objeto juego
    public static function crearJugador($id){
        $jugador = new Juego;

        $jugador->userId = $id;


        try {
        	
        	$jugador->save();
        	return Juego::existeJugador($jugador->userId);

        } catch (\Illuminate\Database\QueryException $ex) {

            //si ocurre algún error devuelve false
            return response()->json(['Error' => true, 'message' => $ex->getMessage() ]);
        } 
    }

    //Metodo para crear un jugador
    //Params: Id: userId
    //retorna: booleano, objeto juego
    public static function listaJugadores($id){
    	
    	$jugador=Juego::lista($id);

    	$arrayJugadores=[];

    	if (count($jugador)>0) {
    		$arrayJugadores=[
    					"userId"  => $id,
						"level"   => $jugador['nivel'],
						"rank"    => $jugador['rank'],
						"entries" => $jugador["jugadores"]
    				  ] ;    	
    	}


        return response()->json($arrayJugadores);

    }

    //Metodo para listar 
    //Params: Id: userId, offset: filtro, limit: filtro
    //retorna: Objeto JSON
    public static function lista($id){
        
        //Se consultan los elementos del modelo juego
        $jugadores = Juego::select("userId","nivel")
                          ->orderBy('nivel','desc')
                          ->get();

        $arrayJugadores=[];
        $rank="";
        foreach ($jugadores as $key => $jugador) {
        	if ($jugador->userId == $id) {
        		$rank = $key+1;
        		$nivel= $jugador->nivel;
        	}
        	$arrayJugadores[]=[
        						"userId"=>$jugador->userId,
        						"nivel"=>$jugador->nivel,
        						"rank"=>$key+1,
        					  ];
        }

        $resultado = [
                       "jugadores" => $arrayJugadores, 
                       "rank" => $rank,
                       "nivel" => $nivel
                     ];

        return $resultado;

    }

    //Metodo para guardar 
    //Param: data: Array de datos
    //retorna: objeto JSON
    public static function guarda($data){
        
        //se crea un objeto de tipo post y asignan valores
    	$post = new Post;
    	$post->userId  = $data['userId'];
    	$post->title   = $data['title'];
    	$post->content = $data['content'];

        try {

            //si se ejecuta correctamente se envía mensaje de guardado exitoso
            $post->save();
            return response()->json(['success' => true]);
            
        } catch (\Illuminate\Database\QueryException $ex) {

            //si ocurre algún error es atrapado y se envía mensaje de error
            return response()->json(['Error' => true, 'message' => $ex->getMessage() ]);
        }   
    }


}
