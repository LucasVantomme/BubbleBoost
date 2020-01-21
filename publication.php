<?php 
include 'assets/include/bdd-connect.php';
include 'assets/include/fonctions.php';

if(!isset($_GET['id']) OR $_GET['id'] == $_SESSION['id'])
{
	$page = 'Publications';
	$titre = 'Mes publications';
	$connected = true;
	$user_id = $_SESSION['id'];

	if(isset($_POST['publier-histoire'])) {
		$result_publier_histoire = form_publier_histoire($_POST, $_FILES, $idcom);
		if($result_publier_histoire[0]) unset($_POST);
	}
}
else {
	$connected = false;
	$user_id = $_GET['id'];
}

// On prend les informations concernant l'utilisateur
$req = $idcom->prepare('SELECT id, firstname, lastname, username FROM user WHERE id=:id');
$req->bindValue(':id', $user_id, PDO::PARAM_INT);
$req->execute();
if($user = $req->fetch()) {

	// Liste de ses histoires
	$req = $idcom->prepare('SELECT * FROM story WHERE id_user = :id_user ORDER BY title');
	$req->bindValue(':id_user', $user['id'], PDO::PARAM_INT);
	$req->execute();
	$story = $req->fetchAll();
	
	$page = 'Publications';
	$titre = 'Publications - '.$user['firstname'].' '.$user['lastname'];

}
else
	header('location: publication.php');

include 'assets/include/header.php';
?>



<!-- Style à mettre ensuite dans le .css -->
<style>
	.author { font-size: medium!important; margin-left: 50px; }
	.cover_chapter { text-align: center; }
	.cover_chapter img { width: 75%; border: 1px solid black; }
</style>



<div class="my-publications">
	<h1 class="mb-0">Publications</h1>
	<h2 class="mt-1 mb-4 author">de <a href="profil?id=<?php echo $user['id']; ?>"><?php echo $user['firstname'].' '.$user['lastname']; ?></a> <?php echo $connected?'(moi)':''; ?></h2>

	<?php
	if(isset($result_publier_histoire[1]))
		echo $result_publier_histoire[1];
	?>
	
	<?php
	if(empty($story))
	{
		?>
		<div class="histoire">
			Aucune histoire...
		</div>
		<?php
	}
	foreach($story as &$s)
	{
		// On récupère la liste des chapitres
		$req = $idcom->prepare('SELECT * FROM chapter WHERE id_story = :id_story');
		$req->bindValue(':id_story', $s['id'], PDO::PARAM_INT);
		$req->execute();
		$s['chapters'] = $req->fetchAll();
		?>
		<hr>
		<div class="histoire">
			<h3><a href="histoire.php?id=<?php echo $s['id']; ?>"><?php echo $s['title']; ?></a></h3>
			<div class="columns is-multiline">
				<?php 
				if(empty($s['chapters']))
				{
					?>
					Aucun chapitre...
					<?php
				}
				else
				{
					foreach($s['chapters'] as $chapter) 
					{ 
						?>
						<div class="column is-one-fifth cover_chapter">
							<a href="chapitre.php?id=<?php echo $chapter['id']; ?>">
								<img class="mb-1" src="assets/images/story/<?php echo $s['id']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover']; ?>" />
								<p class="mb-0">Chapitre <?php echo $chapter['chapitre']; ?></p>
								<?php echo $chapter['title']?'<p class="mb-0"><small><b>'.$chapter['title'].'</b></small></p>':''; ?>
							</a>
						</div>
						<?php 
					}
				} 
				?>
			</div>
			<?php if($connected) { ?>
				<div class="buttons has-addons is-right">
					<button class="button is-dark"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Publier un nouveau chapitre</span></button>
				</div>
			<?php } ?>
		</div>
		<?php
	}   
	?>

	<?php if($connected) { ?>
		<hr>
		<div class="buttons has-addons is-centered">
			<button class="button is-dark" id="modal-histoire"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Publier une nouvelle histoire</span></button>
		</div>
	<?php } ?>
</div>

<!-- Modal pour publier une nouvelle histoire -->
<div class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">Publier une nouvelle histoire</p>
			<button class="delete close-modal" aria-label="close"></button>
		</header>
		<section class="modal-card-body">
			<form method="POST" enctype="multipart/form-data" action="publication.php">
				<div class="field">
					<label for="titre">Titre : </label>
					<p class="control">
						<input class="input" type="text" name="titre" placeholder="Titre de l'histoire" required />
					</p>
				</div>
				<div class="field">
					<label for="synopsis">Synopsis : </label>
					<div class="control">
						<textarea class="textarea" name="synopsis" placeholder="Synopsis de l'histoire" rows="2" required></textarea>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field text-center">
							<div class="select is-multiple">
								<label for="genres[]">Genres : </label>
								<select multiple size="4" name="genres[]" required>
									<?php
									$req = $idcom->prepare('SELECT * FROM genre');
									$req->execute();
									while($genre = $req->fetch()) {
										?>
										<option value="<?php echo $genre['id']; ?>"><?php echo $genre['genre']; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="column">
						<div class="field text-center">
							<label for="couverture">Image de couverture (max : <?php echo ini_get('upload_max_filesize'); ?>) : </label>
							<div class="file has-name is-boxed is-centered">
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
					</div>
				</div>
				<div class="field is-grouped is-grouped-centered">
					<p class="control">
						<button class="button is-dark" name="publier-histoire"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Publier l'histoire</span></button>
					</p>
				</div>
			</form>
		</section>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>