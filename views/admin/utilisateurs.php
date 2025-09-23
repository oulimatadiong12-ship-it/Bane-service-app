<?php
// views/admin/utilisateurs.php
session_start();
require_once __DIR__ . "/../../models/Utilisateur.php";
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';

$utilisateurModel = new Utilisateur($pdo);
$users = $utilisateurModel->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Utilisateurs</title>
</head>
<body>
    <h2>Gestion des Utilisateurs</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <p style="color:green;"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <h3>Liste des utilisateurs</h3>
    <table border="1">
        <tr>
            <th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th>
        </tr>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['nom']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Ajouter un administrateur / agent</h3>
    <form method="post" action="/controllers/UserController.php?action=add">
        <label>Nom :</label>
        <input type="text" name="nom" required><br><br>

        <label>Email :</label>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br><br>

        <label>Rôle :</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="agent">Agent</option>
        </select><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
