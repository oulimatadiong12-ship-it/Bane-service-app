<?php
// Affichage de la liste des abonnements
if (!isset($controller)) {
    require_once __DIR__ . '/../../controllers/AbonnementController.php';
    $controller = new AbonnementController();
}
$abonnements = $controller->liste();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Abonnements Canal+</title>
</head>
<body>
    <h1>Gestion des abonnements</h1>

    <form method="post" action="index.php?action=ajouter">
        <h2>Ajouter un abonnement</h2>
        <input type="text" name="client_id" placeholder="ID Client" required>
        <input type="date" name="date_debut" required>
        <input type="date" name="date_fin" required>
        <button type="submit">Ajouter</button>
    </form>

    <form method="post" action="index.php?action=renouveler">
        <h2>Renouveler un abonnement</h2>
        <input type="text" name="abonnement_id" placeholder="ID Abonnement" required>
        <input type="date" name="nouvelle_date_fin" required>
        <button type="submit">Renouveler</button>
    </form>

    <form method="post" action="index.php?action=suspendre">
        <h2>Suspendre un abonnement</h2>
        <input type="text" name="abonnement_id" placeholder="ID Abonnement" required>
        <button type="submit">Suspendre</button>
    </form>

    <h2>Liste des abonnements</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Formule</th>
            <th>Prix</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Statut</th>
        </tr>
        <?php foreach ($abonnements as $abo): ?>
        <tr>
            <td><?= htmlspecialchars($abo['id']) ?></td>
            <td><?= htmlspecialchars($abo['nom']) ?></td>
            <td><?= htmlspecialchars($abo['prenom']) ?></td>
            <td><?= htmlspecialchars($abo['formule']) ?></td>
            <td><?= htmlspecialchars($abo['prix']) ?></td>
            <td><?= htmlspecialchars($abo['date_debut']) ?></td>
            <td><?= htmlspecialchars($abo['date_fin']) ?></td>
            <td><?= htmlspecialchars($abo['statut']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>