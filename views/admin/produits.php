<?php
require_once __DIR__ . "/../../controllers/ProduitController.php";
require_once __DIR__ . "/../../includes/header.php"; // Header commun
require_once __DIR__ . "/../../includes/navbar.php"; // Navbar admin
?>

<div class="container">
    <h1>Gestion des Produits</h1>

    <!-- Formulaire ajout produit -->
    <h2>Ajouter un produit</h2>
    <form action="../../controllers/ProduitController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="ajouter">
        <div>
            <label>Nom :</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>Prix :</label>
            <input type="number" step="0.01" name="prix" required>
        </div>
        <div>
            <label>Description :</label>
            <textarea name="description" required></textarea>
        </div>
        <div>
            <label>Image :</label>
            <input type="file" name="image">
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Liste des produits -->
    <h2>Liste des produits</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= number_format($p['prix'], 2) ?> CFA</td>
                <td><?= htmlspecialchars($p['description']) ?></td>
                <td>
                    <?php if ($p['image']): ?>
                        <img src="../../uploads/produits/<?= $p['image'] ?>" width="80">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="../../controllers/ProduitController.php?action=supprimer&id=<?= $p['id'] ?>" onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . "/../../includes/footer.php"; // Footer commun
?>
