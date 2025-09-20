<?php
require_once __DIR__ . "/../db/connexion.php";
require_once __DIR__ . "/../models/Produit.php";

$produitModel = new Produit($pdo);

// ------------------------
// Ajouter un produit (Admin)
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../uploads/produits/" . $image);
    }

    $produitModel->create($nom, $prix, $description, $image);
    header("Location: ../views/admin/produits.php");
    exit;
}

// ------------------------
// Modifier un produit (Admin)
// ------------------------
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    $image = $_POST['current_image'] ?? null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../uploads/produits/" . $image);
    }

    $produitModel->update($id, $nom, $prix, $description, $image);
    header("Location: ../views/admin/produits.php");
    exit;
}

// ------------------------
// Supprimer un produit (Admin)
// ------------------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $produitModel->delete($_GET['id']);
    header("Location: ../views/admin/produits.php");
    exit;
}

// ------------------------
// Affichage PUBLIC : Catalogue produits
// ------------------------
$search = $_GET['search'] ?? null;

if (!empty($search)) {
    $produits = $produitModel->search($search);
} else {
    $produits = $produitModel->getAll(); // récupère tous les produits par défaut
}

// ------------------------
// Page catalogue publique
// ------------------------
include __DIR__ . "/../views/public/produits.php";
