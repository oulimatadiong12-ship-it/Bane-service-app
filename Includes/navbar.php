<?php
// includes/navbar.php
session_start();
require_once __DIR__ . "/../auth.php";   // pour isLoggedIn(), isAdmin(), isTechnicien(), isClient(), isAbonne()

/**
 *  menu en fonction du rôle
 */
function getMenuByRole() {
    // Menu public (toujours visible)
    $menu = [
        ["Accueil", "/accueil.php"],
        ["Produits", "/produits.php"],
        ["Services", "/service.php"],
        ["Promotions", "/promotions.php"],
        ["À propos", "/apropos.php"],
        ["Contact", "/contact.php"],
    ];

    if (!isLoggedIn()) {
        // Visiteur non connecté → Connexion
        $menu[] = ["Connexion", "/login.php"];
    } elseif (isAdmin()) {
        // Menu admin
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
        // Menu technicien
        $menu = array_merge($menu, [
            ["Dashboard Technicien", "/views/technicien/dashboard.php"],
            ["Rendez-vous planifiés", "/views/technicien/rendezvous.php"],
            ["Profil Technicien", "/views/technicien/profil.php"],
            ["Déconnexion", "/logout.php"]
        ]);
    } elseif (isClient()) {
        // Menu client simple
        $menu = array_merge($menu, [
            ["Dashboard Client", "/views/client/dashboard.php"],
            ["Produits & Commandes", "/views/client/commandes.php"],
            ["Profil Client", "/views/client/profil.php"],
            ["Facturation & Paiements", "/views/client/paiements.php"],
            ["Notifications", "/views/client/notifications.php"],
            ["Déconnexion", "/logout.php"]
        ]);
    } elseif (isAbonne()) {
        // Menu abonné Canal+
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
        echo "<li><a href=\"{$item[1]}\">{$item[0]}</a></li>";
    }
    echo "</ul></nav>";
}
?>
