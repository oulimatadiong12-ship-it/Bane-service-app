<?php
// controllers/CommandeController.php

session_start();
require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../models/LigneCommande.php';
require_once __DIR__ . '/../models/Produit.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', '/baneservice-app');
}

$commandeModel = new Commande($pdo);
$ligneCommandeModel = new LigneCommande($pdo);
$produitModel = new Produit($pdo);

$action = $_GET['action'] ?? '';

// ------------------------
// PASSER UNE COMMANDE (depuis le panier)
// ------------------------
if ($action === 'passer' && isset($_SESSION['user'])) {
    $panier = $_SESSION['panier'] ?? [];
    
    if (empty($panier)) {
        header("Location: " . BASE_URL . "/views/public/panier.php?error=panier_vide");
        exit;
    }

    // Calculer le montant total
    $montant_total = 0;
    $produits = $produitModel->getAll();
    $produits_indexed = [];
    foreach ($produits as $p) {
        $produits_indexed[$p['id']] = $p;
    }

    foreach ($panier as $produit_id => $quantite) {
        if (isset($produits_indexed[$produit_id])) {
            $montant_total += $produits_indexed[$produit_id]['prix'] * $quantite;
        }
    }

    // Créer la commande
    $commande_id = $commandeModel->create($_SESSION['user']['id'], $montant_total);

    // Ajouter les lignes de commande
    foreach ($panier as $produit_id => $quantite) {
        if (isset($produits_indexed[$produit_id])) {
            $ligneCommandeModel->create(
                $commande_id, 
                $produit_id, 
                $quantite, 
                $produits_indexed[$produit_id]['prix']
            );
        }
    }

    // Vider le panier
    $_SESSION['panier'] = [];

    header("Location: " . BASE_URL . "/views/client/commandes.php?success=commande_passee");
    exit;
}

// ------------------------
// CHANGER LE STATUT (Admin)
// ------------------------
if ($action === 'changer_statut' && isset($_GET['id'], $_GET['statut'])) {
    $commandeModel->updateStatut($_GET['id'], $_GET['statut']);
    header("Location: " . BASE_URL . "/views/admin/commandes.php");
    exit;
}

// ------------------------
// SUPPRIMER UNE COMMANDE (Admin)
// ------------------------
if ($action === 'supprimer' && isset($_GET['id'])) {
    $ligneCommandeModel->deleteByCommande($_GET['id']);
    $commandeModel->delete($_GET['id']);
    header("Location: " . BASE_URL . "/views/admin/commandes.php");
    exit;
}

// ------------------------
// VOIR DÉTAILS D'UNE COMMANDE
// ------------------------
if ($action === 'details' && isset($_GET['id'])) {
    $commande = $commandeModel->getById($_GET['id']);
    $lignes = $ligneCommandeModel->getByCommande($_GET['id']);
    include __DIR__ . '/../views/admin/details_commande.php';
    exit;
}

// ------------------------
// AFFICHAGE ADMIN : Liste de toutes les commandes
// ------------------------
if ($action === '' || $action === 'liste') {
    $commandes = $commandeModel->getAll();
    include __DIR__ . '/../views/admin/commandes.php';
    exit;
}

// ------------------------
// AFFICHAGE CLIENT : Mes commandes
// ------------------------
if ($action === 'mes_commandes' && isset($_SESSION['user'])) {
    $commandes = $commandeModel->getByUser($_SESSION['user']['id']);
    include __DIR__ . '/../views/client/commandes.php';
    exit;
}
