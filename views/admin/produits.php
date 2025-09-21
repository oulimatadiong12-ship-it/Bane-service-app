<?php
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . "/../../models/Produit.php";

if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}

$produitModel = new Produit($pdo);
$produits = $produitModel->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <!-- Titre principal -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary fw-bold">Gestion des Produits</h1>
        <span class="badge bg-secondary"><?= count($produits) ?> produit(s)</span>
    </div>

    <!-- Formulaire ajout produit -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-plus-circle"></i> Ajouter un produit
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>/controllers/ProduitController.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="ajouter">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom :</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nom du produit" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix (CFA) :</label>
                        <input type="number" step="0.01" name="prix" class="form-control" placeholder="0.00" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Description :</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Décrivez le produit..." required></textarea>
                </div>

                <div class="mt-3">
                    <label class="form-label">Image :</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Ajouter
                    </button>
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
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produits)): ?>
                    <?php foreach ($produits as $p): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['nom']) ?></td>
                            <td class="text-success fw-bold"><?= number_format($p['prix'], 2) ?> CFA</td>
                            <td><?= htmlspecialchars($p['description']) ?></td>
                            <td class="text-center">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= BASE_URL ?>/uploads/produits/<?= htmlspecialchars($p['image']) ?>" 
                                         alt="Image produit" 
                                         class="img-thumbnail shadow-sm" 
                                         style="max-width: 80px;">
                                <?php else: ?>
                                    <span class="badge bg-secondary">Pas d'image</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>/views/admin/modifier_produit.php?id=<?= $p['id'] ?>" 
                                   class="btn btn-sm btn-warning mb-1">
                                   <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <a href="<?= BASE_URL ?>/controllers/ProduitController.php?action=supprimer&id=<?= $p['id'] ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Supprimer ce produit ?');">
                                   <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucun produit trouvé.</td>
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
