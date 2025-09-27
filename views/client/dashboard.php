<?php
// views/client/dashboard.php

require_once __DIR__ . "/../../Includes/auth.php";
require_once __DIR__ . "/../../config.php"; // pour BASE_URL
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Client</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-success text-white text-center">
            <h3 class="mb-0">Dashboard Client</h3>
        </div>
        <div class="card-body text-center">
            <p class="fs-5">
                Bonjour, 
                <strong>
                <?php
                if (isset($_SESSION['user']['prenom']) && isset($_SESSION['user']['nom'])) {
                    echo htmlspecialchars($_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']);
                } elseif (isset($_SESSION['user']['username'])) {
                    echo htmlspecialchars($_SESSION['user']['username']);
                } else {
                    echo "Client";
                }
                ?>
                </strong> 👋
            </p>

            <div class="row text-center mt-4">
                <!-- Commandes -->
                <div class="col-md-3 mb-3">
                    <a href="<?= BASE_URL ?>views/client/commandes.php" class="btn btn-outline-primary w-100">🛒 Mes Commandes</a>
                </div>
                <!-- Factures -->
                <div class="col-md-3 mb-3">
                    <a href="<?= BASE_URL ?>views/client/factures.php" class="btn btn-outline-warning w-100">📑 Mes Factures</a>
                </div>
                <!-- Notifications -->
                <div class="col-md-3 mb-3">
                    <a href="<?= BASE_URL ?>views/client/notifications.php" class="btn btn-outline-info w-100">🔔 Notifications</a>
                </div>
                <!-- Profil -->
                <div class="col-md-3 mb-3">
                    <a href="<?= BASE_URL ?>views/client/profil.php" class="btn btn-outline-dark w-100">⚙️ Mon Profil</a>
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
