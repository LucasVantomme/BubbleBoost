<?php 
include 'assets/include/bdd-connect.php';
include 'assets/include/fonctions.php';

if(!isset($_GET['id']))
{
    $page = 'Notification';
    $titre = 'BubbleBoost - Mes Notifications';
    $user_id = $_SESSION['id'];

    if(isset($_POST['opennotif'])) {
        $result_opennotif = form_opennotif($_POST, $idcom);
        if($result_opennotif[0])
            header('location: '.$result_opennotif[1]);
        else
            unset($_POST);
    }
    if(isset($_POST['delnotif'])) {
        form_delnotif($_POST, $idcom);
        unset($_POST);
    }
}
else {
    header('location: notification.php');
}

// On prend les notifications de l'utilisateur
$req = $idcom->prepare('SELECT *, notification.id as notification_id FROM notification, user WHERE id_user_dest = :id AND id_user_exp = user.id AND open = 0 ORDER BY notification.id DESC');
$req->bindValue(':id', $user_id, PDO::PARAM_INT);
$req->execute();
$notifs = $req->fetchAll();

include 'assets/include/header.php';
?>



<div class="container">
    <p class="title">Mes notifications</p>
</div>

<hr>

<div class="container">

    <?php
    if(empty($notifs))
    {
        ?>
        <strong>Aucune notification.</strong>
        <?php
    }
    else
    {
        foreach($notifs as $notif)
        {
            ?>
            <div class="tile is-ancestor">
                <div class="tile is-parent">
                    <div class="tile is-child box">
                        <div class="columns">
                            <div class="column is-2 p-4">
                                <img src="assets/images/avatar/<?php echo $notif['avatar']; ?>">
                            </div>
                            <div class="column is-9 p-4">
                                <p class="title is-5 mb-0">
                                    <?php echo $notif['titre']; ?>
                                </p>
                                <p>
                                    <small><i><?php echo strftime("le %d/%m/%G à %H:%M:%S", strtotime($notif['notification_date'])); ?></i></small>
                                </p>
                                <p>
                                    <?php echo $notif['description']; ?>
                                </p>
                            </div>
                            <form action="notification.php" method="post" class="flex-center">
                                <button type="submit" name="opennotif" value="<?php echo $notif['notification_id']; ?>" class="btn-link">
                                    <div class="column">
                                        <img src="assets/images/arrow.png">
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="field is-grouped is-grouped-centered">
            <div class="control">
                <form method="POST" action="notification.php">
                    <button class="button is-info" name="delnotif">Tout effacer</button>
                </form>
            </div>
        </div>
        <?php
    }
    ?>

</div>

<?php include 'assets/include/footer.php'; ?>