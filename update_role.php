<?php 
session_start();
require "fonctions.php";

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 2) {
    die('Accès refusé.');
}

$pdo = getDB();

if (!isset($_POST['user_id'], $_POST['role_id'])) {
    die('Requete invalide.');
}

$user_id = intval($_POST['user_id']);
$role_id = intval($_POST['role_id']);

$stmt = $pdo->prepare("UPDATE users SET role_id = ? WHERE id = ?");
$stmt->execute([$role_id, $user_id]);

header("Location: admin.php");
exit;
?>
