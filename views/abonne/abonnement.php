<?php
require_once __DIR__ . '/../../Includes/header.php';
require_once __DIR__ . '/../../Includes/navbar.php';
require_once __DIR__ . '/../../controllers/AbonneController.php';
?>

<!-- Inclure Bootstrap CSS si ce n’est pas déjà fait -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Layout principal */
    .wrapper {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #343a40;
        color: white;
        padding: 1rem;
    }

    .sidebar a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 0.5rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 4px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #495057;
    }

    /* Contenu principal */
    .main-content {
        flex-grow: 1;
        padding: 2rem;
        background-color: #f8f9fa;
    }
</style>

<div class="wrapper">

    <!-- Sidebar -->
    <nav class="sidebar">
        <h5 class="mb-4">Menu</h5>
        <a href="/Bane-Service-App/views/abonne/abonnement.php" class="active">Mes abonnements</a>
        <a href="/Bane-Service-App/views/abonne/dashboard.php">Dashboard</a>
        <a href="/Bane-Service-App/views/abonne/profil.php">Mon profil</a>
    </nav>

    <!-- Contenu principal -->
    <div class="main-content">
        <h1 class="mb-4">Mes Abonnements</h1>

        <?php if (!empty($abonnementsHistorique) && is_array($abonnementsHistorique)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Formule</th>
                            <th>Prix</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($abonnementsHistorique as $abo): ?>
                            <tr>
                                <td><?= htmlspecialchars($abo['formule']) ?></td>
                                <td><?= htmlspecialchars($abo['prix']) ?> FCFA</td>
                                <td><?= htmlspecialchars($abo['date_debut']) ?></td>
                                <td><?= htmlspecialchars($abo['date_fin']) ?></td>
                                <td><?= htmlspecialchars($abo['statut']) ?></td>
                                <td>
                                    <?php if ($abo['statut'] === 'actif'): ?>
                                        <form method="POST" action="<?= BASE_URL ?>controllers/AbonneController.php" class="d-flex flex-column gap-2">
                                            <input type="hidden" name="action" value="renouveler">
                                            <input type="hidden" name="abonnement_id" value="<?= $abo['id'] ?>">
                                            <input type="date" name="nouvelle_date_fin" class="form-control form-control-sm" required>
                                            <button type="submit" class="btn btn-sm btn-primary">Renouveler</button>
                                        </form>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
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

</div>

<!-- Inclure Bootstrap JS si ce n’est pas déjà dans le footer -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
