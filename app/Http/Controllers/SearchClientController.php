<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use DB;


class SearchClientController extends Controller
{

    // funcion que busca y retorna las concidencias
    function searchClient($value){
        $clients = Cliente::select('id','nivel1','nivel2','nivel3','status')
        ->where(
            DB::raw("CONCAT(nivel1,nivel2,nivel3)"),'like','%'.$value.'%'
        )
        ->get();

        return $clients;
    }

    public function getClientByInputJSON($value){
        return response()->json($this->searchClient($value));
    }
    
}
