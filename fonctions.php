<?php

// ---------------------------------------
// Connexion PDO à la base de données
// ---------------------------------------
function getDB() {
    $host = "localhost";
    $dbname = "gestion_users";
    $username = "root";
    $password = "";
    $role = "user";

    try {
        return new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        die("Erreur de connexion BDD : " . $e->getMessage());
    }
}



// ---------------------------------------
// Vérifie si un email existe déjà
// ---------------------------------------
function emailExiste($pdo, $email) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->rowCount() > 0;
}



// ---------------------------------------
// Inscrire un utilisateur
// ---------------------------------------
function creerUtilisateur($pdo, $nom, $email, $passwordHash, $adresse, $role_id = 1) {
    $sql = "INSERT INTO users (nom, email, password, adresse, role_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nom, $email, $passwordHash, $adresse, $role_id]);
}



// ---------------------------------------
// Récupérer un utilisateur par email
// ---------------------------------------
function getUserByEmail($pdo, $email) {
    $sql = "SELECT users.*, role.role_name FROM users JOIN role ON users.role_id = role.id WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO :: FETCH_ASSOC);
}

// ---------------------------------------
// Récupérer les rôles de l'utilisateur
// ---------------------------------------
function getAllUsers($pdo) {
    $sql = "SELECT users.id, users.nom, users.email, role.role_name FROM users JOIN role On users.role_id = role.id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO :: FETCH_ASSOC);
}



// ---------------------------------------
// Vérifier si un utilisateur est connecté
// ---------------------------------------
function isLogged() {
    return isset($_SESSION['user_id']);
}



// ---------------------------------------
// Bloquer une page si non connecté
// ---------------------------------------
function requireLogin() {
    if (!isLogged()) {
        header("Location: login.php");
        exit;
    }
}

// ---------------------------------------
// Supprimer un compte utilisateur
// ---------------------------------------
function deleteAccount($pdo, $id){
	$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}

// ---------------------------------------
// Récupérer un utilisateur avec un ID
// ---------------------------------------
function getUserById($pdo, $id) {
    $sql = "SELECT users.*, role.role_name FROM users JOIN role ON users.role_id = role.id WHERE users.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO :: FETCH_ASSOC);
}



?>