<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/UserController.php';
?>

<div class="container">
    <h1>Profil Technicien</h1>

    <form method="POST" action="<?= BASE_URL ?>controllers/UserController.php">
        <input type="hidden" name="action" value="update_profil">

        <div>
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom']) ?>" required>
        </div>

        <div>
            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($profil['prenom']) ?>" required>
        </div>

        <div>
            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($profil['email']) ?>" required>
        </div>

        <div>
            <label>Téléphone :</label>
            <input type="text" name="telephone" value="<?= htmlspecialchars($profil['telephone']) ?>">
        </div>

        <div>
            <label>Adresse :</label>
            <textarea name="adresse"><?= htmlspecialchars($profil['adresse']) ?></textarea>
        </div>

        <button type="submit">Mettre à jour</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
