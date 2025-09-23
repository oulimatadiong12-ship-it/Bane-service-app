<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container">
    <h1>Mes Interventions</h1>

    <h2>Ajouter une intervention</h2>
    <form method="POST" action="<?= BASE_URL ?>controllers/InterventionController.php">
        <input type="hidden" name="action" value="ajouter">

        <div>
            <label>Rendez-vous :</label>
            <select name="rendezvous_id" required>
                <?php foreach($rendezvous as $rv): ?>
                    <option value="<?= $rv['id'] ?>">
                        <?= htmlspecialchars($rv['date'] . ' ' . $rv['heure'] . ' - ' . $rv['client_nom'] . ' ' . $rv['client_prenom'] . ' (' . $rv['service_type'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Date début :</label>
            <input type="datetime-local" name="date_debut" required>
        </div>

        <div>
            <label>Date fin :</label>
            <input type="datetime-local" name="date_fin" required>
        </div>

        <div>
            <label>Observations :</label>
            <textarea name="observations" rows="3"></textarea>
        </div>

        <div>
            <label>Statut :</label>
            <select name="statut">
                <option value="en attente">En attente</option>
                <option value="en cours">En cours</option>
                <option value="terminé">Terminé</option>
                <option value="annulé">Annulé</option>
            </select>
        </div>

        <button type="submit">Ajouter</button>
    </form>

    <hr>

    <h2>Historique des interventions</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Rendez-vous</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Observations</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($interventions as $i): ?>
            <tr>
                <td><?= htmlspecialchars($i['rv_date'] . ' ' . $i['rv_heure'] . ' - ' . $i['client_nom'] . ' ' . $i['client_prenom'] . ' (' . $i['service_type'] . ')') ?></td>
                <td><?= htmlspecialchars($i['date_debut']) ?></td>
                <td><?= htmlspecialchars($i['date_fin']) ?></td>
                <td><?= htmlspecialchars($i['observations']) ?></td>
                <td><?= htmlspecialchars($i['statut']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
