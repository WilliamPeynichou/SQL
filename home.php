<?php
// Démarre la session pour accéder aux infos de l'utilisateur connecté
session_start();

// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit();
}

// if (!isset($_GET['logout']) && $_GET['logout'] === '1'){
//     $_SESSION = [];
//     session_destroy();

//     header('location : login.php');

//     exit();
// }
// Récupération sécurisée des informations utilisateur depuis la session
$user_id = $_SESSION['user_id'] ??'inconnu';
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Utilisateur';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="asset/style/style.css">
</head>
<body>
    <section>
        <h1 class="welcome-title">Bienvenue sur notre site</h1>
        <p class="subtitle">Ravi de vous revoir, <?= $username; ?><?= $email ? " (".$email.")" : ""; ?></p>
        <div class="actions">
            <a class="link-btn" href="logout.php" title="Se déconnecter et revenir à la page de connexion">Se déconnecter</a>
        </div>
    </section>
</body>
</html>
