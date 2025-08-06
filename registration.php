<?php
// Vérification si le formulaire a été soumis via la méthode POST
// $_SERVER["REQUEST_METHOD"] : Variable superglobale qui contient la méthode HTTP utilisée
if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    // NETTOYAGE ET SÉCURISATION DES DONNÉES
    // isset() : Vérifie si une variable existe et n"est pas null
    // $_POST : Variable superglobale contenant les données envoyées par POST
    // htmlspecialchars() : Convertit les caractères spéciaux en entités HTML (protection XSS)
    // trim() : Supprime les espaces au début et à la fin d"une chaîne
    $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : "";
    $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";

    // Initialisation du tableau d"erreurs
    $errors = [];
    
    // VALIDATION DU NOM
    // empty() : Vérifie si une variable est vide (null, "", 0, false, array vide)
    if(empty($name)) {
        $errors[] = "Le nom est requis.";
    } elseif(strlen($name) < 2) {
        // strlen() : Retourne la longueur d"une chaîne de caractères
        $errors[] = "Le nom doit contenir au moins 2 caractères.";
    }
    
    // VALIDATION DE L"EMAIL
    if(empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // filter_var() : Filtre une variable avec un filtre spécifique
        // FILTER_VALIDATE_EMAIL : Constante pour valider le format d"un email
        // ! : Opérateur de négation (inverse le résultat)
        $errors[] = "Veuillez saisir une adresse email valide.";
    }
    
    // VALIDATION DU MOT DE PASSE
    // Première vérification : le mot de passe est-il vide ?
    if(empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif(strlen($password) < 6) {
        // strlen() : Fonction native PHP qui compte le nombre de caractères dans une chaîne
        // Exemple : strlen("abc123") = 6, strlen("test") = 4
        // Cette condition vérifie si le mot de passe fait moins de 6 caractères
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif(strlen($password) < 8) {
        // Cette condition ne s'exécute que si le mot de passe fait 6 ou 7 caractères
        // (car la condition précédente a déjà vérifié qu'il fait au moins 6 caractères)
        // C'est un avertissement pour encourager l'utilisateur à utiliser un mot de passe plus fort
        $errors[] = "Pour plus de sécurité, utilisez au moins 8 caractères.";
    } elseif(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        // preg_match() : Fonction PHP qui teste si une chaîne correspond à un pattern regex
        // Premier paramètre : le pattern regex entre délimiteurs "/"
        // Deuxième paramètre : la chaîne à tester ($password)
        // Retourne true si la chaîne correspond au pattern, false sinon
        // Regex pour valider la complexité du mot de passe :
        // ^ : début de la chaîne
        // (?=.*[a-z]) : au moins une lettre minuscule
        // (?=.*[A-Z]) : au moins une lettre majuscule  
        // (?=.*\d) : au moins un chiffre
        // (?=.*[@$!%*?&]) : au moins un caractère spécial
        // [A-Za-z\d@$!%*?&]{8,} : 8 caractères minimum, uniquement les caractères autorisés
        // $ : fin de la chaîne
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères avec une minuscule, une majuscule, un chiffre et un caractère spécial.";
    }
    
    // VALIDATION DE LA CONFIRMATION DU MOT DE PASSE
    // Vérification : la confirmation du mot de passe est-elle vide ?
    if(empty($confirm_password)) {
        $errors[] = "La confirmation du mot de passe est requise.";
    } elseif($password !== $confirm_password) {
        // !== : Opérateur de comparaison stricte (valeur ET type)
        // Vérifie si les deux mots de passe sont identiques
        // Exemple : "password123" !== "password123" = false (même valeur)
        // Exemple : "password123" !== "Password123" = true (différent)
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    
    // TRAITEMENT EN CAS DE SUCCÈS
    // Si aucune erreur n"a été ajoutée au tableau
    if(empty($errors)) {
        // Ici tu peux ajouter le code pour sauvegarder en base de données
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