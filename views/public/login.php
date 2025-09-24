<?php
session_start();

// Définir BASE_URL si ce n'est pas encore fait
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Bane-service-app/');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Connexion</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <form method="post" action="<?= BASE_URL ?>controllers/UserController.php?action=login">
                <div class="mb-3">
                    <label class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe :</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
