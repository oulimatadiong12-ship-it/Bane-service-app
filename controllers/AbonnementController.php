<?php
session_start();

require_once __DIR__ . "/../db/connexion.php";
require_once __DIR__ . '/../models/Abonnement.php';
require_once __DIR__ . '/../models/PaiementAbonnement.php';
require_once __DIR__ . '/../models/Utilisateur.php';

$abonnementModel = new Abonnement($pdo);
$paiementModel = new PaiementAbonnement($pdo);
$userModel = new Utilisateur($pdo);

// ------------------------
// ADMIN : GESTION ABONNEMENTS
// ------------------------
if (isset($_POST['role']) && $_POST['role'] === 'admin') {

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

    // Supprimer un abonnement
    if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        $abonnementModel->delete($_POST['abonnement_id']);
        header("Location: ../views/admin/abonnements.php");
        exit;
    }
}

// Toujours récupérer les abonnements pour affichage dans la vue admin
$abonnements = $abonnementModel->getAll();

// ------------------------
// ABONNE : VUES & ACTIONS
// ------------------------
if (isset($_SESSION['user_id'])) {

    $userId = $_SESSION['user_id'];

    // Abonnement actif
    $abonnement = $abonnementModel->getActiveByUser($userId);

    // Historique des abonnements
    $abonnementsHistorique = $abonnementModel->getByUser($userId);

    // Paiements de l'utilisateur
    $paiements = $paiementModel->getByUser($userId);

    // Profil utilisateur
    $profil = $userModel->getById($userId);

    // Renouveler l'abonnement
    if (isset($_POST['action']) && $_POST['action'] === 'renouveler') {
        if ($abonnement && !empty($_POST['nouvelle_date_fin'])) {
            $abonnementModel->renew($abonnement['id'], $_POST['nouvelle_date_fin']);
            header("Location: ../views/abonne/abonnement.php");
            exit;
        }
    }

    // Mettre à jour le profil
    if (isset($_POST['action']) && $_POST['action'] === 'update_profil') {
        $nom = $_POST['nom'] ?? $profil['nom'];
        $prenom = $_POST['prenom'] ?? $profil['prenom'];
        $email = $_POST['email'] ?? $profil['email'];
        $telephone = $_POST['telephone'] ?? $profil['telephone'];
        $adresse = $_POST['adresse'] ?? $profil['adresse'];

        $userModel->update($userId, $nom, $prenom, $email, $telephone, $adresse);
        header("Location: ../views/abonne/profil.php");
        exit;
    }
}
?>
