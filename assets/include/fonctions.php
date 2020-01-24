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

				return array(true, '<article class="message is-success">
					<div class="message-body">
					Connexion réussie ! Vous allez être redirigés.
					</div>
					</article>');
			}
			else
				return array(false, '<article class="message is-danger">
					<div class="notification is-danger">
					Impossible de se connecter. Vérifiez vos identifiants.
					</div>
					</article>');
		}
		else
			return array(false, '<article class="message is-danger">
				<div class="message-body">
				Impossible de se connecter. Vérifiez vos identifiants.
				</div>
				</article>');
	}
	else
		return array(false, '<article class="message is-danger">
			<div class="message-body">
			Impossible de se connecter. Vérifiez vos identifiants.
			</div>
			</article>');
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
			$erreur[] = "Votre mot de passe doit faire au moins 6 caractères";
		if($post['password'] != $post['password2'])
			$erreur[] = "Les mots de passe ne sont pas identiques";
	}
	else 
		$erreur[] = "Veuillez remplir les deux champs Mot de passe.";

		// On réalise, ou non, l'inscription
	if(!empty($erreur)) 
	{
		$erreurInscription = '<article class="message is-danger"><div class="message-body">';
		foreach($erreur as $err)
			$erreurInscription .= $err.'<br />';
		unset($erreur);
		$erreurInscription .= '</div></article>';
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
			return array(true, '<article class="message is-success">
				<div class="message-header">
				<p>Bravo</p>
				</div>
				<div class="message-body">
				Inscription réussie ! Vous pouvez désormais vous connecter.
				</div>
				</article>');
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
				return array(true, '<aritcle class="message is-success">
					<div class="message-body">
					Un e-mail de réinitialisation vient d\'être envoyé.
					</div>
					</article>');
			else
				return array(true, '<aritcle class="message is-success">
					<div class="message-body">
					Un e-mail de réinitialisation vient d\'être envoyé.
					</div>
					</article>');
		}
		else
			return array(true, '<aritcle class="message is-success">
				<div class="message-body">
				Un e-mail de réinitialisation vient d\'être envoyé.
				</div>
				</article>');
	}
	else
		return array(false, '<article class="message is-danger">
			<div class="message-header">
			<p>Erreur</p>
			</div>
			<div class="message-body">
			Veuillez remplir le champ Adresse e-mail
			</div>
			</article>');
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
		return array(true, '<aritcle class="message is-success">
			<div class="message-body">
			Mot de passe changé avec succès ! Vous pouvez désormais vous connecter.
			</div>
			</article>');
	}
	else {
		$result = '<article class="message is-danger"><div class="message-body">';
		for($i=0; $i<sizeof($erreur); $i++) $result .= $erreur[$i].'<br />';
			$result .= '</div></article>';
		return array(false, $result);
		unset($erreur);
	}
}

// COMMENTER UN CHAPITRE
function add_commentaire($post, $idcom) {
	if (!empty($post['commentaire'])) {
		$req = $idcom->prepare('INSERT INTO `comment` (`id`, `id_user`, `id_chapter`, `comment_date`, `comment`) VALUES (NULL, :id_user, :id_chapitre, CURRENT_TIMESTAMP, :commentaire)');
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->bindValue(':id_chapitre', $_GET['id'], PDO::PARAM_INT);
		$req->bindValue(':commentaire', $post['commentaire'], PDO::PARAM_STR);
		$req->execute();
	}
}

// SUPPRIMER UN COMMENTAIRE D'UN CHAPITRE
function del_commentaire($post, $idcom) {
	if (!empty($post['supprimer'])) {

				// On vérifie de qui est le commentaire
		$req = $idcom->prepare('SELECT id_user FROM comment WHERE id = :id');
		$req->bindValue(':id', $post['supprimer'], PDO::PARAM_INT);
		$req->execute();
		$id_user = $req->fetch()['id_user'];

				// On vérifie qui est celui qui veut supprimer
		$req = $idcom->prepare('SELECT role FROM user WHERE id = :id');
		$req->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();
		$role = $req->fetch()['role'];

				// Si le membre est admin ou auteur du commentaire, on supprime
		if($role == 'admin' OR $id_user == $_SESSION['id']) {
			$req = $idcom->prepare('DELETE FROM comment WHERE id = :id');
			$req->bindValue(':id', $post['supprimer'], PDO::PARAM_INT);
			$req->execute();
		}
	}
}

// SUIVRE UNE HISTOIRE
function liker($post, $idcom) {
		// On vérifie de qui est l'histoire
	$req = $idcom->prepare('SELECT id_user, id_story FROM chapter, story WHERE chapter.id = :id AND id_story = story.id');
	$req->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	$req->execute();
	$tmp = $req->fetch();
	$id_user = $tmp['id_user'];
	$id_story = $tmp['id_story'];

		// Si le membre n'est pas l'auteur, il peut liker
	if($id_user != $_SESSION['id']) {
		$req = $idcom->prepare('INSERT INTO `bulles_suivies` (`id_user`, `id_story`) VALUES (:id_user, :id_story)');
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->bindValue(':id_story', $id_story, PDO::PARAM_INT);
		$req->execute();
	}
}

// NE PLUS SUIVRE UNE HISTOIRE
function disliker($post, $idcom) {
		// On vérifie de qui est l'histoire
	$req = $idcom->prepare('SELECT id_user, id_story FROM chapter, story WHERE chapter.id = :id_chapter AND id_story = story.id');
	$req->bindValue(':id_chapter', $_GET['id'], PDO::PARAM_INT);
	$req->execute();
	$tmp = $req->fetch();
	$id_user = $tmp['id_user'];
	$id_story = $tmp['id_story'];

		// Si le membre n'est pas l'auteur, il peut disliker
	if($id_user != $_SESSION['id']) {
		$req = $idcom->prepare('DELETE FROM bulles_suivies WHERE id_user = :id_user AND id_story = :id_story');
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->bindValue(':id_story', $id_story, PDO::PARAM_INT);
		$req->execute();
	}
}

// PUBLIER UNE NOUVELLE HISTOIRE
function form_publier_histoire($post, $file, $idcom) {

		// On vérifie que tous les champs sont remplis et sont corrects

	if (empty($post['titre'])) 
		$erreur[] = "Veuillez remplir le champ Titre.";

	if (empty($post['synopsis'])) 
		$erreur[] = "Veuillez remplir le champ Synopsis.";

	if(empty($post['genres']))
		$erreur[] = "Veuillez choisir au moins un Genre.";

	if(!isset($file['couverture']))
		$erreur[] = "Veuillez choisir une image de Couverture.";
	elseif($file['couverture']['error'] === 1)
		$erreur[] = "Image de Couverture trop lourde.";
	else
	{
		$ext = strtolower(pathinfo($file['couverture']['name'], PATHINFO_EXTENSION));
		$cover = 'cover'.$ext;

		$check = getimagesize($file["couverture"]["tmp_name"]);
		if(!($check !== false && in_array($ext, array('gif', 'png', 'jpg', 'jpeg'))))
			$erreur[] = "L'image de couverture doit être au format .gif, .png ou .jpg";
	}

	if(!isset($erreur))
	{
		$req = $idcom->prepare('INSERT INTO `story` (`id`, `title`, `synopsis`, `cover`, `id_user`, `publication_date`, `global_views`, `period_views`) VALUES (NULL, :titre, :synopsis, :cover, :id_user, CURRENT_TIMESTAMP, 0, 0)');
		$req->bindValue(':titre', $post['titre'], PDO::PARAM_STR);
		$req->bindValue(':synopsis', $post['synopsis'], PDO::PARAM_STR);
		$req->bindValue(':cover', $cover, PDO::PARAM_STR);
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();

		$last_id = $idcom->lastInsertId(); 

		if($last_id)
		{
			$req = $idcom->prepare('INSERT INTO `story_genre` (`id_story`, `id_genre`) VALUES (:id_story, :id_genre)');
			$req->bindValue(':id_story', $last_id, PDO::PARAM_INT);
			foreach($post['genres'] as $genre)
			{
				$req->bindValue(':id_genre', $genre, PDO::PARAM_INT);
				$req->execute();
			}

			mkdir("assets/images/story/".$last_id, 0777);
			$target_file = "assets/images/story/".$last_id.'/'.$cover;
			move_uploaded_file($file["couverture"]["tmp_name"], $target_file);
		}

		return array(true, '<article class="message is-success"><div class="message-body">Histoire ajoutée à vos publications !</div></article>');
	}
	else {
		$erreurForm = '<article class="message is-danger"><div class="message-body">';
		foreach($erreur as $err)
			$erreurForm .= $err.'<br />';
		unset($erreur);
		$erreurForm .= '</div></article>';
		return array(false, $erreurForm);
	}
}

// SUPPRIMER UNE HISTOIRE
function form_supprimer_histoire($post, $idcom) {

	// Suppression de l'histoire
	$req = $idcom->prepare('DELETE FROM story WHERE id = :id_story');
	$req->bindValue(':id_story', $_GET['id'], PDO::PARAM_INT);
	$req->execute();

	rmRecursive("assets/images/story/".$_GET['id']);

	return array(true, '<article class="message is-success"><div class="message-body">Histoire supprimée !</div></article>');
	
}

// PUBLIER UN NOUVEAU CHAPITRE
function form_publier_chapitre($post, $file, $idcom) {

	// On vérifie que tous les champs sont remplis et sont corrects
	if(!isset($file['couverture']))
		$erreur[] = "Veuillez choisir une image de Couverture.";
	elseif($file['couverture']['error'] === 1)
		$erreur[] = "Image de Couverture trop lourde.";
	else
	{
		$ext = strtolower(pathinfo($file['couverture']['name'], PATHINFO_EXTENSION));
		$cover = 'cover'.$ext;

		$check = getimagesize($file["couverture"]["tmp_name"]);
		if(!($check !== false && in_array($ext, array('gif', 'png', 'jpg', 'jpeg'))))
			$erreur[] = "L'image de couverture doit être au format .gif, .png ou .jpg";
	}

	for($i=0; $i<count($file['images']['name']); $i++)
	{
		if($file['images']['error'][$i] === 1) {
			$erreur[] = "L'une des images du chapitre dépasse le poids autorisé.";
			break;
		}
		$extimg = strtolower(pathinfo($file['images']['name'][$i], PATHINFO_EXTENSION));
		$checkimg = getimagesize($file['images']['tmp_name'][$i]);
		if(!($checkimg !== false && in_array($extimg, array('gif', 'png', 'jpg', 'jpeg')))) {
			$erreur[] = "L'une des images du chapitre n'est pas au format .gif, .png ou .jpg";
			break;
		}
	}

	if(!isset($erreur))
	{

		// Dans le cas où le titre serait vide
		if(empty($post['titre'])) $titre = null;

		// Liste des chapitres
		$req = $idcom->prepare('SELECT chapitre FROM chapter WHERE id_story = :id_story ORDER BY chapitre');
		$req->bindValue(':id_story', $_GET['id'], PDO::PARAM_INT);
		$req->execute();
		$listchap = $req->fetchAll();
		$prochainchap = 1;
		for($i=1; $i<=count($listchap); $i++)
		{
			if($i == $listchap[$i-1]['chapitre'])
				$prochainchap++;
			else
				break;
		}

		// On ajoute le chapitre
		$req = $idcom->prepare('INSERT INTO `chapter` (`id`, `id_story`, `chapitre`, `title`, `cover`, `publication_date`, `global_views`, `period_views`) VALUES (NULL, :id_story, :chapitre, :title, :cover, CURRENT_TIMESTAMP, 0, 0)');
		$req->bindValue(':id_story', $_GET['id'], PDO::PARAM_INT);
		$req->bindValue(':chapitre', $prochainchap, PDO::PARAM_STR);
		$req->bindValue(':title', $post['titre'], PDO::PARAM_STR);
		$req->bindValue(':cover', $cover, PDO::PARAM_STR);
		$req->execute();

		$last_id = $idcom->lastInsertId(); 

		if($last_id)
		{
			mkdir("assets/images/story/".$_GET['id']."/".$prochainchap, 0777);
			$target_file = "assets/images/story/".$_GET['id']."/".$prochainchap.'/'.$cover;
			move_uploaded_file($file["couverture"]["tmp_name"], $target_file);

			for($i=0; $i<count($file['images']['name']); $i++)
			{
				$extimg = strtolower(pathinfo($file['images']['name'][$i], PATHINFO_EXTENSION));
				$target_file = "assets/images/story/".$_GET['id']."/".$prochainchap.'/'.($i+1).'.'.$extimg;
				move_uploaded_file($file['images']["tmp_name"][$i], $target_file);
			}
		}

		return array(true, '<article class="message is-success"><div class="message-body">Chapitre ajouté à cette histoire !</div></article>');
	}
	else {
		$erreurForm = '<article class="message is-danger"><div class="message-body">';
		foreach($erreur as $err)
			$erreurForm .= $err.'<br />';
		unset($erreur);
		$erreurForm .= '</div></article>';
		return array(false, $erreurForm);
	}
}

// SUPPRIMER UN CHAPITRE
function form_supprimer_chapitre($post, $idcom) {

	// On récupère l'ID de l'histoire et le numéro du chapitre
	$req = $idcom->prepare('SELECT id_story, chapitre FROM chapter WHERE id = :id_chapter');
	$req->bindValue(':id_chapter', $_GET['id'], PDO::PARAM_INT);
	$req->execute();
	$tmp = $req->fetch();
	$id_story = $tmp['id_story'];
	$chapitre = $tmp['chapitre'];

	// Suppression de l'histoire
	$req = $idcom->prepare('DELETE FROM chapter WHERE id = :id_chapter');
	$req->bindValue(':id_chapter', $_GET['id'], PDO::PARAM_INT);
	$req->execute();

	rmRecursive("assets/images/story/".$id_story."/".$chapitre);

	return array(true, '<article class="message is-success"><div class="message-body">Chapitre supprimé !</div></article>');
	
}

function rmRecursive($path) {
    $path = realpath($path);
    chmod($path, 777);
    if(!file_exists($path))
        throw new RuntimeException('Fichier ou dossier non-trouvé');
    if(is_dir($path)) {
        $dir = dir($path);
        while(($file_in_dir = $dir->read()) !== false) {
            if($file_in_dir == '.' or $file_in_dir == '..')
                continue; // passage au tour de boucle suivant
            rmRecursive("$path/$file_in_dir");
        }
        $dir->close();
    }
    unlink($path);
}