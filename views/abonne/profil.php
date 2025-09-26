<?php
require_once __DIR__ . '/../../Includes/header.php';
require_once __DIR__ . '/../../Includes/navbar.php';
require_once __DIR__ . '/../../controllers/AbonneController.php';
?>

<!-- Bootstrap CSS (au cas où ce n’est pas déjà dans header.php) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .wrapper {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

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
        <a href="/Bane-Service-App/views/abonne/abonnement.php">Mes abonnements</a>
        <a href="/Bane-Service-App/views/abonne/dashboard.php">Dashboard</a>
        <a href="/Bane-Service-App/views/abonne/profil.php" class="active">Mon profil</a>
    </nav>

    <!-- Contenu principal -->
    <div class="main-content">
        <h1 class="mb-4">Mon Profil</h1>

        <form action="<?= BASE_URL ?>controllers/AbonneController.php" method="POST" class="needs-validation" novalidate>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($profil['prenom'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($profil['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($profil['telephone'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="<?= htmlspecialchars($profil['adresse'] ?? '') ?>">
            </div>

            <button type="submit" name="action" value="update_profil" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

</div>

<!-- Bootstrap JS (au cas où ce n’est pas dans le footer) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
