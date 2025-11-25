<?php
session_start();
require "fonctions.php";
requireLogin();
$pdo = getBD();
$user = getUserById($pdo,$_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nebula-dot" style="left: 12%; top: 18%;"></div>
    <div class="nebula-dot secondary" style="right: 12%; bottom: 18%;"></div>

    <header class="topbar">
        <nav class="nav-links">
            <a href="index.html">Accueil</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <main class="page">
        <div class="grid-two">
            <section class="hero">
                <div class="eyebrow">Bienvenue</div>
                <p>Statut de compte : <?php echo htmlspecialchars($user['role']); ?> </p>
            </section>

            <section class="card">
                <h3>Informations du compte :</h3>
                <div class="table">
                    <table>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <td><?php echo htmlspecialchars($user['nom']); ?></td>
                            <th>Email utilisé</th>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <th>Adresse postale</th>
                            <td><?php echo htmlspecialchars($user['adresse']); ?></td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>