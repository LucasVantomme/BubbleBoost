<?php 
include 'assets/include/bdd-connect.php';

if(!isset($_GET['id']))
	header('location: index.php');
else
{
	$req = $idcom->prepare('SELECT user.id as id_user, firstname, lastname, username, story.id as id_story, title, cover, synopsis, publication_date FROM story, user WHERE story.id=:id AND user.id=id_user');
	$req->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	$req->execute();
	if($story = $req->fetch()) {
		
		// Nombre de chapitres
		$req = $idcom->prepare('SELECT COUNT(*) as nb_chapter FROM chapter WHERE id_story = :id_story');
		$req->bindValue(':id_story', $story['id_story'], PDO::PARAM_INT);
		$req->execute();
		$story['nb_chapter'] = $req->fetch()['nb_chapter'];
		
		// Nombre de suivis
		$req = $idcom->prepare('SELECT COUNT(*) as nb_suivi FROM bulles_suivies WHERE id_story = :id_story');
		$req->bindValue(':id_story', $story['id_story'], PDO::PARAM_INT);
		$req->execute();
		$story['nb_suivi'] = $req->fetch()['nb_suivi'];
		
		// Genres
		$req = $idcom->prepare('SELECT genre.id as id, genre FROM genre, story_genre WHERE id_story = :id_story AND id_genre = genre.id');
		$req->bindValue(':id_story', $story['id_story'], PDO::PARAM_INT);
		$req->execute();
		$story['genre'] = array();
		while($g = $req->fetch())
			$story['genre'][] = $g['genre'];
		
		$page = 'Story';
		$titre = $story['title'];
	}
	else
		header('location: index.php');
}

include 'assets/include/header.php';
?>


<!-- Style à mettre ensuite dans le .css -->
<style>
	.cover_story
	{ 
		border: 1px solid black;
	}
</style>



<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">
			
			<div class="columns">
				<div class="column is-one-quarter cover_story">
					<img src="assets/images/story/<?php echo $story['id_story']; ?>/<?php echo $story['cover']; ?>" class="cover_story" />
				</div>
				<div class="column">
					<h1 class="mb-0"><?php echo $story['title']; ?></h1>
					<h2 class="mt-0">par <?php echo $story['username']; ?></h2>
					<p><strong><?php echo $story['nb_suivi']; ?> personne<?php echo $story['nb_suivi']>1?'s':''; ?></strong> <?php echo $story['nb_suivi']>1?'suivent':'suit'; ?> cette histoire</p>
					<p><strong>Genre<?php echo count($story['genre'])>1?'s':''; ?> :</strong> <?php echo implode($story['genre'], ', '); ?></p>
					<p><strong>Date de publication :</strong> <?php echo strftime("%d/%m/%G", strtotime($story['publication_date'])); ?></p>
					<p><strong>Nombre de chapitres :</strong> <?php echo $story['nb_chapter']; ?></p>
				</div>
			</div>

			<hr>

			<h3>Synopsis</h3>
			<?php echo $story['synopsis']; ?>

			<hr>

			<h3>Les chapitres</h3>
			...

		</div>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>