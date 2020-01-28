<?php 
$page = 'Notification';
$titre = 'BubbleBoost - Notification';
include 'assets/include/header.php'; 
?>
<div class="container">
    <p class="title">Mes notifications</p>
</div>

<hr>

<div class="container">
<!--DEBUT DE LA NOTIF §§§§§§§§§§§§§§§§§§§§§§§§§§§ -->
    <div class="tile is-ancestor">
        <div class="tile is-parent">
            <div class="tile is-child box">
                <div class="columns">
                    <div class="column">
                    <figure class="image is-48x48">
                        <img src="https://bulma.io/images/placeholders/128x128.png">
                    </figure>
                    </div>
                    <div class="column is-three-quarters">
                        <p class="title is-5">
                            Titre de la notification
                        </p>
                        <p>
                            Description
                        </p>
                    </div>
                    <div class="column">
                        <figure class="image is-64x64">
                            <img src="assets/images/arrow.png">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--FIN DE LA NOTIF §§§§§§§§§§§§§§§§§§§§§§§§§§§ -->
</div>
<hr>
	
    <div class="field is-grouped is-grouped-centered">
		<div class="control">
			<button class="button is-info" name="inscription">Tout effacer</button>
		</div>
	</div>
<?php include 'assets/include/footer.php'; ?>