<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class postController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($userId,$limit=null,$offset=null)
    {
        return $post = Post::lista($userId,$limit,$offset);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json response
     */
    public function store(Request $request)
    {

        //reglas de Validación para el request de posts
        $rules = [
                    'userId' => 'required|numeric',
                    'title' => 'required|max:100|string',
                    'content' => 'required|max:255|string'
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
                    "title"   => $request->get('title'),
                    "content" => $request->get('content')
                ];

        // se guardan los elementos recibidos por post
        $post = Post::guarda($data);

        //se retorna resultado del proceso de base de datos
        return $post;

    }


}
