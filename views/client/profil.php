<?php
// views/client/profil.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/navbar.php";

// Exemple : récupération des infos de l'utilisateur connecté
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Infos Profil -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4>👤 Mon Profil</h4>
                </div>
                <div class="card-body text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" 
                         class="rounded-circle mb-3" width="120" alt="Avatar">
                    <h5>
                        <?= htmlspecialchars($user['prenom'] ?? 'Client') ?> 
                        <?= htmlspecialchars($user['nom'] ?? '') ?>
                    </h5>
                    <p class="text-muted"><?= htmlspecialchars($user['email'] ?? 'Email non défini') ?></p>
                    <span class="badge bg-success"><?= htmlspecialchars($user['role'] ?? 'client') ?></span>
                </div>
            </div>
        </div>

        <!-- Formulaire de mise à jour -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <h4>✏️ Mettre à jour mes informations</h4>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/controllers/UserController.php?action=updateProfile" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" 
                                       value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" 
                                       value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" class="form-control" 
                                       value="<?= htmlspecialchars($user['telephone'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmer mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">💾 Sauvegarder</button>
                            <button type="reset" class="btn btn-outline-secondary">❌ Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
