<?php
	class WAE_post_format_video{
		function __construct(){
			add_action("add_meta_boxes", array( $this,  "meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );  
		}

		function meta_box(){
			add_meta_box("wae_video_settings",
				esc_html__("Video Settings"),
				array($this, "format"),
				"post",
				"normal",
				"high"
				);
		}

		function format($post){
			WAE::admin_resolve_scripts( array( 'media-uploader' ) );
		  	wp_nonce_field( 'wae_video_settings', 'wae_video_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	       	$m4v_url = get_post_meta( $post->ID, '_wae_m4v_url', true );
			$ogv_url = get_post_meta( $post->ID, '_wae_ogv_url', true );
			$preview_image = get_post_meta( $post->ID, '_wae_preview_image', true );
			$embeded_code = get_post_meta( $post->ID, '_wae_embeded_video', true );
			?>  
			<table class="form-table">
				<tr>
					<th>
						<label><?php echo  _e('M4V File URL', THEMENAME) ?></label>
					</th>
					<td>
						<input class="widefat" type='text' name='wae_m4v_url' value='<?php echo  $m4v_url ?>' />
						<input type="button" id="wae_m4v_button" class="button video-button" value="<?php _e( 'Add Media', THEMENAME )?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('OGV File URL', THEMENAME) ?></label>
					</th>
					<td>
						<input class="widefat" type='text' name='wae_ogv_url' value='<?php echo  $ogv_url ?>' />
						<input type="button" id="wae_ogv_button" class="button video-button" value="<?php _e( 'Add Media', THEMENAME )?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('Preview Image', THEMENAME) ?></label>
					</th>
					<td>
						<div id="wae_preview_image_thumbnail"><?php echo empty($preview_image) ? '' : '<img height=300 src="'.$preview_image.'" />' ?></div>
	        			<input  type="hidden" name="wae_preview_image" id="wae_preview_image" value="<?php echo $preview_image  ?>" />
						<input type="button" id="wae_preview_image_button" class="button image-button" value="<?php _e( 'Upload', THEMENAME )?>" />
						<input type="button" id="remove_preview_image" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
					</td>
				</tr>
				<tr>
					<th><label><?php echo  _e('Embeded Code', THEMENAME) ?></label></th>
					<td>
						<textarea rows="10" class="widefat" name="wae_embeded_video"><?php echo  $embeded_code ?></textarea>
					</td>
				</tr>
			</table>
			<?php  
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_video_settings_nonce'] ) )
			   return $post_id;

		 	$nonce = $_POST['wae_video_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_video_settings' ) )
			     return $post_id;

			update_post_meta( $post_id, '_wae_m4v_url', $_POST['wae_m4v_url']);
			update_post_meta( $post_id, '_wae_ogv_url', $_POST['wae_ogv_url']);
			update_post_meta( $post_id, '_wae_preview_image', $_POST['wae_preview_image']);
			update_post_meta( $post_id, '_wae_embeded_video', $_POST['wae_embeded_video']);
		}
	}
?>