@extends('Navbar.index')

@section('content')
<div class="container">
    <h2>Liste des Comptes</h2>

    <!-- Barre de recherche avec Bootstrap -->
    <div class="mb-3">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un compte..." onkeyup="searchComptes()">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>

    <!-- Boutons d'exportation -->
    <div class="mb-3">
        <a href="{{ route('compte.export') }}" class="btn btn-primary">Exporter</a>
    </div>

    <!-- Messages d'alerte -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tableau des comptes -->
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Numéro du Compte</th>
                <th>Type de Compte</th>
                <th>Solde</th>
                <th>Date de Création</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody id="compteTable">
            @foreach($comptes as $compte)
                <tr>
                    <td>{{ $compte->numero }}</td>
                    <td>{{ $compte->type_compte }}</td>
                    <td>{{ number_format($compte->solde, 2, ',', ' ') }} URM</td>
                    <td>{{ \Carbon\Carbon::parse($compte->date_creation)->format('d/m/Y') }}</td>
                    <td>{{ $compte->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Script de recherche -->
<script>
    function searchComptes() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let rows = document.querySelectorAll("#compteTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }
</script>

@endsection
