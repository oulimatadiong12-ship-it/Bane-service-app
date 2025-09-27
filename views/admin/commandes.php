<?php
// views/admin/commandes.php
require_once __DIR__ . '/../../controllers/CommandeController.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Liste des commandes</h2>
        <span class="badge bg-dark"><?= count($commandes) ?> commande(s)</span>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($commandes)): ?>
                    <?php foreach ($commandes as $cmd): ?>
                        <tr>
                            <td class="text-center"><?= $cmd['id'] ?></td>
                            <td><?= htmlspecialchars($cmd['nom'] . ' ' . $cmd['prenom']) ?></td>
                            <td><?= htmlspecialchars($cmd['email']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($cmd['date_commande'])) ?></td>
                            <td class="text-success fw-bold"><?= number_format($cmd['montant_total'], 2) ?> CFA</td>
                            <td class="text-center">
                                <?php 
                                    $badges = [
                                        'en attente' => 'warning',
                                        'validée' => 'info',
                                        'livrée' => 'success',
                                        'annulée' => 'danger'
                                    ];
                                    $badge_class = $badges[$cmd['statut']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $badge_class ?>"><?= ucfirst($cmd['statut']) ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($cmd['statut'] === 'en attente'): ?>
                                    <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=changer_statut&id=<?= $cmd['id'] ?>&statut=validée"
                                       class="btn btn-sm btn-success">Valider</a>
                                <?php endif; ?>

                                <?php if ($cmd['statut'] === 'validée'): ?>
                                    <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=changer_statut&id=<?= $cmd['id'] ?>&statut=livrée"
                                       class="btn btn-sm btn-primary">Livrer</a>
                                <?php endif; ?>

                                <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=supprimer&id=<?= $cmd['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer cette commande ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted">Aucune commande.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
