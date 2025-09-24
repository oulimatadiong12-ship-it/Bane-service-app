<?php 
// views/admin/dashboard.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../includes/auth.php";

requireLogin();

if (!isAdmin()) {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php
require_once __DIR__ . "/../../includes/navbar.php";
?>

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h1 class="card-title text-center text-primary">Dashboard Administrateur</h1>
            <p class="text-center mt-3">
                Bienvenue, 
                <?php
                if (isset($_SESSION['user']['prenom']) && isset($_SESSION['user']['nom'])) {
                    echo htmlspecialchars($_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']);
                } elseif (isset($_SESSION['user']['username'])) {
                    echo htmlspecialchars($_SESSION['user']['username']);
                } else {
                    echo "Admin";
                }
                ?>
            </p>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Produits -->
        <div class="col-md-4 mb-3">
            <a href="/views/admin/produits.php" class="btn btn-outline-primary w-100 p-3 shadow-sm">
                📦 Gestion Produits
            </a>
        </div>

        <!-- Commandes -->
        <div class="col-md-4 mb-3">
            <a href="/views/admin/commandes.php" class="btn btn-outline-success w-100 p-3 shadow-sm">
                🛒 Gestion Commandes
            </a>
        </div>

        <!-- Abonnements -->
        <div class="col-md-4 mb-3">
            <a href="/views/admin/abonnements.php" class="btn btn-outline-warning w-100 p-3 shadow-sm">
                🎫 Abonnements
            </a>
        </div>

        <!-- Finances -->
        <div class="col-md-6 mb-3">
            <a href="/views/admin/finance.php" class="btn btn-outline-info w-100 p-3 shadow-sm">
                💰 Finances
            </a>
        </div>

        <!-- Déconnexion -->
        <div class="col-md-6 mb-3">
            <a href="/controllers/UserController.php?action=logout" class="btn btn-outline-danger w-100 p-3 shadow-sm">
                🚪 Déconnexion
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
