<?php 
// views/admin/utilisateurs.php
session_start();
require_once __DIR__ . "/../../models/Utilisateur.php";
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . '/../../controllers/UserController.php';

$utilisateurModel = new Utilisateur($pdo);
$users = $utilisateurModel->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffffff;
            color: white;
            flex-shrink: 0;
            padding: 20px 15px;
        }

        .sidebar h4 {
            color: #fff;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .admin-menu-title {
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            color: #000000ff;
            margin-top: 30px;
            margin-bottom: 15px;
            padding-left: 5px;
        }

        .sidebar .nav-link {
            color: #000000ff;
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>Bane Service</h4>
    <h6 class="admin-menu-title">Admin Menu</h6>
    <div class="nav flex-column">
        <a href="produits.php" class="nav-link">🛒 Produits</a>
        <a href="commandes.php" class="nav-link">🧾 Commandes</a>
        <a href="detail_commande.php" class="nav-link">📋 Détail Commande</a>
        <a href="abonnements.php" class="nav-link">📺 Abonnements</a>
        <a href="finances.php" class="nav-link">🏅 Finances</a>
        <a href="utilisateurs.php" class="nav-link active">👤 Utilisateurs</a>
        <a href="services.php" class="nav-link">⚙️ Services</a>
        <a href="promotions.php" class="nav-link">🎁 Promotions</a>
        <a href="forme_promotion.php" class="nav-link">📝 Forme Promotion</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <h2 class="text-center mb-4">Gestion des Utilisateurs</h2>

    <!-- Messages -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Liste des utilisateurs -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">Liste des utilisateurs</div>
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['nom']) ?></td>
                            <td><?= htmlspecialchars($u['prenom']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <span class="badge 
                                    <?php 
                                        if($u['role'] === 'admin') echo 'bg-danger';
                                        elseif($u['role'] === 'agent') echo 'bg-info';
                                        elseif($u['role'] === 'client') echo 'bg-warning text-dark';
                                        else echo 'bg-secondary';
                                    ?>">
                                    <?= htmlspecialchars($u['role']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulaire ajout utilisateur -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">Ajouter un utilisateur</div>
        <div class="card-body">
            <form method="post" action="<?= BASE_URL ?>controllers/UserController.php?action=add">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rôle</label>
                    <select name="role" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="agent">Technicien</option>
                        <option value="client">Client</option>
                        <option value="abonne">Abonné</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Ajouter</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
