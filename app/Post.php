<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	//Table definition
    protected $table='posts';
    protected $primaryKey='id';

    public $timestamps = false;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId','title','content'
    ];


    //Metodo para listar 
    //Params: Id: userId, offset: filtro, limit: filtro
    //retorna: Objeto JSON
    public static function lista($id,$limit,$offset){
        
        //Se consultan los elementos del modelo POSTS
        $posts = Post::where("userId","=",$id)
                     ->conLimit($limit)
                     ->conOffset($offset)
                     ->get();

        return response()->json($posts);

    }

    //Para cuando la búsqueda tiene offset
    //Params: Id: userId, offset: filtro
    //retorna: mixto
    public function scopeConOffset($query, $offset)
    {
        //si el request tiene offset
        if ($offset !== null) {
           return $query->offset($offset);
        }
    }

    //Para cuando la búsqueda tiene limit
    //Params: query: query afectado, limit: filtro
    //retorna: mixto
    public function scopeConLimit($query, $limit)
    {
        //si el request tiene limit
        if ($limit !== null) {
           return $query->limit($limit);
        }
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
