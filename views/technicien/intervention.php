<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/InterventionController.php';
require_once __DIR__ . '/../../controllers/UserController.php';
?>

<style>
  /* Eviter scroll horizontal */
  body {
    overflow-x: hidden;
  }

  /* Sidebar fixe */
  .sidebar {
    position: fixed;
    top: 56px; /* hauteur navbar */
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
    transition: background-color 0.2s, color 0.2s;
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
  margin-top: 56px; 
  padding-bottom: 70px; /* espace pour le footer */
  background-color: #f8f9fa;
  min-height: 100vh;
}


/* Ajout pour espacer l'alerte du bord */
.content > .alert {
  margin-left: 10px;
}

  /* Table style */
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
      top: auto;
    }
    .content {
      margin-left: 0;
      padding: 1rem;
    }
  }
</style>

<div class="sidebar">
    <h5 class="mb-4">Menu</h5>
    <a href="/Bane-Service-App/views/technicien/dashboard.php">Dashboard</a>
    <a href="/Bane-Service-App/views/technicien/intervention.php" class="active">Mes interventions</a>
    <a href="/Bane-Service-App/views/technicien/profil.php">Mon profil</a>
    <a href="/Bane-Service-App/views/technicien/rendezvous.php">Mes rendez-vous</a>
    <a href="<?= BASE_URL ?>/controllers/UserController.php?action=logout">Déconnexion</a>
</div>

<div class="content">
    <h1 class="mb-4">Mes Interventions</h1>

    <h2 class="mb-3">Ajouter une intervention</h2>
    <form method="POST" action="<?= BASE_URL ?>controllers/InterventionController.php" class="mb-5">
        <input type="hidden" name="action" value="ajouter">

        <div class="mb-3">
            <label for="rendezvous_id" class="form-label">Rendez-vous :</label>
            <select name="rendezvous_id" id="rendezvous_id" class="form-select" required>
                <?php foreach($rendezvous as $rv): ?>
                    <option value="<?= $rv['id'] ?>">
                        <?= htmlspecialchars($rv['date'] . ' ' . $rv['heure'] . ' - ' . $rv['client_nom'] . ' ' . $rv['client_prenom'] . ' (' . $rv['service_type'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date début :</label>
            <input type="datetime-local" name="date_debut" id="date_debut" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date fin :</label>
            <input type="datetime-local" name="date_fin" id="date_fin" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="observations" class="form-label">Observations :</label>
            <textarea name="observations" id="observations" rows="3" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut :</label>
            <select name="statut" id="statut" class="form-select">
                <option value="en attente">En attente</option>
                <option value="en cours">En cours</option>
                <option value="terminé">Terminé</option>
                <option value="annulé">Annulé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <hr>

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
                        <td><?= htmlspecialchars($i['statut']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Aucune intervention enregistrée.</div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
