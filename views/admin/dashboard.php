<?php  
// views/admin/dashboard.php

require_once __DIR__ . "/../../Includes/auth.php";
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . '/../../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Dashboard Administrateur</h3>
        </div>
        <div class="card-body">
            <p class="fs-5">
                Bienvenue,
                <strong>
                <?php
                if (isset($_SESSION['user']['prenom']) && isset($_SESSION['user']['nom'])) {
                    echo htmlspecialchars($_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']);
                } elseif (isset($_SESSION['user']['username'])) {
                    echo htmlspecialchars($_SESSION['user']['username']);
                } else {
                    echo "Admin";
                }
                ?>
                </strong>
            </p>

            <div class="row g-3 text-center">
                <!-- Produits -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/produits.php" class="btn btn-outline-primary w-100">
                        📦 Produits
                    </a>
                </div>
                <!-- Commandes -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/commandes.php" class="btn btn-outline-success w-100">
                        🛒 Commandes
                    </a>
                </div>
                <!-- Détail Commande -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/detail_commande.php" class="btn btn-outline-secondary w-100">
                        📋 Détail Commande
                    </a>
                </div>
                <!-- Abonnements -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/abonnements.php" class="btn btn-outline-warning w-100">
                        📑 Abonnements
                    </a>
                </div>
                <!-- Finances -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/finances.php" class="btn btn-outline-info w-100">
                        💰 Finances
                    </a>
                </div>
                <!-- Utilisateurs -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/utilisateurs.php" class="btn btn-outline-dark w-100">
                        👤 Utilisateurs
                    </a>
                </div>
                <!-- Services -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/services.php" class="btn btn-outline-primary w-100">
                        ⚙️ Services
                    </a>
                </div>
                <!-- Promotions -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/promotions.php" class="btn btn-outline-danger w-100">
                        🎁 Promotions
                    </a>
                </div>
                <!-- Forme Promotion -->
                <div class="col-md-4 col-lg-3">
                    <a href="<?= BASE_URL ?>/views/admin/form_promotion.php" class="btn btn-outline-success w-100">
                        📝 Forme Promotion
                    </a>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= BASE_URL ?>/controllers/UserController.php?action=logout" class="btn btn-danger">
                    🚪 Déconnexion
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>