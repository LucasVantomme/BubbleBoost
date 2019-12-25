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

<div class="container">
	<div class="row">
		<div class="col-12 titre">
			<h1>Connexion</h1>
		</div>
	</div>
	<?php if(isset($result_connexion)) { ?>
	<div class="row">
		<?php echo $result_connexion[1]; ?>
	</div>
	<?php } ?>
	<form method="POST" action="connexion.php">
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="text" name="identifiant" placeholder="Pseudo ou Adresse e-mail" />
					<span class="icon is-small is-left">
						<i class="fas fa-user"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="password" name="password" placeholder="Mot de passe" />
					<span class="icon is-small is-left">
						<i class="fas fa-lock"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row mt-2">
			<div class="field">
				<div class="control">
					<button class="button is-link is-rounded" name="connexion">Se connecter</button>
				</div>
			</div>
		</div>
	</form>
</div>

<?php include 'assets/include/footer.php'; ?>