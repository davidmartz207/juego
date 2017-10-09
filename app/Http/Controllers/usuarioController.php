<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userLoad(Request $request) 
    {
        $id = $request->get("userId");

        return Usuario::lista($id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json response
     */
    public function userSave(Request $request)
    {

        //reglas de Validación para el request de usuarios
        $rules = [
                    'userId' => 'required|numeric',
                    'data' => 'required|array',
            ];
 
        // Ejecutamos el validador, en caso de que falle devolvemos la respuesta o respuestas directamente
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return [
                'Error' => true,
                'message'  => $validator->errors()->all()
            ];
        }

        //si todo ocurre sin novedades el código continua en su proceso
        //generamos array de datos a guardar:
        $data = [
                    "userId"  => $request->get('userId'),
                    "data"    => json_encode($request->get('data')),
                ];

        // se guardan los elementos recibidos por post
        $user = Usuario::guarda($data);

        //se retorna resultado del proceso de base de datos
        return $user;

    }

}
