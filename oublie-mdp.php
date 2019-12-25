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
	<div class="container">
		<div class="row">
			<div class="col-12 titre">
				<h1>Mot de passe oublié</h1>
			</div>
		</div>
		<?php if(isset($result_oubliemdp)) { ?>
			<div class="row">
				<?php echo $result_oubliemdp[1]; ?>
			</div>
		<?php } ?>
		<form method="POST" action="oublie-mdp.php">
			<div class="row">
				<div class="field">
					<p class="control has-icons-left">
						<input class="input" type="text" name="email" placeholder="Adresse e-mail" />
						<span class="icon is-small is-left">
							<i class="fas fa-envelope"></i>
						</span>
					</p>
				</div>
			</div>
			<div class="row mt-2">
				<div class="field">
					<div class="control">
						<button class="button is-link is-rounded" name="oubliemdp">Envoyer</button>
					</div>
				</div>
			</div>
		</form>
	</div>

<?php 
}
else {
	if(isset($_POST['oubliemdp'])) {
		$result_oubliemdp = form_oubliemdp2($_POST, $idcom);
		if($result_oubliemdp[0]) unset($_POST);
	}
	?>
	<div class="container">
		<div class="row">
			<div class="col-12 titre">
				<h1>Réinitialisation du mot de passe</h1>
			</div>
		</div>
		<?php if(isset($result_oubliemdp)) { ?>
			<div class="row">
				<?php echo $result_oubliemdp[1]; ?>
			</div>
		<?php } ?>
		<form method="POST" action="oublie-mdp.php?keyuniq=<?php echo $_GET['keyuniq']; ?>">
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
			<div class="row">
				<div class="field">
					<p class="control has-icons-left">
						<input class="input" type="password" name="password2" placeholder="Confirmation mot de passe" />
						<span class="icon is-small is-left">
							<i class="fas fa-lock"></i>
						</span>
					</p>
				</div>
			</div>
			<div class="row mt-2">
				<div class="field">
					<div class="control">
						<button class="button is-link is-rounded" name="oubliemdp">Réinitialiser</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php
}
?>

<?php include 'assets/include/footer.php'; ?>