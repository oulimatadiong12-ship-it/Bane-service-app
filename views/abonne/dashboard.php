<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container">
    <h1>Bonjour, <?= htmlspecialchars($profil['nom'] ?? '') ?> <?= htmlspecialchars($profil['prenom'] ?? '') ?></h1>

    <h2>Abonnement Actif</h2>
    <?php if (!empty($abonnement)): ?>
        <ul>
            <li>Formule : <?= htmlspecialchars($abonnement['formule']) ?></li>
            <li>Prix : <?= htmlspecialchars($abonnement['prix']) ?> FCFA</li>
            <li>Date de début : <?= htmlspecialchars($abonnement['date_debut']) ?></li>
            <li>Date de fin : <?= htmlspecialchars($abonnement['date_fin']) ?></li>
            <li>Statut : <?= htmlspecialchars($abonnement['statut']) ?></li>
        </ul>
    <?php else: ?>
        <p>Aucun abonnement actif</p>
    <?php endif; ?>

    <h2>Derniers Paiements</h2>
    <?php if (!empty($paiements) && is_array($paiements)): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Date paiement</th>
                    <th>Montant</th>
                    <th>Abonnement</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paiements as $paiement): ?>
                    <tr>
                        <td><?= htmlspecialchars($paiement['date_paiement']) ?></td>
                        <td><?= htmlspecialchars($paiement['montant']) ?> FCFA</td>
                        <td><?= htmlspecialchars($paiement['abonnement_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun paiement enregistré</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
