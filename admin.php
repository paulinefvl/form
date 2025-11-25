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
<html>
<body>
    <p><a href="tableau.php">Retour à mon compte</a></p>
    <h1> — Accès ADMINISTRATEUR </h1>

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
                    <button type="submit"> Modifier </button>
                </form>
            </td>
            <td> 
                <form method="POST" action="delete_user.php" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce compte ? Les données seront perdues.');">
                    <input type="hidden" name="user_id" value="<?=$u['id'] ?>">
                    <button type="submit" class="btn btn-danger">Supprimer le compte</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<h2>Ajouter un utilisateur</h2>

<form method="POST" action="add_user.php">
    <label>Nom :</label>
    <input type="text" name="nom" required>
<br>
    <label>Email :</label>
    <input type="email" name="email" required>
<br>
    <label>Adresse :</label>
    <input type="text" name="adresse" required>
<br>
    <label>Mot de passe :</label>
    <input type="password" name="password" required>
<br>
    <label>Rôle :</label>
    <select name="role_id">
        <option value="1">Utilisateur</option>
        <option value="2">Administrateur</option>
    </select>
<br>
    <button type="submit">Créer l'utilisateur</button>
</form>

</body>
</html>