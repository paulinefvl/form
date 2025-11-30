<?php
session_start();
require "fonctions.php";

$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === "" || $password === "") {
        die("Veuillez remplir tous les champs.");
    }

    $user = getUserByEmail($pdo, $email);

    if (!$user) {
        die("Email ou mot de passe incorrect.");
    }

    if (!password_verify($password, $user['password'])) {
        die("Email ou mot de passe incorrect.");
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nom'] = $user['nom'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['role_name'] = $user['role_name'];

    header("Location: tableau.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Ecran de connexion </title>
    <link rel="stylesheet" href="assets/css/style_login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="topbar">
        <div class="brand">
        </div>
        <nav class="nav-links">
            <a href="index.html">Accueil</a>
            <a href="register.php">Inscription</a>
        </nav>
    </header>

    <main class="page">
        <h3 class=titre>Accéder au compte</h3>
        <section class="card">
            <div class="grid-two">
                <form method="POST">
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" required>
                    </div>
                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <div class="actions">
                        <button class="btn" type="submit">Se connecter</button>
                        <a class="inline-link" href="register.php">Créer un compte</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>