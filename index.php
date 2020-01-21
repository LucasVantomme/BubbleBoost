<?php 
$page = 'Accueil';
$titre = 'BubbleBoost - Page d\'Accueil';
include 'assets/include/header.php'; 
?>

<?php
// Si le membre n'est pas connecté
if(!isset($_SESSION['id']))
{
	?>
	<div class="tile is-ancestor">
		<div class="tile is-parent">
			<div class="tile is-child box">
				
				<div class="columns">
					<div class="column">
						<div class="container">
							<p class="title">Qu'est-ce que BubbleBoost ?</p>
							<p>BubbleBoost est un site <strong>communautaire</strong> français qui permet aux artistes/dessinateurs/auteurs <strong>débutants ou avancés</strong> de gagner en <strong>visibilité</strong> auprès d'un public fan de BD et de Comics en tout genre.</p>
							<p>L'inscription est <strong>gratuite</strong>, vous pouvez choisir d'être uniquement <strong>lecteur</strong> ou de devenir <strong>artiste en publiant</strong> vos créations.</p>
							<!--<a class="btn btn-outline-danger btn-lg">Découvrir</a>-->
						</div>	
					</div>
					<div class="column is-narrow">
						<div class="container" style="width: 300px;">
							<div class="puzzle-slider puzzle-slider-1">
								<div class="slides">
									<img class="item" src="assets/images/5.jpg" alt="image">
									<img class="item" src="assets/images/7.jpg" alt="image">
									<img class="item" src="assets/images/4.jpg" alt="image">
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="tile is-ancestor">
		<div class="tile is-parent">
			<div class="tile is-child box">

				<div class="columns">
					<div class="column is-narrow">
						<div class="container" style="width: 300px;">
							<img src="assets/images/2.jpg" alt="image">
						</div>	
					</div>
					<div class="column">
						<div class="container">
							<p class="title">Pourquoi BubbleBoost ?</p>
							<p>
								<i class="fas fa-arrow-alt-circle-right"></i>
								Profitez des bulles de vos artistes préférés,<strong> gratuitement</strong> !
							</p>
							<p>
								<i class="fas fa-arrow-alt-circle-right"></i>
								<strong>Soutenez</strong>-les, <strong>suivez</strong>-les : donnez leur de la <strong>visibilité</strong>.
							</p>
							<p>
								<i class="fas fa-arrow-alt-circle-right"></i>
								Donnez votre <strong>avis</strong> sur les dernières sorties de vos bulles favorites !
							</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="tile is-ancestor">
		<div class="tile is-parent">
			<div class="tile is-child box">
				<p class="title">Nous suivre</p>
				<div class="columns">
					<div class="column">
						<button class="button is-link is-large is-outlined is-fullwidth"> 
							<span class="icon">
								<i class="fab fa-facebook"></i>
							</span>
							<span>Facebook</span>
						</button>
					</div>
					<div class="column">
						<button class="button is-primary is-large is-outlined is-fullwidth"> 
							<span class="icon">
								<i class="fab fa-twitter"></i>
							</span>
							<span>Twitter</span>
						</button>
					</div>
					<div class="column">
						<button class="button is-black is-large is-outlined is-fullwidth"> 
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
	<?php
}
// Sinon (si le membre est connecté)
else
{
	?>
	<center>
		<div class="field">
			<p class="control has-icons-left">
				<input class="input" type="text" placeholder="Recherche un bulle">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</p>
		</div>
	</center>

	<div id="demo" class="carousel slide" data-ride="carousel">
		<h1>Reprendre la lecture</h1> 
		<!-- The slideshow -->
		<div class="container carousel-inner no-padding">
			<div class="carousel-item active">
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/0.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div> 
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/0.jpg">
					<h3>Elle était si forte</h3>
					<p>jbdjkd</p>
				</div>   
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/0.jpg">
					<h3>Aventure</h3>
					<p>jbdjkd</p>
				</div>   
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/0.jpg">
					<h3>Titre</h3>
					<p>jbdjkd</p>
				</div>   
			</div>
			<div class="carousel-item">
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/0.jpg">
					<h3>Titre</h3>
					<p>jbdjkd</p>
				</div>    
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/0.jpg">
					<h3>Titre</h3>
					<p>jbdmkfn</p>
				</div>    
			</div>
		</div>
		<!-- Left and right controls -->
		<a class="carousel-control-prev" href="#demo" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</a>
		<a class="carousel-control-next" href="#demo" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		</a>
	</div>
	<hr>
	<div id="demo2" class="carousel slide" data-ride="carousel">
		<h1>Les plus populaires</h1> 
		<!-- The slideshow -->
		<div class="container carousel-inner no-padding">
			<div class="carousel-item active">
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/1.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div> 
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/1.jpg">
					<h3>Elle était si forte</h3>
					<p>lkfnslknfd </p>
				</div>   
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/1.jpg">
					<h3>Aventure</h3>
					<p>lkfnslknfd </p>
				</div>   
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/1.jpg">
					<h3>Titre</h3>
					<p>lkfnslknfd </p>
				</div>   
			</div>
			<div class="carousel-item">
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/1.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div>    
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/1.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div>   
			</div>
		</div>
		
		<!-- Left and right controls -->
		<a class="carousel-control-prev" href="#demo2" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</a>
		<a class="carousel-control-next" href="#demo2" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		</a>
	</div>
	<hr>
	<div id="demo3" class="carousel slide" data-ride="carousel">
		<h1>Dernière sorties</h1> 
		<!-- The slideshow -->
		<div class="container carousel-inner no-padding">
			<div class="carousel-item active">
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/6.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div> 
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/6.jpg">
					<h3>Elle était si forte</h3>
					<p>lkfnslknfd </p>
				</div>   
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/6.jpg">
					<h3>Aventure</h3>
					<p>lkfnslknfd </p>
				</div>   
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/6.jpg">
					<h3>Titre</h3>
					<p>lkfnslknfd </p>
				</div>   
			</div>
			<div class="carousel-item">
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/6.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div>    
				<div class="col-xs-3 col-sm-3 col-md-3">
					<img src="assets/images/6.jpg">
					<h3>Histoire de la vie</h3>
					<p>lkfnslknfd </p>
				</div>   
			</div>
		</div>
		
		<!-- Left and right controls -->
		<a class="carousel-control-prev" href="#demo3" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</a>
		<a class="carousel-control-next" href="#demo3" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		</a>
	</div>
	<?php
}
?>

<?php include 'assets/include/footer.php'; ?>