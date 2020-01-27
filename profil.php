<?php 
include 'assets/include/bdd-connect.php';
include 'assets/include/fonctions.php';

$page = 'Profil';
if(!isset($_GET['id']) OR $_GET['id'] == $_SESSION['id'])
{
    $connected = true;
    $user_id = $_SESSION['id'];

    if(isset($_POST['changer-avatar'])) {
        $result_publier_histoire = form_changer_avatar($_FILES, $idcom);
        if($result_publier_histoire[0]) {
            unset($_POST);
            //header('location: profil.php');
        }
    }
}
else {
    $connected = false;
    $user_id = $_GET['id'];
}

// On prend les informations concernant l'utilisateur
$req = $idcom->prepare('SELECT * FROM user WHERE id=:id');
$req->bindValue(':id', $user_id, PDO::PARAM_INT);
$req->execute();
if($user = $req->fetch()) {

    // Liste de ses histoires
    $req = $idcom->prepare('SELECT *, (SELECT COUNT(*) FROM chapter WHERE id_story = story.id) as nb_chapters FROM story WHERE id_user = :id_user ORDER BY title');
    $req->bindValue(':id_user', $user['id'], PDO::PARAM_INT);
    $req->execute();
    $user['story'] = $req->fetchAll();

    // Liste de ses suivis
    $req = $idcom->prepare('SELECT *, (SELECT COUNT(*) FROM chapter WHERE id_story = story.id) as nb_chapters FROM bulles_suivies, story WHERE bulles_suivies.id_user = :id_user AND id_story = story.id');
    $req->bindValue(':id_user', $user['id'], PDO::PARAM_INT);
    $req->execute();
    $user['suivis'] = $req->fetchAll();

    // Liste des commentaires
    $req = $idcom->prepare('SELECT comment.id as id_comment, comment, comment_date, chapter.chapitre as chapitre, chapter.id as id_chapitre, story.title as title FROM comment, chapter, story WHERE comment.id_user = :id_user AND id_chapter = chapter.id AND id_story = story.id ORDER BY comment_date DESC');
    $req->bindValue(':id_user', $user['id'], PDO::PARAM_INT);
    $req->execute();
    $user['comments'] = $req->fetchAll();
    
    if(!$connected)
        $titre = 'BubbleBoost - Profil de '.$user['firstname'].' '.$user['lastname'];
    else
        $titre = 'BubbleBoost - Mon Profil';
}
else
    header('location: profil.php');

include 'assets/include/header.php';
?>

<?php
if(isset($result_publier_histoire[1]))
    echo $result_publier_histoire[1];
?>

<div class="row profil">
    <div class="col-4">
        <img src="assets/images/avatar/<?php echo $user['avatar']; ?>" alt="Avatar de  <?php echo $user['firstname'].' '.$user['lastname']; ?>" class="img-thumbnail">
        <button type="button" id="modal-avatar" class="btn btn-info">Changer de photo</button>
    </div>
    <div class="col-8">
        <h1><?php echo $user['firstname'].' '.$user['lastname']; ?></h1>
        <p><i>Membre depuis le <?php echo strftime("%d/%m/%G", strtotime($user['registration_date'])); ?></i></p>
        <div class="profil_infos">
            <p>Suit <?php echo count($user['suivis'])>1?count($user['suivis']).' histoires':count($user['suivis']).' histoire'; ?> actuellement</p>
            <p>A publié <?php echo count($user['story'])>1?count($user['story']).' histoires':count($user['story']).' histoire'; ?></p>
            <button type="button" class="btn btn-info">Modifier mes informations</button>
        </div> 
    </div>
</div>

<h2>Histoires suivies</h2>
<div class="row liste_histoires px-4">
    <?php
    if(empty($user['suivis']))
    {
        ?>
        <strong>Aucune histoire suivie</strong>
        <?php
    }
    else
    {
        foreach($user['suivis'] as $story)
        {
            ?>
            <div class="col-6">
                <a href="histoire.php?id=<?php echo $story['id']; ?>"> 
                    <div>
                        <img src="assets/images/story/<?php echo $story['id']; ?>/<?php echo $story['cover']; ?>" alt="Cover de l'histoire : <?php echo $story['title']; ?>" class="img-thumbnail">
                        <div class="bulles_content">
                            <h5><?php echo $story['title']; ?></h5>
                            <p>Publiée le <?php echo strftime("%d/%m/%G", strtotime($story['publication_date'])); ?></p>
                            <p><strong><?php echo $story['nb_chapters']; ?> chapitres</strong></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
    }
    ?>
</div>

<h2>Histoires rédigées</h2>
<div class="row liste_histoires px-4"> 
    <?php
    if(empty($user['story']))
    {
        ?>
        <strong>Aucune histoire suivie</strong>
        <?php
    }
    else
    {
        foreach($user['story'] as $story)
        {
            ?>
            <div class="col-6">
                <a href="histoire.php?id=<?php echo $story['id']; ?>"> 
                    <div>
                        <img src="assets/images/story/<?php echo $story['id']; ?>/<?php echo $story['cover']; ?>" alt="Cover de l'histoire : <?php echo $story['title']; ?>" class="img-thumbnail">
                        <div class="bulles_content">
                            <h5><?php echo $story['title']; ?></h5>
                            <p>Publiée le <?php echo strftime("%d/%m/%G", strtotime($story['publication_date'])); ?></p>
                            <p><strong><?php echo $story['nb_chapters']; ?> chapitres</strong></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
    }
    ?>
</div>

<h2>Commentaires</h2>
<?php 
foreach($user['comments'] as $comment) 
{ 
    ?>
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
                <img src="assets/images/avatar/<?php echo $user['avatar']; ?>">
            </p>
        </figure>
        <div class="media-content">
            <div>
                <nav class="level mb-0">
                    <div class="level-left">
                        <div class="level-item">
                            <strong><?php echo $user['firstname'].' '.$user['lastname']; ?></strong>
                        </div>
                        <div class="level-item">
                            <small><?php echo strftime("%d/%m/%G %H:%M", strtotime($comment['comment_date'])); ?></small>
                        </div>
                    </div>
                </nav>
                <p><?php echo $comment['comment']; ?></p>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="chapitre.php?id=<?php echo $comment['id_chapitre']; ?>"><strong><?php echo $comment['title']; ?></strong> - Chapitre <?php echo $comment['chapitre']; ?></a>
                </div>
            </div>
        </div>
    </article>
    <?php 
}
?>

<?php
if($connected)
{
    ?>
    <!-- Modal pour changer de photo de profil -->
    <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Changer de photo de profil</p>
                <button class="delete close-modal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <form method="POST" enctype="multipart/form-data" action="profil.php">
                    <div class="field text-center">
                        <label for="avatar">Nouvelle photo (max : <?php echo ini_get('upload_max_filesize'); ?>) : </label>
                        <div class="file has-name is-boxed is-centered">
                            <label class="file-label" id="user-file">
                                <input class="file-input" type="file" name="avatar" accept="image/*" required>
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Choisir un fichier
                                    </span>
                                </span>
                                <span class="file-name">
                                    Aucun fichier...
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="field is-grouped is-grouped-centered">
                        <p class="control">
                            <button class="button is-dark" name="changer-avatar"><span class="icon"><i class="fa fa-plus-square"></i></span><span>Changer la photo</span></button>
                        </p>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <?php
}
?>

<?php include 'assets/include/footer.php'; ?>