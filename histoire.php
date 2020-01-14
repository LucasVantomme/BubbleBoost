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

		// Liste des chapitres
		$req = $idcom->prepare('SELECT * FROM chapter WHERE id_story = :id_story');
		$req->bindValue(':id_story', $story['id_story'], PDO::PARAM_INT);
		$req->execute();
		$story['chapters'] = $req->fetchAll();
		
		// Histoire suivie ?
		$req = $idcom->prepare('SELECT 1 FROM bulles_suivies WHERE id_story = :id_story AND id_user = :id_user');
		$req->bindValue(':id_story', $story['id_story'], PDO::PARAM_INT);
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();
		if($req->fetch() !== false) $story['suivi'] = true;
		else $story['suivi'] = false;

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
		
		$page = 'Histoire';
		$titre = $story['title'];
	}
	else
		header('location: index.php');
}

include 'assets/include/header.php';
?>


<!-- Style à mettre ensuite dans le .css -->
<style>
	.cover_story img { border: 1px solid black; }
	.author_story { font-size: medium!important; margin-left: 50px; }
	.cover_chapter { text-align: center; }
	.cover_chapter img { width: 75%; border: 1px solid black; }
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
					<h2 class="mt-1 mb-4 author_story">par <a href="profil?id=<?php echo $chapter['id_user']; ?>"><?php echo $chapter['firstname'].' '.$chapter['lastname']; ?></a></h2>
					<p><strong><?php echo $story['nb_suivi']; ?> personne<?php echo $story['nb_suivi']>1?'s':''; ?></strong> <?php echo $story['nb_suivi']>1?'suivent':'suit'; ?> cette histoire</p>
					<p><strong>Genre<?php echo count($story['genre'])>1?'s':''; ?> :</strong> <?php echo implode($story['genre'], ', '); ?></p>
					<p><strong>Date de publication :</strong> <?php echo strftime("%d/%m/%G", strtotime($story['publication_date'])); ?></p>
					<p><strong>Nombre de chapitres :</strong> <?php echo $story['nb_chapter']; ?></p>
                    <?php if($story['id_user'] == $_SESSION['id']) { ?>
                        <div class="buttons has-addons is-right">
                            <button class="button is-dark"><span class="icon"><i class="fa fa-trash"></i></span><span>Supprimer l'histoire</span></button>
                        </div>
                    <?php } else { ?>
						<form method="POST" action="chapitre.php?id=<?php echo $chapter['id_chapter']; ?>">
							<div class="buttons has-addons is-right">
								<?php if($story['suivi'] == false) { ?>
									<button class="button is-dark" name="liker"><span class="icon"><i class="far fa-heart"></i></span><span>Suivre</span></button>
								<?php } else { ?>
									<button class="button is-dark" name="disliker"><span class="icon"><i class="fa fa-heart"></i></span><span>Ne plus suivre</span></button>
								<?php } ?>
							</div>
						</form>
					<?php } ?>
				</div>
			</div>

			<hr>

			<h3>Synopsis</h3>
			<?php echo $story['synopsis']; ?>

			<hr>

			<h3>Les chapitres</h3>
			<div class="columns is-multiline">
				<?php foreach($story['chapters'] as $chapter) { ?>
					<div class="column is-one-fifth cover_chapter">
                        <a href="chapitre.php?id=<?php echo $chapter['id']; ?>">
                        	<img src="assets/images/story/<?php echo $story['id_story']; ?>/<?php echo $chapter['id']; ?>/<?php echo $chapter['cover']; ?>" />
                        	Chapitre <?php echo $chapter['chapitre']; ?>
                        </a>
					</div>
				<?php } ?>
            </div>
            <?php if($story['id_user'] == $_SESSION['id']) { ?>
                <div class="buttons has-addons is-right">
                    <button class="button is-dark"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Publier un nouveau chapitre</span></button>
                </div>
            <?php } ?>
		</div>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>