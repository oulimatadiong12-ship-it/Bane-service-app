<?php
$promotions = $promotions ?? []; // si $promotions n'est pas défini, on crée un tableau vide

// views/admin/promotions.php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Promotions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <!-- Titre principal -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary fw-bold">Gestion des Promotions</h1>
        <span class="badge bg-secondary"><?= count($promotions) ?> promotion(s)</span>
    </div>

    <!-- Bouton ajouter -->
    <a href="<?= BASE_URL ?>/controllers/PromotionController.php?action=edit" class="btn btn-success mb-4">
        <i class="bi bi-plus-circle"></i> Ajouter une promotion
    </a>

    <!-- Liste des promotions -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Statut</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($promotions)): ?>
                    <?php foreach($promotions as $p): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['titre']) ?></td>
                            <td>
                                <span class="badge bg-info"><?= ucfirst($p['type']) ?></span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($p['date_debut'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($p['date_fin'])) ?></td>
                            <td>
                                <?php if($p['statut'] === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if(!empty($p['image_path']) && file_exists(__DIR__ . '/../../uploads/promotions/' . $p['image_path'])): ?>
                                    <img src="<?= BASE_URL ?>/uploads/promotions/<?= $p['image_path'] ?>" 
                                         class="img-thumbnail" style="max-width:80px;">
                                <?php else: ?>
                                    <span class="badge bg-secondary">Pas d'image</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>/controllers/PromotionController.php?action=edit&id=<?= $p['id'] ?>" 
                                   class="btn btn-sm btn-warning mb-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <a href="<?= BASE_URL ?>/controllers/PromotionController.php?action=supprimer&id=<?= $p['id'] ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Supprimer cette promotion ?')">
                                    <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Aucune promotion disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
