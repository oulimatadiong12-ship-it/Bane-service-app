<?php
// includes/navbar.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définir BASE_URL si non défini
if (!defined('BASE_URL')) {
    define('BASE_URL', '/bane-service-app/');
}


// Récupération du rôle (par défaut = visiteur)
$role = $_SESSION['role'] ?? 'guest';

renderNavbar($role);

/**
 * Menu principal public
 */
function getPublicMenu()
{
    return [
        "Accueil"     => BASE_URL . "views/public/accueil.php",
        "Produits"    => BASE_URL . "views/public/produits.php",
        "Services"    => BASE_URL . "views/public/services.php",
        "Promotions"  => BASE_URL . "views/public/promotions.php",
        "À propos"    => BASE_URL . "views/public/apropos.php",
        "Contact"     => BASE_URL . "views/public/contact.php",
        "Connexion"   => BASE_URL . "views/public/login.php",
    ];
}

/**
 * Retourne le menu selon le rôle
 */
function getMenuByRole($role)
{
    switch ($role) {
        case 'admin':
            return [
                "Dashboard"   => BASE_URL . "views/admin/dashboard.php",
                "Produits"    => BASE_URL . "views/admin/produits.php",
                "Commandes"   => BASE_URL . "views/admin/commandes.php",
                "Détails Commande"   => BASE_URL . "views/admin/details_commande.php",
                "Abonnements" => BASE_URL . "views/admin/abonnements.php",
                "Utilisateurs"=> BASE_URL . "views/admin/utilisateurs.php",
                "Finances"    => BASE_URL . "views/admin/finances.php",
                "Promotions"  => BASE_URL . "views/admin/promotions.php",
            ];

        case 'client':
            return [
                "Dashboard"     => BASE_URL . "views/client/dashboard.php",
                "Commandes"     => BASE_URL . "views/client/commandes.php",
                "Profil"        => BASE_URL . "views/client/profil.php",
                "Factures"      => BASE_URL . "views/client/factures.php",
                "Notifications" => BASE_URL . "views/client/notifications.php",
            ];

        case 'abonne':
            return [
                "Dashboard"     => BASE_URL . "views/abonne/dashboard.php",
                "Mon Abonnement"=> BASE_URL . "views/abonne/abonnement.php",
                "Profil"        => BASE_URL . "views/abonne/profil.php",
            ];

        case 'technicien':
            return [
                "Dashboard"   => BASE_URL . "views/technicien/dashboard.php",
                "Rendez-vous" => BASE_URL . "views/technicien/rendezvous.php",
                "Profil"      => BASE_URL . "views/technicien/profil.php",
            ];

        default: // visiteur
            return getPublicMenu();
    }
}

/**
 * Affiche la navbar (Bootstrap 5)
 */
function renderNavbar($role)
{
    $menus = getMenuByRole($role);
    ?>
    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="<?= BASE_URL ?>index.php">Bane Service</a>

            <!-- Bouton responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Liens -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php foreach ($menus as $label => $url): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= htmlspecialchars($url) ?>">
                                <?= htmlspecialchars($label) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <?php if ($role !== 'guest'): ?>
                        <!-- Déconnexion visible uniquement si connecté -->
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= BASE_URL ?>logout.php">Déconnexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}



