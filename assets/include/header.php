<?php
include_once 'bdd-connect.php';
include_once 'fonctions.php';
?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo $titre; ?></title>
		<link rel="stylesheet" href="/Bubbleboost/assets/css/styles.css">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-light logo">
			<a class="navbar-brand" href="/Bubbleboost/index.php">
				<img class="d-inline-block align-top" src="/Bubbleboost/assets/images/logo.png">
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

		<div class="content">