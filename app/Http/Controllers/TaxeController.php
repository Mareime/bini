<?php

namespace App\Http\Controllers;

use App\Models\Taxe;
use Illuminate\Http\Request;
use App\Exports\TaxesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TaxesImport;

class TaxeController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $taxes = Taxe::all();
        return view('taxes.index', compact('taxes'));
    }

    public function edit($id)
    {
        $taxes = Taxe::findOrFail($id);
        return view('taxes.edit', compact('taxes'));
    }
    public function create()
    {
        return view('taxes.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'pourcentage' => 'required|numeric|min:0|max:100',
        ]);
    
        Taxe::create($request->only(['nom', 'pourcentage']));
    
        return redirect()->route('admin.taxes_index')->with('success', 'Taxe ajoutée avec succès.');
    }
    

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255', // Validation pour le nom de la taxe
            'pourcentage' => 'required|numeric|min:0|max:100', // Validation pour le pourcentage
        ]);
    

        $taxe = Taxe::findOrFail($id);
        $taxe->nom = $request->nom;
        $taxe->pourcentage = $request->pourcentage;

        $taxe->save();

        return redirect()->route('admin.taxes_index')->with('success', 'La taxe a été mise à jour avec succès.');
    }
    
    public function destroy($id)
{
    $taxe = Taxe::findOrFail($id); 
    $taxe->delete(); 

    return redirect()->route('admin.taxes_index')->with('success', 'Taxe supprimée avec succès.');
}
public function export()
    {
        return Excel::download(new TaxesExport, 'taxes.xlsx');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
    
        Excel::import(new TaxesImport, $request->file('file'));
    
        return redirect()->route('taxes.index')->with('success', 'Taxes importées avec succès.');
    }
    public function usertaxe()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        $taxes = Taxe::all();
        return view('partieUsers.taxe', compact('taxes'));
    }
}
