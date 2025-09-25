<?php
// controllers/ProduitController.php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Produit.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Bane-service-app/');
}

session_start();

$produitModel = new Produit($pdo);

// ------------------------
// Ajouter un produit (Admin)
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $libelle       = $_POST['libelle'];
    $categorie     = $_POST['categorie'];
    $prixAchat     = $_POST['prixAchat'];
    $prixVente     = $_POST['prixVente'];
    $stock         = $_POST['stock'] ?? 0;
    $seuilAlerte   = $_POST['seuil_alerte'] ?? 5;
    $description   = $_POST['description'];
    $fournisseur   = $_POST['fournisseur'];

    $produitModel->create(
        $libelle, $categorie, $prixAchat, $prixVente, $stock,
        $seuilAlerte, $description, $fournisseur
    );

    header("Location: " . BASE_URL . "views/admin/produits.php");
    exit;
}

// ------------------------
// Modifier un produit (Admin)
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['id'])) {
    $id            = $_POST['id'];
    $libelle       = $_POST['libelle'];
    $categorie     = $_POST['categorie'];
    $prixAchat     = $_POST['prixAchat'];
    $prixVente     = $_POST['prixVente'];
    $stock         = $_POST['stock'] ?? 0;
    $seuilAlerte   = $_POST['seuil_alerte'] ?? 5;
    $description   = $_POST['description'];
    $fournisseur   = $_POST['fournisseur'];

    $produitModel->update(
        $id, $libelle, $categorie, $prixAchat, $prixVente, $stock,
        $seuilAlerte, $description, $fournisseur
    );

    header("Location: " . BASE_URL . "views/admin/produits.php");
    exit;
}

// ------------------------
// Supprimer un produit (Admin)
// ------------------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $produitModel->delete($_GET['id']);
    header("Location: " . BASE_URL . "views/admin/produits.php");
    exit;
}

// ------------------------
// Affichage PUBLIC : Catalogue produits
// ------------------------
$search = $_GET['search'] ?? null;

if (!empty($search)) {
    $produits = $produitModel->search($search);
} else {
    $produits = $produitModel->getAllProduits();
}

// ------------------------
// Inclure la vue publique
// ------------------------
include __DIR__ . '/../views/public/produits.php';
