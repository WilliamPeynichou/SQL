<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password == $confirm_password){
        // echo "Password and confirm password are the same";
    }else{
        // echo "Password and confirm password are not the same";
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