<?php
require_once "config/database.php";

$errors = [];
$message = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // ===== RÉCUPÉRATION ET NETTOYAGE DES DONNÉES =====
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // ===== VALIDATION DE L'EMAIL =====
    if(empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Veuillez saisir une adresse email valide.";
    }

    // ===== VALIDATION DU MOT DE PASSE =====
    if(empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif(strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if (empty($errors)){
        try {
            // Connexion à la base de données
            $pdo = createConnection();

            // Recherche de l'utilisateur par email
            $userEmail = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $userEmail->execute([$email]);
            $user = $userEmail->fetch();
            if ($user) {
                if(password_verify($password, $user["password"])){
                    $message = "Connexion réussie !";
                } else {
                    $errors[] = "Mot de passe incorrect.";
                }
            } else {
                $errors[] = "Aucun compte associé à cet email.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur base de données : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="asset/style/stylelogin.css">
</head>
<body>
    <section>
        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)): ?>
            <div class="errorBox">
                <?php foreach ($errors as $err): ?>
                    <p style="color:red;"> <?= $err ?> </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- Affichage du message de succès -->
        <?php if (!empty($message)): ?>
            <div class="successBox">
                <p style="color:green;"> <?= $message ?> </p>
            </div>
        <?php endif; ?>
        <!-- Formulaire de connexion avec méthode POST -->
        <form action="" method="POST">
            <h1>Connexion</h1>
            <div class="emailBox">
                <label for="email">Votre email</label>
                <input type="email" name="email" id="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
            </div>
            <div class="passwordBox">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="buttonBox">
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </section>
</body>
</html>
