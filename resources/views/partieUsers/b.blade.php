@extends('Navbar.index') <!-- inclut la navbar depuis Navbar/index.blade.php -->

@section('content')

    <div class="container">
        <h2 class="mb-4">Liste des Bénéficiaires</h2>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Barre de recherche -->
        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un bénéficiaire..." onkeyup="searchBeneficiaires()">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>
        </div>

        <!-- Conteneur avec alignement à droite pour les boutons Exporter et Importer -->
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('beneficiaire.export') }}" class="btn btn-primary mr-2">Exporter</a>
        </div>

        <!-- Tableau des bénéficiaires -->
        <table class="table table-bordered table-striped" id="beneficiaireTable">
            <thead class="thead-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Type de Bénéficiaire</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiaires as $beneficiaire)
                <tr>
                    <td>{{ $beneficiaire->nom }}</td>
                    <td>{{ $beneficiaire->prenom }}</td>
                    <td>{{ $beneficiaire->adresse }}</td>
                    <td>{{ $beneficiaire->telephone }}</td>
                    <td>{{ $beneficiaire->email }}</td>
                    <td>{{ $beneficiaire->type_beneficiaire }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Script JavaScript pour la recherche -->
    <script>
        function searchBeneficiaires() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("beneficiaireTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // commencer à partir de 1 pour ignorer l'en-tête
                let cells = rows[i].getElementsByTagName("td");
                let found = false;

                // Vérifier si le texte dans chaque cellule correspond à la recherche
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }

                // Afficher ou cacher la ligne en fonction de la recherche
                rows[i].style.display = found ? "" : "none";
            }
        }
    </script>

@endsection
