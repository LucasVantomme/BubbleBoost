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
    <!--<link rel="stylesheet" href="/BubbleBoost/assets/css/profil.css">-->
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
		$userheader = $req->fetch();
		?>
		<!--Navbar 
		<nav class="mb-1 navbar navbar-expand-lg navbar-dark secondary-color lighten-1">
  			<a class="navbar-brand" href="#">
				Navbar
			</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555" aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse" id="navbarSupportedContent-555">
    			<ul class="navbar-nav mr-auto">
      				<li class="nav-item active">
        				<a class="nav-link" href="#">
							Home
          					<span class="sr-only">(current)</span>
        				</a>
      				</li>
      				<li class="nav-item">
        				<a class="nav-link" href="#">
							Features
						</a>
      				</li>
      				<li class="nav-item">
        				<a class="nav-link" href="#">
							Pricing
						</a>
      				</li>
      				<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Dropdown
						</a>
						<div class="dropdown-menu dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-555">
							<a class="dropdown-item" href="#">
								Action
							</a>
							<a class="dropdown-item" href="#">
								Another action
							</a>
							<a class="dropdown-item" href="#">
								Something else here
							</a>
						</div>
					</li>
    			</ul>
				<ul class="navbar-nav ml-auto nav-flex-icons">
					<li class="nav-item">
						<a class="nav-link waves-effect waves-light">
							1
							<i class="fas fa-envelope"></i>
						</a>
					</li>
					<li class="nav-item avatar dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-2.jpg" class="rounded-circle z-depth-0" alt="avatar image">
						</a>
						<div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-55">
							<a class="dropdown-item" href="#">
								Action
							</a>
							<a class="dropdown-item" href="#">
								Another action
							</a>
							<a class="dropdown-item" href="#">
								Something else here
							</a>
						</div>
					</li>
				</ul>
  			</div>
		</nav>
/.Navbar
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
									<span>Bienvenue, </span>
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
		</nav> -->
		<nav class="navbar" role="navigation" aria-label="main navigation">
  			<div class="navbar-brand">
			  	<a class="navbar-item" href="index.php">
      				<img src="/BubbleBoost/assets/images/logo.png" width="100" height="100">
  				</a>
			</div>
		
  			<div class="navbar-menu">
    			<div class="navbar-end">
					<a class="navbar-item" href="notification.php">
						<strong>1</strong>
						<span class="icon is-large">
							<span class="fa-stack">
								<i class="fas fa-circle fa-stack-2x has-text-info"></i>
								<i class="fas fa-bell fa-stack-1x fa-inverse"></i>
							</span>
						</span>
					</a>
					
      				<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-item">
							Bienvenu, <strong><?php echo $userheader['firstname'].' '.$userheader['lastname']; ?></strong>
							<figure class="image is-48x48">
								<img class="is-rounded" src="/BubbleBoost/assets/images/avatar/johnsnow.jpg">
							</figure>
						</a>
						<div class="navbar-dropdown is-right">
							<a class="navbar-item" href="profil.php">
								<strong>MA PAGE</strong>
							</a>
							<a class="navbar-item" href="publication.php">
								<strong>MES PUBLICATIONS</strong>
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