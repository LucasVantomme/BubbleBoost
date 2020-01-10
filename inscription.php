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
<div class="tile is-ancestor">
	<div class="tile is-parent">
		<div class="tile is-child box">

			<div class="columns is-mobile">
				<div class="column is-half is-offset-one-quarter">

					<h1>Inscription</h1>
					<?php if(isset($result_inscription)) { ?>
					<p>
						<?php echo $result_inscription[1]; ?>
					</p>
					<?php } ?>
					<form method="POST" action="inscription.php">

						<div class="field">
							<label for="lable">Email</label>
							<p class="control has-icons-left">
								<input class="input" type="email" name="email" placeholder="Adresse e-mail" <?php echo isset($_POST['email'])?'value="'.$_POST['email'].'"':''; ?> />
								<span class="icon is-small is-left">
									<i class="fas fa-envelope"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Pseudo</label>
							<p class="control has-icons-left">
								<input class="input" type="text" name="username" placeholder="Pseudo" <?php echo isset($_POST['username'])?'value="'.$_POST['username'].'"':''; ?> />
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Nom</label>
							<p class="control has-icons-left">
								<input class="input" type="text" name="lastname" placeholder="Nom" <?php echo isset($_POST['lastname'])?'value="'.$_POST['lastname'].'"':''; ?> />
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Prénom</label>
							<p class="control has-icons-left">
								<input class="input" type="text" name="firstname" placeholder="Prénom" <?php echo isset($_POST['firstname'])?'value="'.$_POST['firstname'].'"':''; ?> />
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Date de naissance</label>
							<p class="control has-icons-left">
								<input class="input" type="text" name="birthday" placeholder="Date de naissance (JJ/MM/YYYY)" <?php echo isset($_POST['birthday'])?'value="'.$_POST['birthday'].'"':''; ?> />
								<span class="icon is-small is-left">
									<i class="fas fa-calendar"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Numéro de téléphone</label>
							<p class="control has-icons-left">
								<input class="input" type="phone" name="phone" placeholder="Téléphone" <?php echo isset($_POST['phone'])?'value="'.$_POST['phone'].'"':''; ?> />
								<span class="icon is-small is-left">
									<i class="fas fa-phone"></i>
								</span>
							</p>
						</div>
						<div class="field">
							<label for="label">Nationalité</label>
							<p class="control has-icons-left">
								<!--<input class="input" type="text" name="country" placeholder="Pays"/>-->
								<span class="select">
      								<select class="form-control" name="country" <?php echo isset($_POST['country'])?'value="'.$_POST['country'].'"':''; ?>>
        								<option value="FRANCE">France</option>
        								<option value="BELGIQUE">Belgique</option>
										<option value="SUISSE">Suisse</option>
										<option value="PAYS-BAS">Pays-Bas</option>
      								</select>
    							</span>
    							<span class="icon is-small is-left">
      								<i class="fas fa-globe"></i>
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
						<div class="field">
							<label for="label">Confirmation du mot de passe</label>
							<p class="control has-icons-left">
							<input class="input" type="password" name="password2" placeholder="Confirmation du mot de passe" />
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
							</p>
						</div>
						<div class="field is-grouped is-grouped-centered">
							<div class="control">
								<button class="button is-link is-rounded" name="inscription">S'inscrire</button>
							</div>
						</div>
						<div class="field">
							<p class="has-text-right">
								<a href="connexion.php">Déjà inscrit ?</a>
							</p>
						</div>

					</form>

				</div>
			</div>

		</div>
	</div>
</div>

<?php include 'assets/include/footer.php'; ?>