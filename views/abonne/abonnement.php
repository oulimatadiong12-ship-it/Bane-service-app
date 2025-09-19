<?php
require_once __DIR__ . '/../../controllers/AbonnementController.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Abonnements</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Mes Abonnements</h1>

    <?php if (!empty($abonnementsHistorique)): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Formule</th>
                    <th>Prix</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($abonnementsHistorique as $abo): ?>
                    <tr>
                        <td><?= htmlspecialchars($abo['formule']) ?></td>
                        <td><?= htmlspecialchars($abo['prix']) ?> FCFA</td>
                        <td><?= htmlspecialchars($abo['date_debut']) ?></td>
                        <td><?= htmlspecialchars($abo['date_fin']) ?></td>
                        <td><?= htmlspecialchars($abo['statut']) ?></td>
                        <td>
                            <?php if ($abo['statut'] === 'actif'): ?>
                                <form method="POST" action="../../controllers/abonneController.php">
                                    <input type="hidden" name="action" value="renouveler">
                                    <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                                    <input type="date" name="nouvelle_date_fin" required>
                                    <button type="submit">Renouveler</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun abonnement trouvé</p>
    <?php endif; ?>
</body>
</html>
