<?php 
$page = 'Accueil';
$titre = 'BubbleBoost - Mes publications';
include '../assets/include/header-connect.php';

$displayModal = false;
$connected = true;
?>

<?php
if(isset($_POST['newStory'])) {
    $displayModal = true;
}

if(isset($_POST['closeNewStory'])) {
    $displayModal = false;
}

if(isset($_POST['createStory'])) {
    echo "<script> console.log('CREATE STORY');</script>";
}
?>

<div class="my-publications">
    <div class="title">
        <h2 class="title is-2"><?php echo ($connected == true) ? "Mes p" : "P"; ?>ublications</h2>
    </div>
    <?php echo ($connected == true) ? "" : "<p>de <span class='nameArtise'>ARTISTE</span></p>"; ?>
    <hr>

    <div class="histoire">
        <div class="histoire title">
            <h3 class="subtitle is-3">Histoire 1</h3>
        </div>
        <div class="histoire publications">
            <p>Liste publications</p>
            <div class="file is-boxed <?php echo ($connected == true) ? "" : "displayAddChapter"; ?>">
                <label class="file-label">
                    <input class="file-input" type="file" name="resume">
                    <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Ajouter un nouveau chapitre
                    </span>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <hr>

    <div class="histoire">
        <div class="histoire title">
            <h3 class="subtitle is-3">Histoire 2</h3>
        </div>
        <div class="histoire publications">
            <p>Liste publications</p>
            <div class="file is-boxed <?php echo ($connected == true) ? "" : "displayAddChapter"; ?>">
                <label class="file-label">
                    <input class="file-input" type="file" name="resume">
                    <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Ajouter un nouveau chapitre
                    </span>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <hr>

    <form method="POST" action="mes-publications.php">
        <div class="button-new-story">
            <?php echo ($connected == true) ? "<button class='button is-link is-rounded' name='newStory'>Créer une nouvelle bulle</button>" : ""; ?>
        </div>
    </form>
</div>

<div id="modal-ter" class="modal <?php echo ($displayModal == true) ? "is-active" : ""; ?>">
    <div class="modal-background"></div>
    <div class="modal-card">
        <form method="POST" action="mes-publications.php">
            <header class="modal-card-head">
                <p class="modal-card-title">Création d'une nouvelle histoire</p>
                <button class="delete" aria-label="close" name="closeNewStory"></button>
            </header>
            <section class="modal-card-body">
                <div class="contentModal">
                    <div class="field">
                        <label class="label">Titre</label>
                        <div class="control">
                            <input class="input" type="text">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Synopsis</label>
                        <div class="control">
                            <textarea class="textarea"></textarea>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Genre</label>
                        <div class="control">
                            <input class="input" type="text" placeholder="">
                        </div>
                    </div>
                    <div class="field">
                        <div class="file">
                            <label class="file-label">
                                <input class="file-input" type="file" name="resume">
                                <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Télécharger
                                </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            </section>
            <div class="modal-card-foot footerModal">
                <button class="button is-link is-rounded" name="createStory">Publier</button>
            </div>
        </form>
    </div>
</div>

<?php include '../assets/include/footer.php'; ?>