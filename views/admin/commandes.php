<?php
// views/admin/commandes.php

require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . "/../../models/Commande.php";
require_once __DIR__ . "/../../includes/navbar.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Commandes - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php renderNavbar($role); ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary">Gestion des Commandes</h1>
        <!-- (Optionnel) bouton pour créer une commande manuellement -->
        <a href="<?= BASE_URL ?>controllers/CommandeController.php?action=ajouter" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nouvelle commande
        </a>
    </div>

    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (!empty($commandes) && count($commandes) > 0): ?>
        <div class="table-responsive shadow-sm bg-white">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Montant Total</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $cmd): ?>
                        <tr>
                            <td><?= htmlspecialchars($cmd['id']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($cmd['date_commande'])) ?></td>
                            <td><?= htmlspecialchars($cmd['nom'] . ' ' . $cmd['prenom']) ?></td>
                            <td><?= htmlspecialchars($cmd['email']) ?></td>
                            <td><span class="text-success fw-bold"><?= number_format($cmd['montant_total'], 2) ?> CFA</span></td>
                            <td>
                                <?php
                                $badges = [
                                    'en attente' => 'warning',
                                    'validée' => 'info',
                                    'livrée'   => 'success',
                                    'annulée'  => 'danger',
                                ];
                                $badge_class = $badges[$cmd['statut']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $badge_class ?>"><?= ucfirst(htmlspecialchars($cmd['statut'])) ?></span>
                            </td>
                            <td>
                                <!-- Voir Détails -->
                                <a href="<?= BASE_URL ?>controllers/CommandeController.php?action=details&id=<?= $cmd['id'] ?>" 
                                   class="btn btn-sm btn-primary" title="Voir les détails">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <!-- Changer statut (ex : de “en attente” à “validée”) -->
                                <a href="<?= BASE_URL ?>controllers/CommandeController.php?action=changer_statut&id=<?= $cmd['id'] ?>&statut=validée" 
                                   class="btn btn-sm btn-success" title="Valider" 
                                   onclick="return confirm('Voulez-vous valider cette commande ?');">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                                <a href="<?= BASE_URL ?>controllers/CommandeController.php?action=changer_statut&id=<?= $cmd['id'] ?>&statut=annulée" 
                                   class="btn btn-sm btn-warning" title="Annuler" 
                                   onclick="return confirm('Voulez-vous annuler cette commande ?');">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                                <!-- Supprimer -->
                                <a href="<?= BASE_URL ?>controllers/CommandeController.php?action=supprimer&id=<?= $cmd['id'] ?>" 
                                   class="btn btn-sm btn-danger" title="Supprimer"
                                   onclick="return confirm('Supprimer cette commande ?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Aucune commande trouvée.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
