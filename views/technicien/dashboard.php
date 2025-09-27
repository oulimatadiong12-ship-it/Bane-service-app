<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/RendezVousController.php';
?>

<style>
  /* Sidebar fixe */
  body {
    overflow-x: hidden; /* éviter scroll horizontal */
  }

  .sidebar {
    position: fixed;
    top: 56px; /* hauteur navbar si bootstrap navbar */
    left: 0;
    width: 220px;
    height: 100vh;
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
  }

  .sidebar a.active,
  .sidebar a:hover {
    background-color: #0d6efd;
    color: white;
  }

  /* Contenu à droite */
  .content {
    margin-left: 220px;
    padding: 2rem;
  }

  /* Table style */
  table th, table td {
    vertical-align: middle !important;
  }

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
    }
  }
</style>

<div class="sidebar">
    <h5 class="mb-4">Menu</h5>
    <a href="/Bane-Service-App/views/technicien/dashboard.php" class="active">Dashboard</a>
    <a href="/Bane-Service-App/views/technicien/intervention.php">Mes interventions</a>
    <a href="/Bane-Service-App/views/technicien/profil.php">Mon profil</a>
    <a href="/Bane-Service-App/views/technicien/rendezvous.php">Mes rendez-vous</a>
</div>

<div class="content">
    <h1>Dashboard Technicien</h1>
    <h2 class="mb-4">Rendez-vous planifiés</h2>

    <?php if (!empty($rendezvous)): ?>
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle">
              <thead class="table-primary">
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
                  <?php foreach($rendezvous as $rv): ?>
                  <tr>
                      <td><?= htmlspecialchars($rv['date']) ?></td>
                      <td><?= htmlspecialchars($rv['heure']) ?></td>
                      <td><?= htmlspecialchars($rv['client_nom'].' '.$rv['client_prenom']) ?></td>
                      <td><?= htmlspecialchars($rv['service_type']) ?></td>
                      <td><?= htmlspecialchars($rv['statut']) ?></td>
                      <td>
                          <form method="post" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline">
                              <input type="hidden" name="action" value="terminer">
                              <input type="hidden" name="id" value="<?= $rv['id'] ?>">
                              <button type="submit" class="btn btn-success btn-sm">Terminé</button>
                          </form>
                          <form method="post" action="<?= BASE_URL ?>controllers/RendezVousController.php" style="display:inline">
                              <input type="hidden" name="action" value="annuler">
                              <input type="hidden" name="id" value="<?= $rv['id'] ?>">
                              <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                          </form>
                      </td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>
    <?php else: ?>
        <p>Aucun rendez-vous planifié.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
