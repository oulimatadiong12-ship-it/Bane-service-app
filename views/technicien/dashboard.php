<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/RendezVousController.php';
require_once __DIR__ . '/../../controllers/InterventionController.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body { margin: 0; padding: 0; overflow-x: hidden; }
  .sidebar {
    position: fixed; top: 56px; left: 0; width: 220px; height: calc(100vh - 56px);
    padding: 1rem; background-color: #f8f9fa; border-right: 1px solid #dee2e6; overflow-y: auto;
  }
  .sidebar a {
    display: block; padding: 0.5rem 0.75rem; color: #333; text-decoration: none;
    border-radius: 0.25rem; margin-bottom: 0.25rem; transition: background-color 0.2s;
  }
  .sidebar a.active, .sidebar a:hover { background-color: #0d6efd; color: white; }
  .content {
    margin-left: 220px; padding: 2rem; padding-top: calc(2rem + 56px);
    background-color: #f8f9fa; min-height: 100vh; padding-bottom: 80px;
  }
  .card-summary { margin-bottom: 2rem; }
  @media (max-width: 767.98px) {
    .sidebar { position: static; width: 100%; height: auto; border-right: none; border-bottom: 1px solid #dee2e6; top: 0; }
    .content { margin-left: 0; padding: 1rem; padding-top: calc(1rem + 56px); }
  }
</style>

<div class="sidebar">
  <h5 class="mb-4">Menu</h5>
  <a href="/Bane-Service-App/views/technicien/dashboard.php" class="active">Dashboard</a>
  <a href="/Bane-Service-App/views/technicien/intervention.php">Mes interventions</a>
  <a href="/Bane-Service-App/views/technicien/profil.php">Mon profil</a>
  <a href="/Bane-Service-App/views/technicien/rendezvous.php">Mes rendez-vous</a>
  <a href="<?= BASE_URL ?>/controllers/UserController.php?action=logout">Déconnexion</a>
</div>

<div class="content">
  <h1 class="mb-4">Dashboard Technicien</h1>

  <!-- Résumé -->
  <div class="row card-summary">
    <div class="col-md-4 mb-3">
      <div class="card border-primary">
        <div class="card-body text-center">
          <h5 class="card-title">Rendez-vous à venir</h5>
          <p class="display-6"><?= isset($rendezvous) ? count(array_filter($rendezvous, fn($rv) => in_array($rv['statut'], ['planifié', 'en cours']))) : 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-success">
        <div class="card-body text-center">
          <h5 class="card-title">Interventions réalisées</h5>
          <p class="display-6"><?= isset($interventions) ? count(array_filter($interventions, fn($i) => $i['statut'] === 'terminé')) : 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-warning">
        <div class="card-body text-center">
          <h5 class="card-title">Interventions en cours</h5>
          <p class="display-6"><?= isset($interventions) ? count(array_filter($interventions, fn($i) => $i['statut'] === 'en cours')) : 0 ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Prochains rendez-vous -->
  <h2 class="mb-3">Prochains rendez-vous</h2>
  <?php
    $rvsAvenir = isset($rendezvous) ? array_filter($rendezvous, fn($rv) => in_array($rv['statut'], ['planifié', 'en cours'])) : [];
  ?>
  <?php if (!empty($rvsAvenir)): ?>
    <div class="table-responsive mb-5">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-primary">
          <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Client</th>
            <th>Service</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rvsAvenir as $rv): ?>
          <tr>
            <td><?= htmlspecialchars($rv['date']) ?></td>
            <td><?= htmlspecialchars(substr($rv['heure'], 0, 5)) ?></td>
            <td><?= htmlspecialchars($rv['client_nom'].' '.$rv['client_prenom']) ?></td>
            <td><?= htmlspecialchars($rv['service_type']) ?></td>
            <td>
              <?php
                $badgeClass = match($rv['statut']) {
                  'planifié' => 'bg-primary',
                  'en cours' => 'bg-warning text-dark',
                  'terminé' => 'bg-success',
                  'annulé' => 'bg-danger',
                  default => 'bg-secondary'
                };
              ?>
              <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($rv['statut']) ?></span>
            </td>

          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Aucun rendez-vous à venir.</div>
  <?php endif; ?>

  <!-- Historique des interventions -->
  <h2 class="mb-3">Historique des interventions</h2>
  <?php if (!empty($interventions)): ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Rendez-vous</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Observations</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($interventions as $i): ?>
          <tr>
            <td><?= htmlspecialchars($i['rv_date'] . ' ' . $i['rv_heure'] . ' - ' . $i['client_nom'] . ' ' . $i['client_prenom'] . ' (' . $i['service_type'] . ')') ?></td>
            <td><?= htmlspecialchars($i['date_debut']) ?></td>
            <td><?= htmlspecialchars($i['date_fin']) ?></td>
            <td><?= htmlspecialchars($i['observations']) ?></td>
            <td>
              <?php
                $badgeClass = match($i['statut']) {
                  'en attente' => 'bg-secondary',
                  'en cours' => 'bg-warning text-dark',
                  'terminé' => 'bg-success',
                  'annulé' => 'bg-danger',
                  default => 'bg-secondary'
                };
              ?>
              <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($i['statut']) ?></span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Aucune intervention enregistrée.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
