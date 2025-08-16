<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\RegisterRequest; // <-- Important
use App\Models\Role;
use App\Models\Structure;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        try {
            // Utiliser une transaction pour assurer l'intégrité des données
            $createdData = DB::transaction(function () use ($request) {
                
                // 1. Gérer l'upload du logo
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    // Stocke dans 'storage/app/public/logos' et renvoie le chemin
                    // N'oubliez pas de lancer 'php artisan storage:link'
                    $logoPath = $request->file('logo')->store('logos', 'public');
                }

                // 2. Créer la Structure
                $structure = Structure::create([
                    'nom' => $request->input('nom'),
                    'slug' => Str::slug($request->input('nom')),
                    'type' => $request->input('type'),
                    'adresse' => $request->input('adresse'),
                    'ville' => $request->input('ville'),
                    'pays' => $request->input('pays'),
                    'telephone' => $request->input('telephone'),
                    'logo_url' => $logoPath,
                    'est_active' => true,
                ]);

                // 3. Créer l'Utilisateur (administrateur de la structure)
                // Assurez-vous d'avoir un rôle "Admin" ou "Propriétaire" dans votre table `roles`
                $adminRole = Role::where('nom', 'admin_structure')->firstOrFail();
                
                $user = User::create([
                    'role_id' => $adminRole->id,
                    'name' => $request->input('name'),
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'password' => Hash::make($request->input('password')),
                    'statut_actuel' => 'disponible', // ou 'deconnecte'
                ]);

                // 4. Lier l'utilisateur à la structure (table pivot)
                $user->structures()->attach($structure->id);
                
                return ['user' => $user];
            });

            // 5. Connecter l'utilisateur après une inscription réussie
            Auth::login($createdData['user']);

            // 6. Rediriger vers le tableau de bord
            return redirect()->route('dashboard')->with('success', 'Bienvenue ! Votre structure et votre compte ont été créés avec succès.');

        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            // Loggez l'erreur pour le débogage : \Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');
        }
    }
}
