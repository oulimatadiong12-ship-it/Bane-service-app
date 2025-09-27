<?php
require_once __DIR__ . '/../../Includes/header.php';
require_once __DIR__ . '/../../Includes/navbar.php';
require_once __DIR__ . '/../../controllers/AbonneController.php';
require_once __DIR__ . '/../../controllers/UserController.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        overflow-x: hidden;
    }

    .sidebar {
        position: fixed;
        top: 56px;
        left: 0;
        width: 220px;
        height: calc(100vh - 56px);
        background-color: #343a40;
        color: white;
        padding: 1rem;
        border-right: 1px solid #dee2e6;
    }

    .sidebar a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 0.5rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 4px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #495057;
    }

    .main-content {
        margin-left: 220px;
        margin-top: 56px;
        padding: 2rem;
        padding-bottom: 70px;
        background-color: #f8f9fa;
        min-height: calc(100vh - 56px);
    }

    @media (max-width: 767.98px) {
        .sidebar {
            position: static;
            width: 100%;
            height: auto;
            top: auto;
            border-right: none;
            border-bottom: 1px solid #dee2e6;
        }

        .main-content {
            margin-left: 0;
            margin-top: 0;
            padding: 1rem;
        }
    }
</style>

<div class="sidebar">
    <h5 class="mb-4">Menu</h5>
    <a href="/Bane-Service-App/views/abonne/abonnement.php">Mes abonnements</a>
    <a href="/Bane-Service-App/views/abonne/dashboard.php" class="active">Dashboard</a>
    <a href="/Bane-Service-App/views/abonne/profil.php">Mon profil</a>
    <a href="<?= BASE_URL ?>/controllers/UserController.php?action=logout">Déconnexion</a>
</div>

<div class="main-content">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">
            Bonjour, <?= htmlspecialchars($profil['nom'] ?? '') ?> <?= htmlspecialchars($profil['prenom'] ?? '') ?>
        </h1>
        <p class="lead text-muted">Voici le résumé de votre abonnement et de vos derniers paiements.</p>
    </div>

    <!-- Abonnement actif -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    Abonnement Actif
                </div>
                <div class="card-body">
                    <?php if (!empty($abonnement)): ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Formule :</strong> <?= htmlspecialchars($abonnement['formule']) ?></li>
                            <li class="list-group-item"><strong>Prix :</strong> <?= htmlspecialchars($abonnement['prix']) ?> FCFA</li>
                            <li class="list-group-item"><strong>Date de début :</strong> <?= htmlspecialchars($abonnement['date_debut']) ?></li>
                            <li class="list-group-item"><strong>Date de fin :</strong> <?= htmlspecialchars($abonnement['date_fin']) ?></li>
                            <li class="list-group-item"><strong>Statut :</strong> <?= htmlspecialchars($abonnement['statut']) ?></li>
                        </ul>
                    <?php else: ?>
                        <p class="text-center mb-0">Aucun abonnement actif</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers paiements -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    Derniers Paiements
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($paiements) && is_array($paiements)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date paiement</th>
                                        <th>Montant (FCFA)</th>
                                        <th>Abonnement ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paiements as $paiement): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($paiement['date_paiement']) ?></td>
                                            <td><?= htmlspecialchars($paiement['montant']) ?></td>
                                            <td><?= htmlspecialchars($paiement['abonnement_id']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center m-3">Aucun paiement enregistré</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
