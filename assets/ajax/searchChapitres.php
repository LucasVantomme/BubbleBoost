<?php
require("../include/bdd-connect.php");

if(isset($_POST['recherche']) && !empty($_POST['recherche']))
{
	$recherche = '%'.$_POST['recherche'].'%';
	$req = $idcom->prepare('SELECT *, chapter.cover as cover_chapter, chapter.id as id_chapter, story.title as title_story, chapter.title as title_chapter FROM chapter, story WHERE id_story=story.id AND (UPPER(story.title) LIKE UPPER(:recherche) OR UPPER(chapter.title) LIKE UPPER(:recherche)) ORDER BY story.title, chapter.title LIMIT 15');
	$req->bindValue(':recherche', $recherche, PDO::PARAM_STR);
	$req->execute();
	$chapters = $req->fetchAll();

	if(empty($chapters))
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
			foreach($chapters as $chapter)
			{
				?>
				<div class="column is-one-fifth cover_chapter">
					<a href="chapitre.php?id=<?php echo $chapter['id_chapter']; ?>">
						<img class="mb-1" src="assets/images/story/<?php echo $chapter['id_story']; ?>/<?php echo $chapter['chapitre']; ?>/<?php echo $chapter['cover_chapter']; ?>" />
						<p class="mb-0 small"><b><?php echo $chapter['title_story']; ?></b> - Chapitre <?php echo $chapter['chapitre']; ?></p>
						<?php echo $chapter['title_chapter']?'<p class="mb-0 small">'.$chapter['title_chapter'].'</p>':''; ?>
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