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
						<a target="_blank" href="https://www.facebook.com/BubbleBoost-103290247903585/" class="button is-link is-large is-outlined is-fullwidth"> 
							<span class="icon">
								<i class="fab fa-facebook"></i>
							</span>
							<span>Facebook</span>
						</a>
					</div>
					<div class="column">
						<a target="_blank" href="https://twitter.com/boost_bubble" class="button is-primary is-large is-outlined is-fullwidth"> 
							<span class="icon">
								<i class="fab fa-twitter"></i>
							</span>
							<span>Twitter</span>
						</a>
					</div>
					<div class="column">
						<a target="_blank" href="https://www.instagram.com/bubbleboost_/ " class="button is-black is-large is-outlined is-fullwidth"> 
							<span class="icon">
								<i class="fab fa-instagram"></i>
							</span>
							<span>Instagram</span>
						</a>
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

	<h1>Modules de recherche</h1> 
	<div class="columns">
		<div class="column is-4">
			<div class="control has-icons-left">
				<input class="input" type="text" name="select-membre" placeholder="Membres">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>
		<div class="column is-4">
			<div class="control has-icons-left">
				<input class="input" type="text" name="select-histoire" placeholder="Histoires">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>
		<div class="column is-4">
			<div class="control has-icons-left">
				<input class="input" type="text" name="select-chapitre" placeholder="Chapitres">
				<span class="icon is-small is-left">
					<i class="fas fa-search"></i>
				</span>
			</div>
		</div>
	</div>
	<h2 id="titre-recherches" class="display-none mt-0"></h2>
	<div id="recherches" class="display-none"></div>

	<hr>

	<h1>Reprendre la lecture</h1> 
	<?php
	// Liste des dernières sorties
	$req = $idcom->prepare('SELECT chapter.id as id, id_story, chapter.chapitre as chapitre, chapter.cover as cover, story.title as titre FROM chapter, story WHERE id_story = story.id AND id_story IN (SELECT id_story FROM bulles_suivies WHERE id_user='.$_SESSION['id'].') ORDER BY chapter.id DESC LIMIT 20');
	$req->execute();
	$lstChapters = $req->fetchAll();
	?>
	<div class="<?php echo !empty($lstChapters)?'columns ':''; ?>slideshow-container">
		<?php
		if(empty($lstChapters))
		{
			?>
			<div class="mySlides1">
				Vous ne suivez aucune histoire pour le moment...
			</div>
			<?php
		}
		else
		{
			?>
			<div class="column flex-center is-1"><a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a></div>
			<div class="column">
				<?php 
				for($i=0; $i<count($lstChapters); $i=$i+5) 
				{
					?>
					<div class="columns is-multiline mySlides1">
						<?php 
						for($j=0; $j<5; $j++)
						{
							if(isset($lstChapters[$i+$j]))
							{
								$chapter = $lstChapters[$i+$j];
								?>
								<div class="column is-one-fifth cover_chapter">
									<a href="chapitre.php?id=<?php echo $chapter['id']; ?>">
										<img class="mb-1" src="assets/images/story/<?php echo $chapter['id_story']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover']; ?>" />
										<p class="mb-0"><b><?php echo $chapter['titre']; ?></b></p>
										<p class="mb-0">Chapitre <?php echo $chapter['chapitre']; ?></p>
									</a>
								</div>
								<?php
							}
						}
						?>
					</div>
					<?php 
				}
				?>
			</div>
			<div class="column flex-center is-1"><a class="next" onclick="plusSlides(1, 0)">&#10095;</a></div>
			<?php
		}
		?>
	</div>

	<hr>

	<h1>Les plus populaires</h1> 
	<?php
	// Liste des dernières sorties
	$req = $idcom->prepare('SELECT chapter.id as id, id_story, chapter.chapitre as chapitre, chapter.cover as cover, story.title as titre FROM chapter, story WHERE id_story = story.id ORDER BY chapter.period_views DESC, chapter.global_views DESC, chapter.id DESC LIMIT 20');
	$req->execute();
	$lstChapters = $req->fetchAll();
	?>
	<div class="columns slideshow-container">
		<div class="column flex-center is-1"><a class="prev" onclick="plusSlides(-1, 1)">&#10094;</a></div>
		<div class="column">
			<?php 
			for($i=0; $i<count($lstChapters); $i=$i+5) 
			{
				?>
				<div class="columns is-multiline mySlides2">
					<?php 
					for($j=0; $j<5; $j++)
					{
						if(isset($lstChapters[$i+$j]))
						{
							$chapter = $lstChapters[$i+$j];
							?>
							<div class="column is-one-fifth cover_chapter">
								<a href="chapitre.php?id=<?php echo $chapter['id']; ?>">
									<img class="mb-1" src="assets/images/story/<?php echo $chapter['id_story']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover']; ?>" />
									<p class="mb-0"><b><?php echo $chapter['titre']; ?></b></p>
									<p class="mb-0">Chapitre <?php echo $chapter['chapitre']; ?></p>
								</a>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php 
			}
			?>
		</div>
		<div class="column flex-center is-1"><a class="next" onclick="plusSlides(1, 1)">&#10095;</a></div>
	</div>

	<hr>

	<h1>Dernière sorties</h1> 
	<?php
	// Liste des dernières sorties
	$req = $idcom->prepare('SELECT chapter.id as id, id_story, chapter.chapitre as chapitre, chapter.cover as cover, story.title as titre FROM chapter, story WHERE id_story = story.id ORDER BY chapter.id DESC LIMIT 20');
	$req->execute();
	$lstChapters = $req->fetchAll();
	?>
	<div class="columns slideshow-container">
		<div class="column flex-center is-1"><a class="prev" onclick="plusSlides(-1, 2)">&#10094;</a></div>
		<div class="column">
			<?php 
			for($i=0; $i<count($lstChapters); $i=$i+5) 
			{
				?>
				<div class="columns is-multiline mySlides3">
					<?php 
					for($j=0; $j<5; $j++)
					{
						if(isset($lstChapters[$i+$j]))
						{
							$chapter = $lstChapters[$i+$j];
							?>
							<div class="column is-one-fifth cover_chapter">
								<a href="chapitre.php?id=<?php echo $chapter['id']; ?>">
									<img class="mb-1" src="assets/images/story/<?php echo $chapter['id_story']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover']; ?>" />
									<p class="mb-0"><b><?php echo $chapter['titre']; ?></b></p>
									<p class="mb-0">Chapitre <?php echo $chapter['chapitre']; ?></p>
								</a>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php 
			}
			?>
		</div>
		<div class="column flex-center is-1"><a class="next" onclick="plusSlides(1, 2)">&#10095;</a></div>
	</div>


	<?php
}
?>

<?php include 'assets/include/footer.php'; ?>