<?php
// controllers/ProduitController.php

require_once __DIR__ . "/../db/connexion.php";
require_once __DIR__ . "/../models/Produit.php";

$produitModel = new Produit($pdo); // On passe la connexion PDO au modèle

// ------------------------
// Ajouter un produit
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    // Gestion image
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../uploads/produits/" . $image);
    }

    $produitModel->create($nom, $prix, $description, $image);
    header("Location: ../views/admin/produits.php");
    exit;
}

// ------------------------
// Supprimer un produit
// ------------------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $produitModel->delete($_GET['id']);
    header("Location: ../views/admin/produits.php");
    exit;
}

// ------------------------
// Récupérer tous les produits pour affichage
// ------------------------
$produits = $produitModel->getAll();
