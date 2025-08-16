<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        // Récupère la structure depuis la route
        $structure = $this->route('structure');

        // Vous devez adapter cette logique à votre système de permissions.
        return $this->user()->structures()->where('structure_id', $structure->id)->exists();
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'branch_name' => ['required', 'string', 'max:255'],
            'branch_description' => ['nullable', 'string'],
            'branch_location' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Personnaliser les messages d'erreur.
     */
    public function messages(): array
    {
        return [
            'branch_name.required' => 'Le nom de la branche est obligatoire.',
            'branch_name.max' => 'Le nom de la branche ne peut pas dépasser 255 caractères.',
        ];
    }
}