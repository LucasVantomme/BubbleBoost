<?php 
$page = 'Connexion';
$titre = 'BubbleBoost - Se connecter';
include 'assets/include/header.php'; 

?>

<?php
if(isset($_POST['connexion'])) {
	$result_connexion = form_connexion($_POST, $idcom);
	if($result_connexion[0]) unset($_POST);
}
?>


<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">
			<div class="columns is-mobile">
  				<div class="column is-half is-offset-one-quarter">
					<p class="title">Connexion</p>
					<?php if(isset($result_connexion)) { ?>
					<div class="row">
						<?php echo $result_connexion[1]; ?>
					</div>
					<?php } ?>
					<form method="POST" action="connexion.php">
						<div class="field">
							<label for="label">Pseudo</label>
							<p class="control has-icons-left has-icons-right">
								<input class="input" type="text" name="identifiant" placeholder="Pseudo ou Adresse e-mail" />
								<span class="icon is-small is-left">
									<i class="fas fa-envelope"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Mot de passe</label>
							<p class="control has-icons-left">
								<input class="input" type="password" name="password" placeholder="Mot de passe" />
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
							</p>
						</div>
						<div class="field is-grouped is-grouped-centered">
							<p class="control">
								<button class="button is-link is-rounded" name="connexion">Se connecter</button>
							</p>
						</div>
						<div class="field">
							<p class="has-text-right">
								<a href="inscription.php">Pas encore inscrit ?</a>
							</p>
							<p class="has-text-right">
								<a href="oublie-mdp.php">Mot de passe oublié</a>
							</p>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'assets/include/footer.php'; ?>