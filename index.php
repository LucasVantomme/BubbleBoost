<?php 
$page = 'Accueil';
$titre = 'BubbleBoost - Page d\'Accueil';
include 'assets/include/header.php'; 
?>
<div class="row">
	<div class="col-4 titre">
		<div class="titre">
			<h2>Pour les passionnés des Mangas et BDs !</h2>
			<h4>Ne ratez pas les dernières sorties de nos artistes</h4>
			<a class="btn btn-outline-danger btn-lg">Découvrir</a>
		</div>
	</div>
	
	<div class="col-8">
		<div class="puzzle-slider puzzle-slider-1">
			<div class="slides">
				<img class="item" src="assets/images/5.jpg" alt="image">
				<img class="item" src="assets/images/7.jpg" alt="image">
				<img class="item" src="assets/images/4.jpg" alt="image">
			</div>
		</div>
	</div>
</div>

<div class="row row2">
	<div class="col-xs-3 col-md-6 ">
		<img src="assets/images/anime.png">
	</div>

	<div class="col-xs-3 col-md-6">
		<h2>BubbleBoost, C'est quoi ? </h2>
		<div class="row">
			<div class="col">
				<h3>Titre 1</h3>
				<p>ljbdjdblfnlfnlk</p>
			</div>
			<div class="col">
				<h3>Titre 2</h3>
				<p>lddflnfln</p>
			</div>
			<div class="w-100"></div>
			<div class="col">
				<h3>Titre 3</h3>
				<p>lddflnfln</p>
			</div>
			<div class="col">
				<h3>Titre 4</h3>
				<p>lddflnfln</p>
			</div>
		</div>
	</div>
</div>

<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">
			<p class="title">Qu'est-ce que BubbleBoost ?</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.</p>
		</div>
	</div>
</div>
<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">
			<p class="title">Pourquoi BubbleBoost ?</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.</p>
		</div>
	</div>
</div>
<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">
			<p class="title">Nous suivre</p>
			<div class="columns">
				<div class="column">
					<button class="button is-link is-large"> 
						<span class="icon">
							<i class="fab fa-facebook"></i>
						</span>
						<span>Facebook</span>
					</button>
				</div>
				<div class="column">
					<button class="button is-primary is-large"> 
						<span class="icon">
							<i class="fab fa-twitter"></i>
						</span>
						<span>Twitter</span>
					</button>
				</div>
				<div class="column">
					<button class="button is-inverted is-large"> 
						<span class="icon">
							<i class="fab fa-instagram"></i>
						</span>
						<span>Instagram</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>