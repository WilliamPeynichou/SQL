<?php
// Importe le fichier de configuration pour la connexion à la base de données (nécessaire pour utiliser la fonction createConnection)
require_once "config/database.php";
// Démarre une session PHP pour stocker les informations de l'utilisateur connecté
session_start();
// Initialise un tableau vide pour stocker les messages d'erreur
$errors = [];
// Initialise une variable pour stocker un éventuel message de succès
$message = "";

// Vérifie si le formulaire a été soumis en méthode POST (c'est-à-dire si l'utilisateur a cliqué sur "Se connecter")
if($_SERVER["REQUEST_METHOD"] === "POST"){
    // ===== RÉCUPÉRATION ET NETTOYAGE DES DONNÉES =====
    // Récupère la valeur du champ email du formulaire, enlève les espaces inutiles (trim) et convertit les caractères spéciaux en entités HTML (htmlspecialchars) pour éviter les failles XSS
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : "";
    // Récupère la valeur du champ mot de passe du formulaire, sans nettoyage car il sera vérifié et hashé
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // ===== VALIDATION DE L'EMAIL =====
    // Vérifie si le champ email est vide
    if(empty($email)) {
        // Ajoute un message d'erreur si l'email est vide
        $errors[] = "L'email est requis.";
    // Vérifie si l'email n'a pas un format valide grâce à la fonction native filter_var avec le filtre FILTER_VALIDATE_EMAIL
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ajoute un message d'erreur si l'email n'est pas valide
        $errors[] = "Veuillez saisir une adresse email valide.";
    }

    // ===== VALIDATION DU MOT DE PASSE =====
    // Vérifie si le champ mot de passe est vide
    if(empty($password)) {
        // Ajoute un message d'erreur si le mot de passe est vide
        $errors[] = "Le mot de passe est requis.";
    // Vérifie si la longueur du mot de passe est inférieure à 8 caractères avec la fonction native strlen
    } elseif(strlen($password) < 8) {
        // Ajoute un message d'erreur si le mot de passe est trop court
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // Si le tableau $errors est vide, on continue le traitement (aucune erreur de validation)
    if (empty($errors)){
        // On utilise un bloc try/catch pour gérer les exceptions (erreurs inattendues) lors de la connexion à la base ou de l'exécution SQL
        try {
            // Connexion à la base de données
            $pdo = createConnection();
            // Recherche de l'utilisateur par email avec tous les champs nécessaires
            $userEmail = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
            // Exécute la requête préparée en liant la valeur de $email au paramètre ?
            $userEmail->execute([$email]);
            // Récupère la première ligne de résultat sous forme de tableau associatif (ou false si aucun résultat). La méthode fetch() est native à PDOStatement
            $user = $userEmail->fetch();

            if ($user) {
                // Vérifie si le mot de passe fourni correspond au hash stocké en base grâce à la fonction native password_verify
                if (password_verify($password, $user["password"])) {
                    // Stocke les informations de l'utilisateur dans la session PHP
                    $_SESSION["user_id"] = $user['id'];
                    $_SESSION["username"] = $user['name'];
                    $_SESSION["email"] = $user['email'];
                    $_SESSION['login'] = true;

                    // Prépare un message de succès avec le nom de l'utilisateur
                    $message = "Super, vous êtes connecté " . htmlspecialchars($user['name']);
                    // Redirige vers la page d'accueil après connexion réussie
                    header('Location: home.php');
                    exit();
                } else {
                    // Si le mot de passe ne correspond pas, on ajoute une erreur
                    $errors[] = "Mot de passe incorrect.";
                }     
            } else {
                // Si aucun utilisateur n'a été trouvé, on ajoute une erreur
                $errors[] = "Aucun compte associé à cet email.";
            }  
        // Si une exception de type PDOException est levée (erreur de base de données), on la capture ici
        } catch (PDOException $e) {
            // On ajoute le message d'erreur détaillé à la liste des erreurs
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
