<?php
// controllers/ProduitController.php
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

    // Gestion image
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

    // Gestion image
    $image = $_POST['current_image'] ?? null; // conserver l'image actuelle si pas de nouvelle
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

// Toujours récupérer les produits pour affichage
$produits = $produitModel->getAll();

// Si recherche
if (isset($_GET['page']) && $_GET['page'] === 'catalogue') {
    $search = $_GET['search'] ?? null;

    if ($search) {
        $produits = $produitModel->search($search); // méthode search() dans Produit.php
    }

    include __DIR__ . "/../views/public/produits.php";
    exit;
}
