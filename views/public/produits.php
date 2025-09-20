<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définir l'URL de base pour les liens si ce n’est pas déjà défini
if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue Produits</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Catalogue Produits</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="<?= BASE_URL ?>/controllers/ProduitController.php" 
          class="mb-4 d-flex justify-content-center">
        <input type="hidden" name="page" value="catalogue">
        <input type="text" name="search" class="form-control me-2 w-50" 
               placeholder="Rechercher un produit..." 
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <!-- Liste des produits -->
    <div class="row">
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Image produit -->
                        <img src="<?= $p['image_url'] ?>" 
                             class="card-img-top" 
                             alt="<?= $p['image_alt'] ?>">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($p['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                            <p class="fw-bold text-success">
                                <?= number_format($p['prix'], 2, ',', ' ') ?> FCFA
                            </p>
                        </div>
                        <div class="card-footer text-center">
                            <?php if (!isset($_SESSION['user'])): ?>
                                <a href="<?= BASE_URL ?>/views/public/login.php" class="btn btn-warning">
                                    Ajouter au panier
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/controllers/PanierController.php?action=ajouter&id=<?= $p['id'] ?>" 
                                   class="btn btn-success">
                                    Ajouter au panier
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">Aucun produit trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
        crossorigin="anonymous"></script>
</body>
</html>
