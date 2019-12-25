<?php 
$page = 'Inscription';
$titre = 'BubbleBoost - S\'inscrire';
include 'assets/include/header.php';
?>

<?php
if(isset($_POST['inscription'])) {
	$result_inscription = form_inscription($_POST, $idcom);
	if($result_inscription[0]) unset($_POST);
}
?>

<div class="container">
	<div class="row">
		<div class="col-12 titre">
			<h1>Inscription</h1>
		</div>
	</div>
	<?php if(isset($result_inscription)) { ?>
	<div class="row">
		<?php echo $result_inscription[1]; ?>
	</div>
	<?php } ?>
	<form method="POST" action="inscription.php">
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="email" name="email" placeholder="Adresse e-mail" <?php echo isset($_POST['email'])?'value="'.$_POST['email'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-envelope"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="text" name="username" placeholder="Pseudo" <?php echo isset($_POST['username'])?'value="'.$_POST['username'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-user"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="text" name="lastname" placeholder="Nom de famille" <?php echo isset($_POST['lastname'])?'value="'.$_POST['lastname'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-user"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="text" name="firstname" placeholder="Prénom" <?php echo isset($_POST['firstname'])?'value="'.$_POST['firstname'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-user"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="text" name="birthday" placeholder="Date de naissance (JJ/MM/YYYY)" <?php echo isset($_POST['birthday'])?'value="'.$_POST['birthday'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-calendar"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="phone" name="phone" placeholder="Téléphone" <?php echo isset($_POST['phone'])?'value="'.$_POST['phone'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-phone"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="text" name="country" placeholder="Pays" <?php echo isset($_POST['country'])?'value="'.$_POST['country'].'"':''; ?> />
					<span class="icon is-small is-left">
						<i class="fas fa-country"></i>
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
		<div class="row">
			<div class="field">
				<p class="control has-icons-left">
					<input class="input" type="password" name="password2" placeholder="Confirmation du mot de passe" />
					<span class="icon is-small is-left">
						<i class="fas fa-lock"></i>
					</span>
				</p>
			</div>
		</div>
		<div class="row mt-2">
			<div class="field">
				<div class="control">
					<button class="button is-link is-rounded" name="inscription">S'inscrire</button>
				</div>
			</div>
		</div>
	</form>
</div>

<?php include 'assets/include/footer.php'; ?>