<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAgentRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
  
     public function authorize(): bool
     {
         // Règle de sécurité simple et efficace :
         // L'utilisateur doit être connecté ET être associé à au moins une structure pour pouvoir créer un agent.
         return $this->user() && $this->user()->structures()->exists();
     }
    /**
     * Obtenir les règles de validation.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string'],
        ];
    }
}