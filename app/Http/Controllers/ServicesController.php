<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest; // La validation reste la même
use App\Models\Service;
use Illuminate\Http\RedirectResponse; // <-- Changer le type de retour

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
        try {
            $branch = Branche::findOrFail($request->input('branche_id'));
        
            // Vérifier si un service existe déjà dans cette branche avec le même nom
            $exists = $branch->services()
                ->where('nom', $request->input('nom'))
                ->exists();
        
            if ($exists) {
                return redirect()->back()->with('error', 'Un service avec ce nom existe déjà dans cette branche.');
            }
        
            // Sinon, on crée le service
            $branch->services()->create([
                'nom' => $request->input('nom'),
                'prefixe_ticket' => strtoupper(substr($request->input('nom'), 0, 1)),
                'temps_moyen_estime' => $request->input('temps_moyen_estime', 10),
                'est_actif' => true,
                'ordre_affichage' => 0,
            ]);
        
            return redirect()->back()->with('success', 'Le service a été créé avec succès !');
        
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du service.');
        }
        
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
