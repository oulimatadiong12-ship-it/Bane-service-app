<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/ServiceController.php';
?>

<div class="container">
    <h1>Gestion des Services</h1>

    <!-- Formulaire ajout service -->
    <h2>Ajouter un service</h2>
    <form method="POST" action="../../controllers/ServiceController.php">
        <input type="hidden" name="action" value="ajouter">
        <div>
            <label>Type :</label>
            <input type="text" name="type" required>
        </div>
        <div>
            <label>Prix :</label>
            <input type="number" step="0.01" name="prix" required>
        </div>
        <div>
            <label>Durée moyenne :</label>
            <input type="text" name="duree">
        </div>
        <div>
            <label>Description :</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Compétences requises :</label>
            <input type="text" name="competences">
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <hr>

    <!-- Liste des services -->
    <h2>Liste des services</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Prix</th>
                <th>Durée moyenne</th>
                <th>Description</th>
                <th>Compétences</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['type']) ?></td>
                <td><?= number_format($s['prix'],2) ?> FCFA</td>
                <td><?= htmlspecialchars($s['duree_moyenne']) ?></td>
                <td><?= htmlspecialchars($s['description']) ?></td>
                <td><?= htmlspecialchars($s['competences_requises']) ?></td>
                <td>
                    <!-- Modifier et supprimer -->
                    <form method="POST" action="<?= BASE_URL ?>controllers/ServiceController.php" style="display:inline">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button type="submit">Modifier</button>
                    </form>
                    <form method="POST" action="<?= BASE_URL ?>controllers/ServiceController.php" style="display:inline" onsubmit="return confirm('Voulez-vous supprimer ce service ?');">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
