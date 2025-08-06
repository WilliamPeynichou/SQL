<?php
// ===== DÉBUT DU TRAITEMENT PHP =====
require_once "config/database.php";

// On vérifie si le formulaire a été envoyé (quand l'utilisateur clique sur "Envoyé")
// $_SERVER["REQUEST_METHOD"] contient la méthode utilisée (GET ou POST)
if($_SERVER["REQUEST_METHOD"] === "POST"){

    // ===== RÉCUPÉRATION ET NETTOYAGE DES DONNÉES =====
    // On récupère les données du formulaire et on les nettoie
    
    // isset() vérifie si le champ existe dans le formulaire
    // htmlspecialchars() protège contre les attaques en convertissant les caractères spéciaux
    // trim() enlève les espaces au début et à la fin
    $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : "";
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";

    // On crée un tableau vide pour stocker les erreurs
    $errors = [];
    
    // ===== VALIDATION DU NOM =====
    // empty() vérifie si la variable est vide
    if(empty($name)) {
        $errors[] = "Le nom est requis.";
    } elseif(strlen($name) < 2) {
        // strlen() compte le nombre de caractères
        $errors[] = "Le nom doit contenir au moins 2 caractères.";
    }
    
    // ===== VALIDATION DE L'EMAIL =====
    if(empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // filter_var() avec FILTER_VALIDATE_EMAIL vérifie si c'est un email valide
        // Le ! inverse le résultat (si l'email est invalide, on ajoute une erreur)
        $errors[] = "Veuillez saisir une adresse email valide.";
    }
    
    // ===== VALIDATION DU MOT DE PASSE =====
    if(empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif(strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif(strlen($password) < 8) {
        // Cette condition ne s'exécute que si le mot de passe fait 6 ou 7 caractères
        $errors[] = "Pour plus de sécurité, utilisez au moins 8 caractères.";
    } elseif(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        // preg_match() teste si le mot de passe respecte le pattern regex
        // Le regex vérifie qu'il y a au moins :
        // - une minuscule (?=.*[a-z])
        // - une majuscule (?=.*[A-Z])  
        // - un chiffre (?=.*\d)
        // - un caractère spécial (?=.*[@$!%*?&])
        // - 8 caractères minimum {8,}
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères avec une minuscule, une majuscule, un chiffre et un caractère spécial.";
    }
    
    // ===== VALIDATION DE LA CONFIRMATION =====
    if(empty($confirm_password)) {
        $errors[] = "La confirmation du mot de passe est requise.";
    } elseif($password !== $confirm_password) {
        // !== compare si les deux mots de passe sont différents
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    
    // ===== TRAITEMENT FINAL =====
    // Si aucune erreur n'a été trouvée
    if(empty($errors)) {
        // Ici on pourrait sauvegarder en base de données
        $success_message = "Inscription réussie !";
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
        <!-- Formulaire d'inscription avec méthode POST -->
        <form action="" method="POST">
            <!-- Titre principal du formulaire -->
            <h1>Inscription</h1>
            
            <!-- Champ pour le nom -->
            <div class="nameBox">
                <!-- Label associé au champ name via l'attribut "for" -->
                <label for="name">Votre nom</label>
                <!-- Input de type texte pour le nom
                     name="name" : nom du champ envoyé au serveur
                     id="name" : identifiant unique pour l'association avec le label
                     required : attribut HTML5 qui rend le champ obligatoire -->
                <input type="text" name="name" id="name" required>
            </div>
            
            <!-- Champ pour l'email -->
            <div class="emailBox">
                <!-- Label associé au champ email -->
                <label for="email">Votre email</label>
                <!-- Input de type email avec validation HTML5 automatique
                     type="email" : valide automatiquement le format email -->
                <input type="email" name="email" id="email" required>
            </div>
            
            <!-- Champ pour le mot de passe -->
            <div class="passwordBox">
                <!-- Label associé au champ password -->
                <label for="password">Mot de passe</label>
                <!-- Input de type password qui masque les caractères saisis -->
                <input type="password" name="password" id="password" required>
            </div>
            
            <!-- Champ pour la confirmation du mot de passe -->
            <div class="confirmPasswordBox">
                <!-- Label associé au champ confirm_password -->
                <label for="confirm_password">Confirmer le mot de passe</label>
                <!-- Input de type password pour la confirmation -->
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            
            <!-- Bouton de soumission du formulaire -->
            <div class="buttonBox">
                <!-- Bouton de type submit qui déclenche l'envoi du formulaire -->
                <button type="submit">Envoyé</button>
            </div>
        </form>
    </section>
</body>
</html>