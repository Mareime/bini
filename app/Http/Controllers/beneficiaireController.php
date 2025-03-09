<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaire;
use Illuminate\Http\Request;
use App\Exports\BeneficiairesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BeneficiairesImport;

class beneficiaireController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $beneficiaires = Beneficiaire::all();
        return view('admin.beneficiere', compact('beneficiaires'));
    }

    public function create()
    {
        return view('beneficiaire.create');
    }

    public function edit(Beneficiaire $beneficiaire)
    {
        return view('beneficiaire.edit', compact('beneficiaire'));
    }

    public function update(Request $request, Beneficiaire $beneficiaire)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|numeric',
            'email' => 'nullable|email',
            'type_beneficiaire' => 'nullable|in:personne,entreprise',
        ]);
    
        $beneficiaire->update($request->all());
    
        return redirect()->route('admin.benefi_index')->with('success', 'Bénéficiaire mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|numeric|digits:8|regex:/^[2-4][0-9]{7}$/',
            'email' => 'required|email',
            'type_beneficiaire' => 'required|in:personne,entreprise',
        ]);
        
        Beneficiaire::create($request->all());

        return redirect()->route('admin.benefi_index')->with('success', 'Bénéficiaire créé avec succès.');
    }

    public function destroy(Beneficiaire $beneficiaire)
    {
        // Supprimez les paiements associés au bénéficiaire (si applicable)
        $beneficiaire->paiements()->delete();
        
        // Supprimez le bénéficiaire
        $beneficiaire->delete();
    
        return redirect()->route('admin.benefi_index')->with('success', 'Bénéficiaire supprimé avec succès.');
    }
    
    

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new BeneficiairesImport, $request->file('file'));
            return redirect()->route('beneficiaire.index')->with('success', 'Bénéficiaires importés avec succès!');
        } catch (\Exception $e) {
            return redirect()->route('beneficiaire.index')->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new BeneficiairesExport, 'beneficiaires.xlsx');
    }
    public function userb()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $beneficiaires = Beneficiaire::all();
        return view('partieUsers.b', compact('beneficiaires'));
    }
}
