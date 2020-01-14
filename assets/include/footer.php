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
		if($page == 'Chapitre') {
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
			</script>
			<?php
		}
		?>

	</body>

	</html>