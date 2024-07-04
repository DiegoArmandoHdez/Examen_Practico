<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{

    /**
     * Obtiene las compañias de la base de datos
     * si no es especifica un id.
     * Si se recibe un id por una petición get, se
     * buscará una unica compañía basado en el id
     */
    public function companies(){

        if(isset($_GET["id"])){
            $company = Company::with(["tasks", "tasks.user"])->where("id", $_GET["id"])->first();
            //Devolver mensaje de error si la compañía no existe
            if(!isset($company)){
                return response()->json([
                    'message' => "La compañia solicitada no existe"
                ]);
            }
            //Retorno de la compañia encontrada
            return new CompanyResource($company);
        }
        /**
         * Buscamos todas las compañías de la base de datos
         * junto a su relación con usuarios y tareas
         */
        $companies = Company::with(["tasks", "tasks.user"])->get();
        //Retorno de todas las compañías encontradas
        if(sizeof($companies) <= 0){
            return response()->json([
                'message' => "No se ha encontrado ninguna compañia"
            ]);
        }
        return CompanyResource::collection(
            $companies
        );
    }
}
