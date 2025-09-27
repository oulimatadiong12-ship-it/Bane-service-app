<?php
// views/client/notifications.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../includes/navbar.php";

// Données fictives
$commandes = [
    ["id" => 101, "produit" => "Chaussures Nike", "statut" => "En cours de livraison", "date" => "2025-09-20"],
    ["id" => 102, "produit" => "Ordinateur HP", "statut" => "Livré", "date" => "2025-09-15"],
    ["id" => 103, "produit" => "Montre Rolex", "statut" => "En attente de paiement", "date" => "2025-09-10"],
];

$promos = [
    ["titre" => "Promo spéciale rentrée", "message" => "-20% sur les produits électroniques jusqu’au 30 Septembre !"],
    ["titre" => "Offre Fidélité", "message" => "Vous avez gagné un coupon de 5000 FCFA valable sur votre prochaine commande."],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Mes Notifications</title>
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
    .list-group-item {
      border-left: 5px solid #0d6efd2e;
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
        <a class="nav-link" href="<?= BASE_URL ?>/views/client/factures.php"><i class="bi bi-file-earmark-text"></i> Mes factures</a>
        <a class="nav-link" href="<?= BASE_URL ?>/views/client/profil.php"><i class="bi bi-person"></i> Mon profil</a>
        <a class="nav-link active" href="<?= BASE_URL ?>/views/client/notifications.php"><i class="bi bi-bell"></i> Notifications</a>
      </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="col-md-10 ms-sm-auto content">
      <h1 class="mb-4"><i class="bi bi-bell"></i> Mes Notifications</h1>

      <div class="row g-4">

        <!-- Notifications commandes -->
        <div class="col-lg-6">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
              📦 Suivi de mes commandes
            </div>
            <div class="card-body">
              <?php if (!empty($commandes)): ?>
                <ul class="list-group list-group-flush">
                  <?php foreach ($commandes as $cmd): ?>
                    <li class="list-group-item">
                      <strong>Commande #<?= htmlspecialchars($cmd['id']) ?></strong> — 
                      <?= htmlspecialchars($cmd['produit']) ?>
                      <span class="badge bg-info ms-2"><?= htmlspecialchars($cmd['statut']) ?></span>
                      <div class="text-muted small">📅 <?= htmlspecialchars($cmd['date']) ?></div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <p class="text-muted">Aucune commande en cours.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Notifications promotions -->
        <div class="col-lg-6">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
              🎁 Promotions personnalisées
            </div>
            <div class="card-body">
              <?php if (!empty($promos)): ?>
                <?php foreach ($promos as $promo): ?>
                  <div class="alert alert-warning mb-3">
                    <h6 class="mb-1"><?= htmlspecialchars($promo['titre']) ?></h6>
                    <p class="mb-0"><?= htmlspecialchars($promo['message']) ?></p>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted">Pas de promotions disponibles pour le moment.</p>
              <?php endif; ?>
            </div>
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
