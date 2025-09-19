<?php
require_once __DIR__ . '/../../controllers/AbonnementController.php'; // 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Abonné</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Bonjour, <?= htmlspecialchars($profil['nom']) ?> <?= htmlspecialchars($profil['prenom']) ?></h1>

    <h2>Abonnement Actif</h2>
    <?php if ($abonnement): ?>
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
    <?php if (!empty($paiements)): ?>
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
</body>
</html>
