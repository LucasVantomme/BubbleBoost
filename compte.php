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



<div class="my-publications">
	<h1 class="mb-0">Mon compte</h1>
    <hr>

    <div class="informations formulaire">
        <h3>Editer mes informations</h3>

        <form method="POST" action="compte.php">
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
                <label for="label">Pseudo</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="username" placeholder="Pseudo" <?php echo isset($_POST['username'])?'value="'.$_POST['username'].'"':''; ?> />
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
            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link is-rounded" name="updateInformations">Modifier mes informations</button>
                </div>
            </div>
        </form>
    </div>
    
    <hr>

    <div class="mail formulaire">
        <h3>Changer de mail</h3>

        <form method="POST" action="compte.php">
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
                <label for="lable">Email</label>
                <p class="control has-icons-left">
                    <input class="input" type="email" name="email" placeholder="Adresse e-mail" <?php echo isset($_POST['email'])?'value="'.$_POST['email'].'"':''; ?> />
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </p>
            </div>
            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link is-rounded" name="sendNewMail">Envoyer</button>
                </div>
            </div>
        </form>
    </div>

    <hr>

    <div class="password formulaire">
        <h3>Changer de mot de passe</h3>

        <form method="POST" action="compte.php">
            <div class="field">
                <label for="label">Ancien mot de passe</label>
                <p class="control has-icons-left">
                    <input class="input" type="password" name="oldPassword" placeholder="Ancien mot de passe" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Nouveau mot de passe</label>
                <p class="control has-icons-left">
                    <input class="input" type="password" name="newPassword" placeholder="Nouveau mot de passe" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Confirmation du nouveau mot de passe</label>
                <p class="control has-icons-left">
                    <input class="input" type="password" name="confirmNewPassword" placeholder="Confirmation du nouveau mot de passe" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </p>
            </div>
            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button class="button is-link is-rounded" name="confirmNewPassword">Confirmer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'assets/include/footer.php'; ?>