<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/ServiceController.php';
?>

<style>
  body {
    overflow-x: hidden;
  }

  .sidebar {
    position: fixed;
    top: 56px; /* sous navbar */
    left: 0;
    width: 220px;
    height: calc(100vh - 56px);
    padding: 1rem;
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
    overflow-y: auto;
  }

  .sidebar a {
    display: block;
    padding: 0.5rem 0.75rem;
    color: #333;
    text-decoration: none;
    border-radius: 0.25rem;
    margin-bottom: 0.25rem;
  }

  .sidebar a.active,
  .sidebar a:hover {
    background-color: #0d6efd;
    color: white;
  }

  .content {
    margin-left: 220px;
    padding: 2rem;
    padding-top: 70px;
    padding-bottom: 80px;
    min-height: calc(100vh - 56px);
  }

  table th, table td {
    vertical-align: middle !important;
  }

  /* Responsive */
  @media (max-width: 767.98px) {
    .sidebar {
      position: static;
      width: 100%;
      height: auto;
      border-right: none;
      border-bottom: 1px solid #dee2e6;
    }
    .content {
      margin-left: 0;
      padding: 1rem;
      padding-top: 1rem;
      padding-bottom: 80px;
    }
  }
</style>

<div class="sidebar">
    <h5 class="mb-4">Menu</h5>
    <a href="<?= BASE_URL ?>/views/admin/produits.php">📦 Produits</a>
    <a href="<?= BASE_URL ?>/views/admin/commandes.php">🛒 Commandes</a>
    <a href="<?= BASE_URL ?>/views/admin/detail_commande.php">📋 Détail Commande</a>
    <a href="<?= BASE_URL ?>/views/admin/abonnements.php">📑 Abonnements</a>
    <a href="<?= BASE_URL ?>/views/admin/finances.php">💰 Finances</a>
    <a href="<?= BASE_URL ?>/views/admin/utilisateurs.php">👤 Utilisateurs</a>
    <a href="<?= BASE_URL ?>/views/admin/services.php" class="active">⚙️ Services</a>
    <a href="<?= BASE_URL ?>/views/admin/promotions.php">🎁 Promotions</a>
    <a href="<?= BASE_URL ?>/views/admin/form_promotion.php">📝 Forme Promotion</a>
</div>

<div class="content container">
    <h1>Gestion des Services</h1>

    <!-- Formulaire ajout service -->
    <h2>Ajouter un service</h2>
    <form method="POST" action="<?= BASE_URL ?>controllers/ServiceController.php" class="mb-4">
        <input type="hidden" name="action" value="ajouter">

        <div class="mb-3">
            <label class="form-label">Type :</label>
            <input type="text" name="type" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Prix :</label>
            <input type="number" step="0.01" name="prix" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Durée moyenne :</label>
            <input type="text" name="duree" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description :</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Compétences requises :</label>
            <input type="text" name="competences" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <hr>

    <!-- Liste des services -->
    <h2>Liste des services</h2>
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
          <thead class="table-light">
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
                  <td><?= number_format($s['prix'], 2) ?> FCFA</td>
                  <td><?= htmlspecialchars($s['duree_moyenne']) ?></td>
                  <td><?= htmlspecialchars($s['description']) ?></td>
                  <td><?= htmlspecialchars($s['competences_requises']) ?></td>
                  <td>
                      <form method="POST" action="<?= BASE_URL ?>controllers/ServiceController.php" style="display:inline">
                          <input type="hidden" name="action" value="modifier">
                          <input type="hidden" name="id" value="<?= $s['id'] ?>">
                          <button type="submit" class="btn btn-sm btn-warning">Modifier</button>
                      </form>
                      <form method="POST" action="<?= BASE_URL ?>controllers/ServiceController.php" style="display:inline" onsubmit="return confirm('Voulez-vous supprimer ce service ?');">
                          <input type="hidden" name="action" value="supprimer">
                          <input type="hidden" name="id" value="<?= $s['id'] ?>">
                          <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                      </form>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
