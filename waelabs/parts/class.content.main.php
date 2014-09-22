<?php
	class WAE_content_main extends WAE_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'wae_display_media', array( $this, 'display_media' ), 10, 1 );
			add_action( 'wae_google_map', array( $this, 'display_google_map' ) );
			$this->load_media_class();
		}

		function display_media( $type ){
			$media = new WAE_post_media( $type );
			$media->display();
		}

		function display_google_map(){
			WAE::resolve_scripts( array( 'googlemap' ) );
			$options = $this->options;
			$zoom_level = (!empty($options['map_zoom_level']) ? $options['map_zoom_level'] : '');
			$enable_zoom = $options['map_enable_zoom'] == 0 ? 'false' : 'true';
			$center_coordinate =  (!empty($options['map_coordinate']) ? $options['map_coordinate'] : '');
			$map_positions = (!empty($options['map_positions']) ? implode(';', $options['map_positions']) :  '');
			$position_infos =  (!empty($options['map_position_infos']) ? implode('#;#', $options['map_position_infos']) :  '');
			$marker_image = (!empty($options['map_marker'])) ? $options['map_marker']['url'] : '';
			$accent_color = !empty($options['map_color']) ? $options[$options['map_color']] : '';
			$type = $options['map_type'];
			?>
			<div id="map-holder" 
				data-zoom-level="<?php echo  $zoom_level ?>"
				data-enable-zoom="<?php echo  $enable_zoom ?>"
				data-center-coordinate="<?php echo  $center_coordinate ?>"
				data-positions="<?php echo  $map_positions ?>" 
				data-marker-img="<?php echo  $marker_image ?>"
				data-position-infos="<?php echo  $position_infos ?>"
				data-map-type="<?php echo  $type ?>"
				data-accent-color="<?php echo  $accent_color ?>"
				>
			</div>
			<?php
		}

		private function load_media_class(){
			require_once('includes/class.post.media.php');
		}
	}
?>