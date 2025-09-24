<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container my-5">
    <!-- Titre principal -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">À propos de nous</h1>
        <p class="lead text-muted">Une entreprise multiservices au service de votre quotidien</p>
    </div>

    <!-- Texte descriptif -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <p class="fs-5 text-justify">
                <strong>Bane Service</strong> est une entreprise multiservices innovante,
                spécialisée dans la fourniture de solutions complètes pour les particuliers
                et les professionnels.
            </p>
            <p class="fs-5 text-justify">
                Notre mission est de simplifier la vie de nos clients en regroupant plusieurs
                services essentiels sous une seule enseigne, avec une approche moderne,
                rapide et sécurisée.
            </p>
        </div>
    </div>

    <!-- Valeurs de l'entreprise -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">🎯 Notre Vision</h5>
                    <p class="card-text">Être un acteur incontournable dans les services multisectoriels, reconnu pour la qualité et la fiabilité.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">🤝 Notre Mission</h5>
                    <p class="card-text">Simplifier la vie des clients grâce à une offre diversifiée allant des abonnements Canal+ aux services techniques.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">💡 Nos Valeurs</h5>
                    <p class="card-text">Fiabilité, innovation, proximité et satisfaction client sont au cœur de toutes nos actions.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
