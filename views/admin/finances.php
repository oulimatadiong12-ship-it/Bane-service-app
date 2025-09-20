<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container">
    <h1>Module Finances</h1>

    <h2>Solde actuel caisse : <?= number_format($soldeCaisse,2) ?> FCFA</h2>

    <hr>

    <h2>Ajouter une transaction</h2>
    <form method="POST" action="../../controllers/TransactionController.php">
        <input type="hidden" name="action" value="ajouter">

        <div>
            <label>Type :</label>
            <select name="type" required>
                <option value="OM">OM</option>
                <option value="Wave">Wave</option>
                <option value="Espèces">Espèces</option>
            </select>
        </div>

        <div>
            <label>Opération :</label>
            <select name="operation" required>
                <option value="dépôt">Dépôt</option>
                <option value="retrait">Retrait</option>
                <option value="crédit">Crédit</option>
            </select>
        </div>

        <div>
            <label>Montant :</label>
            <input type="number" step="0.01" name="montant" required>
        </div>

        <div>
            <label>Numéro client / référence :</label>
            <input type="text" name="numero" required>
        </div>

        <div>
            <label>Client :</label>
            <select name="utilisateur_id" required>
                <?php foreach($clients as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['nom'].' '.$c['prenom'].' ('.$c['telephone'].')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Statut :</label>
            <select name="statut">
                <option value="validée">Validée</option>
                <option value="annulée">Annulée</option>
            </select>
        </div>

        <button type="submit">Ajouter</button>
    </form>

    <hr>

    <h2>Historique des transactions</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Opération</th>
                <th>Montant</th>
                <th>Numéro</th>
                <th>Client</th>
                <th>Employé</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['type']) ?></td>
                <td><?= htmlspecialchars($t['operation']) ?></td>
                <td><?= number_format($t['montant'],2) ?> FCFA</td>
                <td><?= htmlspecialchars($t['numero']) ?></td>
                <td><?= htmlspecialchars($t['client_nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($t['employe_nom'] ?? '') ?></td>
                <td><?= $t['date'] ?></td>
                <td><?= htmlspecialchars($t['statut']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
