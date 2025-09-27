<?php
// controllers/UserController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure auth (BASE_URL), connexion PDO et navbar
require_once __DIR__ . "/../Includes/auth.php";
require_once __DIR__ . "/../db/connexion.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . '/../Includes/navbar.php';


$utilisateurModel = new Utilisateur($pdo);

// Action choisie
$action = $_GET['action'] ?? null;

// Connexion
if ($action === "login" && $_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $user = $utilisateurModel->getByEmail($email);
     
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            "id"    => $user['id'],
            "nom"   => $user['nom'],
            "email" => $user['email'],
            "role"  => $user['role']
        ];
       
        $id = $_SESSION['user']['id'];
    $profil = $utilisateurModel->getById($id);

        // Redirection selon rôle
        switch ($user['role']) {
            case 'admin':
                header('Location: ' . BASE_URL . 'views/admin/dashboard.php');
                exit;
            case 'abonne':
                header('Location: ' . BASE_URL . 'views/abonne/dashboard.php');
                exit;
            case 'client':
                header('Location: ' . BASE_URL . 'views/client/dashboard.php');
                exit;
            case 'technicien':
                header('Location: ' . BASE_URL . 'views/technicien/dashboard.php');
                exit;
            default:
                header('Location: ' . BASE_URL . 'views/public/login.php');
                exit;
        }
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header("Location: " . BASE_URL . "views/public/login.php");
        exit;
    }
}

// Déconnexion
if ($action === "logout") {
    session_destroy();
    header("Location: " . BASE_URL . "index.php");
    exit;
}

// Ajout admin/agent
if ($action === "add" && $_SERVER['REQUEST_METHOD'] === "POST") {
    $nom = $_POST['nom'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    $role = $_POST['role'] ?? "agent";

    if ($utilisateurModel->add($nom, $email, $password, $role)) {
        $_SESSION['success'] = "Utilisateur ajouté avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de l'ajout.";
    };
    exit;
}


$id = $_SESSION['user']['id'];
$profil = $utilisateurModel->getById($id);

// ✏️ ACTION : Mettre à jour le profil
if ($action === "update_profil" && $_SERVER['REQUEST_METHOD'] === "POST") {
    

    $id = $_SESSION['user']['id'];
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? null;
    $adresse = $_POST['adresse'] ?? null;

    if ($utilisateurModel->update($id, $nom, $prenom, $email, $telephone, $adresse)) {
        $_SESSION['success'] = "Profil mis à jour avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
    }

    header("Location: " . BASE_URL . "views/technicien/profil.php");
}