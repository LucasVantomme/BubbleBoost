<?php
include_once 'bdd-connect.php';
include_once 'fonctions.php';
?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title><?php echo $titre; ?></title>
	<link rel="stylesheet" href="/BubbleBoost/assets/css/styles.css">
	<?php if($page == "Publications") { ?> <link rel="stylesheet" href="/BubbleBoost/assets/css/mes-publications.css"> <?php } ?>
	<?php if($page == "Accueil") { ?> <link rel="stylesheet" href="/BubbleBoost/assets/css/accueil.css"> <?php } ?>
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
		<nav class="navbar navbar-expand-lg navbar-light logo">
			<a class="navbar-brand" href="/BubbleBoost/index.php">
				<img class="d-inline-block align-top" src="/BubbleBoost/assets/images/logo.png">
				<span>BubbleBoost</span>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

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
		$req = $idcom->prepare('SELECT id, firstname, lastname, username FROM user WHERE id=:id');
		$req->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();
		$user = $req->fetch();
		?>

		<nav class="navbar navbar-expand-lg navbar-light logo">
			<a class="navbar-brand" href="/BubbleBoost/index.php">
				<img class="d-inline-block align-top" src="/BubbleBoost/assets/images/logo.png">
				<span>BubbleBoost</span>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdownButton">
						<span class="icon is-medium notificationsIcon">
							<i class="fas fa-bell"></i>
						</span>
						<div class="dropdown is-right">
							<div class="dropdown-trigger">
								<button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
									<span>Bienvenue, <?php echo $user['firstname'].' '.$user['lastname']; ?></span>
									<span class="icon is-small">
										<i class="fas fa-angle-down" aria-hidden="true"></i>
									</span>
								</button>
							</div>
							<div class="dropdown-menu" id="dropdown-menu" role="menu">
								<div class="dropdown-content">
									<a href="" class="dropdown-item">Ma page</a>
									<a href="publication.php" class="dropdown-item">Mes publications</a>
									<a href="compte.php" class="dropdown-item">Mon compte</a>
									<a href="connexion.php" class="dropdown-item">Deconnexion</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<?php
	}
	?>

	<div class="content">