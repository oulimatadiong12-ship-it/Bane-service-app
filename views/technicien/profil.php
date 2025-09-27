<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/UserController.php';
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
    background-color: #f8f9fa;
    min-height: 100vh;
  }

  /* Form groupes Bootstrap */
  .form-group {
    margin-bottom: 1rem;
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
    <a href="/Bane-Service-App/views/technicien/intervention.php">Mes interventions</a>
    <a href="/Bane-Service-App/views/technicien/profil.php" class="active">Mon profil</a>
    <a href="/Bane-Service-App/views/technicien/rendezvous.php">Mes rendez-vous</a>
</div>

<div class="content">
    <h1 class="mb-4">Profil Technicien</h1>

    <!-- Messages de session -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire de mise à jour -->
    <form method="POST" action="<?= BASE_URL ?>controllers/UserController.php?action=update_profil">
        <input type="hidden" name="action" value="update_profil">

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($profil['nom']) ?>" required class="form-control">
        </div>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($profil['prenom']) ?>" required class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($profil['email']) ?>" required class="form-control">
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($profil['telephone'] ?? '') ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="adresse">Adresse :</label>
            <textarea id="adresse" name="adresse" class="form-control"><?= htmlspecialchars($profil['adresse'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
