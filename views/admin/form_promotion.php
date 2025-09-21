<?php
// views/admin/form_promotion.php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($promotion) ? 'Modifier' : 'Ajouter' ?> une promotion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><?= isset($promotion) ? 'Modifier la promotion' : 'Ajouter une promotion' ?></h2>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>/controllers/PromotionController.php" 
                  method="post" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="<?= isset($promotion) ? 'modifier' : 'ajouter' ?>">
                <?php if(isset($promotion)): ?>
                    <input type="hidden" name="id" value="<?= $promotion['id'] ?>">
                    <input type="hidden" name="old_image" value="<?= $promotion['image_path'] ?? '' ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Titre :</label>
                    <input type="text" name="titre" class="form-control" 
                           value="<?= $promotion['titre'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description :</label>
                    <textarea name="description" class="form-control" rows="3"><?= $promotion['description'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type :</label>
                    <select name="type" class="form-select" required>
                        <option value="canal" <?= (isset($promotion['type']) && $promotion['type']=='canal')?'selected':'' ?>>Canal+</option>
                        <option value="produit" <?= (isset($promotion['type']) && $promotion['type']=='produit')?'selected':'' ?>>Produit</option>
                        <option value="service" <?= (isset($promotion['type']) && $promotion['type']=='service')?'selected':'' ?>>Service</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date début :</label>
                        <input type="date" name="date_debut" class="form-control" 
                               value="<?= $promotion['date_debut'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date fin :</label>
                        <input type="date" name="date_fin" class="form-control" 
                               value="<?= $promotion['date_fin'] ?? '' ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statut :</label>
                    <select name="statut" class="form-select" required>
                        <option value="active" <?= (isset($promotion['statut']) && $promotion['statut']=='active')?'selected':'' ?>>Active</option>
                        <option value="inactive" <?= (isset($promotion['statut']) && $promotion['statut']=='inactive')?'selected':'' ?>>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image :</label>
                    <input type="file" name="image" class="form-control">
                    <?php if(isset($promotion['image_path']) && $promotion['image_path']): ?>
                        <img src="<?= BASE_URL ?>/uploads/promotions/<?= $promotion['image_path'] ?>" 
                             alt="image promo" class="img-thumbnail mt-2" style="max-width:120px;">
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <?= isset($promotion) ? 'Mettre à jour' : 'Ajouter' ?>
                    </button>
                    <a href="<?= BASE_URL ?>/views/admin/promotions.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
