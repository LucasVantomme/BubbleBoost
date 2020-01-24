		</div>

		<footer>
			<div>
				<span class="text-muted">BubbleBoost 2019-2020</span>
			</div>
			<div>
				<div><a href="#">Conditions générales</a></div>
				<div>Contact : <a href="mailto:bubbleboost.help@gmail.com">bubbleboost.help@gmail.com</a></div>
			</div>
		</footer>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script type="text/javascript" src="assets/js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="assets/js/puzzleSlider.js"></script>
		<script type="text/javascript" src="assets/js/main.js"></script>
		<?php 
		if($page == 'Accueil' AND isset($_SESSION['id'])) {
			?>
			<script>
				var slideIndex = [1,1,1];
				var slideId = ["mySlides1", "mySlides2", "mySlides3"];
				showSlides(1, 0);
				showSlides(1, 1);
				showSlides(1, 2);

				function plusSlides(n, no) 
				{
					showSlides(slideIndex[no] += n, no);
				}

				function showSlides(n, no) 
				{
					var i;
					var x = document.getElementsByClassName(slideId[no]);
					if (n > x.length) 
					{
						slideIndex[no] = 1;
					}   
					if (n < 1) 
					{
						slideIndex[no] = x.length
					}
					for (i = 0; i < x.length; i++) 
					{
						x[i].style.display = "none";  
					}
					x[slideIndex[no]-1].style.display = "flex";  
				}
			</script>
			<?php
		}
		elseif($page == 'Chapitre') {
			?>
			<script>
				var slideIndex = 1;
				showSlides(slideIndex);

				function plusSlides(n) {
					var slides = document.getElementsByClassName("mySlides");
					if((n == -1 && slideIndex > 1) || (n == 1 && slideIndex < slides.length))
						showSlides(slideIndex += n);
				}

				function showSlides(n) {
					var i;
					var slides = document.getElementsByClassName("mySlides");
					if (n > slides.length) {slideIndex = 1}    
						if (n < 1) { slideIndex = slides.length; }
					for (i = 0; i < slides.length; i++) {
						slides[i].style.display = "none";  
					}
					slides[slideIndex-1].style.display = "block";
				}

				$("#modal-supprimer").click(function() {
					$(".modal-supprimer-chapitre").addClass("is-active");  
				});

				$(".close-modal").click(function() {
					$(".modal").removeClass("is-active");
				});
			</script>
			<?php
		}
		elseif($page == 'Publications') {
			?>
			<script>
				$("#modal-histoire").click(function() {
					$(".modal").addClass("is-active");  
				});

				$(".close-modal").click(function() {
					$(".modal").removeClass("is-active");
				});

				const fileInput = document.querySelector('#story-file input[type=file]');
				fileInput.onchange = () => {
					if (fileInput.files.length > 0) {
						const fileName = document.querySelector('#story-file .file-name');
						fileName.textContent = fileInput.files[0].name;
					}
				}
			</script>
			<?php
		}
		elseif($page == 'Histoire') {
			?>
			<script>
				var nombre_input = 1;

				function ajouterInput()
				{
					var div = document.getElementById('field_images');
					var e = document.createElement('div');
					nombre_input += 1;
					e.innerHTML = '<input type="file" name="images[]" accept="image/*">';

					div.appendChild(e);
				}

				$("#modal-chapitre").click(function() {
					$(".modal-chapitre").addClass("is-active");  
				});

				$("#modal-supprimer").click(function() {
					$(".modal-supprimer-histoire").addClass("is-active");  
				});

				$(".close-modal").click(function() {
					$(".modal").removeClass("is-active");
				});

				const fileInput = document.querySelector('#story-file input[type=file]');
				fileInput.onchange = () => {
					if (fileInput.files.length > 0) {
						const fileName = document.querySelector('#story-file .file-name');
						fileName.textContent = fileInput.files[0].name;
					}
				}
			</script>
			<?php
		}
		?>

	</body>

	</html>