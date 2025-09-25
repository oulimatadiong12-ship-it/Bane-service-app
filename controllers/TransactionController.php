<?php

require_once __DIR__ . '/../db/connexion.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../Includes/navbar.php';
$transactionModel = new Transaction($pdo);
$userModel = new Utilisateur($pdo);


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

        header("Location: " . BASE_URL . "views/admin/finances.php");
        exit;
    }
}

// Préparer les données pour la vue
$transactions = $transactionModel->getAll();
$soldeCaisse = $transactionModel->getSoldeCaisse();
$clients = $userModel->getAllClients();


?>
