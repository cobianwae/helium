	<?php
	do_action( 'fl_before_footer' );
	?>
	<footer id="footer" class="footer">
		<div class="row secondary-footer">
			<?php do_action( 'fl_footer' ) ?>
		</div>
	</footer>
	<?php 
	wp_footer(); //do not remove, used by the theme and many plugins
	do_action( 'fl_after_footer' ); 
	?>
	</body>
</html>