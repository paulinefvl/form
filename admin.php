<?php
session_start();
require "fonctions.php";

if (!isset($_SESSION['role_name']) || $_SESSION['role_name'] !== 'admin') {
    die('Accès refusé.');
}

$pdo = getDB();
$users = getAllUsers($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin page </title>
    <link rel="stylesheet" href="assets/css/style_admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <p class="titre1"><a href="tableau.php">Retour à mon compte</a></p>
    <h1 class="titre"> — Accès ADMINISTRATEUR </h1>

    <table border="1">
        <tr>
            <th> ID </th>
            <th> NOM </th>
            <th> EMAIL </th>
            <th> ROLE </th>
            <th> CHANGER DE ROLE </th>
            <th> SUPPRIMER </th>
        </tr>

        <?php foreach ($users as $u): ?>
        <tr>
            <td> <?= $u['id'] ?></td>
            <td> <?= $u['nom'] ?></td>
            <td> <?= $u['email'] ?></td>
            <td> <?= $u['role_name'] ?></td>
            <td>
                <form method="POST" action="update_role.php">
                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                    <select name="role_id">
                        <option value="1"> USER </option>
                        <option value="2"> ADMINISTRATEUR </option>
                    </select>
                    <button type="submit" class="btn"> Modifier </button>
                </form>
            </td>
            <td> 
                <form method="POST" action="delete_user.php" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce compte ? Les données seront perdues.');">
                    <input type="hidden" name="user_id" value="<?=$u['id'] ?>">
                    <button type="submit" class="suppr">Supprimer le compte</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<h2 class="titre1">Ajouter un utilisateur</h2>

<form method="POST" action="add_user.php">
    <div class=field>
        <label>Nom :</label>
        <input type="text" name="nom" required>
    </div>
    <div class=field>
        <label>Email :</label>
        <input type="email" name="email" required>
    </div>
    <div class=field>
        <label>Adresse :</label>
        <input type="text" name="adresse" required>
    </div>
    <div class=field>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
    </div>
    <div class=field>
        <label>Rôle :</label>
        <select name="role_id">
            <option value="1">Utilisateur</option>
            <option value="2">Administrateur</option>
        </select>
    </div>
    <button type="submit" class="btn">Créer l'utilisateur</button>
</form>

</body>
</html>