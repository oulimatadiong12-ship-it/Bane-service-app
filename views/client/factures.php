<?php
// views/client/factures.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../includes/navbar.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Factures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h3>📑 Mes Factures</h3>
        </div>
        <div class="card-body">

            <!-- Historique des factures -->
            <h4 class="mb-3">Historique des factures</h4>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>FAC-001</td>
                            <td>2025-09-01</td>
                            <td>25 000 CFA</td>
                            <td><span class="badge bg-success">Payée</span></td>
                            <td><a href="#" class="btn btn-sm btn-outline-primary">Voir détail</a></td>
                        </tr>
                        <tr>
                            <td>FAC-002</td>
                            <td>2025-09-10</td>
                            <td>15 000 CFA</td>
                            <td><span class="badge bg-warning text-dark">En attente</span></td>
                            <td><a href="#" class="btn btn-sm btn-outline-primary">Voir détail</a></td>
                        </tr>
                        <tr>
                            <td>FAC-003</td>
                            <td>2025-09-20</td>
                            <td>30 000 CFA</td>
                            <td><span class="badge bg-danger">Impayée</span></td>
                            <td><a href="#" class="btn btn-sm btn-outline-primary">Voir détail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Détail des paiements -->
            <h4 class="mb-3">Détails des paiements</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th># Facture</th>
                            <th>Date Paiement</th>
                            <th>Méthode</th>
                            <th>Référence</th>
                            <th>Montant Payé</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>FAC-001</td>
                            <td>2025-09-01</td>
                            <td>Orange Money</td>
                            <td>OM123456</td>
                            <td>25 000 CFA</td>
                        </tr>
                        <tr>
                            <td>FAC-002</td>
                            <td>2025-09-10</td>
                            <td>Wave</td>
                            <td>WV987654</td>
                            <td>15 000 CFA</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
