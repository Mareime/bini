<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #343a40, #212529);
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0px 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .nav-links {
            flex-grow: 1;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background: #495057;
            transform: scale(1.05);
        }
        .logout {
            margin-top: auto;
            background: #dc3545;
            text-align: center;
            font-weight: bold;
            padding: 12px;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }
        .logout:hover {
            background: #c82333;
            transform: scale(1.05);
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            text-align: center;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 2.5rem;
            font-weight: 600;
        }
        .badge-custom {
            font-size: 1.2rem;
            margin-left: 10px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
            }
            .content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="nav-links">
            <h2><a href="{{ route('admin.dashboard')}}">Dashboard</a></h2>
            <a href="{{ route('admin.compt_index')}}"><i class="fas fa-wallet"></i> Comptes</a>
            <a href="{{ route("admin.benefi_index")}}"><i class="fas fa-users"></i> Bénéficiaires</a>
            <a href="{{route("admin.paieme_index")}}"><i class="fas fa-credit-card"></i> Paiements</a>
            <a href="{{route("admin.taxes_index")}}"><i class="fas fa-money-bill-wave"></i> Taxes</a>
            <a href="{{route('admin.compteure_index')}}"><i class="fas fa-calendar-alt"></i> Année/id</a>
            <a href="{{route("admin.users")}}"><i class="fas fa-users-cog"></i> Utilisateurs</a>
        </div>
        <a class="logout" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>

    <div class="content" id="content">
        <div class="container">
            <div class="row">
                <!-- Cartes pour les statistiques -->
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('admin.compt_index')}}"><i class="fas fa-wallet"></i> Comptes</a>
                            </h5>
                            <p class="card-text fs-3" id="total-comptes">{{count($comptes)}}</p>
                            {{-- <span class="badge badge-custom bg-light text-dark" id="badge-comptes">N/A</span> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route("admin.benefi_index")}}"><i class="fas fa-users"></i> Bénéficiaires</a></h5>
                            <p class="card-text fs-3" id="total-beneficiaires">{{count($beneficiaires)}}</p>
                            {{-- <span class="badge badge-custom bg-light text-dark" id="badge-beneficiaires">N/A</span> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{route("admin.paieme_index")}}"><i class="fas fa-credit-card"></i> Paiements</a></h5>
                            <p class="card-text fs-3" id="total-paiements">{{count($paiements)}}</p>
                            {{-- <span class="badge badge-custom bg-light text-dark" id="badge-paiements">N/A</span> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{route("admin.taxes_index")}}"><i class="fas fa-money-bill-wave"></i> Taxes</a></h5>
                            <p class="card-text fs-3" id="total-taxes">{{count($taxes)}}</p>
                            {{-- <span class="badge badge-custom bg-light text-dark" id="badge-taxes">N/A</span> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{route("admin.users")}}"><i class="fas fa-users-cog"></i> Utilisateurs</a></h5>
                            <p class="card-text fs-3" id="total-users">{{count($users)}}</p>
                            {{-- <span class="badge badge-custom bg-light text-dark" id="badge-users">N/A</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
    function loadContent(url) {
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement de la page:', error);
            document.getElementById('content').innerHTML = '<h1>Erreur</h1><p>Impossible de charger la page.</p>';
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ route('admin.dashboard.stats') }}")
            .then(response => response.json())
            .then(data => {
                // Met à jour les nombres sur les cartes
                document.getElementById("total-comptes").innerText = data.comptes;
                document.getElementById("total-beneficiaires").innerText = data.beneficiaires;
                document.getElementById("total-paiements").innerText = data.paiements;
                document.getElementById("total-taxes").innerText = data.taxes;
                document.getElementById("total-users").innerText = data.users;

                // Met à jour les badges
                document.getElementById("badge-comptes").innerText = data.comptes ? "OK" : "N/A";
                document.getElementById("badge-beneficiaires").innerText = data.beneficiaires ? "OK" : "N/A";
                document.getElementById("badge-paiements").innerText = data.paiements ? "OK" : "N/A";
                document.getElementById("badge-taxes").innerText = data.taxes ? "OK" : "N/A";
                document.getElementById("badge-users").innerText = data.users ? "OK" : "N/A";
            })
            .catch(error => console.error("Erreur lors du chargement des statistiques:", error));
    });
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
