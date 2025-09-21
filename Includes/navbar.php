<?php
// includes/navbar.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/roles.php";
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Bane-service-app/');
}

function getMenuByRole() {
    $menu = [
        ["Accueil", BASE_URL . "index.php"],
        ["Produits", BASE_URL . "produits.php"],
        ["Services", BASE_URL . "service.php"],
        ["Promotions", BASE_URL . "promotions.php"],
        ["À propos", BASE_URL . "apropos.php"],
        ["Contact", BASE_URL . "contact.php"],
    ];

    if (!isLoggedIn()) {
        $menu[] = ["Connexion", BASE_URL . "views/public/login.php"];
    } elseif (isAdmin()) {
        $menu = array_merge($menu, [
            ["Dashboard", BASE_URL . "views/admin/dashboard.php"],
            ["Produits (Admin)", BASE_URL . "views/admin/produits.php"],
            ["Commandes", BASE_URL . "views/admin/commandes.php"],
            ["Abonnements", BASE_URL . "views/admin/abonnements.php"],
            ["Utilisateurs", BASE_URL . "views/admin/utilisateurs.php"],
            ["Finance", BASE_URL . "views/admin/finance.php"],
            ["Promotions (Admin)", BASE_URL . "views/admin/promotions.php"],
            ["Déconnexion", BASE_URL . "controllers/UserController.php?action=logout"]
        ]);
    } elseif (isTechnicien()) {
        $menu = array_merge($menu, [
            ["Dashboard Technicien", BASE_URL . "views/technicien/dashboard.php"],
            ["Rendez-vous", BASE_URL . "views/technicien/rendezvous.php"],
            ["Profil", BASE_URL . "views/technicien/profil.php"],
            ["Déconnexion", BASE_URL . "controllers/UserController.php?action=logout"]
        ]);
    } elseif (isClient()) {
        $menu = array_merge($menu, [
            ["Mon Dashboard", BASE_URL . "views/client/dashboard.php"],
            ["Mes Commandes", BASE_URL . "views/client/commandes.php"],
            ["Profil", BASE_URL . "views/client/profil.php"],
            ["Paiements", BASE_URL . "views/client/paiements.php"],
            ["Notifications", BASE_URL . "views/client/notifications.php"],
            ["Déconnexion", BASE_URL . "controllers/UserController.php?action=logout"]
        ]);
    } elseif (isAbonne()) {
        $menu = array_merge($menu, [
            ["Mon Dashboard", BASE_URL . "views/abonne/dashboard.php"],
            ["Mes Abonnements", BASE_URL . "views/abonne/abonnements.php"],
            ["Profil", BASE_URL . "views/abonne/profil.php"],
            ["Déconnexion", BASE_URL . "controllers/UserController.php?action=logout"]
        ]);
    }

    return $menu;
}

function renderNavbar() {
    $menu = getMenuByRole();
    echo "<nav><ul>";
    // Lien vers BASE_URL (Accueil)
    echo "<li><a href=\"" . htmlspecialchars(BASE_URL) . "\">Accueil</a></li>";
    foreach ($menu as $item) {
        echo "<li><a href=\"" . htmlspecialchars($item[1]) . "\">" . htmlspecialchars($item[0]) . "</a></li>";
    }
    echo "</ul></nav>";
}