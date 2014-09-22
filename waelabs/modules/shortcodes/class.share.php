<?php
	class WAE_shortcodes_share{
		function __construct(){
			add_shortcode( 'wae_share', array( $this, 'display' ) );
		}

		function display($atts, $content){
			extract( shortcode_atts( array( 'media' => 'wae_love,facebook,twitter,pinterest' ), $atts ) );
			ob_start();
			$media_array = explode( ',', $media );
			global $keeva;
			?>
				<div class="wae-social-sharing">
					<ul>
					<?php foreach ($media_array as $key => $media_item) {
						echo '<li>';
						if ( strpos( $media_item, 'wae_' ) === 0 ){
							call_user_func( array( $this, $media_item ) );
						}else{
							$this->share( $media_item );
						}
						echo '</li>';	
					}
					?>
					</ul>
				</div>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}

		function wae_love(){
			echo apply_filters( 'wae_love_anywhere', '' );
		}

		function share( $type ){
			?>
			<a class='<?php echo $type?>-share wae-sharing' data-target='<?php the_permalink() ?>' href='#' title='Share this'> <i class='fa fa-<?php echo $type?>'></i> <span class='count'></span></a>
			<?php
		}
	}
?>