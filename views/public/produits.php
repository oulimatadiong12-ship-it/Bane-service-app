<?php
// views/public/produits.php

session_start();

require_once __DIR__ . "/../../config.php";  
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . "/../../models/Produit.php";

// Instanciation du modèle
$produitModel = new Produit($pdo);

// Récupérer le mot-clé de recherche si fourni
$search = $_GET['search'] ?? '';

// Charger les produits selon la recherche ou tous
if (!empty($search)) {
    $produits = $produitModel->search($search);
} else {
    $produits = $produitModel->getAllProduits();
}

// Vérifier la connexion utilisateur (adapter selon ta session)
$connected = isset($_SESSION['user_id']); 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container my-5">
    <h1 class="mb-4 text-primary">Catalogue Produits</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="<?= BASE_URL ?>views/public/produits.php" class="mb-4">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Rechercher un produit..."
                value="<?= htmlspecialchars($search) ?>"
            >
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-search"></i> Rechercher
            </button>
        </div>
    </form>

    <!-- Catalogue produits -->
    <div class="row g-4">
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $p): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Si image dans le modèle, sinon remplacer / retirer cette partie -->
                        <?php /* Si tu as champ image dans modèle */ ?>
                        <?php if (!empty($p['image'])): ?>
                            <img 
                                src="<?= BASE_URL ?>uploads/produits/<?= htmlspecialchars($p['image']) ?>" 
                                class="card-img-top" 
                                alt="<?= htmlspecialchars($p['libelle']) ?>" 
                                style="object-fit: cover; height: 200px;"
                            >
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-secondary text-white" style="height: 200px;">
                                Pas d'image
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($p['libelle']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($p['categorie']) ?></p>
                            <p class="card-text mb-1"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                            <div class="mt-auto">
                                <span class="fw-bold text-success"><?= number_format($p['prixVente'], 2) ?> FCFA</span>
                            </div>
                            <div class="mt-3">
                                <?php if ($connected): ?>
                                    <a href="<?= BASE_URL ?>controllers/PanierController.php?action=ajouter&id=<?= $p['id'] ?>" class="btn btn-primary">
                                        <i class="bi bi-cart-plus"></i> Ajouter au panier
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>views/public/login.php" class="btn btn-secondary">
                                        Ajouter au panier
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">Aucun produit trouvé.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<? require_once __DIR__ . '/../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>