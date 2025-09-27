<?php
// views/client/factures.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../includes/navbar.php";

// Données fictives (à remplacer par les vraies depuis ta BDD)
$factures = [
    ['id' => 'FAC-001', 'date' => '2025-09-01', 'montant' => 25000, 'statut' => 'payée'],
    ['id' => 'FAC-002', 'date' => '2025-09-10', 'montant' => 15000, 'statut' => 'en attente'],
    ['id' => 'FAC-003', 'date' => '2025-09-20', 'montant' => 30000, 'statut' => 'impayée'],
];
$paiements = [
    ['facture_id' => 'FAC-001', 'date_paiement' => '2025-09-01', 'methode' => 'Orange Money', 'reference' => 'OM123456', 'montant' => 25000],
    ['facture_id' => 'FAC-002', 'date_paiement' => '2025-09-10', 'methode' => 'Wave', 'reference' => 'WV987654', 'montant' => 15000],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Mes Factures</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      background-color: #fff;
      border-right: 1px solid #dee2e6;
      padding-top: 1rem;
      position: sticky;
      top: 0;
    }

    .sidebar .nav-link {
      color: #333;
      font-weight: 500;
      padding: 12px 16px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #f0f0f0;
      color: #0d6efd;
      font-weight: 600;
    }

    .content {
                margin-left: 0;
                padding: 1rem;
                padding-top: 56px;
                padding-bottom: 70px;
            }
    .table th,
    .table td {
      vertical-align: middle;
    }
  </style>
</head>

<body>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <aside class="col-md-2 d-none d-md-block sidebar">
      <nav class="nav flex-column">
        <a class="nav-link" href="<?= BASE_URL ?>/views/client/dashboard.php"><i class="bi bi-house"></i> Tableau de bord</a>
        <a class="nav-link" href="<?= BASE_URL ?>/views/client/commandes.php"><i class="bi bi-cart"></i> Mes commandes</a>
        <a class="nav-link active" href="<?= BASE_URL ?>/views/client/factures.php"><i class="bi bi-file-earmark-text"></i> Mes factures</a>
        <a class="nav-link" href="<?= BASE_URL ?>/views/client/profil.php"><i class="bi bi-person"></i> Mon profil</a>
        <a class="nav-link" href="<?= BASE_URL ?>/views/client/notifications.php"><i class="bi bi-bell"></i> Notifications</a>
      </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="col-md-10 ms-sm-auto content">
      <h1 class="mb-4"><i class="bi bi-file-earmark-text"></i> Mes Factures</h1>

      <!-- Carte des factures -->
      <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white text-center">
          <h5 class="mb-0">📜 Historique des factures</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
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
                <?php foreach ($factures as $facture): 
                  $badgeClass = match ($facture['statut']) {
                    'payée' => 'success',
                    'en attente' => 'warning text-dark',
                    'impayée' => 'danger',
                    default => 'secondary'
                  };
                ?>
                <tr>
                  <td><?= htmlspecialchars($facture['id']) ?></td>
                  <td><?= htmlspecialchars($facture['date']) ?></td>
                  <td><?= number_format($facture['montant'], 0, ',', ' ') ?> CFA</td>
                  <td><span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($facture['statut']) ?></span></td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Voir détail</a></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Carte des paiements -->
      <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white text-center">
          <h5 class="mb-0">💳 Détails des paiements</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th># Facture</th>
                  <th>Date Paiement</th>
                  <th>Méthode</th>
                  <th>Référence</th>
                  <th>Montant Payé</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($paiements as $paiement): ?>
                <tr>
                  <td><?= htmlspecialchars($paiement['facture_id']) ?></td>
                  <td><?= htmlspecialchars($paiement['date_paiement']) ?></td>
                  <td><?= htmlspecialchars($paiement['methode']) ?></td>
                  <td><?= htmlspecialchars($paiement['reference']) ?></td>
                  <td><?= number_format($paiement['montant'], 0, ',', ' ') ?> CFA</td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

  </div>
</div>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
