<?php
// views/client/notifications.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../includes/navbar.php";

// Exemple : données fictives pour la démo
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
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">🔔 Mes Notifications</h2>

    <div class="row g-4">
        <!-- Suivi commandes -->
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
                                    <strong>Commande #<?= htmlspecialchars($cmd['id']) ?></strong> - 
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

        <!-- Promotions personnalisées -->
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
</div>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
