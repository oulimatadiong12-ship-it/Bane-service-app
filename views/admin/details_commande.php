<?php
// views/admin/details_commande.php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Commande #<?= $commande['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary fw-bold">Détails Commande #<?= $commande['id'] ?></h1>
        <a href="<?= BASE_URL ?>/views/admin/commandes.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- Informations Client -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person-circle"></i> Informations Client
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> <?= htmlspecialchars($commande['nom'] . ' ' . $commande['prenom'] ?? '') ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($commande['email'] ?? '') ?></p>
                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($commande['telephone'] ?? 'N/A') ?></p>
                    <p><strong>Adresse :</strong> <?= htmlspecialchars($commande['adresse'] ?? 'N/A') ?></p>
                </div>
            </div>
        </div>

        <!-- Informations Commande -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-receipt"></i> Informations Commande
                </div>
                <div class="card-body">
                    <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></p>
                    <p><strong>Montant Total :</strong> <span class="text-success fw-bold"><?= number_format($commande['montant_total'], 2) ?> CFA</span></p>
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

    <!-- Produits commandés -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-cart-check"></i> Produits Commandés
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Image</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lignes)): ?>
                            <?php foreach($lignes as $ligne): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ligne['produit_nom'] ?? '') ?></td>
                                    <td>
                                        <?php if (!empty($ligne['image'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/produits/<?= htmlspecialchars($ligne['image'] ?? '') ?>" 
                                                 class="img-thumbnail" style="max-width:60px;">
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Pas d'image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= number_format($ligne['prix_unitaire'], 2) ?> CFA</td>
                                    <td><?= $ligne['quantite'] ?></td>
                                    <td class="fw-bold"><?= number_format($ligne['prix_unitaire'] * $ligne['quantite'], 2) ?> CFA</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucun produit.</td>
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