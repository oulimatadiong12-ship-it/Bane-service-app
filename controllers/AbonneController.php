<?php
session_start();
require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../models/Abonnement.php';
require_once __DIR__ . '/../models/PaiementAbonnement.php';
require_once __DIR__ . '/../models/Utilisateur.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'abonne') {
    header("Location: " . BASE_URL . "/views/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

$abonnementModel = new Abonnement($pdo);
$paiementModel = new PaiementAbonnement($pdo);
$userModel = new Utilisateur($pdo);

// -------------------------
// Actions POST
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'renouveler':
            $abonnement = $abonnementModel->getActiveByUser($userId);
            if ($abonnement && !empty($_POST['nouvelle_date_fin'])) {
                $abonnementModel->renew($abonnement['id'], $_POST['nouvelle_date_fin']);
            }
            header("Location: " . BASE_URL . "/views/abonne/abonnement.php");
            exit;

        case 'update_profil':
            $profil = $userModel->getById($userId);
            $nom = $_POST['nom'] ?? $profil['nom'];
            $prenom = $_POST['prenom'] ?? $profil['prenom'];
            $email = $_POST['email'] ?? $profil['email'];
            $telephone = $_POST['telephone'] ?? $profil['telephone'];
            $adresse = $_POST['adresse'] ?? $profil['adresse'];

            $userModel->update($userId, $nom, $prenom, $email, $telephone, $adresse);
            header("Location: " . BASE_URL . "/views/abonne/profil.php");
            exit;
    }
}

// -------------------------
// Préparer les données pour les vues
// -------------------------
$abonnement = $abonnementModel->getActiveByUser($userId);
$abonnementsHistorique = $abonnementModel->getByUser($userId);
$paiements = $paiementModel->getByUser($userId);
$profil = $userModel->getById($userId);

// Inclure la vue selon paramètre GET
$view = $_GET['view'] ?? 'dashboard';

switch ($view) {
    case 'abonnement':
        require_once __DIR__ . '/../views/abonne/abonnement.php';
        break;
    case 'profil':
        require_once __DIR__ . '/../views/abonne/profil.php';
        break;
    default:
        require_once __DIR__ . '/../views/abonne/dashboard.php';
        break;
}
?>
