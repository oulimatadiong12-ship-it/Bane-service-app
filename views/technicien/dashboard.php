<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/RendezVousController.php';
?>

<div class="container">
    <h1>Dashboard Technicien</h1>

    <h2>Rendez-vous planifiés</h2>

    <?php if (!empty($rendezvous)): ?>
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
                <?php foreach($rendezvous as $rv): ?>
                <tr>
                    <td><?= htmlspecialchars($rv['date']) ?></td>
                    <td><?= htmlspecialchars($rv['heure']) ?></td>
                    <td><?= htmlspecialchars($rv['client_nom'].' '.$rv['client_prenom']) ?></td>
                    <td><?= htmlspecialchars($rv['service_type']) ?></td>
                    <td><?= htmlspecialchars($rv['statut']) ?></td>
                    <td>
                        <form method="post" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline">
                            <input type="hidden" name="action" value="terminer">
                            <input type="hidden" name="id" value="<?= $rv['id'] ?>">
                            <button type="submit">Terminé</button>
                        </form>
                        <form method="post" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline">
                            <input type="hidden" name="action" value="annuler">
                            <input type="hidden" name="id" value="<?= $rv['id'] ?>">
                            <button type="submit">Annuler</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun rendez-vous planifié.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
