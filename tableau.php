<?php
session_start();
require "fonctions.php";
requireLogin();
$pdo = getDB();
$user = getUserById($pdo,$_SESSION['user_id']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    deleteAccount($pdo, $_SESSION['user_id']);
    session_destroy();
    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="assets/css/style_tableau.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="nebula-dot" style="left: 12%; top: 18%;"></div>
    <div class="nebula-dot secondary" style="right: 12%; bottom: 18%;"></div>

    <header class="topbar">
        <nav class="nav-links">
            <a href="index.html">Accueil</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
        <form method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer votre compte ? Vous ne pourrez pas retrouver vos données.');">
                <input type="hidden" name="delete_account" value="1">
                <button type="submit" class="suppr">Supprimer mon compte</button>
           </form>
    </header>

    <main class="page">
<?php if ($_SESSION['role_name'] === 'admin'): ?>
    <a href="admin.php" class="btn-admin"> Accès Administrateur </a>
<?php endif; ?>
        <div class="grid-two">
            <section class="hero">
                <div class=welcome>Bienvenue</div>
                <p>Statut de compte : <?php echo htmlspecialchars($user['role_name']); ?> </p>
            </section>

            <section class="card">
                <h3>Informations du compte :</h3>
                <div class="table">
                    <table>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <td><?php echo htmlspecialchars($user['nom']); ?></td>
                        </tr>
                        <tr>
                            <th>Email utilisé</th>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                        <tr>
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