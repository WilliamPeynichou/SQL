<?php
// Démarrer ou reprendre la session afin d'accéder aux variables stockées dans $_SESSION
session_start();

// Réinitialise le tableau $_SESSION pour supprimer toutes les données de session en mémoire
$_SESSION = [];

// Si PHP utilise des cookies pour gérer la session, on invalide également le cookie côté navigateur
// ini_get('session.use_cookies') est une fonction native PHP qui lit la configuration du serveur
// Elle retourne true si les cookies de session sont activés, false sinon
if (ini_get('session.use_cookies')) {
    // session_get_cookie_params() est une fonction native PHP qui récupère les paramètres du cookie de session
    // Elle retourne un tableau associatif avec les clés : lifetime, path, domain, secure, httponly, samesite
    // Exemple de retour : ['lifetime' => 0, 'path' => '/', 'domain' => '', 'secure' => false, 'httponly' => true]
    $params = session_get_cookie_params();
    // setcookie() est une fonction native PHP qui définit un cookie HTTP
    // Syntaxe : setcookie(nom, valeur, expiration, chemin, domaine, sécurisé, httponly)
    // - session_name() : fonction qui retourne le nom du cookie de session (ex: "PHPSESSID")
    // - '' : valeur vide pour effacer le contenu du cookie
    // - time() - 42000 : time() retourne le timestamp actuel, on soustrait 42000 secondes (environ 11h) pour mettre la date dans le passé
    // - $params['path'] : chemin où le cookie est valide (ex: "/" pour tout le site)
    // - $params['domain'] : domaine où le cookie est valide (ex: "localhost" ou ".monsite.com")
    // - $params['secure'] : si true, le cookie n'est envoyé qu'en HTTPS
    // - $params['httponly'] : si true, le cookie n'est pas accessible via JavaScript (sécurité)
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

// session_destroy() est une fonction native PHP qui détruit complètement la session
// Elle supprime le fichier de session côté serveur et invalide l'identifiant de session
session_destroy();

// header() est une fonction native PHP qui envoie un en-tête HTTP au navigateur
// 'Location: login.php' est un en-tête de redirection HTTP 302
// Le navigateur recevra cette instruction et naviguera automatiquement vers login.php
header('Location: login.php');
// exit() est une fonction native PHP qui arrête immédiatement l'exécution du script
// Elle empêche que du code HTML soit envoyé après la redirection (ce qui causerait une erreur)
exit();
