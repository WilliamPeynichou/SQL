<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Nettoyage et sécurisation des entrées
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    $errors = [];
    
    if(empty($name)) {
        $errors[] = 'Le nom est requis.';
    } elseif(strlen($name) < 2) {
        $errors[] = 'Le nom doit contenir au moins 2 caractères.';
    }
    
    if(empty($email)) {
        $errors[] = 'L\'email est requis.';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Veuillez saisir une adresse email valide.';
    }
    
    if(empty($password)) {
        $errors[] = 'Le mot de passe est requis.';
    } elseif(strlen($password) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    } elseif(strlen($password) < 8) {
        $errors[] = 'Pour plus de sécurité, utilisez au moins 8 caractères.';
    }
    
    if(empty($confirm_password)) {
        $errors[] = 'La confirmation du mot de passe est requise.';
    } elseif($password !== $confirm_password) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }
    
    // Si aucune erreur, traitement réussi
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section>
        <form action="" method="POST">
            <h1>Inscription</h1>
            <div class="nameBox">
                <label for="name">Votre nom</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="emailBox">
                <label for="email">Votre email</label>
                <input type="email" name="email" id="email" required>
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