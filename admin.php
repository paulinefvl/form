<?php
session_start();

if (isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Accès refusé.');
}

$pdo = getDB();
require "fonctions.php";
$users = getAllUsers($pdo);
?>

<!DOCTYPE html>
<html>
<body>
    <h1> — Accès ADMINISTRATEUR </h1>

    <table border="1">
        <tr>
            <th> ID </th>
            <th> NOM </th>
            <th> EMAIL </th>
            <th> ROLE </th>
            <th> CHANGER DE ROLE </th>
        </tr>

        <?php foreach ($users as $u): ?>
        <tr>
            <td> <?= $u['id'] ?></td>
            <td> <?= $u['nom'] ?></td>
            <td> <?= $u['email'] ?></td>
            <td> <?= $u['role_name'] ?></td>
            <td>
                <form method="POST" action="opdate_role.php">
                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                    <select name="role_id">
                        <option value="1"> USER </option>
                        <option value="2"> ADMINISTRATEUR </option>
                    </select>
                    <button type="submit"> Modifier </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>