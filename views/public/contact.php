<?php
require_once __DIR__. '/includes/header.php';
?>

<h1>Contactez-nous</h1>
<form action="contact_send.php" method="POST">
    <label for="name">Nom :</label>
    <input type="text" name="name" id="name" required><br><br>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="message">Message :</label>
    <textarea name="message" id="message" rows="5" required></textarea><br><br>

    <button type="submit">Envoyer</button>
</form>

<?php
require_once __DIR__ . '/includes/footer.php';
?>