<?php

// FORMULAIRE CONNEXION
function form_connexion($post, $idcom) {
	if(!empty($post['identifiant']) && !empty($post['password'])) {
		$req = $idcom->prepare('SELECT id, username, password, token FROM user WHERE username = :username OR mail = :username');
        $req->bindValue(':username', $post['identifiant'], PDO::PARAM_STR);
        $req->execute();
        $membre = $req->fetch();
        $req->closeCursor();
        if($membre) 
        {
        	if(password_verify($post['password'], $membre['password'])) 
            {
            	if($membre['token'] != NULL) 
                {
                    $req = $idcom->prepare('UPDATE user SET token = NULL WHERE id = :id');
                    $req->bindValue(':id', $membre['id'], PDO::PARAM_INT);
                    $req->execute();
                }
                $_SESSION['id'] = $membre['id'];
                $_SESSION['username'] = $membre['username'];
                setCookie('username', $membre['username'], (time()+60*60*24*60));
                setCookie('password', $membre['password'], (time()+60*60*24*60));
                echo '<script>setTimeout(function () { window.location.href = "index.php"; }, 2000);</script>';
				
				return array(true, '<div class="notification is-success"><button class="delete"></button>Connexion réussie ! Vous allez être redirigés.</div>');
            }
            else
                return array(false, '<div class="notification is-danger"><button class="delete"></button>Impossible de se connecter. Vérifiez vos identifiants.</div>');
        }
        else
        	return array(false, '<div class="notification is-danger"><button class="delete"></button>Impossible de se connecter. Vérifiez vos identifiants.</div>');
	}
	else
        return array(false, '<div class="notification is-danger"><button class="delete"></button>Impossible de se connecter. Vérifiez vos identifiants.</div>');
}

// FORMULAIRE INSCRIPTION
function form_inscription($post, $idcom) {

	// Vérification de l'email
    if (!empty($post['email'])) 
    {
    	if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
        	$erreur[] = 'L\'adresse mail doit avoir la forme exemple@bubbleboost.com';
	    $req = $idcom->prepare('SELECT id FROM user WHERE LOWER(mail) = LOWER(:email)');
	    $req->bindValue(':email', $post['email'], PDO::PARAM_STR);
	    $req->execute();
	    $emailBdd = $req->fetch();
    	if ($emailBdd)
        	$erreur[] = 'L\'adresse mail est déjà utilisée, vous ne pouvez pas la choisir.';
	}
    else
        $erreur[] = "Veuillez remplir le champ Adresse mail.";

    // Vérification du pseudo
    if (!empty($post['username'])) 
    {
    	if (strlen($post['username']) < 3 || strlen($post['username']) > 25) 
        	$erreur[] = 'Votre identifiant doit être compris entre 3 et 25 caractères';
		if (!preg_match('#^[a-zA-Z0-9_]{3,16}$#', $post['username']))
    	    $erreur[] = 'La syntaxe du champ Pseudo est incorrecte. Lettres, chiffres et _ autorisés.';
		$req = $idcom->prepare('SELECT LOWER(username) FROM user WHERE LOWER(username)=LOWER(:username)');
        $req->bindValue(':username', $post['username'], PDO::PARAM_STR);
        $req->execute();
        $loginBdd = $req->fetch();
        $req->closeCursor();
        if ($loginBdd)
            $erreur[] = "Ce pseudo est déjà utilisé, veuillez en choisir un autre.";
    }
    else
    	$erreur[] = "Veuillez remplir le champ Pseudo.";

    // Vérification du nom
    if (!empty($post['lastname'])) 
    {
    	if (!preg_match('#^([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |\')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+([-]([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |\')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+)*$#iu', $post['lastname']))
   			$erreur [] = "Syntaxe du nom incorrecte";
    }
    else
    	$erreur[] = "Veuillez remplir le champ Nom.";

    // Vérification du prénom
    if (!empty($post['firstname'])) 
    {
    	if (!preg_match('#^([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |\')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+([-]([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |\')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+)*$#iu', $post['firstname']))
   			$erreur[] = "Syntaxe du prénom incorrecte";
    }
    else
    	$erreur[] = "Veuillez remplir le champ Prénom.";

    // Vérification de la date de naissance
    if (!empty($post['birthday'])) 
    {
    	if(!preg_match('#[0-9]{2}/[0-9]{2}/[0-9]{4}#', $post['birthday']))
    		$erreur[] = 'Syntaxe de la date de naissance incorrecte : JJ/MM/YYYY';
    	else {
    		$birthday = explode('/', $post['birthday']);
    		$post['birthday_correct'] = $birthday[2].'-'.$birthday[1].'-'.$birthday[0];
	    	$date_now = new datetime();
		    $date_birthday = new datetime($post['birthday_correct']);
		    if ($date_now <= $date_birthday)
		        $erreur[] = 'Vous ne pouvez pas naître dans le futur ;)';
		    if (!(($date_birthday->diff($date_now))->y >= 13))
		        $erreur[] = 'Vous devez avoir au moins 13 ans';
    	}
    }
    else
    	$erreur[] = "Veuillez remplir le champ Date de Naissance.";

    // Vérification du numéro de téléphone
    if (!empty($post['phone'])) 
    {
    	if(!preg_match('#[0-9]*#', $post['phone']))
    		$erreur[] = 'Syntaxe du numéro de téléphone incorrecte.';
    }

    // Vérification du mot de passe
    if (!empty($post['password']) && !empty($post['password2'])) 
    {
    	$post['password_hash'] = password_hash($post['password'], PASSWORD_DEFAULT);
        if (strlen($post['password']) < 6) 
        	return "Votre mot de passe doit faire au moins 6 caractères";
    	if($post['password'] != $post['password2'])
        	$erreur[] = "Les mots de passe ne sont pas identiques";
    }
    else 
        $erreur[] = "Veuillez remplir les deux champs Mot de passe.";

    // On réalise, ou non, l'inscription
    if(!empty($erreur)) 
    {
        $erreurInscription = '<article class="message is-danger"><div class="message-body"></div>';
        foreach($erreur as $err)
            $erreurInscription .= $err.'<br />';
        unset($erreur);
        $erreurInscription .= '</article>';
        return array(false, $erreurInscription);
    }
    else {
    	$req = $idcom->prepare('INSERT INTO user (id, firstname, lastname, username, role, country, phone, birthday_date, tipeee, mail, password, avatar, registration_date, token) VALUES (NULL, :firstname, :lastname, :username, "member", :country, :phone, :birthday, NULL, :email, :password, "default.jpg", CURRENT_TIMESTAMP, NULL)');
        $req->bindValue(':firstname', $post['firstname'], PDO::PARAM_STR);
        $req->bindValue(':lastname', $post['lastname'], PDO::PARAM_STR);
        $req->bindValue(':username', $post['username'], PDO::PARAM_STR);
        $req->bindValue(':country', $post['country']?$post['country']:NULL);
        $req->bindValue(':phone', $post['phone']?$post['phone']:NULL);
        $req->bindValue(':birthday', $post['birthday_correct']);
        $req->bindValue(':email', $post['email'], PDO::PARAM_STR);
        $req->bindValue(':password', $post['password_hash'], PDO::PARAM_STR);
        if($req->execute()) {
        	include('assets/vendor/phpmailer/sendemail.php');
        	$subject = "Bienvenue sur BubbleBoost !";
	        $body = '<p>Bienvenue sur BubbleBoost, '.$post['username'].' !</p><p>Grâce à votre compte, vous allez enfin pouvoir accéder à toutes les fonctionnalités du site !</p><p>Vous ne savez pas par où commencer ? Dans votre profil, ajoutez par exemple une photo de profil ! Pourquoi ne pas remplir quelques informations supplémentaires en plus ? Ensuite, regardez le catalogue de mangas et BDs que vous allez pouvoir suivre ou commenter ! Bref, il y a tant de chose à faire et à découvrir sur BubbleBoost.</p><p>Merci de vous être enregistré, et à bientôt.</p>';
	        sendemail($post['email'], $subject, $body);
	        return array(true, '<article class="message is-success"><div class="message-header"><p>Bravo</p><button class="delete" arial-label="delete"></button></div><div class="message-body">Inscription réussie ! Vous pouvez désormais vous connecter.</div></article>');
        }
    }
}

// FORMULAIRE MOT DE PASSE OUBLIÉ 1
function form_oubliemdp1($post, $idcom) {
	if(isset($post['email'])) {
		// On regarde si l'email est bien dans la BDD avant d'envoyer un lien de réinitialisation du password
		$req = $idcom->prepare('SELECT mail, username FROM user WHERE mail=:email');
		$req->bindValue(':email', $post['email'], PDO::PARAM_STR);
        $req->execute();
        if($membre = $req->fetch()) {
			// Si oui, on créé une clé unique, qu'on enregistre dans la BDD, qui va servir à réinitialiser le mot de passe
			$unique = false;
			while(!$unique) {
				$keyuniq = uniqid();
				echo $keyuniq;
				$req_unique = $idcom->prepare('SELECT 1 FROM user WHERE token=:keyuniq');
				$req_unique->bindValue(':keyuniq', $keyuniq, PDO::PARAM_STR);
        		$req_unique->execute();
        		if(!$req_unique->fetch())
        			$unique = true;
			}
			$req = $idcom->prepare('UPDATE user SET token=:keyuniq WHERE mail=:email');
			$req->bindValue(':keyuniq', $keyuniq, PDO::PARAM_STR);
        	$req->bindValue(':email', $post['email'], PDO::PARAM_STR);
        	$req->execute();
        
			// Et on envoi un mail
			include('assets/vendor/phpmailer/sendemail.php');
        	$subject = "Mot de passe oublié";
			$body = '<p>Bonjour '.$membre['username'].',</p><p>Nous avons reçu une demande de réinitialisation de votre mot de passe BubbleBoost.</p><p><a href="'.$_SERVER['HTTP_REFERER'].'?keyuniq='.$keyuniq.'" target="_blank" rel="noopener noreferrer" style="color:#3b5998; text-decoration:none">Cliquez ici pour changer votre mot de passe</a>.</p><p><b>Vous n\'avez pas demandé ce changement ?</b><br>Si vous n\'avez pas demandé de nouveau mot de passe, ignorez simplement ce message.</p>';
			if(sendemail($membre['mail'], $subject, $body))
				return array(true, '<aritcle class="message is-success"><div class="message-body">Si l\'adresse e-mail correspond à un compte de BubbleBoost, un e-mail vient d\'être envoyé.</div></article>');
			else
				return array(true, '<aritcle class="message is-success"><div class="message-body">Si l\'adresse e-mail correspond à un compte de BubbleBoost, un e-mail vient d\'être envoyé.</div></article>');
		}
		else
			return array(true, '<aritcle class="message is-success"><div class="message-body">Si l\'adresse e-mail correspond à un compte de BubbleBoost, un e-mail vient d\'être envoyé.</div></article>');
	}
	else
		return array(false, '<article class="message is-danger"><div class="message-header"><p>Erreur</p><button class="delete" aria-label="delete"></button></div><div class="message-body">Veuillez remplir le champ Adresse e-mail</div></article>');
}

// FORMULAIRE MOT DE PASSE OUBLIÉ 2
function form_oubliemdp2($post, $idcom) {
	// Vérification pour les mots de passe
	if (!empty($post['password']) && !empty($post['password2'])) {
		if (strlen($post['password']) < 6) $erreur[] = "Votre mot de passe doit faire au moins 6 caractères";
		else {
			if ($post['password'] != $post['password2']) $erreur[] = "Les mots de passe ne sont pas identiques";
			else $password = password_hash($post['password'], PASSWORD_DEFAULT);
		}
	}
	else $erreur[] = "Veuillez remplir les deux champs Mot de passe.";
	if (!isset($erreur)) {
		$req = $idcom->prepare('UPDATE user SET password=:password, token=NULL WHERE token=:token');
		$req->bindValue(':password', $password, PDO::PARAM_STR);
        $req->bindValue(':token', $_GET['keyuniq'], PDO::PARAM_STR);
        $req->execute();
		echo '<script>setTimeout(function () { window.location.href = "connexion.php"; }, 2000);</script>';
		return array(true, '<aritcle class="message is-success"><div class="message-body">Mot de passe changé avec succès ! Vous pouvez désormais vous connecter.</div></article>');
	}
	else {
		$result = '<article class="message is-danger"><div class="message-body"></div>';
		for($i=0; $i<sizeof($erreur); $i++) $result .= $erreur[$i].'<br />';
		$result .= '</article>';
		return array(false, $result);
		unset($erreur);
	}
}
?>