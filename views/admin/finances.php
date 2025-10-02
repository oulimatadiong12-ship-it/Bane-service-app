<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/TransactionController.php';
?>

<style>
  body {
    overflow-x: hidden; /* éviter scroll horizontal */
  }

  /* Navbar fixe : 56px height */
  /* Sidebar fixe */
  .sidebar {
    position: fixed;
    top: 56px; /* sous la navbar */
    left: 0;
    width: 220px;
    height: calc(100vh - 56px); /* pleine hauteur moins navbar */
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
    margin-left: 220px; /* largeur sidebar */
    padding: 2rem;
    padding-top: 70px; /* espace sous navbar fixe */
    padding-bottom: 80px; /* espace footer */
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
    <a href="<?= BASE_URL ?>/views/admin/finances.php" class="active">💰 Finances</a>
    <a href="<?= BASE_URL ?>/views/admin/utilisateurs.php">👤 Utilisateurs</a>
    <a href="<?= BASE_URL ?>/views/admin/services.php">⚙️ Services</a>
    <a href="<?= BASE_URL ?>/views/admin/promotions.php">🎁 Promotions</a>
    <a href="<?= BASE_URL ?>/views/admin/form_promotion.php">📝 Forme Promotion</a>
</div>

<div class="content container">
    <h1>Module Finances</h1>

    <h2>Solde actuel caisse : <?= number_format($soldeCaisse, 2) ?> FCFA</h2>

    <hr>

    <h2>Ajouter une transaction</h2>
    <form method="POST" action="<?= BASE_URL ?>controllers/TransactionController.php" class="mb-4">
        <input type="hidden" name="action" value="ajouter">

        <div class="mb-3">
            <label class="form-label">Type :</label>
            <select name="type" required class="form-select">
                <option value="OM">OM</option>
                <option value="Wave">Wave</option>
                <option value="Espèces">Espèces</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Opération :</label>
            <select name="operation" required class="form-select">
                <option value="dépôt">Dépôt</option>
                <option value="retrait">Retrait</option>
                <option value="crédit">Crédit</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Montant :</label>
            <input type="number" step="0.01" name="montant" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Numéro client / référence :</label>
            <input type="text" name="numero" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Client :</label>
            <select name="utilisateur_id" required class="form-select">
                <?php foreach($clients as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['nom'].' '.$c['prenom'].' ('.$c['telephone'].')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Statut :</label>
            <select name="statut" class="form-select">
                <option value="validée">Validée</option>
                <option value="annulée">Annulée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <hr>

    <h2>Historique des transactions</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Opération</th>
                    <th>Montant</th>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Employé</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['type']) ?></td>
                    <td><?= htmlspecialchars($t['operation']) ?></td>
                    <td><?= number_format($t['montant'], 2) ?> FCFA</td>
                    <td><?= htmlspecialchars($t['numero']) ?></td>
                    <td><?= htmlspecialchars($t['client_nom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($t['employe_nom'] ?? '') ?>Cheikh Gueye</td>
                    <td><?= $t['date'] ?></td>
                    <td><?= htmlspecialchars($t['statut']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
