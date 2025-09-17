<?php
session_start();
include __DIR__ . "/../../includes/header.php";
include __DIR__ . "/../../includes/navbar.php";
?>

<div class="container mt-4">
    <h1 class="mb-4">Catalogue Produits</h1>

    <!-- Formulaire de recherche -->
    <form method="get" action="/Bane-service-app/controllers/ProduitController.php">
      <input type="hidden" name="page" value="catalogue">
      <input type="text" name="search" class="form-control me-2" 
           placeholder="Rechercher un produit..." 
           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
      <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>


    <!-- Liste des produits -->
    <div class="row">
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php
                        $imagePath = __DIR__ . "/../../uploads/produits/" . $p['image'];
                        if (!empty($p['image']) && file_exists($imagePath)): ?>
                           <img src="/baneservice-app/uploads/produits/<?= htmlspecialchars($p['image']) ?>" 
                           class="card-img-top" alt="<?= htmlspecialchars($p['nom']) ?>">

                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x200?text=Pas+d'image" 
                                 class="card-img-top" alt="Image par défaut">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($p['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                            <p class="fw-bold text-success"><?= number_format($p['prix'], 2, ',', ' ') ?> €</p>
                        </div>
                        <div class="card-footer text-center">
                            <?php if (!isset($_SESSION['user'])): ?>
                                <a href="/Bane-service-app/views/public/login.php" class="btn btn-warning">Ajouter au panier</a>

                            <?php else: ?>
                                <a href="/Bane-service-app/controllers/PanierController.php?action=ajouter&id=<?= $p['id'] ?>" class="btn btn-success">


                                  Ajouter au panier
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Aucun produit trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . "/../../includes/footer.php"; ?>
