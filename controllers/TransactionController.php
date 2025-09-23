<?php
session_start();
require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Utilisateur.php';

$transactionModel = new Transaction($pdo);
$userModel = new Utilisateur($pdo);

// Vérification rôle admin/agent
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin','agent'])) {
    header("Location: ../views/login.php");
    exit;
}

// Actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
        $type = $_POST['type'] ?? 'OM';
        $operation = $_POST['operation'] ?? 'dépôt';
        $montant = floatval($_POST['montant'] ?? 0);
        $numero = $_POST['numero'] ?? '';
        $statut = $_POST['statut'] ?? 'validée';
        $utilisateur_id = $_POST['utilisateur_id'] ?? null;
        $employe_id = $_SESSION['user']['id'];

        if ($montant > 0 && $utilisateur_id) {
            $transactionModel->create($type, $operation, $montant, $numero, $statut, $utilisateur_id, $employe_id);
        }

        header("Location: ../views/admin/finances.php");
        exit;
    }
}

// Préparer les données pour la vue
$transactions = $transactionModel->getAll();
$soldeCaisse = $transactionModel->getSoldeCaisse();
$clients = $userModel->getAllClients();

// Inclure la vue
require_once __DIR__ . '/../views/admin/finances.php';
?>
