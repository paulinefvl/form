<?php
session_start();
require "fonctions.php";

$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $adresse = trim($_POST['adresse']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);
    $pattern = "/^(?=.[A-Za-z])(?=.\d)(?=.[@$!%#?&])[A-Za-z\d@$!%*#?&]{12,}$/";
    $role_id = 1;

    if ($nom === "" || $email === "" || $adresse === "" || $password === "" || $passwordConfirm === "") {
        die("Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide.");
    }

    if ($password !== $passwordConfirm) {
        die("Les mots de passe ne correspondent pas.");
    }

    if (emailExiste($pdo, $email)) {
        die("Cet email existe déjà.");
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (creerUtilisateur($pdo, $nom, $email, $passwordHash, $adresse, $role_id)) {
        echo "<p class='success-message'>Inscription réussie. <a href='login.php'>Se connecter</a></p>";

    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I= Page d'inscription </title>
    <link rel="stylesheet" href="assets/css/style_register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="nebula-dot" style="left: 10%; top: 15%;"></div>
    <div class="nebula-dot secondary" style="right: 8%; bottom: 22%;"></div>

    <header class="topbar">
        <div class="brand">
            <span>Welcome</span>
        </div>
        <nav class="nav-links">
            <a href="index.html">Accueil</a>
            <a href="login.php">Connexion</a>
        </nav>
    </header>

    <main class="page">
        <div class="grid-two">
            <section class="card">
                <h3 class="titre">Créer un compte</h3>
                <form method="POST">
                    <div class="field">
                        <label>Nom : </label>
                        <input type="text" name="nom" required>
                    </div>

                    <div class="field">
                        <label>Email : </label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="field">
                        <label>Adresse physique : </label>
                        <input type="text" 
                        id="addressInput" 
                        name="adresse" 
                        placeholder="Commencez à taper votre adresse..." 
                        autocomplete="off" required>
                        <ul id="suggestions"></ul>
                    </div>

                    <div class="field">
                        <label>Mot de passe : </label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="field">
                        <label>Confirmer le mot de passe : </label>
                        <input type="password" name="password_confirm" required>
                    </div>

                    <div class="actions">
                        <button class="btn" type="submit">S'inscrire</button>
                        <a class="inline-link" href="login.php">Déjà membre ?</a>
                    </div>
                </form>
            </section>
        </div>
    </main>
<script>
document.addEventListener("DOMContentLoaded", () => {

  const input = document.getElementById("addressInput");
  const suggestions = document.getElementById("suggestions");

  if (!input || !suggestions) {
    console.error("❌ Input ou suggestions introuvables");
    alert("❌ Input ou suggestions introuvables");
    return;
  } else {
    console.log("✅ Input détecté");
  }

  input.addEventListener("input", async () => {
    const query = input.value.trim();

    if (query.length < 3) {
      suggestions.innerHTML = "";
      return;
    }

    try {
      const response = await fetch(
        `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&limit=5`
      );
      const data = await response.json();

      suggestions.innerHTML = "";

      data.features.forEach(feature => {
        const li = document.createElement("li");
        li.textContent = feature.properties.label;

        li.onclick = () => {
          input.value = feature.properties.label;
          suggestions.innerHTML = "";
        };

        suggestions.appendChild(li);
      });

    } catch (err) {
      console.error("❌ API erreur :", err);
    }
  });

});
</script>
</body>
</html>