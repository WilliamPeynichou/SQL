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
        <!-- Formulaire de connexion avec méthode POST -->
        <form action="" method="POST">
            <h1>Connexion</h1>
            <div class="emailBox">
                <label for="email">Votre email</label>
                <input type="email" name="email" id="email" required>
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
