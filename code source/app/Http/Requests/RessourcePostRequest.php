<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;


class RessourcePostRequest extends FormRequest
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
                'title' => ['required','string', 'min:3', 'max:50', 'unique:forum_posts,title'],
                'description' => ['required','string', 'min:1', 'max: 500'],
                'theme' =>['required', 'integer', 'exists:themes,id'],
                'file' => ['required', 'file', 'mimes:png,jpeg,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,mp3,wav,mp4,avi,mpg,mpeg', 'max:5000'],

        ];
    }
 }
