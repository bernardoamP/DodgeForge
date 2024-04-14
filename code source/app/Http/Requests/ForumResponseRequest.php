<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumResponseRequest extends FormRequest
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
            'content' => ['string', 'min:1', 'max: 500'],
            'forum_post_id' =>['integer', 'exists:forum_posts,id']
            //'user_id' =>['integer', 'exists:users,id'],
        ];
    }
}
