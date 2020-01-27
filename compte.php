<?php 
include 'assets/include/bdd-connect.php';
include 'assets/include/fonctions.php';

if(!isset($_GET['id']))
{
	$page = 'Compte';
	$titre = 'BubbleBoost - Mon compte';
	$user_id = $_SESSION['id'];

	if(isset($_POST['updateInformations'])) {
		$result_updateInformations = form_updateInformations($_POST, $idcom);
		if($result_updateInformations[0]) unset($_POST);
	}
    if(isset($_POST['sendNewMail'])) {
        $result_sendNewMail = form_sendNewMail($_POST, $idcom);
        if($result_sendNewMail[0]) unset($_POST);
    }
    if(isset($_POST['sendNewPassword'])) {
        $result_sendNewPassword = form_sendNewPassword($_POST, $idcom);
        if($result_sendNewPassword[0]) unset($_POST);
    }
}
else {
	header('location: profil.php');
}

// On prend les informations concernant l'utilisateur
$req = $idcom->prepare('SELECT * FROM user WHERE id=:id');
$req->bindValue(':id', $user_id, PDO::PARAM_INT);
$req->execute();
$user = $req->fetch();

include 'assets/include/header.php';
?>



<div class="my-profile">
	<h1 class="mb-0">Mon compte</h1>
    <hr class="barre">

    <div class="informations formulaire">
        <h3>Editer mes informations</h3>

        <?php if(isset($result_updateInformations)) { ?>
            <p>
                <?php echo $result_updateInformations[1]; ?>
            </p>
        <?php } ?>

        <form method="POST" action="compte.php">
            <div class="field">
                <label for="label">Nom</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="lastname" placeholder="Nom" value="<?php echo isset($_POST['lastname'])?$_POST['lastname']:$user['lastname']; ?>" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Prénom</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="firstname" placeholder="Prénom" value="<?php echo isset($_POST['firstname'])?$_POST['firstname']:$user['firstname']; ?>" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Pseudo</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="username" placeholder="Pseudo" value="<?php echo isset($_POST['username'])?$_POST['username']:$user['username']; ?>" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Date de naissance</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="birthday" placeholder="Date de naissance (JJ/MM/YYYY)" value="<?php echo isset($_POST['birthday'])?$_POST['birthday']:strftime("%d/%m/%G", strtotime($user['birthday_date'])); ?>" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-calendar"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Numéro de téléphone</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="phone" placeholder="Téléphone" value="<?php echo isset($_POST['phone'])?$_POST['phone']:$user['phone']; ?>" />
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
                            <?php
                            $regions = array("FRANCE" => "France", "BELGIQUE" => "Belgique", "SUISSE" => "Suisse", "PAYS-BAS" => "Pays-Bas");
                            foreach($regions as $key => $value)
                            {
                                ?>
                                <option value="<?php echo $key; ?>" <?php echo isset($_POST['country'])?(($_POST['country'] == $key)?'selected="selected"':''):(($user['country'] == $key)?'selected="selected"':'');
                                ?> >
                                <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </span>
                    <span class="icon is-small is-left">
                        <i class="fas fa-globe"></i>
                    </span>
                </p>
            </div>
            <div class="field">
                <label for="label">Ajouter un lien Tipeee sur ma page</label>
                <p class="control has-icons-left">
                    <input class="input" type="text" name="tipeee" placeholder="Lien Tipeee" value="<?php echo isset($_POST['tipeee'])?$_POST['tipeee']:$user['tipeee']; ?>" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-money-check-alt"></i>
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

    <hr class="barre">

    <div class="mail formulaire">
        <h3>Changer de mail</h3>

        <?php if(isset($result_sendNewMail)) { ?>
            <p>
                <?php echo $result_sendNewMail[1]; ?>
            </p>
        <?php } ?>

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
                    <input class="input" type="email" name="mail" placeholder="Adresse e-mail" value="<?php echo isset($_POST['mail'])?$_POST['mail']:$user['mail']; ?>" />
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

    <hr class="barre">

    <div class="password formulaire">
        <h3>Changer de mot de passe</h3>

        <?php if(isset($result_sendNewPassword)) { ?>
            <p>
                <?php echo $result_sendNewPassword[1]; ?>
            </p>
        <?php } ?>

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
                    <button class="button is-link is-rounded" name="sendNewPassword">Confirmer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'assets/include/footer.php'; ?>