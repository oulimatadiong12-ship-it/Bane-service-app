<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container">
    <h1>Mes Rendez-Vous</h1>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Client</th>
                <th>Service</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rendezvous as $rv): ?>
            <tr>
                <td><?= htmlspecialchars($rv['date']) ?></td>
                <td><?= htmlspecialchars($rv['heure']) ?></td>
                <td><?= htmlspecialchars($rv['client_nom'] . ' ' . $rv['client_prenom']) ?></td>
                <td><?= htmlspecialchars($rv['service_type']) ?></td>
                <td><?= htmlspecialchars($rv['statut']) ?></td>
                <td>
                    <?php if($rv['statut'] === 'planifié' || $rv['statut'] === 'en cours'): ?>
                        <form method="POST" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline">
                            <input type="hidden" name="rv_id" value="<?= $rv['id'] ?>">
                            <input type="hidden" name="action" value="terminer">
                            <button type="submit">Terminé</button>
                        </form>
                        <form method="POST" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline" onsubmit="return confirm('Voulez-vous annuler ce rendez-vous ?');">
                            <input type="hidden" name="rv_id" value="<?= $rv['id'] ?>">
                            <input type="hidden" name="action" value="annuler">
                            <button type="submit">Annuler</button>
                        </form>
                    <?php else: ?>
                        <span>Aucune action</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
