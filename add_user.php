<?php
session_start();
require "fonctions.php";

// Vérification admin
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    die("Accès refusé.");
}

$pdo = getDB();

// ---------------------------------------
// Vérification des champs
// ---------------------------------------
if (!isset($_POST['nom'], $_POST['email'], $_POST['adresse'], $_POST['password'], $_POST['role_id'])) {
    die("Requête invalide.");
}

$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$adresse = trim($_POST['adresse']);
$password = trim($_POST['password']);
$role_id = intval($_POST['role_id']);

// ---------------------------------------
// Vérification email non utilisé
// ---------------------------------------
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    die("Cet email est déjà utilisé.");
}

// ---------------------------------------
// Hash du mot de passe
// ---------------------------------------
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// ---------------------------------------
// Insertion dans la base
// ---------------------------------------
$stmt = $pdo->prepare("
    INSERT INTO users (nom, email, password, adresse, role_id) 
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([$nom, $email, $passwordHash, $adresse, $role_id]);

header("Location: admin.php");
exit;
?>
