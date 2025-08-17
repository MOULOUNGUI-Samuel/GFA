<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class CaissesController extends Controller
{
    public function index()
    {
        $structureId = session('structure_id');
        abort_unless($structureId, 403, 'Structure non sélectionnée.');

        $structure = Structure::query()->findOrFail($structureId);

        // Eager-load + count, avec pagination si besoin
        $caisses = $structure->caisses()
            ->with('branche:id,nom')   // limite les colonnes
            ->withCount('tickets')
            ->orderBy('nom')
            ->paginate(24);            // ← passe à ->get() si tu veux tout

        $branches = $structure->branches()->select('id','nom')->orderBy('nom')->get();

        return view('components.caisses', compact('caisses', 'branches'));
    }

    public function store(Request $request)
    {
        $structureId = session('structure_id');
        abort_unless($structureId, 403, 'Structure non sélectionnée.');
        $structure = Structure::findOrFail($structureId);

        $validated = $request->validate([
            'nom'          => ['required','string','max:255'],
            'numero_poste' => ['nullable','string','max:10'],
            'branche_id'   => [
                'required','uuid',
                Rule::exists('branches','id')->where('structure_id', $structure->id),
            ],
        ]);

        // On s’assure que la branche appartient bien à la structure
        $branche = $structure->branches()->whereKey($validated['branche_id'])->firstOrFail();

        $branche->caisses()->create([
            'nom'          => $validated['nom'],
            'numero_poste' => $validated['numero_poste'] ?? null,
            'statut'       => 'fermee',
        ]);

        return back()->with('success', 'La caisse a été créée avec succès !');
    }

    public function update(Request $request, Caisse $caisse)
    {
        // Autorisation par structure (si Policy: $this->authorize('update', $caisse);)
        $this->assertCaisseInSessionStructure($caisse);

        $validated = $request->validate([
            'nom'          => ['required','string','max:255'],
            'numero_poste' => ['nullable','string','max:10'],
        ]);

        $caisse->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'La caisse a été mise à jour avec succès.',
            'caisse'  => $caisse->fresh(['branche:id,nom']),
        ]);
    }

    public function destroy(Caisse $caisse)
    {
        // Autorisation par structure
        $this->assertCaisseInSessionStructure($caisse);

        try {
            $caisse->delete();
        } catch (QueryException $e) {
            // exemple: contrainte FK tickets → empêcher la suppression
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer cette caisse car des éléments y sont rattachés.",
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'La caisse a été supprimée avec succès.',
        ]);
    }

    /** ------- Helpers privés ------- */

    private function assertCaisseInSessionStructure(Caisse $caisse): void
    {
        $structureId = session('structure_id');
        abort_unless($structureId, 403, 'Structure non sélectionnée.');

        // Vérifie via la relation branche->structure_id (évite l’accès transversal)
        $belongs = $caisse->branche()->where('structure_id', $structureId)->exists();
        abort_unless($belongs, 403, 'Accès non autorisé à cette caisse.');
    }
}
