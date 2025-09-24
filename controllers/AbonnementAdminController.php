<?php
session_start();
require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../Includes/navbar.php';
require_once __DIR__ . '/../models/Abonnement.php';
require_once __DIR__ . '/../models/Utilisateur.php';

$abonnementModel = new Abonnement($pdo);
$userModel = new Utilisateur($pdo);


// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: " . BASE_URL . "views/public/login.php");
    exit;
}

// Actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'ajouter':
            $abonnementModel->create(
                $_POST['client_id'],
                $_POST['formule'] ?? 'Canal+ Basique',
                $_POST['prix'] ?? 5000,
                $_POST['date_debut'],
                $_POST['date_fin']
            );
            break;

        case 'renouveler':
            $abonnementModel->renew($_POST['abonnement_id'], $_POST['nouvelle_date_fin']);
            break;

        case 'suspendre':
            $abonnementModel->suspend($_POST['abonnement_id']);
            break;

        case 'supprimer':
            $abonnementModel->delete($_POST['abonnement_id']);
            
            break;
    }
    // Redirection après action
    // Bon ✅
header("Location: " . BASE_URL . "controllers/AbonnementAdminController.php");

    exit;
}

// Récupérer tous les abonnements pour la vue
$abonnements = $abonnementModel->getAll();

// Inclure la vue
require_once __DIR__ . '/../views/admin/abonnements.php';
?>
