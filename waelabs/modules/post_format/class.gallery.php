<?php
	class WAE_post_format_gallery{
		function __construct(){
			add_action("add_meta_boxes", array( $this,  "meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );    
		}

		function meta_box(){
			add_meta_box("wae_gallery_settings",
				esc_html__("Gallery Settings"),
				array($this, "format"),
				"post",
				"normal",
				"high"
				);
		}

		function format($post){
		  	wp_nonce_field( 'wae_gallery_settings', 'wae_gallery_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	       	$as_slider = get_post_meta( $post->ID, '_wae_gallery_slider', true );
			?>  
			<table class="form-table">
				<tr>
					<th>
						<label><?php echo  _e('Turn into slider', THEMENAME) ?></label>
					</th>
					<td>
						<input type='checkbox' name='wae_gallery_slider' value='yes' <?php checked( $as_slider, 'yes' ) ?> />
					</td>
				</tr>
			</table>
			<?php  
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_gallery_settings_nonce'] ) )
			   return $post_id;

		 	$nonce = $_POST['wae_gallery_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_gallery_settings' ) )
			     return $post_id;

			update_post_meta( $post_id, '_wae_gallery_slider', $_POST['wae_gallery_slider']);
		}
	}
?>