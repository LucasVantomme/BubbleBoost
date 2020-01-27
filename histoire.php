<?php 
include 'assets/include/bdd-connect.php';
include 'assets/include/fonctions.php';


if(!isset($_GET['id']))
	header('location: index.php');
else
{

	if(isset($_POST['supprimer-histoire'])) {
		$result_supprimer_histoire = form_supprimer_histoire($_POST, $idcom);
		if($result_supprimer_histoire[0]) 
			header('location: publication.php');
	}

	if(isset($_POST['publier-chapitre'])) {
		$result_publier_chapitre = form_publier_chapitre($_POST, $_FILES, $idcom);
		if($result_publier_chapitre[0]) unset($_POST);
	}


	$req = $idcom->prepare('SELECT user.id as id_user, firstname, lastname, username, story.id as id_story, title, cover, synopsis, publication_date FROM story, user WHERE story.id=:id AND user.id=id_user');
	$req->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	$req->execute();
	if($story = $req->fetch()) {
		
		// Nombre de chapitres
		$req = $idcom->prepare('SELECT COUNT(*) as nb_chapter FROM chapter WHERE id_story = :id_story');
		$req->bindValue(':id_story', $story['id_story'], PDO::PARAM_INT);
		$req->execute();
		$story['nb_chapter'] = $req->fetch()['nb_chapter'];

		// Le prochain chapitre
		$req = $idcom->prepare('SELECT chapitre FROM chapter WHERE id_story = :id_story ORDER BY chapitre');
		$req->bindValue(':id_story', $_GET['id'], PDO::PARAM_INT);
		$req->execute();
		$listchap = $req->fetchAll();
		$story['next_chapter'] = 1;
		for($i=1; $i<=count($listchap); $i++)
		{
			if($i == $listchap[$i-1]['chapitre'])
				$story['next_chapter']++;
			else
				break;
		}

		// Liste des chapitres
		$req = $idcom->prepare('SELECT * FROM chapter WHERE id_story = :id_story ORDER BY chapitre');
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
		$titre = 'BubbleBoost - '.$story['title'];
	}
	else
		header('location: index.php');
}

include 'assets/include/header.php';
?>



<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">

			<?php
			if(isset($result_publier_chapitre[1]))
				echo $result_publier_chapitre[1];
			?>
			
			<div class="columns">
				<div class="column is-one-quarter cover_story">
					<img src="assets/images/story/<?php echo $story['id_story']; ?>/<?php echo $story['cover']; ?>" class="cover_story" />
				</div>
				<div class="column">
					<h1 class="mb-0"><?php echo $story['title']; ?></h1>
					<h2 class="mt-1 mb-4 author_story">par <a href="profil.php?id=<?php echo $story['id_user']; ?>"><?php echo $story['firstname'].' '.$story['lastname']; ?></a></h2>
					<p><strong><?php echo $story['nb_suivi']; ?> personne<?php echo $story['nb_suivi']>1?'s':''; ?></strong> <?php echo $story['nb_suivi']>1?'suivent':'suit'; ?> cette histoire</p>
					<p><strong>Genre<?php echo count($story['genre'])>1?'s':''; ?> :</strong> <?php echo implode($story['genre'], ', '); ?></p>
					<p><strong>Date de publication :</strong> <?php echo strftime("%d/%m/%G", strtotime($story['publication_date'])); ?></p>
					<p><strong>Nombre de chapitres :</strong> <?php echo $story['nb_chapter']; ?></p>
					<?php if($story['id_user'] == $_SESSION['id']) { ?>
						<div class="buttons has-addons is-right">
							<button class="button is-dark" id="modal-supprimer"><span class="icon"><i class="fa fa-trash"></i></span><span>Supprimer l'histoire</span></button>
						</div>
					<?php } else { ?>
						<form method="POST" action="histoire.php?id=<?php echo $story['id_story']; ?>">
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
			<?php echo nl2br($story['synopsis']); ?>

			<hr>

			<h3>Les chapitres</h3>
			<div class="columns is-multiline">
				<?php foreach($story['chapters'] as $chapter) { ?>
					<div class="column is-one-fifth cover_chapter">
						<a href="chapitre.php?id=<?php echo $chapter['id']; ?>">
							<img src="assets/images/story/<?php echo $story['id_story']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover']; ?>" />
							Chapitre <?php echo $chapter['chapitre']; ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<?php if($story['id_user'] == $_SESSION['id']) { ?>
				<div class="buttons has-addons is-right">
					<button class="button is-dark" id="modal-chapitre"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Publier un nouveau chapitre</span></button>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<!-- Modal pour publier un nouveau chapitre -->
<div class="modal modal-chapitre">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">Publier un nouveau chapitre</p>
			<button class="delete close-modal" aria-label="close"></button>
		</header>
		<section class="modal-card-body">
			<form method="POST" enctype="multipart/form-data" action="histoire.php?id=<?php echo $_GET['id']; ?>">
				<div class="field">
					<label for="chapitre">Chapitre : </label>
					<p class="control">
						<input class="input" type="text" name="chapitre" placeholder="Numéro du nouveau chapitre" value="Chapitre <?php echo $story['next_chapter']; ?>" required disabled />
					</p>
				</div>
				<div class="field">
					<label for="titre">Titre : </label>
					<p class="control">
						<input class="input" type="text" name="titre" placeholder="Titre du chapitre, s'il existe" />
					</p>
				</div>
				<div class="field">
					<label for="couverture">Image de couverture (max : <?php echo ini_get('upload_max_filesize'); ?>) : </label>
					<div class="file has-name">
						<label class="file-label" id="story-file">
							<input class="file-input" type="file" name="couverture" accept="image/*" required>
							<span class="file-cta">
								<span class="file-icon">
									<i class="fas fa-upload"></i>
								</span>
								<span class="file-label">
									Choisir un fichier
								</span>
							</span>
							<span class="file-name">
								Aucun fichier...
							</span>
						</label>
					</div>
				</div>
				<div class="field" id="field_images">
					<label for="couverture">Pages du chapitre (images) : </label>
					<div>
						<input type="file" name="images[]" accept="image/*" required />
					</div>
				</div>
				<div class="field">
					<button type="button" class="button" onclick="ajouterInput();"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Ajouter une page</span></button>
				</div>
				<div class="field is-grouped is-grouped-centered">
					<p class="control">
						<button class="button is-dark" name="publier-chapitre"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Publier le chapitre</span></button>
					</p>
				</div>
			</form>
		</section>
	</div>
</div>

<!-- Modal pour supprimer une histoire -->
<div class="modal modal-supprimer-histoire">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">Supprimer une histoire</p>
			<button class="delete close-modal" aria-label="close"></button>
		</header>
		<section class="modal-card-body">
			<form method="POST" enctype="multipart/form-data" action="chapitre.php?id=<?php echo $story['id_story']; ?>">
				<p>Êtes-vous sûr de vouloir supprimer cette histoire ? Cela entraînera la suppression de tous ses chapitres et par extension de tous ses suivis et commentaires.</p>
				<div class="field is-grouped is-grouped-centered">
					<p class="control">
						<button class="button is-danger" name="supprimer-histoire"><span class="icon"><i class="fa fa-minus-square"></i></span><span>Supprimer cette histoire</span></button>
					</p>
				</div>
			</form>
		</section>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>