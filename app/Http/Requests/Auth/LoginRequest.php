<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Structure; // <-- Importer le modèle Structure
use App\Models\User;      // <-- Importer le modèle User

class LoginRequest extends FormRequest
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
            'codeEntreprise' => ['required', 'string'],
            'identifiant' => ['required', 'string'], // Champ 'email' renommé en 'identifiant'
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $structureSlug = $this->input('codeEntreprise');
        $identifier = $this->input('identifiant');
        $password = $this->input('password');

        // --- ÉTAPE 1 : Trouver la structure ---
        // On vérifie d'abord si la structure demandée existe.
        $structure = Structure::where('slug', $structureSlug)->first();

        if (!$structure) {
            RateLimiter::hit($this->throttleKey());
            // On lève une erreur sur le champ du code pour guider l'utilisateur.
            throw ValidationException::withMessages([
                'codeEntreprise' => 'Ce code structure est invalide.',
            ]);
        }

        // --- ÉTAPE 2 : Trouver l'utilisateur ---
        // On cherche l'utilisateur par son email OU son nom d'utilisateur.
        $user = User::where('email', $identifier)
                    ->orWhere('username', $identifier)
                    ->first();

        // --- ÉTAPE 3 : Vérifier le mot de passe ET l'appartenance à la structure ---
        // On vérifie trois conditions en une seule fois pour une sécurité maximale :
        // 1. L'utilisateur existe-t-il ?
        // 2. Le mot de passe est-il correct ?
        // 3. L'utilisateur trouvé appartient-il bien à la structure trouvée ?
        if (!$user || !Hash::check($password, $user->password) || !$user->structures()->where('structure_id', $structure->id)->exists()) {
            RateLimiter::hit($this->throttleKey());

            // On renvoie un message d'erreur générique pour ne pas donner d'indices
            // à un attaquant potentiel (ex: "l'utilisateur existe mais n'est pas dans la bonne structure").
            throw ValidationException::withMessages([
                'identifiant' => 'Les informations fournies (identifiant ou mot de passe) sont incorrectes.',
            ]);
        }

        // --- SUCCÈS ---
        session()->put('structure_nom', $structure->nom);
        session()->put('structure_logo', $structure->logo_url);
        session()->put('structure_id', $structure->id);
        // Si toutes les vérifications passent, on connecte l'utilisateur.
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }


    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
