<?php
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . "/../../models/Produit.php";

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Bane-service-app/');
}

$produitModel = new Produit($pdo);
$produits = $produitModel->getAllproduits();

// Gestion du formulaire en mode modification
$editProduit = null;
if (isset($_GET['edit'])) {
    $editProduit = $produitModel->getproduitById($_GET['edit']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary fw-bold">Gestion des Produits</h1>
        <span class="badge bg-secondary"><?= count($produits) ?> produit(s)</span>
    </div>

    <!-- Formulaire ajout/modification -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-<?= $editProduit ? 'pencil-square' : 'plus-circle' ?>"></i>
            <?= $editProduit ? 'Modifier le produit #' . $editProduit['id'] : 'Ajouter un produit' ?>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>controllers/ProduitController.php" method="post">
                <input type="hidden" name="action" value="<?= $editProduit ? 'modifier' : 'ajouter' ?>">
                <?php if ($editProduit): ?>
                    <input type="hidden" name="id" value="<?= $editProduit['id'] ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Libellé :</label>
                        <input type="text" name="libelle" class="form-control" required
                               value="<?= $editProduit ? htmlspecialchars($editProduit['libelle']) : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catégorie :</label>
                        <input type="text" name="categorie" class="form-control"
                               value="<?= $editProduit ? htmlspecialchars($editProduit['categorie']) : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix d'achat :</label>
                        <input type="number" name="prixAchat" step="0.01" class="form-control" required
                               value="<?= $editProduit ? $editProduit['prixAchat'] : '' ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix de vente :</label>
                        <input type="number" name="prixVente" step="0.01" class="form-control" required
                               value="<?= $editProduit ? $editProduit['prixVente'] : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stock :</label>
                        <input type="number" name="stock" class="form-control"
                               value="<?= $editProduit ? $editProduit['stock'] : '0' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Seuil d'alerte :</label>
                        <input type="number" name="seuil_alerte" class="form-control"
                               value="<?= $editProduit ? $editProduit['seuil_alerte'] : '5' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fournisseur :</label>
                        <input type="text" name="fournisseur" class="form-control"
                               value="<?= $editProduit ? htmlspecialchars($editProduit['fournisseur']) : '' ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description :</label>
                        <textarea name="description" class="form-control" rows="3" required><?= $editProduit ? htmlspecialchars($editProduit['description']) : '' ?></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-<?= $editProduit ? 'warning' : 'success' ?>">
                        <i class="bi bi-check-circle"></i>
                        <?= $editProduit ? 'Modifier' : 'Ajouter' ?>
                    </button>
                    <?php if ($editProduit): ?>
                        <a href="<?= BASE_URL ?>views/admin/produits.php" class="btn btn-secondary ms-2">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des produits -->
    <h2 class="h4 mb-3">Liste des produits</h2>
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Libellé</th>
                    <th>Catégorie</th>
                    <th>Prix Achat</th>
                    <th>Prix Vente</th>
                    <th>Stock</th>
                    <th>Seuil</th>
                    <th>Fournisseur</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produits)): ?>
                    <?php foreach ($produits as $p): ?>
                        <tr>
                            <td class="text-center"><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['libelle']) ?></td>
                            <td><?= htmlspecialchars($p['categorie']) ?></td>
                            <td class="text-end"><?= number_format($p['prixAchat'], 2) ?> CFA</td>
                            <td class="text-end"><?= number_format($p['prixVente'], 2) ?> CFA</td>
                            <td class="text-center"><?= $p['stock'] ?></td>
                            <td class="text-center"><?= $p['seuil_alerte'] ?></td>
                            <td><?= htmlspecialchars($p['fournisseur']) ?></td>
                            <td><?= htmlspecialchars($p['description']) ?></td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>views/admin/produits.php?edit=<?= $p['id'] ?>" 
                                   class="btn btn-sm btn-warning mb-1">
                                   <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <a href="<?= BASE_URL ?>controllers/ProduitController.php?action=supprimer&id=<?= $p['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer ce produit ?');">
                                   <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted">Aucun produit enregistré.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
