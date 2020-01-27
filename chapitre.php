<?php 
include 'assets/include/bdd-connect.php';
include 'assets/include/fonctions.php';
?>

<?php
if(!isset($_GET['id']))
	header('location: index.php');
else
{

	$req = $idcom->prepare('SELECT user.id as id_user, firstname, lastname, username, story.id as id_story, chapter.id as id_chapter, story.title as story_title, chapter.title as chapter_title, chapitre, chapter.cover as cover, chapter.publication_date as publication_date FROM story, chapter, user WHERE chapter.id=:id AND story.id=chapter.id_story AND user.id=id_user');
	$req->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
	$req->execute();
	if($chapter = $req->fetch()) {

		if(isset($_POST['supprimer-chapitre'])) {
			$result_supprimer_chapitre = form_supprimer_chapitre($_POST, $idcom);
//			if($result_supprimer_chapitre[0]) 
//				header('location: histoire.php?id='.$chapter['id_story']);
		}

		if(isset($_POST))
		{
			if(isset($_POST['commenter'])) add_commentaire($_POST, $idcom);
			if(isset($_POST['supprimer'])) del_commentaire($_POST, $idcom);
			if(isset($_POST['liker'])) liker($_POST, $idcom);
			if(isset($_POST['disliker'])) disliker($_POST, $idcom);
		}
		
		// Nombre de chapitres
		$req = $idcom->prepare('SELECT COUNT(*) as nb_chapter FROM chapter WHERE id_story = :id_story');
		$req->bindValue(':id_story', $chapter['id_story'], PDO::PARAM_INT);
		$req->execute();
		$chapter['nb_chapter'] = $req->fetch()['nb_chapter'];

		// Chapitre précédant
		$req = $idcom->prepare('SELECT id FROM chapter WHERE id_story = :id_story AND chapitre = :chapitre');
		$req->bindValue(':id_story', $chapter['id_story'], PDO::PARAM_INT);
		$req->bindValue(':chapitre', $chapter['chapitre']-1, PDO::PARAM_INT);
		$req->execute();
		$chapter['prev_chapter'] = $req->fetch()['id'];

		// Chapitre suivant
		$req = $idcom->prepare('SELECT id FROM chapter WHERE id_story = :id_story AND chapitre = :chapitre');
		$req->bindValue(':id_story', $chapter['id_story'], PDO::PARAM_INT);
		$req->bindValue(':chapitre', $chapter['chapitre']+1, PDO::PARAM_INT);
		$req->execute();
		$chapter['next_chapter'] = $req->fetch()['id'];

		// Nombre de suivis
		$req = $idcom->prepare('SELECT COUNT(*) as nb_suivi FROM bulles_suivies WHERE id_story = :id_story');
		$req->bindValue(':id_story', $chapter['id_story'], PDO::PARAM_INT);
		$req->execute();
		$chapter['nb_suivi'] = $req->fetch()['nb_suivi'];
		
		// Histoire suivie ?
		$req = $idcom->prepare('SELECT 1 FROM bulles_suivies WHERE id_story = :id_story AND id_user = :id_user');
		$req->bindValue(':id_story', $chapter['id_story'], PDO::PARAM_INT);
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();
		if($req->fetch() !== false) $chapter['suivi'] = true;
		else $chapter['suivi'] = false;

		// Genres
		$req = $idcom->prepare('SELECT genre.id as id, genre FROM genre, story_genre WHERE id_story = :id_story AND id_genre = genre.id');
		$req->bindValue(':id_story', $chapter['id_story'], PDO::PARAM_INT);
		$req->execute();
		$chapter['genre'] = array();
		while($g = $req->fetch())
			$chapter['genre'][] = $g['genre'];

		// Avatar et rôle de l'utilisateur
		$req = $idcom->prepare('SELECT avatar, role FROM user WHERE id = :id_user');
		$req->bindValue(':id_user', $_SESSION['id'], PDO::PARAM_INT);
		$req->execute();
		$user = $req->fetch();
		$avatar = $user['avatar'];
		$role = $user['role'];

		// Liste des commentaires
		$req = $idcom->prepare('SELECT user.id as id_user, comment.id as id_comment, avatar, firstname, lastname, comment, comment_date FROM comment, user WHERE id_chapter = :id_chapter AND id_user = user.id ORDER BY comment_date DESC');
		$req->bindValue(':id_chapter', $chapter['id_chapter'], PDO::PARAM_INT);
		$req->execute();
		$chapter['comments'] = $req->fetchAll();
		
		$page = 'Chapitre';
		$titre = 'BubbleBoost - '.$chapter['story_title'].' (Chapitre '.$chapter['chapitre'].')';
	}
	else
		header('location: index.php');
}

include 'assets/include/header.php';
?>


<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">
			
			<div class="columns">
				<div class="column is-one-quarter cover_chapter">
					<img src="assets/images/story/<?php echo $chapter['id_story']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover']; ?>" class="cover_story" />
				</div>
				<div class="column">
					<h1 class="mb-0"><a href="histoire.php?id=<?php echo $chapter['id_story']; ?>"><?php echo $chapter['story_title']; ?></a></h1>
					<h2 class="mt-1 mb-4 author_story">par <a href="profil.php?id=<?php echo $chapter['id_user']; ?>"><?php echo $chapter['firstname'].' '.$chapter['lastname']; ?></a></h2>
					<p><strong><?php echo $chapter['nb_suivi']; ?> personne<?php echo $chapter['nb_suivi']>1?'s':''; ?></strong> <?php echo $chapter['nb_suivi']>1?'suivent':'suit'; ?> cette histoire</p>
					<p><strong>Genre<?php echo count($chapter['genre'])>1?'s':''; ?> :</strong> <?php echo implode($chapter['genre'], ', '); ?></p>
					<p><strong>Nombre de chapitres :</strong> <?php echo $chapter['nb_chapter']; ?></p>
					<p><strong>Date de publication :</strong> <?php echo strftime("%d/%m/%G", strtotime($chapter['publication_date'])); ?></p>
					<?php if($chapter['id_user'] == $_SESSION['id']) { ?>
						<div class="buttons has-addons is-right">
							<button class="button is-dark" id="modal-supprimer"><span class="icon"><i class="fa fa-trash"></i></span><span>Supprimer le chapitre</span></button>
						</div>
					<?php } else { ?>
						<form method="POST" action="chapitre.php?id=<?php echo $chapter['id_chapter']; ?>">
							<div class="buttons has-addons is-right">
								<?php if($chapter['suivi'] == false) { ?>
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

			<h3>Chapitre <?php echo $chapter['chapitre']; ?><?php echo $chapter['chapter_title']?' : '.$chapter['chapter_title']:''; ?></h3>
			<div class="columns slideshow-container">
				<div class="column is-1"><a class="prev" onclick="plusSlides(-1)">&#10094;</a></div>
				<div class="column">
					<?php 
					$iterator = 1;
					$items = array_slice(glob('assets/images/story/'.$chapter['id_story'].'/'.$chapter['chapitre'].'/[0-9]*.*'), 0);
					natsort($items);
					foreach ($items as $fichier) 
					{ 
						?>
						<div class="mySlides">
							<div class="numbertext"><?php echo $iterator++; ?> / <?php echo count($items); ?></div>
							<img src="<?php echo $fichier; ?>" class="cover_story" />
						</div>
						<?php 
					} 
					?>
				</div>
				<div class="column is-1"><a class="next" onclick="plusSlides(1)">&#10095;</a></div>
			</div>
			<div class="buttons has-addons is-centered">
				<a class="button is-dark mx-2"<?php echo $chapter['prev_chapter']?' href="chapitre.php?id='.$chapter['prev_chapter'].'"':' disabled'; ?>>
					<span class="icon is-small">
						<i class="fas fa-arrow-left"></i>
					</span>
					<span>Chapitre précédant</span>
				</a>
				<a class="button is-dark mx-2"<?php echo $chapter['next_chapter']?' href="chapitre.php?id='.$chapter['next_chapter'].'"':' disabled'; ?>>
					<span>Chapitre suivant</span>
					<span class="icon is-small">
						<i class="fas fa-arrow-right"></i>
					</span>
				</a>
			</div>

			<hr>

			<h3>Les commentaires</h3>
			<article class="media">
				<figure class="media-left">
					<p class="image is-64x64">
						<img src="assets/images/avatar/<?php echo $avatar; ?>">
					</p>
				</figure>
				<div class="media-content">
					<form method="POST" action="chapitre.php?id=<?php echo $chapter['id_chapter']; ?>">
						<div class="field">
							<p class="control">
								<textarea class="textarea" name="commentaire" placeholder="Rédigez votre commentaire..."></textarea>
							</p>
						</div>
						<div class="buttons has-addons is-right">
							<button class="button is-dark is-rounded" name="commenter">Poster</button>
						</div>
					</form>
				</div>
			</article>
			<?php foreach($chapter['comments'] as $comment) { ?>
				<article class="media">
					<figure class="media-left">
						<p class="image is-64x64">
							<img src="assets/images/avatar/<?php echo $comment['avatar']; ?>">
						</p>
					</figure>
					<div class="media-content">
						<div>
							<nav class="level mb-0">
								<div class="level-left">
									<div class="level-item">
										<strong><a href="profil.php?id=<?php echo $comment['id_user']; ?>"><?php echo $comment['firstname'].' '.$comment['lastname']; ?></a></strong>
									</div>
									<div class="level-item">
										<small><?php echo strftime("%d/%m/%G %H:%M", strtotime($comment['comment_date'])); ?></small>
									</div>
								</div>
								<div class="level-right">
									<div class="level-item">
										<div class="dropdown is-hoverable is-right">
											<div class="dropdown-trigger">
												<button class="button dropdown-button" aria-haspopup="true" aria-controls="dropdown-menu">
													<span class="icon is-small">
														<i class="fas fa-ellipsis-h" aria-hidden="true"></i>
													</span>
												</button>
											</div>
											<div class="dropdown-menu" role="menu">
												<div class="dropdown-content">
													<?php if($_SESSION['id'] != $comment['id_user']) { ?>
														<button class="button dropdown-item">
															<span class="icon"><i class="fas fa-exclamation-triangle"></i></span><span>Signaler</span>
														</button>
													<?php } ?>
													<?php if($role == "admin" OR $_SESSION['id'] == $comment['id_user']) { ?>
														<form method="POST" action="chapitre.php?id=<?php echo $chapter['id_chapter']; ?>">
															<button class="button dropdown-item" name="supprimer" value="<?php echo $comment['id_comment']; ?>">
																<span class="icon"><i class="fas fa-trash"></i></span><span>Supprimer</span>
															</button>
														</form>
													<?php } ?>
												</div>
											</div>
										</div>

									</div>
								</div>
							</nav>
							<p><?php echo $comment['comment']; ?></p>
						</div>
					</div>
				</article>
			<?php } ?>
		</div>
	</div>
</div>

<!-- Modal pour supprimer un chapitre -->
<div class="modal modal-supprimer-chapitre">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">Supprimer un chapitre</p>
			<button class="delete close-modal" aria-label="close"></button>
		</header>
		<section class="modal-card-body">
			<form method="POST" enctype="multipart/form-data" action="chapitre.php?id=<?php echo $chapter['id_chapter']; ?>">
				<p>Êtes-vous sûr de vouloir supprimer ce chapître ? Cela entraînera la suppression de tous ses commentaires.</p>
				<div class="field is-grouped is-grouped-centered">
					<p class="control">
						<button class="button is-danger" name="supprimer-chapitre"><span class="icon"><i class="fa fa-minus-square"></i></span><span>Supprimer ce chapitre</span></button>
					</p>
				</div>
			</form>
		</section>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>