<?php

namespace App\Http\Controllers;

use App\Models\Compteur;
use Illuminate\Http\Request;

class CompteurController extends Controller
{
    public function index()
    {
        $compteurs = Compteur::all();
        return view('compteurs.index', compact('compteurs'));
    }

    public function create()
    {
        return view('compteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee' => 'required|integer',
            'compteur' => 'required|integer',
        ]);

        Compteur::create($request->all());
        return redirect()->route('admin.compteure_index')->with('success', 'Compteur ajouté avec succès!');
    }

    // Méthode pour afficher le formulaire d'édition
    public function edit($id)
    {
        $compteur = Compteur::findOrFail($id);
        return view('compteurs.edit', compact('compteur'));
    }

    // Méthode pour mettre à jour un compteur
    public function update(Request $request, $id)
    {
        $request->validate([
            'annee' => 'required|integer',
            'compteur' => 'required|integer',
        ]);

        $compteur = Compteur::findOrFail($id);
        $compteur->update($request->all());

        return redirect()->route('admin.compteure_index')->with('success', 'Compteur mis à jour avec succès!');
    }

    // Méthode pour supprimer un compteur
    public function destroy($id)
    {
        $compteur = Compteur::findOrFail($id);
        $compteur->delete();

        return redirect()->route('admin.compteure_index')->with('success', 'Compteur supprimé avec succès!');
    }
}
