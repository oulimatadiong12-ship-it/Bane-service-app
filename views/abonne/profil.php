<?php
require_once __DIR__ . '/../../Includes/header.php';
require_once __DIR__ . '/../../Includes/navbar.php';
?>

<div class="container">
    <h1>Mon Profil</h1>

    <form action="<?= BASE_URL ?>controllers/AbonneController.php" method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>" required><br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($profil['prenom'] ?? '') ?>" required><br><br>

        <label>Email :</label>
        <input type="email" name="email" value="<?= htmlspecialchars($profil['email'] ?? '') ?>" required><br><br>

        <label>Téléphone :</label>
        <input type="text" name="telephone" value="<?= htmlspecialchars($profil['telephone'] ?? '') ?>"><br><br>

        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= htmlspecialchars($profil['adresse'] ?? '') ?>"><br><br>

        <button type="submit" name="action" value="update_profil">Mettre à jour</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
