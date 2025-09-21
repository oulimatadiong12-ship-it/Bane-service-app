<?php
$promotions = $promotions ?? []; // si $promotions n'est pas défini, on crée un tableau vide
// views/public/promotions.php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Promotions Actives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4 text-center">Promotions Actives</h1>

    <div class="row">
        <?php if (!empty($promotions)): ?>
            <?php foreach($promotions as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if(!empty($p['image_path']) && file_exists(__DIR__ . '/../../uploads/promotions/' . $p['image_path'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/promotions/<?= $p['image_path'] ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($p['titre']) ?>">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x250?text=Promotion" class="card-img-top" alt="Promo">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($p['titre']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                            <p>
                                <span class="badge bg-info"><?= ucfirst($p['type']) ?></span>
                            </p>
                            <p class="text-muted">
                                <small>Du <?= date('d/m/Y', strtotime($p['date_debut'])) ?> 
                                au <?= date('d/m/Y', strtotime($p['date_fin'])) ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">Aucune promotion active pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
