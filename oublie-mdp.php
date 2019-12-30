<?php 
$page = 'Mot de passe oublié';
$titre = 'BubbleBoost - Mot de passe oublié';
include 'assets/include/header.php'; 
?>

<?php 
if(!isset($_GET['keyuniq']) OR empty($_GET['keyuniq']) OR $_GET['keyuniq'] == "NULL") {

	if(isset($_POST['oubliemdp'])) {
		$result_oubliemdp = form_oubliemdp1($_POST, $idcom);
		if($result_oubliemdp[0]) unset($_POST);
	}
?>
<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">

			<div class="columns is-mobile">
				<div class="column is-half is-offset-one-quarter">
					<p class="title">Mot de passe oublié</p>
					<?php if(isset($result_oubliemdp)) { ?>
					<div class="row">
						<?php echo $result_oubliemdp[1]; ?>
					</div>
					<?php } ?>
					<form method="POST" action="oublie-mdp.php">

						<div class="field">
							<p class="control has-icons-left">
								<input class="input" type="text" name="email" placeholder="Adresse e-mail" />
								<span class="icon is-small is-left">
									<i class="fas fa-envelope"></i>
								</span>
								Si vous êtes inscrit, un mail de réinitialisation de mot de passe sera envoyé sur votre boite.
							</p>
						</div>
						<div class="field is-grouped is-grouped-centered">
							<div class="control">
								<button class="button is-link is-rounded" name="oubliemdp">Envoyer</button>
							</div>
						</div>

					</form>
				</div>
			</div>

		</div>
	</div>
</div>
<?php 
}
else {
	if(isset($_POST['oubliemdp'])) {
		$result_oubliemdp = form_oubliemdp2($_POST, $idcom);
		if($result_oubliemdp[0]) unset($_POST);
	}
?>

<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">

			<div class="columns is-mobile">
				<div class="column is-half is-offset-one-quarter">	
					<p class="title">
						Réinitialisation du mot de passe
					</p>
					<?php if(isset($result_oubliemdp)) { ?>
					<div class="row">
						<?php echo $result_oubliemdp[1]; ?>
					</div>
					<?php } ?>
					<form method="POST" action="oublie-mdp.php?keyuniq=<?php echo $_GET['keyuniq']; ?>">
						<div class="field">
							<label for="label">Mot de passe</label>
							<p class="control has-icons-left">
								<input class="input" type="password" name="password" placeholder="Mot de passe" />
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Confirmation du mot de passe</label>
							<p class="control has-icons-left">
								<input class="input" type="password" name="password2" placeholder="Confirmation mot de passe" />
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
							</p>
						</div>
						<div class="field is-grouped is-grouped-centered">
							<div class="control">
								<button class="button is-link is-rounded" name="oubliemdp">Réinitialiser</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<?php include 'assets/include/footer.php'; ?>