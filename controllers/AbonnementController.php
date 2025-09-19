<?php
require_once __DIR__ . "/../db/connexion.php";
require_once __DIR__ . '/../models/Abonnement.php';
require_once __DIR__ . '/../models/PaiementAbonnement.php';

$abonnementModel = new Abonnement($pdo);
$paiementModel = new PaiementAbonnement($pdo);

// Ajouter un abonnement
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $abonnementModel->create(
        $_POST['client_id'],
        $_POST['formule'] ?? 'Canal+ Basique',
        $_POST['prix'] ?? 5000,
        $_POST['date_debut'],
        $_POST['date_fin']
    );
    header("Location: ../views/admin/abonnements.php");
    exit;
}

// Renouveler un abonnement
if (isset($_POST['action']) && $_POST['action'] === 'renouveler') {
    $abonnementModel->renew($_POST['abonnement_id'], $_POST['nouvelle_date_fin']);
    header("Location: ../views/admin/abonnements.php");
    exit;
}

// Suspendre un abonnement
if (isset($_POST['action']) && $_POST['action'] === 'suspendre') {
    $abonnementModel->suspend($_POST['abonnement_id']);
    header("Location: ../views/admin/abonnements.php");
    exit;
}

// Liste des abonnements pour affichage
$abonnements = $abonnementModel->getAll();

// Supprimer un abonnement
if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $abonnementModel->delete($_POST['abonnement_id']);
    header("Location: ../views/admin/abonnements.php");
    exit;
}
