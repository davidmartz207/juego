<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //Table definition
    protected $table='usuarios';
    protected $primaryKey='id';

    public $timestamps = false;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId','data'
    ];



    //Metodo para listar 
    //Param: data: Array de datos
    //retorna: objeto JSON
    public static function lista($id){
        
		//Se consultan los elementos del modelo usuarios
        $usuarios = Usuario::select("data")
                     ->where("userId","=",$id)
                     ->get();


        $arrayConfig = [];
        //decodifica cada uno de los elementos
	    foreach ($usuarios as $key => $config) {

    		$arrayConfig[] = json_decode($config->data);	    	
        
        }

        //envía la respuesta en formato json
        return response()->json($arrayConfig); 
    }

    //Metodo para guardar 
    //Param: data: Array de datos
    //retorna: objeto JSON
    public static function guarda($data){
        
        //se crea un objeto de tipo post y asignan valores
    	$user = new Usuario;
    	$user->userId  = $data['userId'];
    	$user->data   = $data['data'];

        try {

            //si se ejecuta correctamente se envía mensaje de guardado exitoso
            $user->save();
            return response()->json(['success' => true]);
            
        } catch (\Illuminate\Database\QueryException $ex) {

            //si ocurre algún error es atrapado y se envía mensaje de error
            return response()->json(['Error' => true, 'message' => $ex->getMessage() ]);
        }   
    }

}
