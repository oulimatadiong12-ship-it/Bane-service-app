<?php
// views/client/commandes.php
require_once __DIR__ . '/../../db/connexion.php';
require_once __DIR__ . '/../../models/Commande.php';
require_once __DIR__ . '/../../includes/navbar.php';

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
    <style>
        body {
            overflow-x: hidden;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 56px; /* hauteur navbar fixe */
            left: 0;
            width: 220px;
            height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar a {
            display: block;
            padding: 0.5rem 0.75rem;
            color: #333;
            text-decoration: none;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background-color: #0d6efd;
            color: white;
        }

        /* Contenu */
        .content {
            margin-left: 220px;
            padding: 2rem;
            padding-top: 70px; /* pour navbar */
            padding-bottom: 80px; /* pour footer */
            min-height: calc(100vh - 56px);
        }

        /* Footer padding bottom */
        footer {
            padding: 1rem 2rem;
            background: #f1f1f1;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            left: 220px;
            right: 0;
            height: 56px;
            display: flex;
            align-items: center;
            z-index: 1030;
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }
            .content {
                margin-left: 0;
                padding: 1rem;
                padding-top: 56px;
                padding-bottom: 70px;
            }
            footer {
                left: 0;
                height: auto;
                position: static;
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-light">

<!-- Sidebar -->
<nav class="sidebar" aria-label="Sidebar menu">
    <h5 class="mb-4">Menu</h5>
    <a href="<?= BASE_URL ?>/views/client/dashboard.php">🏠 Tableau de bord</a>
    <a href="<?= BASE_URL ?>/views/client/commandes.php" class="active">🛒 Mes commandes</a>
    <a href="<?= BASE_URL ?>/views/client/factures.php">Mes factures</a>
    <a href="<?= BASE_URL ?>/views/client/profil.php">👤 Mon profil</a>
    <a href="<?= BASE_URL ?>/views/client/notifications.php">Mes notifications</a>
</nav>

<!-- Contenu principal -->
<div class="content container">
    <h1 class="mb-4">Mes Commandes</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'commande_passee'): ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            Votre commande a été passée avec succès !
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
                    <?php foreach($commandes as $cmd): ?>
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

<footer>
    &copy; <?= date('Y') ?> MonSite - Tous droits réservés
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
