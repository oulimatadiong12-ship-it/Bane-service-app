<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/AbonnementAdminController.php';
require_once __DIR__ . '/../../controllers/UserController.php';
?>

<style>
 /* Sidebar fixe */
body {
  overflow-x: hidden; /* éviter scroll horizontal */
  margin: 0;
  padding: 0;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.sidebar {
  position: fixed;
  top: 56px; /* hauteur navbar */
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

/* Contenu à droite */
.content {
  margin-left: 220px;
  padding: 4rem 2rem 6rem 2rem; /* padding-bottom augmenté pour espacer du footer */
  min-height: calc(100vh - 56px); /* hauteur viewport moins navbar */
  box-sizing: border-box;
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
    padding: 1rem 1rem 6rem 1rem;
  }
  
}
</style>

<div class="sidebar">
  <h5 class="mb-3">Admin Menu</h5>
  <a href="<?= BASE_URL ?>/views/admin/produits.php">📦 Produits</a>
  <a href="<?= BASE_URL ?>/views/admin/commandes.php">🛒 Commandes</a>
  <a href="<?= BASE_URL ?>/views/admin/detail_commande.php">📋 Détail Commande</a>
  <a href="<?= BASE_URL ?>/views/admin/abonnements.php">📑 Abonnements</a>
  <a href="<?= BASE_URL ?>/views/admin/finances.php">💰 Finances</a>
  <a href="<?= BASE_URL ?>/views/admin/utilisateurs.php">👤 Utilisateurs</a>
  <a href="<?= BASE_URL ?>/views/admin/services.php">⚙️ Services</a>
  <a href="<?= BASE_URL ?>/views/admin/promotions.php">🎁 Promotions</a>
  <a href="<?= BASE_URL ?>/views/admin/form_promotion.php">📝 Forme Promotion</a>
</div>

<div class="content">
  <h1 class="mb-4">Gestion des Abonnements Canal+</h1>

  <!-- Formulaire ajout -->
  <div class="form-section">
    <h2 class="h4 mb-3">Ajouter un abonnement</h2>
    <form method="post" action="<?= BASE_URL ?>controllers/AbonnementAdminController.php" class="row g-3">
      <input type="hidden" name="action" value="ajouter">

      <div class="col-md-4">
        <label class="form-label">ID Client</label>
        <input type="number" name="client_id" class="form-control" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Formule</label>
        <input type="text" name="formule" class="form-control" placeholder="Ex: Canal+ Basique">
      </div>

      <div class="col-md-4">
        <label class="form-label">Prix</label>
        <input type="number" name="prix" class="form-control" placeholder="5000">
      </div>

      <div class="col-md-4">
        <label class="form-label">Date début</label>
        <input type="date" name="date_debut" class="form-control" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Date fin</label>
        <input type="date" name="date_fin" class="form-control" required>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </div>
    </form>
  </div>

  <hr>

  <!-- Liste des abonnements -->
  <h2 class="h4 mb-3">Liste des abonnements</h2>

  <?php if (!empty($abonnements) && is_array($abonnements)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
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
              <td><?= number_format($abo['prix'], 0, ',', ' ') ?> FCFA</td>
              <td><?= htmlspecialchars($abo['date_debut']) ?></td>
              <td><?= htmlspecialchars($abo['date_fin']) ?></td>
              <td><?= htmlspecialchars($abo['statut']) ?></td>
              <td>
                <!-- Renouveler -->
                <form method="post" action="<?= BASE_URL ?>controllers/AbonnementAdminController.php" class="d-inline">
                  <input type="hidden" name="action" value="renouveler">
                  <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                  <input type="date" name="nouvelle_date_fin" value="<?= date('Y-m-d', strtotime('+1 month')) ?>" required class="form-control form-control-sm mb-1">
                  <button type="submit" class="btn btn-sm btn-primary">Renouveler</button>
                </form>

                <!-- Suspendre -->
                <form method="post" action="<?= BASE_URL ?>controllers/AbonnementAdminController.php" class="d-inline">
                  <input type="hidden" name="action" value="suspendre">
                  <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-warning">Suspendre</button>
                </form>

                <!-- Supprimer -->
                <form method="post" action="<?= BASE_URL ?>controllers/AbonnementAdminController.php" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet abonnement ?');">
                  <input type="hidden" name="action" value="supprimer">
                  <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Aucun abonnement trouvé.</div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
