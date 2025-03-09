@extends('Navbar.index')

@section('content')

<div class="container">
    <h1>Liste des Paiements</h1>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Barre de recherche -->
    <div class="mb-3">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un paiement..." onkeyup="searchPaiements()">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                {{-- <th>id</th> --}}
                <th>Montant</th>
                <th>Date de Paiement</th>
                <th>Mode de Paiement</th>
                <th>Compte</th>
                <th>Bénéficiaire</th>
                <th>Status</th>
                <th>Motif de la dépense</th>
                <th>Impulsion</th>
            </tr>
        </thead>
        <tbody id="paiementTable">  <!-- Ajout de l'ID ici -->
            @foreach ($paiements as $paiement)
            <tr>
                {{-- <th>{{$paiement->id}}</th> --}}
                <td>{{ number_format($paiement->montant, 2, ',', ' ') }} URM</td>
                <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d') }}</td>
                <td>{{ $paiement->mode_paiement }}</td>
                <td>{{ $paiement->id_compte }}</td>
                <td>{{ $paiement->id_beneficiaire }}</td> 
                <td>{{ $paiement->status }}</td>
                <td>{{ $paiement->motif_de_la_depence }}</td>
                <td>{{ $paiement->impulsion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Script de recherche en JS -->
<script>
    function searchPaiements() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let rows = document.querySelectorAll("#paiementTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    }
</script>

@endsection
