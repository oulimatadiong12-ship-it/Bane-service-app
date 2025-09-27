<?php
// views/admin/details_commande.p
require_once __DIR__ . '/../../db/connexion.php';
require_once __DIR__ . '/../../models/Commande.php';
require_once __DIR__ . '/../../models/LigneCommande.php';
require_once __DIR__ . '/../../includes/navbar.php';

$commandeModel = new Commande($pdo);
$ligneCommandeModel = new LigneCommande($pdo);

// Récupération de l'ID depuis l'URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Vérification de l'ID
if ($id <= 0) {
    echo "<div class='alert alert-danger m-4'>ID de commande invalide.</div>";
    exit;
}

// Récupérer les données
$commande = $commandeModel->getById($id);
$lignes = $ligneCommandeModel->getBycommande($id);

// Vérifie si la commande existe
if (!$commande) {
    echo "<div class='alert alert-danger m-4'>Commande introuvable.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Commande #<?= htmlspecialchars($commande['id']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">Détails Commande #<?= htmlspecialchars($commande['id']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=liste" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>
<a href="<?= BASE_URL ?>/views/admin/details_commande.php?id=<?= $cmd['id'] ?>"
   class="btn btn-sm btn-outline-secondary">
   <i class="bi bi-eye"></i> Détails
</a>
    <div class="row mb-4">
        <!-- Informations Client -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person"></i> Client
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> <?= htmlspecialchars($commande['nom'] . ' ' . $commande['prenom']) ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($commande['email']) ?></p>
                    <!-- Si tu as d’autres champs utilisateurs comme téléphone, adresse, les afficher ici -->
                </div>
            </div>
        </div>
        <!-- Infos Commande -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-receipt"></i> Commande
                </div>
                <div class="card-body">
                    <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></p>
                    <p><strong>Montant total :</strong> <span class="text-success fw-bold"><?= number_format($commande['montant_total'], 2) ?> CFA</span></p>
                    <p>
                        <strong>Statut :</strong>
                        <?php
                        $badges = [
                            'en attente' => 'warning',
                            'validée' => 'info',
                            'livrée' => 'success',
                            'annulée' => 'danger'
                        ];
                        $badge_class = $badges[$commande['statut']] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?= $badge_class ?>"><?= ucfirst($commande['statut']) ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lignes de commande / Produits -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-cart"></i> Produits commandés
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Image</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lignes)): ?>
                            <?php foreach ($lignes as $ligne): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ligne['produit_nom'] ?? '') ?></td>
                                    <td>
                                        <?php if (!empty($ligne['image'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/produits/<?= htmlspecialchars($ligne['image']) ?>"
                                                 class="img-thumbnail" style="max-width: 60px;">
                                        <?php else: ?>
                                            <span class="text-muted">Pas d’image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= number_format($ligne['prix_unitaire'], 2) ?> CFA</td>
                                    <td><?= htmlspecialchars($ligne['quantite']) ?></td>
                                    <td class="fw-bold"><?= number_format($ligne['prix_unitaire'] * $ligne['quantite'], 2) ?> CFA</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Pas de produits dans cette commande.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
