<?php
// views/public/panier.php
session_start();
require_once __DIR__ . '/../../db/connexion.php';
require_once __DIR__ . '/../../models/Produit.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}

$panier = $_SESSION['panier'] ?? [];
$produitModel = new Produit($pdo);
$produits = $produitModel->getAllProduits();

// Indexer les produits par ID
$produits_indexed = [];
foreach ($produits as $p) {
    $produits_indexed[$p['id']] = $p;
}

// Calculer le total
$total = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="mb-4"><i class="bi bi-cart"></i> Mon Panier</h1>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'panier_vide'): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Votre panier est vide !
        </div>
    <?php endif; ?>

    <?php if (empty($panier)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Votre panier est vide.
            <a href="<?= BASE_URL ?>/controllers/ProduitController.php" class="alert-link">Voir les produits</a>
        </div>
    <?php else: ?>
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Produit</th>
                        <th>Image</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($panier as $id => $qty): ?>
                        <?php if (isset($produits_indexed[$id])): ?>
                            <?php 
                            $produit = $produits_indexed[$id];
                            $subtotal = $produit['prix'] * $qty;
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($produit['nom']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($produit['image'])): ?>
                                        <img src="<?= BASE_URL ?>/uploads/produits/<?= htmlspecialchars($produit['image']) ?>" 
                                             class="img-thumbnail" style="max-width:60px;">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Pas d'image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($produit['prix'], 2) ?> CFA</td>
                                <td class="text-center"><?= $qty ?></td>
                                <td class="fw-bold text-success"><?= number_format($subtotal, 2) ?> CFA</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr class="table-light">
                        <td colspan="4" class="text-end fw-bold">TOTAL :</td>
                        <td class="fw-bold text-success fs-5"><?= number_format($total, 2) ?> CFA</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="<?= BASE_URL ?>/controllers/ProduitController.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Continuer mes achats
            </a>
            
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=passer" 
                   class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle"></i> Valider la commande
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/views/public/login.php" class="btn btn-warning btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter pour commander
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>