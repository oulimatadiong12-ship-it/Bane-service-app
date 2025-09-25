<?php
// views/admin/dashboard.php



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
</head>
<body>

<?php
require_once '../../Includes/navbar.php';
?>

<h1>Dashboard Administrateur</h1>

<p>
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

<ul>
    <li><a href="/views/admin/produits.php">Produits</a></li>
    <li><a href="/views/admin/commandes.php">Commandes</a></li>
    <li><a href=" ../../controllers/AbonnementAdminController.php">Abonnements</a></li>
    <li><a href="/views/admin/finance.php">Finances</a></li>
    <li><a href="/controllers/UserController.php?action=logout">Déconnexion</a></li>
</ul>

</body>
</html>