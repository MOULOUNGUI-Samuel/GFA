<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use App\Http\Requests\StoreBranchRequest; // Nous allons créer ce fichier
use App\Models\Branche;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branches=Branche::where('structure_id',session('structure_id'))->get();
        return view('components.branches',compact('branches'));
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
    // La signature de la méthode change pour indiquer qu'on renvoie une redirection
public function store(StoreBranchRequest $request, Structure $structure)
{
    try {
        $structure->branches()->create([
            'nom' => $request->input('branch_name'),
            'description' => $request->input('branch_description'),
            'adresse' => $request->input('branch_location'),
            'code_branche' => strtoupper(Str::random(8)),
            'est_ouverte' => true,
        ]);

        return redirect()->back()->with('success', 'La branche a été créée avec succès !');

    } catch (\Exception $e) {
        // La syntaxe correcte pour le message d'erreur
        return redirect()->back()->with('error', 'Une erreur est survenue sur le serveur. Veuillez réessayer.');
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
    public function update(Request $request, Branche $branche)
    {
        $validated = $request->validate([
            'branch_name' => ['required','string','max:255'],
            'branch_description' => ['nullable','string','max:500'],
        ]);

        $branche->update([
            'nom'         => $validated['branch_name'],
            'description' => $validated['branch_description'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'La branche a été mise à jour avec succès.',
            'branche' => $branche->fresh(),
        ]);
    }

    public function destroy(Branche $branche)
    {
        $branche->delete();

        return response()->json([
            'success' => true,
            'message' => 'La branche a été supprimée avec succès.',
        ]);
    }
}
