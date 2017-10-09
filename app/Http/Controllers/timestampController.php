<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class timestampController extends Controller
{
    /**
     * devuelve el valor de la fecha y tiempo actual en formato UNIX.
     *
     * @return \json\Response
     */
    public function printTimestamp()
    {

        $fecha = mktime(time());

        return response()->json(['timestamp' => $fecha]);
    }

}
