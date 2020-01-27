<?php
session_start();

// Méthode PDO
function connexpdo($base, $param) 
{
    include_once($param.'.php');
    $connexion = false;
    
    for($i=0; $i<count(PARAMETRES) && $connexion==false; $i++) {
        $host = PARAMETRES[$i]["MYHOST"];
        $user = PARAMETRES[$i]["MYUSER"];
        $pass = PARAMETRES[$i]["MYPASS"];
        $dsn = "mysql:host=".$host.";dbname=".$base.";charset=UTF8";
        try 
        {
            $idcom = new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            return $idcom;
        } 
        catch(PDOException $e) {
            //
        }
    }
}

// On se connecte à la base BubbleBoost
$idcom = connexpdo("BubbleBoost", "bdd-param");

// Si le membre n'est pas connecté
if (!isset($_SESSION['id']))
{
    // Si le membre n'a pas les cookies
    if (!isset($_COOKIE['username']) && !isset($_COOKIE['password'])) 
    {
        // S'il tente d'accéder à une page où l'authentification est obligatoire
        if (!in_array($page, array('Accueil', 'Connexion', 'Inscription', 'Mot de passe oublié'))) {
            header('location: index.php');
        }
    }
    else 
    {
        // S'il a les cookies
        $req = $idcom->prepare('SELECT id, username, avatar, token FROM user WHERE username = :username AND password = :password');
        $req->bindValue(':username', $_COOKIE['username'], PDO::PARAM_STR);
        $req->bindValue(':password', $_COOKIE['password'], PDO::PARAM_STR);
        $req->execute();
        $membre = $req->fetch();
        $req->closeCursor();
        if ($membre) 
        {
            // Si on trouve le membre
            if ($membre['token'] != null)
            {
                $req = $idcom->prepare('UPDATE user SET token = NULL WHERE id = :id');
                $req->bindValue(':id', $membre['id'], PDO::PARAM_INT);
                $req->execute();
                $req->closeCursor();
            }
            // Ouverture de session
            $_SESSION['id'] = $membre['id'];
            $_SESSION['username'] = $membre['username'];
            $_SESSION['avatar'] = $membre['avatar'];
        }
        else 
        {
            // Il y a une erreur dans les cookies ou mauvais login ou password
            setcookie('username', '', time() - 3600);
            setcookie('password', '', time() - 3600);
            header('location: index.php');
        }
    }
}
else {
    // S'il tente d'accéder à une page où l'authentification ne doit pas encore être faite
    if (isset($page) AND in_array($page, array('Connexion', 'Inscription', 'Mot de passe oublié'))) {
        // Fermeture de session
        session_unset();
        session_destroy();
        // On supprime les cookie s'il en a
        if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            setCookie('username', '', 1);
            setCookie('password', '', 1);
        }
    }
}            

?>
