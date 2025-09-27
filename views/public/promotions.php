<?php
// views/public/promotions.php

session_start();

require_once __DIR__ . '/../../db/connexion.php';
require_once __DIR__ . '/../../models/Promotion.php';
require_once __DIR__ . '/../../includes/navbar.php';

$promotionModel = new Promotion($pdo);

// Récupérer le mot-clé de recherche
$search = $_GET['search'] ?? '';

// Récupérer les promotions actives (avec ou sans filtre)
$promotions = $promotionModel->getPromotionsActives($search); // Méthode à implémenter dans le modèle
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Promotions Actives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- La navbar est déjà incluse via navbar.php -->

<div class="container my-5">
    <h1 class="mb-4 text-primary text-center">Promotions Actives</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Rechercher une promotion..."
                value="<?= htmlspecialchars($search) ?>"
            >
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </div>
    </form>

    <!-- Liste des promotions -->
    <div class="row g-4">
        <?php if (!empty($promotions)): ?>
            <?php foreach ($promotions as $promo): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($promo['image_path'])): ?>
                            <img 
                                src="<?= BASE_URL ?>uploads/promotions/<?= htmlspecialchars($promo['image_path']) ?>" 
                                class="card-img-top" 
                                alt="<?= htmlspecialchars($promo['titre']) ?>" 
                                style="object-fit: cover; height: 200px;"
                            >
                        <?php else: ?>
                            <div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                                Aucune image
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($promo['titre']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($promo['description'])) ?></p>
                            <p class="text-muted mt-auto">
                                <small>Du <?= htmlspecialchars($promo['date_debut']) ?> au <?= htmlspecialchars($promo['date_fin']) ?></small>
                            </p>
                            <a href="<?= BASE_URL ?>views/public/promotion_detail.php?id=<?= $promo['id'] ?>" class="btn btn-primary mt-3">
                                Voir plus
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">Aucune promotion active trouvée.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
