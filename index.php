<?php 
session_start();
define('BASE_URL', '/bane-service-app/'); // à ajuster selon ton URL

// Déterminer la page à inclure
$page = $_GET['page'] ?? 'accueil'; // par défaut 'accueil'

// Liste des pages publiques valides
$pages_valides = ['accueil', 'produits', 'services', 'promotions', 'apropos', 'contact'];

// Sécurité : vérifier si la page demandée existe
if (!in_array($page, $pages_valides)) {
    $page = 'accueil';
}

// Inclure header et navbar
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

// Inclure la page publique correspondante
require_once __DIR__ . "/views/public/$page.php";

// Inclure footer
require_once __DIR__ . '/includes/footer.php';
