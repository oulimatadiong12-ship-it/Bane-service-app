<?php 
require_once __DIR__ . '/controllers/ProduitController.php';
$controller = new ProduitController();

$action = $_GET['action'] ?? 'produits';

switch ($action) {
    case 'produits':
        $controller->index();
        break;
    case 'addProduit':
        $controller->add();
        break;
    case 'editProduit':
        $controller->edit();
        break;
    case 'deleteProduit':
        $controller->delete();
        break;
    default:
        echo "Action inconnue";
}
