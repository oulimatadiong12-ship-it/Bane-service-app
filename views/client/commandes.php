<?php
session_start();
require_once __DIR__ . '/../../db/connexion.php';
require_once __DIR__ . '/../../models/Commande.php';
require_once __DIR__ . '/../../includes/navbar.php'; // navbar client (ajuste si besoin)



if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "/views/public/login.php");
    exit;
}

$commandeModel = new Commande($pdo);
$commandes = $commandeModel->getByUser($_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="mb-4">Mes Commandes</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'commande_passee'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> Votre commande a été passée avec succès !
        </div>
    <?php endif; ?>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($commandes)): ?>
                    <?php foreach ($commandes as $cmd): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $cmd['id'] ?></td>
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
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Aucune commande passée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
