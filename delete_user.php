<?php 
session_start();
require "fonctions.php";

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 2) {
    die('Accès refusé.');
}

$pdo = getDB();

if (!isset($_POST['user_id'])) {
    die('Requete invalide.');
}

$user_id = intval($_POST['user_id']);

if ($user_id == $_SESSION['user_id']) {
    die("Un compte administrateur ne peut pas être supprimé depuis le panneau d'administration.");
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

$pdo = getDB();
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

header("Location: admin.php");
exit;
?>