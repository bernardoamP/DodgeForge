<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
    * Détermine si l'utilisateur est autorisé à effectuer cette demande.
    *
    * @return bool
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtient les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required','string', 'min:3'],
            'first_name'=>['required','string', 'min:3'],
            'email'=>['required', 'email', 'unique:users,email'],
            'password' =>['required','min:8','regex:/[0-9]/','regex:/[A-Z]/','regex:/\W/', 'confirmed'],
            'formation_id'=>['required', 'exists:formations,id']
        ];
    }
}
