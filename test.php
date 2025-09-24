<?php
require_once 'db/connexion.php'; // Assure que $pdo est bien créé

$users = [
    [
        "nom" => "Bousso",
        "prenom" => "Amadou",
        "email" => "admin@example.com",
        "password" => "admin123",
        "role" => "admin",
        "telephone" => "770000001",
        "adresse" => "Dakar, Sénégal"
    ],
    [
        "nom" => "Diop",
        "prenom" => "Fatou",
        "email" => "fatou@example.com",
        "password" => "fatou123",
        "role" => "client",
        "telephone" => "770000002",
        "adresse" => "Thiès, Sénégal"
    ],
    [
        "nom" => "Sarr",
        "prenom" => "Moussa",
        "email" => "moussa@example.com",
        "password" => "moussa123",
        "role" => "technicien",
        "telephone" => "770000003",
        "adresse" => "Saint-Louis, Sénégal"
    ],
    [
        "nom" => "Ba",
        "prenom" => "Awa",
        "email" => "awa@example.com",
        "password" => "awa123",
        "role" => "abonne",
        "telephone" => "770000004",
        "adresse" => "Kaolack, Sénégal"
    ],
    [
        "nom" => "Gueye",
        "prenom" => "Cheikh",
        "email" => "cheikh@example.com",
        "password" => "cheikh123",
        "role" => "client",
        "telephone" => "770000005",
        "adresse" => "Ziguinchor, Sénégal"
    ],
];

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("
        INSERT INTO Utilisateur (nom, prenom, email, password, role, telephone, adresse)
        VALUES (:nom, :prenom, :email, :password, :role, :telephone, :adresse)
    ");

    foreach ($users as $u) {
        $stmt->execute([
            ':nom'       => $u['nom'],
            ':prenom'    => $u['prenom'],
            ':email'     => $u['email'],
            ':password'  => password_hash($u['password'], PASSWORD_BCRYPT),
            ':role'      => $u['role'],
            ':telephone' => $u['telephone'],
            ':adresse'   => $u['adresse'],
        ]);
    }

    $pdo->commit();
    echo "✅ 5 utilisateurs insérés avec succès.";
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "❌ Erreur d'insertion : " . $e->getMessage();
}
