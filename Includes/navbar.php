<?php
// includes/navbar.php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/auth.php";

function getMenuByRole() {
    $menu = [
        ["Accueil", "/index.php"],
        ["Produits", "/produits.php"],
        ["Services", "/service.php"],
        ["Promotions", "/promotions.php"],
        ["À propos", "/apropos.php"],
        ["Contact", "/contact.php"],
    ];

    if (!isLoggedIn()) {
        $menu[] = ["Connexion", "/login.php"];
    } elseif (isAdmin()) {
        $menu = array_merge($menu, [
            ["Dashboard", "/views/admin/dashboard.php"],
            ["Gestion Produits", "/views/admin/produits.php"],
            ["Gestion Commandes", "/views/admin/commandes.php"],
            ["Gestion Abonnements", "/views/admin/abonnements.php"],
            ["Gestion Utilisateurs", "/views/admin/utilisateurs.php"],
            ["Gestion Finance", "/views/admin/finance.php"],
            ["Gestion Promotions", "/views/admin/promotions.php"],
            ["Déconnexion", "/logout.php"]
        ]);
    } elseif (isTechnicien()) {
        $menu = array_merge($menu, [
            ["Dashboard Technicien", "/views/technicien/dashboard.php"],
            ["Rendez-vous planifiés", "/views/technicien/rendezvous.php"],
            ["Profil Technicien", "/views/technicien/profil.php"],
            ["Déconnexion", "/logout.php"]
        ]);
    } elseif (isClient()) {
        $menu = array_merge($menu, [
            ["Dashboard Client", "/views/client/dashboard.php"],
            ["Produits & Commandes", "/views/client/commandes.php"],
            ["Profil Client", "/views/client/profil.php"],
            ["Facturation & Paiements", "/views/client/paiements.php"],
            ["Notifications", "/views/client/notifications.php"],
            ["Déconnexion", "/logout.php"]
        ]);
    } elseif (isAbonne()) {
        $menu = array_merge($menu, [
            ["Dashboard Abonné", "/views/abonne/dashboard.php"],
            ["Mes Abonnements", "/views/abonne/abonnements.php"],
            ["Profil Abonné", "/views/abonne/profil.php"],
            ["Déconnexion", "/logout.php"]
        ]);
    }

    return $menu;
}

/**
 * Affiche le menu
 */
function renderNavbar() {
    $menu = getMenuByRole();
    echo "<nav><ul>";
    foreach ($menu as $item) {
        $title = htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8');
        $link  = htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8');
        echo "<li><a href=\"{$link}\">{$title}</a></li>";
    }
    echo "</ul></nav>";
}
?>