<?php
// views/admin/commandes.php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <!-- Titre principal -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary fw-bold">Gestion des Commandes</h1>
        <span class="badge bg-secondary"><?= count($commandes) ?> commande(s)</span>
    </div>

    <!-- Liste des commandes -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
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
                    <?php foreach($commandes as $cmd): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $cmd['id'] ?></td>
                            <td><?= htmlspecialchars(($cmd['nom'] ?? '') . ' ' . ($cmd['prenom'] ?? '')) ?></td>
                            <td><?= htmlspecialchars($cmd['email'] ?? '') ?></td>
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
                                <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=details&id=<?= $cmd['id'] ?>" 
                                   class="btn btn-sm btn-info mb-1">
                                    <i class="bi bi-eye"></i> Détails
                                </a>
                                
                                <?php if ($cmd['statut'] === 'en attente'): ?>
                                    <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=changer_statut&id=<?= $cmd['id'] ?>&statut=validée" 
                                       class="btn btn-sm btn-success mb-1">
                                        <i class="bi bi-check-circle"></i> Valider
                                    </a>
                                <?php endif; ?>

                                <?php if ($cmd['statut'] === 'validée'): ?>
                                    <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=changer_statut&id=<?= $cmd['id'] ?>&statut=livrée" 
                                       class="btn btn-sm btn-primary mb-1">
                                        <i class="bi bi-truck"></i> Livrer
                                    </a>
                                <?php endif; ?>

                                <a href="<?= BASE_URL ?>/controllers/CommandeController.php?action=supprimer&id=<?= $cmd['id'] ?>" 
                                   class="btn btn-sm btn-danger mb-1" 
                                   onclick="return confirm('Supprimer cette commande ?')">
                                    <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucune commande disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>