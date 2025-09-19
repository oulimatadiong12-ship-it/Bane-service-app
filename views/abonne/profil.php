<?php
require_once __DIR__ . '/../../controllers/AbonnementController.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Mon Profil</h1>

    <form action="../../controllers/abonneController.php" method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom']) ?>" required><br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($profil['prenom']) ?>" required><br><br>

        <label>Email :</label>
        <input type="email" name="email" value="<?= htmlspecialchars($profil['email']) ?>" required><br><br>

        <label>Téléphone :</label>
        <input type="text" name="telephone" value="<?= htmlspecialchars($profil['telephone']) ?>"><br><br>

        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= htmlspecialchars($profil['adresse']) ?>"><br><br>

        <button type="submit" name="action" value="update_profil">Mettre à jour</button>
    </form>
</body>
</html>
