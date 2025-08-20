<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest; // La validation reste la même
use App\Models\Service;
use Illuminate\Http\RedirectResponse; // <-- Changer le type de retour
use Illuminate\Validation\ValidationException; // Importer pour l'erreur de validation
class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $structureId = session('structure_id');
    
        if (!$structureId) {
            abort(403, 'Aucune structure active dans la session.');
        }
    
        // --- NOUVELLE LOGIQUE ---
        // "Donne-moi les Services qui ont ('whereHas') une relation 'branche'
        // où la 'structure_id' de cette branche est égale à mon $structureId"
        $services = Service::whereHas('branche', function ($query) use ($structureId) {
            $query->where('structure_id', $structureId);
        })->with('branche')->get(); // with('branche') charge la branche pour éviter N+1 requêtes
    
        // On récupère les branches de la même manière pour les passer à la vue
        $branches = Branche::where('structure_id', $structureId)->get();
    
        return view('components.services', compact('services', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        // La validation de base (nom, branche_id) est déjà faite par StoreServiceRequest
        $validatedData = $request->validated();
        
        // try {
            $branch = Branche::findOrFail($validatedData['branche_id']);
            $serviceName = $validatedData['nom'];

            // --- NOUVELLE LOGIQUE DE GÉNÉRATION DE PRÉFIXE UNIQUE ---
            
            // 1. Récupérer tous les préfixes déjà utilisés POUR CETTE BRANCHE
            $existingPrefixes = Service::where('branche_id', $branch->id)
                                       ->pluck('prefixe_ticket')
                                       ->all();

            $prefix = null;
            $normalizedName = strtoupper(str_replace(' ', '', $serviceName)); // Met en majuscule et enlève les espaces
            

            // 2. Essayer chaque lettre du nom du service
            foreach (str_split($normalizedName) as $char) {
                if (!in_array($char, $existingPrefixes)) {
                    $prefix = $char;
                    break; // On a trouvé un préfixe, on arrête la boucle
                }
            }
            
            // 3. Si toutes les lettres du nom sont prises, on parcourt l'alphabet
            if (is_null($prefix)) {
                $alphabet = range('A', 'Z');
                foreach ($alphabet as $char) {
                    if (!in_array($char, $existingPrefixes)) {
                        $prefix = $char;
                        break;
                    }
                }
            }

            // 4. Cas extrême : si tous les préfixes de A à Z sont pris, on renvoie une erreur.
            if (is_null($prefix)) {
                throw ValidationException::withMessages([
                    'nom' => 'Impossible de générer un préfixe unique pour ce service dans cette branche. Veuillez choisir un autre nom ou libérer un préfixe.'
                ]);
            }
            
            // --- FIN DE LA LOGIQUE ---

            $branch->services()->create([
                'nom' => $serviceName,
                'prefixe_ticket' => $prefix, // On utilise notre préfixe unique
                'temps_moyen_estime' => $validatedData['temps_moyen_estime'] ?? 10,
                'est_actif' => true,
                'ordre_affichage' => 0,
            ]);

            return redirect()->back()->with('success', 'Le service a été créé avec succès !');

        // } catch (\Exception $e) {
        //     // Gère l'erreur de validation ou toute autre exception
        //     return redirect()->back()->with('error', $e instanceof ValidationException ? $e->getMessage() : 'Une erreur est survenue lors de la création du service.');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'service_name' => ['required','string','max:255'],
            // 'temps_moyen_estime' => ['nullable','integer','min:1'],
        ]);

        $service->update([
            'nom' => $validated['service_name'],
            // 'temps_moyen_estime' => $validated['temps_moyen_estime'] ?? $service->temps_moyen_estime,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service mis à jour avec succès.',
            'service' => $service->fresh(['branche:id,nom']),
        ]);
    }

    public function destroy(Service $service)
    {
        // Si des contraintes empêchent la suppression, renvoyer 409
        try {
            $service->delete();
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer ce service, des éléments y sont rattachés.",
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Service supprimé avec succès.',
        ]);
    }
}
