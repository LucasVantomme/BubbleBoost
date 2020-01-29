<?php
include_once 'bdd-connect.php';
include_once 'fonctions.php';
?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $titre; ?></title>
	<link rel="stylesheet" href="assets/css/styles.css">
	<?php if($page == "Profil") { ?> <link rel="stylesheet" href="assets/css/profil.css"> <?php } ?>
	<?php if($page == "Publications") { ?> <link rel="stylesheet" href="assets/css/mes-publications.css"> <?php } ?>
	<?php if($page == "Accueil") { ?> <link rel="stylesheet" href="assets/css/accueil.css"> <?php } ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
	<?php
	// Si le membre n'est pas connecté 
	if(!isset($_SESSION['id'])) {
		?>
		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href="index.php">
				<img class="d-inline-block align-top logo" src="assets/images/logo.png">
				<div class="flex-center ml-2">BubbleBoost</div>
			</a>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item buttoninscrip">
						<a class="button is-black is-rounded" href="inscription.php">Inscription</a>
					</li>
					<li class="nav-item buttonconnex">
						<a class="button is-rounded is_white is-outlined is-active" href="connexion.php">Connexion</a>
					</li>
				</ul>
			</div>
		</nav>
		<?php
	}
	// Si le membre est connecté
	else 
	{
		// Informations sur le membre
		$req = $idcom->prepare('SELECT id, firstname, lastname, username, (SELECT COUNT(*) FROM notification WHERE id_user_dest=user.id AND open=0) as nb_notif FROM user WHERE id=:id');
		$req->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();
		$userheader = $req->fetch();
		?>

		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href="index.php">
				<img class="d-inline-block align-top logo" src="assets/images/logo.png">
				<div class="flex-center ml-2">BubbleBoost</div>
			</a>

			<div class="navbar-menu">
				<div class="navbar-end">
					<a class="navbar-item" href="notification.php">
						<strong><?php echo $userheader['nb_notif']; ?></strong>
						<span class="icon is-large">
							<span class="fa-stack">
								<i class="fas fa-circle fa-stack-2x has-text-<?php echo $userheader['nb_notif']>0?'info':'grey-lighter'; ?>"></i>
								<i class="fas fa-bell fa-stack-1x fa-inverse has-text-<?php echo $userheader['nb_notif']>0?'white':'dark'; ?>"></i>
							</span>
						</span>
					</a>
					
					<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-item">
							Bienvenue, &nbsp; <strong><?php echo $userheader['firstname'].' '.$userheader['lastname']; ?></strong>
							<img class="ml-3 avatar-bords" src="assets/images/avatar/<?php echo $_SESSION['avatar']; ?>">
						</a>
						<div class="navbar-dropdown is-right">
							<a class="navbar-item" href="publication.php">
								<strong>MES PUBLICATIONS</strong>
							</a>
							<a class="navbar-item" href="profil.php">
								<strong>MON PROFIL</strong>
							</a>
							<a class="navbar-item" href="compte.php">
								<strong>MON COMPTE</strong>
							</a>
							<hr class="navbar-divider">
							<a class="navbar-item is-active" href="connexion.php">
								Déconnexion
							</a>
						</div>
					</div>
				</div>
			</div>
		</nav>

		<?php
	}
	?>
	<div class="content">