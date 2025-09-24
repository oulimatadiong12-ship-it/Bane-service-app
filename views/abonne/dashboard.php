<?php
require_once __DIR__ . '/../../Includes/header.php';
require_once __DIR__ . '/../../Includes/navbar.php';
?>

<div class="container my-5">
    <!-- Titre -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">
            Bonjour, <?= htmlspecialchars($profil['nom'] ?? '') ?> <?= htmlspecialchars($profil['prenom'] ?? '') ?>
        </h1>
        <p class="lead text-muted">Voici le résumé de votre abonnement et de vos derniers paiements.</p>
    </div>

    <!-- Abonnement actif -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6">
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
        <div class="col-lg-8">
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

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

