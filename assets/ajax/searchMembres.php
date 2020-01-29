<?php
require("../include/bdd-connect.php");

if(isset($_POST['recherche']) && !empty($_POST['recherche']))
{
	$recherche = '%'.$_POST['recherche'].'%';
	$req = $idcom->prepare('SELECT * FROM user WHERE UPPER(firstname) LIKE UPPER(:recherche) OR UPPER(lastname) LIKE UPPER(:recherche) OR UPPER(username) LIKE UPPER(:recherche) OR UPPER(CONCAT_WS(\' \', firstname, lastname, username)) LIKE UPPER(:recherche) OR UPPER(CONCAT_WS(\' \', lastname, firstname, username)) LIKE UPPER(:recherche) OR UPPER(CONCAT_WS(\' \', username, firstname, lastname)) LIKE UPPER(:recherche) OR UPPER(CONCAT_WS(\' \', username, lastname, firstname)) LIKE UPPER(:recherche) ORDER BY firstname, lastname, username LIMIT 10');
	$req->bindValue(':recherche', $recherche, PDO::PARAM_STR);
	$req->execute();
	$users = $req->fetchAll();

	if(empty($users))
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
			foreach($users as $user)
			{
				?>
				<div class="column is-one-fifth cover_chapter">
					<a href="profil.php?id=<?php echo $user['id']; ?>">
						<img class="mb-1" src="assets/images/avatar/<?php echo $user['avatar']; ?>" />
						<p class="mb-0 small"><b><?php echo $user['firstname'].' '.$user['lastname']; ?></b></p>
						<p class="mb-0 small"><b>(<?php echo $user['username']; ?>)</b></p>
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