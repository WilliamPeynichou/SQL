<?php
// ===== DÉBUT DU TRAITEMENT PHP =====
require_once "config/database.php";

// Initialisation des variables pour l'affichage
$errors = [];
$message = "";

// On vérifie si le formulaire a été envoyé (quand l'utilisateur clique sur "Envoyé")
if($_SERVER["REQUEST_METHOD"] === "POST"){
    // ===== RÉCUPÉRATION ET NETTOYAGE DES DONNÉES =====
    $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : "";
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";

    // ===== VALIDATION DU NOM =====
    if(empty($name)) {
        $errors[] = "Le nom est requis.";
    } elseif(strlen($name) < 2) {
        $errors[] = "Le nom doit contenir au moins 2 caractères.";
    }

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
    // } elseif(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
    //     $errors[] = "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial.";
    }

    // ===== VALIDATION DE LA CONFIRMATION =====
    if(empty($confirm_password)) {
        $errors[] = "La confirmation du mot de passe est requise.";
    } elseif($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // ===== TRAITEMENT FINAL =====
    if(empty($errors)) {
        try {
            // Connexion à la base de données
            $pdo = createConnection();
            
            // Vérification de l'existence de l'email
            $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email= ?");
            $checkEmail->execute([$email]);
            
            if ($checkEmail->rowCount() > 0) {
                $errors[] = "Email déjà utilisé.";
            } else {
                // Hash du mot de passe
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                // Insertion de l'utilisateur
                $insertUser = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $insertUser->execute([$name, $email, $hashPassword]);
                $message = "$name, votre compte a été créé avec succès.";
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
    <title>Document</title>
    <link rel="stylesheet" href="asset/style/style.css">
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
        <!-- Formulaire d'inscription avec méthode POST -->
        <form action="" method="POST">
            <h1>Inscription</h1>
            <div class="nameBox">
                <label for="name">Votre nom</label>
                <input type="text" name="name" id="name" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">
            </div>
            <div class="emailBox">
                <label for="email">Votre email</label>
                <input type="email" name="email" id="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
            </div>
            <div class="passwordBox">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="confirmPasswordBox">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="buttonBox">
                <button type="submit">Envoyé</button>
            </div>
        </form>
    </section>
</body>
</html>