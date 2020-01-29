<?php
require("../include/bdd-connect.php");

if(isset($_POST['recherche']) && !empty($_POST['recherche']))
{
	$recherche = '%'.$_POST['recherche'].'%';
	$req = $idcom->prepare('SELECT * FROM story WHERE UPPER(title) LIKE UPPER(:recherche) ORDER BY title LIMIT 15');
	$req->bindValue(':recherche', $recherche, PDO::PARAM_STR);
	$req->execute();
	$stories = $req->fetchAll();

	if(empty($stories))
	{
		?>
		Aucun résultat...
		<?php
	}
	else
	{
		?>
		<div class="columns is-multiline">
			<?php
			foreach($stories as $story)
			{
				?>
				<div class="column is-one-fifth cover_chapter">
					<a href="histoire.php?id=<?php echo $story['id']; ?>">
						<img class="mb-1" src="assets/images/story/<?php echo $story['id']; ?>/<?php echo $story['cover']; ?>" />
						<p class="mb-0 small"><b><?php echo $story['title']; ?></b></p>
					</a>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}
?>