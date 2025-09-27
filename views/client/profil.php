<?php
// views/client/profil.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/navbar.php";
require_once __DIR__ . '/../../controllers/UserController.php';

// Exemple : récupération des infos de l'utilisateur connecté
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 56px; /* hauteur navbar fixe */
            left: 0;
            width: 220px;
            height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar a {
            display: block;
            padding: 0.5rem 0.75rem;
            color: #333;
            text-decoration: none;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background-color: #0d6efd;
            color: white;
        }

        /* Contenu */
        .content {
            margin-left: 220px;
            padding: 2rem;
            padding-top: 70px; /* pour navbar */
            padding-bottom: 80px; /* pour footer */
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
        }

        /* Footer */
        footer {
            padding: 1rem 2rem;
            background: #f1f1f1;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            left: 220px;
            right: 0;
            height: 56px;
            display: flex;
            align-items: center;
            z-index: 1030;
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }
            .content {
                margin-left: 0;
                padding: 1rem;
                padding-top: 56px;
                padding-bottom: 70px;
            }
            footer {
                left: 0;
                height: auto;
                position: static;
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-light">

<!-- Sidebar -->
<nav class="sidebar" aria-label="Sidebar menu">
    <h5 class="mb-4">Menu</h5>
    <a href="<?= BASE_URL ?>/views/client/dashboard.php">🏠 Tableau de bord</a>
    <a href="<?= BASE_URL ?>/views/client/commandes.php" class="active">🛒 Mes commandes</a>
    <a href="<?= BASE_URL ?>/views/client/factures.php">Mes factures</a>
    <a href="<?= BASE_URL ?>/views/client/profil.php">👤 Mon profil</a>
    <a href="<?= BASE_URL ?>/views/client/notifications.php">Mes notifications</a>
</nav>

<!-- Contenu principal -->
<div class="content container">
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
                    <form action="<?= BASE_URL ?>/controllers/UserController.php?action=update_client" method="POST">
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

<footer>
    &copy; <?= date('Y') ?> MonSite - Tous droits réservés
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
