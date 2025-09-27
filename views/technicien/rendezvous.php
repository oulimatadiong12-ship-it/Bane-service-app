<?php
require_once __DIR__ . '/../../Includes/header.php';
require_once __DIR__ . '/../../Includes/navbar.php';
require_once __DIR__ . '/../../controllers/RendezVousController.php';
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    overflow-x: hidden;
  }

  /* Sidebar fixe */
  .sidebar {
    position: fixed;
    top: 56px; /* hauteur navbar */
    left: 0;
    width: 220px;
    height: calc(100vh - 56px);
    padding: 1rem;
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
  }

  .sidebar a {
    display: block;
    padding: 0.5rem 0.75rem;
    color: #333;
    text-decoration: none;
    border-radius: 0.25rem;
    margin-bottom: 0.25rem;
    transition: background-color 0.2s, color 0.2s;
  }

  .sidebar a.active,
  .sidebar a:hover {
    background-color: #0d6efd;
    color: white;
  }

  /* Contenu principal */
  .content {
    margin-left: 220px;
    margin-top: 56px;       /* décalage sous la navbar fixe */
    padding: 2rem;
    padding-bottom: 70px;   /* éviter que le footer cache le contenu */
    background-color: #f8f9fa;
    min-height: calc(100vh - 56px);
  }

  /* Responsive */
  @media (max-width: 767.98px) {
    .sidebar {
      position: static;
      width: 100%;
      height: auto;
      border-right: none;
      border-bottom: 1px solid #dee2e6;
      top: auto;
    }
    .content {
      margin-left: 0;
      margin-top: 0; /* plus besoin de marge sur petit écran */
      padding: 1rem;
      min-height: auto;
    }
  }
</style>

<div class="sidebar">
  <h5 class="mb-4">Menu</h5>
  <a href="/Bane-Service-App/views/technicien/dashboard.php">Dashboard</a>
  <a href="/Bane-Service-App/views/technicien/intervention.php">Mes interventions</a>
  <a href="/Bane-Service-App/views/technicien/profil.php">Mon profil</a>
  <a href="/Bane-Service-App/views/technicien/rendezvous.php" class="active">Mes rendez-vous</a>
</div>

<div class="content">
  <h1 class="mb-4">Mes Rendez-Vous</h1>

  <?php if (!empty($rendezvous)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Client</th>
            <th>Service</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rendezvous as $rv): ?>
            <tr>
              <td><?= htmlspecialchars($rv['date']) ?></td>
              <td><?= htmlspecialchars($rv['heure']) ?></td>
              <td><?= htmlspecialchars($rv['client_nom'] . ' ' . $rv['client_prenom']) ?></td>
              <td><?= htmlspecialchars($rv['service_type']) ?></td>
              <td><?= htmlspecialchars($rv['statut']) ?></td>
              <td>
                <?php if($rv['statut'] === 'planifié' || $rv['statut'] === 'en cours'): ?>
                  <form method="POST" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline">
                    <input type="hidden" name="rv_id" value="<?= $rv['id'] ?>">
                    <input type="hidden" name="action" value="terminer">
                    <button type="submit" class="btn btn-sm btn-success me-1">Terminé</button>
                  </form>
                  <form method="POST" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline" onsubmit="return confirm('Voulez-vous annuler ce rendez-vous ?');">
                    <input type="hidden" name="rv_id" value="<?= $rv['id'] ?>">
                    <input type="hidden" name="action" value="annuler">
                    <button type="submit" class="btn btn-sm btn-danger">Annuler</button>
                  </form>
                <?php else: ?>
                  <span>Aucune action</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Aucun rendez-vous planifié.</div>
  <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
