<?php
/**
 * The Header for Helium
 *
 * Displays all of the <head> section and everything up till main content
 *
 * @package Helium
 * @since Helium 1.0
 */
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
	<?php do_action( 'wae_html_head' ) ?>
	<body <?php body_class( 'main-wrapper off-canvas-wrap' ) ?> data-offcanvas>
	<!-- <body <?php body_class( 'main-wrapper' ) ?>> -->
		<div class="inner-wrap">			
			<?php do_action( 'hl_primary_navigation' ) ?>
			