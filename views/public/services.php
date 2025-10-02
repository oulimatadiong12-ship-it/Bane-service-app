<?php
// views/admin/services.php
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../db/connexion.php";
require_once __DIR__ . "/../../includes/navbar.php";

// --- Récupération des services ---
$stmt = $pdo->query("SELECT * FROM Service ORDER BY id DESC");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4 class="mb-0">📋 Gestion des Services</h4>
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">➕ Ajouter</button>
        </div>
        <div class="card-body">
            <?php if (!empty($services)): ?>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Prix</th>
                            <th>Durée</th>
                            <th>Description</th>
                            <th>Compétences requises</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $srv): ?>
                        <tr>
                            <td><?= htmlspecialchars($srv['id']) ?></td>
                            <td><?= htmlspecialchars($srv['type']) ?></td>
                            <td><?= number_format($srv['prix'], 2) ?> FCFA</td>
                            <td><?= htmlspecialchars($srv['duree_moyenne']) ?></td>
                            <td><?= htmlspecialchars($srv['description']) ?></td>
                            <td><?= htmlspecialchars($srv['competences_requises']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>controllers/ServiceController.php?action=edit&id=<?= $srv['id'] ?>" class="btn btn-warning btn-sm">✏ Modifier</a>
                                <a href="<?= BASE_URL ?>controllers/ServiceController.php?action=delete&id=<?= $srv['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce service ?')">🗑 Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">Aucun service enregistré pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="<?= BASE_URL ?>controllers/ServiceController.php?action=add" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addServiceModalLabel">➕ Ajouter un Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Type de service</label>
            <input type="text" name="type" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Prix (FCFA)</label>
            <input type="number" step="0.01" name="prix" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Durée moyenne</label>
            <input type="text" name="duree_moyenne" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Compétences requises</label>
            <textarea name="competences_requises" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">💾 Enregistrer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . "/../../includes/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
