<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskApiRequest;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{

    /**
     * Función "store" almacenará un nuevo registro de la tabla "task".
     * El nuevo registro será relacionado con el usuario y compañía indicados en la petición
     *  solo si el usuario no ha superado el limite de 5 tareas registradas
     */
    public function create(StoreTaskApiRequest $request){
        /* $request->validate([
            "company_id"=> ["required", "numeric"],
            "user_id"=> ["required", "numeric"],
            "name"=> ["required", "string"],
            "description"=> ["required", "string"],
        ]); */
        //Buscar a la compañia indicada
        $company = Company::find($request->all()["company_id"]);
        if(!isset($company)){
            return response()->json([
                "message" => "La compañía en la solicitud no existe"
            ]);
        }
        //Buscar usuario indicado
        $user = User::find($request->all()["user_id"]);
        //si no se encuentra, retornar mensaje de error
        if(!isset($user)){
            return response()->json([
                "message" => "El usuario en la solicitud no existe"
            ]);
        }
        //Si el usuario tiene 5 tareas, no puede crear más
        if($user->tasks?->count() >= 5){
            return response()->json([
                "message" => "El usuario ha excedido el limite de 5 tareas registradas"
            ]);

        }
        //Guardar datos de la tarea
        $task = Task::create($request->all());
        //retornar datos de la tarea generada
        return [
            "id" => $task->id,
            "name" => $task->name,
            "description" => $task->description,
            "user" => $task->user->name,
            "company" => [
                "id" => $task->company->id,
                "name" =>$task->company->name
            ]
        ];
    }
}
