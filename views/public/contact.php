<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/navbar.php';
?>

<div class="container my-5">
    <!-- Titre -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Contactez-nous</h1>
        <p class="lead text-muted">Une question ? N'hésitez pas à nous envoyer un message.</p>
    </div>

    <!-- Formulaire -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="contact_send.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom :</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message :</label>
                    <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Envoyer</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
