<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\Branche;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        // On récupère la branche depuis les données du formulaire
        $branch = Branche::find($this->input('branche_id'));

        // Si la branche n'existe pas, on refuse
        if (!$branch) {
            return false;
        }

        // Règle : L'utilisateur doit appartenir à la structure qui possède la branche
        return $this->user()->structures()->where('id', $branch->structure_id)->exists();
    }

    /**
     * Obtenir les règles de validation.
     */
    public function rules(): array
    {
        return [
            'nom' => [
                'required',
                'string',
                'max:255',
                // Le nom du service doit être unique pour une branche donnée
                Rule::unique('services')->where('branche_id', $this->input('branche_id'))
            ],
            'branche_id' => ['required', 'uuid', 'exists:branches,id'],
            'temps_moyen_estime' => ['nullable', 'integer', 'min:1'],
        ];
    }
}