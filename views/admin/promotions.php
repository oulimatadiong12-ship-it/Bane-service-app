<?php
require_once __DIR__ . '/../../db/connexion.php';
require_once __DIR__ . '/../../models/Promotion.php';
require_once __DIR__ . '/../../includes/navbar.php';

$promotionModel = new Promotion($pdo);
$promotions = $promotionModel->getAll();

$isEditing = false;
$promotionToEdit = null;

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $promotionToEdit = $promotionModel->getById($_GET['id']);
    if ($promotionToEdit) {
        $isEditing = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Promotions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- La navbar est déjà affichée depuis navbar.php -->

<div class="container my-5">
    <h1 class="h3 mb-4 text-primary fw-bold">Gestion des Promotions</h1>

    <!-- Formulaire Ajout / Modification -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <?= $isEditing ? 'Modifier la Promotion' : 'Ajouter une Promotion' ?>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>controllers/PromotionController.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $isEditing ? 'modifier' : 'ajouter' ?>">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?= $promotionToEdit['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Titre :</label>
                    <input type="text" name="titre" class="form-control" value="<?= $promotionToEdit['titre'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description :</label>
                    <textarea name="description" class="form-control" rows="3"><?= $promotionToEdit['description'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image :</label>
                    <input type="file" name="image" class="form-control">
                    <?php if (!empty($promotionToEdit['image_path'])): ?>
                        <img src="<?= BASE_URL ?>uploads/promotions/<?= htmlspecialchars($promotionToEdit['image_path']) ?>" class="img-thumbnail mt-2" style="max-width: 100px;">
                    <?php endif; ?>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Type :</label>
                        <select name="type" class="form-select" required>
                            <option value="produit" <?= isset($promotionToEdit['type']) && $promotionToEdit['type'] === 'produit' ? 'selected' : '' ?>>Produit</option>
                            <option value="service" <?= isset($promotionToEdit['type']) && $promotionToEdit['type'] === 'service' ? 'selected' : '' ?>>Service</option>
                            <option value="canal" <?= isset($promotionToEdit['type']) && $promotionToEdit['type'] === 'canal' ? 'selected' : '' ?>>Canal</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date de début :</label>
                        <input type="date" name="date_debut" class="form-control" value="<?= $promotionToEdit['date_debut'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date de fin :</label>
                        <input type="date" name="date_fin" class="form-control" value="<?= $promotionToEdit['date_fin'] ?? '' ?>" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Statut :</label>
                    <select name="statut" class="form-select">
                        <option value="active" <?= isset($promotionToEdit['statut']) && $promotionToEdit['statut'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= isset($promotionToEdit['statut']) && $promotionToEdit['statut'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-<?= $isEditing ? 'warning' : 'success' ?>">
                        <?= $isEditing ? 'Modifier' : 'Ajouter' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="<?= BASE_URL ?>views/admin/promotions.php" class="btn btn-secondary">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des Promotions -->
    <h2 class="h4 mb-3">Liste des Promotions</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($promotions)): ?>
                    <?php foreach ($promotions as $promo): ?>
                        <tr>
                            <td class="text-center"><?= $promo['id'] ?></td>
                            <td><?= htmlspecialchars($promo['titre']) ?></td>
                            <td class="text-center"><?= $promo['type'] ?></td>
                            <td class="text-center"><?= $promo['date_debut'] ?></td>
                            <td class="text-center"><?= $promo['date_fin'] ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $promo['statut'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= $promo['statut'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($promo['image_path'])): ?>
                                    <img src="<?= BASE_URL ?>uploads/promotions/<?= htmlspecialchars($promo['image_path']) ?>" class="img-thumbnail" style="max-width: 60px;">
                                <?php else: ?>
                                    <span class="text-muted">Aucune</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="?action=edit&id=<?= $promo['id'] ?>" class="btn btn-sm btn-warning">
                                    Modifier
                                </a>
                                <a href="<?= BASE_URL ?>controllers/PromotionController.php?action=supprimer&id=<?= $promo['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer cette promotion ?');">
                                   Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted">Aucune promotion enregistrée.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

</body>
</html>
