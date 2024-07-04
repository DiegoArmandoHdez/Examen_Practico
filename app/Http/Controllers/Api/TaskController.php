<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $expiredAt = isset($request->all()["expired_at"])
            ? Carbon::parse($request->all()["expired_at"])
            : null;
        $startAt = isset($request->all()["start_at"])
            ? Carbon::parse($request->all()["start_at"])
            : null;
        /**
         * Validar que la fecha de inicio siempre es antes que la de expiración,
         * siempre y cuando se hayan definido ambas fechas
         */
        if((isset($expiredAt) && isset($startAt)) && $startAt->isAfter($expiredAt)){
            return response()->json([
                "message" => "La fecha de inicio no puede ser después a la fecha de expiración"
            ]);
        }
        /**
         * Si la fecha de expiración está definida pero no la
         * fecha de inicio, entonces la fecha de expiración debe
         * ser después a la fecha actual
         */
        if((isset($expiredAt) && !isset($startAt)) &&
            Carbon::now()->isAfter($expiredAt) ){
            return response()->json([
                "message" => "La fecha de expiración debe ser después de hoy si no se indica una fecha de inicio"
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
