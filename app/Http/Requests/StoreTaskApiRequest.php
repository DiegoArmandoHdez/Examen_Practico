<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "company_id"=> ["required", "numeric"],
            "user_id"=> ["required", "numeric"],
            "name"=> ["required", "string"],
            "description"=> ["required", "string"],
        ];
    }

    /**
     * Obtener los mensajes de error de los campos requeridos
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company_id.required' => 'Se necesita una compañia para generar la tarea',
            'company_id.numeric' => 'El identificador de la compañia debe ser numerico',
            'user_id.required' => 'Se necesita un usuario para crear la tarea',
            'user_id.numeric' => 'El identificador de usuario debe ser numerico',
            'name.required' => 'Se necesita un nombre para identificar la tarea',
            'description.required' => 'Se necesita una descripción para la tarea',

        ];
    }


}
