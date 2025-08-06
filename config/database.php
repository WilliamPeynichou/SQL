<?php
// Début du code PHP

// logique de connexion a la database
// Déclaration de l'adresse du serveur de base de données
$host = "localhost";

// nom de la database
// Nom de la base de données à laquelle se connecter
$db_name = "tableuser";

// nom d'utilisateur
// Nom d'utilisateur pour la connexion à la base de données
$username = "root";

// mot de passe
// Mot de passe associé à l'utilisateur pour la connexion
$password = "";

// port
// Numéro de port utilisé pour la connexion MySQL (par défaut 3306)
$port = 3306;

// charset 
// Jeu de caractères utilisé pour la connexion à la base de données
$charset = "utf8mb4";

//fonction qui creer la connexion a la database
// Déclaration d'une fonction pour créer la connexion à la base de données
function createConnection(){
    // On utilise le mot-clé global pour accéder aux variables définies en dehors de la fonction
    global $host, $username, $password, $db_name, $port, $charset;
    // Le bloc try permet de tester un code qui pourrait provoquer une erreur
    try {
        // On construit une chaîne de connexion (DSN) pour se connecter à une base de données MySQL avec PDO
        $dsn = "mysql:host=$host;dbname=$db_name;port=$port;charset=$charset;port=$port";
        // On crée un nouvel objet PDO pour établir la connexion à la base de données
        $pdo = new PDO($dsn, $username, $password);
        // On configure PDO pour lancer des exceptions en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // On configure PDO pour que les résultats soient retournés sous forme de tableaux associatifs
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // On retourne l'objet PDO pour que d'autres parties du code puissent l'utiliser
        return $pdo;
        // ... (aucune vérification supplémentaire nécessaire, PDO gère les erreurs via les exceptions)
    } catch (PDOException $e) {
        // Le bloc catch permet d'attraper et de gérer les erreurs survenues dans le try
        // $e est un objet représentant l'exception levée lors d'une erreur de connexion ou d'exécution PDO
        // $e->getMessage() retourne une description textuelle de l'erreur qui s'est produite
        // Ici, on affiche le message d'erreur et on arrête le script
        die("Erreur de connexion : " . $e->getMessage());
    }
};

// creer la connexion
$connection = createConnection();

// verifier la connexion
if($connection){
    echo "Connexion réussie";
} else {
    echo "Connexion échouée";
}


