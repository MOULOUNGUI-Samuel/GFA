<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgentRequest;
use App\Models\Role;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    /**
     * Affiche la liste des agents.
     */
    public function index()
    {
        
        $structure_id = session('structure_id');
        $structure = Structure::where('id', $structure_id)->first();
       
        // Récupère uniquement les utilisateurs qui ont le rôle 'agent' ET qui sont liés à la structure active
        $agentRole = Role::where('nom', 'agent')->firstOrFail();

        $agents = $structure->users()->where('role_id', $agentRole->id)->get();

        return view('components.agents', compact('agents', 'structure_id'));
    }

    /**
     * Enregistre un nouvel agent.
     */
    public function store(StoreAgentRequest $request)
    {
        // La validation est déjà faite par StoreAgentRequest
        $validatedData = $request->validated();
        $structureId = session('structure_id');

        if (!$structureId) {
            return redirect()->back()->with('error', 'Veuillez d\'abord sélectionner une structure active.');
        }

        // 2. Sécurité : Vérifier que l'utilisateur a bien le droit de travailler sur cette structure
        $structure = Structure::where('id', $structureId)
            ->first();


        try {
            // Utiliser une transaction garantit que soit tout réussit, soit tout échoue.
            DB::transaction(function () use ($validatedData, $structure) {

                // 1. Récupérer l'ID du rôle "agent".
                // En production, il est bon de mettre en cache ce résultat.
                $agentRole = Role::where('nom', 'agent')->firstOrFail();

                // 2. Créer l'utilisateur
                $agent = User::create([
                    'role_id' => $agentRole->id,
                    'name' => $validatedData['name'],
                    'username' => $validatedData['username'],
                    'email' => $validatedData['email'],
                    'phone_number' => $validatedData['phone_number'],
                    'password' => Hash::make($validatedData['password']),
                    'statut_actuel' => 'deconnecte', // Statut par défaut
                ]);

                // 3. Lier le nouvel agent à la structure de l'admin
                $structure->users()->attach($agent->id);
            });

            return redirect()->back()->with('success', 'L\'agent a été créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur de création d\'agent : ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la création de l\'agent.');
        }
    }
}
