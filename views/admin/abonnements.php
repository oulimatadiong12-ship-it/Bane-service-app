<?php
// Cette vue est incluse par AbonnementAdminController.php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container">
    <h1>Gestion des abonnements Canal+</h1>

    <!-- Formulaire ajout abonnement -->
    <h2>Ajouter un abonnement</h2>
    <form method="post" action="../../controllers/AbonnementAdminController.php">
        <input type="hidden" name="action" value="ajouter">
        <div>
            <label>ID Client :</label>
            <input type="number" name="client_id" required>
        </div>
        <div>
            <label>Formule :</label>
            <input type="text" name="formule" placeholder="Ex: Canal+ Basique">
        </div>
        <div>
            <label>Prix :</label>
            <input type="number" name="prix" placeholder="5000">
        </div>
        <div>
            <label>Date début :</label>
            <input type="date" name="date_debut" required>
        </div>
        <div>
            <label>Date fin :</label>
            <input type="date" name="date_fin" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <hr>

    <!-- Liste des abonnements -->
    <h2>Liste des abonnements</h2>
    <?php if (!empty($abonnements) && is_array($abonnements)): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Formule</th>
                    <th>Prix</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($abonnements as $abo): ?>
                <tr>
                    <td><?= htmlspecialchars($abo['id']) ?></td>
                    <td><?= htmlspecialchars($abo['nom']) ?></td>
                    <td><?= htmlspecialchars($abo['prenom']) ?></td>
                    <td><?= htmlspecialchars($abo['formule']) ?></td>
                    <td><?= number_format($abo['prix'], 2) ?> FCFA</td>
                    <td><?= htmlspecialchars($abo['date_debut']) ?></td>
                    <td><?= htmlspecialchars($abo['date_fin']) ?></td>
                    <td><?= htmlspecialchars($abo['statut']) ?></td>
                    <td>
                        <!-- Renouveler -->
                        <form method="post" action="../../controllers/AbonnementAdminController.php" style="display:inline">
                            <input type="hidden" name="action" value="renouveler">
                            <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                            <input type="date" name="nouvelle_date_fin" value="<?= date('Y-m-d', strtotime('+1 month')) ?>" required>
                            <button type="submit">Renouveler</button>
                        </form>

                        <!-- Suspendre -->
                        <form method="post" action="../../controllers/AbonnementAdminController.php" style="display:inline">
                            <input type="hidden" name="action" value="suspendre">
                            <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                            <button type="submit">Suspendre</button>
                        </form>

                        <!-- Supprimer -->
                        <form method="post" action="../../controllers/AbonnementAdminController.php" style="display:inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet abonnement ?');">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun abonnement trouvé.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
