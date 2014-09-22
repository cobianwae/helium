<?php
	class WAE_post_format_audio{
		function __construct(){
			add_action("add_meta_boxes", array( $this,  "meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );    
		}

		function meta_box(){
			add_meta_box("wae_audio_settings",
				esc_html__("Audio Settings"),
				array($this, "format"),
				"post",
				"normal",
				"high"
				);
		}

		function format($post){
			WAE::admin_resolve_scripts( array( 'media-uploader' ) );
		  	wp_nonce_field( 'wae_audio_settings', 'wae_audio_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	       	$mp3_url = get_post_meta( $post->ID, '_wae_mp3_url', true );
		    $oga_url = get_post_meta( $post->ID, '_wae_oga_url', true );
		    $embedded = get_post_meta( $post->ID, '_wae_audio_embedded', true );
			?>  
			<table class="form-table">
				<tr>
					<th>
						<label><?php echo  _e('MP3 File URL', THEMENAME) ?></label>
					</th>
					<td>
						<input type="text" class="widefat" name="wae_mp3_url" value="<?php echo  $mp3_url ?>" />
						<input type="button" id="wae_mp3_button" class="button audio-button" value="<?php _e( 'Add Media', THEMENAME )?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('OGA File URL', THEMENAME) ?></label>
					</th>
					<td>
						<input type="text" class="widefat" name="wae_oga_url" value="<?php echo  $oga_url ?>" />
						<input type="button" id="wae_oga_button" class="button audio-button" value="<?php _e( 'Add Media', THEMENAME )?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('Embedded Code', THEMENAME) ?></label>
					</th>
					<td>
						<textarea class="widefat" name="wae_audio_embedded"><?php echo $embedded ?></textarea>
					</td>
				</tr>
			</table>
			<?php  
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_audio_settings_nonce'] ) )
			   return $post_id;

		 	$nonce = $_POST['wae_audio_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_audio_settings' ) )
			     return $post_id;

			update_post_meta( $post_id, '_wae_mp3_url', $_POST['wae_mp3_url']);
			update_post_meta( $post_id, '_wae_oga_url', $_POST['wae_oga_url']);
			update_post_meta( $post_id, '_wae_audio_embedded', $_POST['wae_audio_embedded'] );
		}
	}
?>