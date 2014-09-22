<?php
	class WAE_page_options_admin{

		function __construct(){
			add_action("add_meta_boxes", array( $this,  "meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );
		}

		function meta_box(){
			add_meta_box("wae_page_header_settings",
				esc_html__("Header Options", THEMENAME),
				array($this, "header_settings"),
				"page",
				"normal",
				"high"
			);
		}

		function header_settings($post){
			WAE::admin_resolve_scripts( array( 'media-uploader', 'wp-color-picker' ) );
			wp_nonce_field( 'wae_header_settings', 'wae_header_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	        $header_background = get_post_meta( $post->ID, '_wae_header_background', true );
	        $header_caption_title = get_post_meta( $post->ID, '_wae_header_caption_title', true );
	        $header_caption_subtitle = get_post_meta( $post->ID, '_wae_header_caption_subtitle', true );
	        $header_caption_color = get_post_meta( $post->ID, '_wae_header_caption_color', true );
	        $header_caption_color = empty($header_caption_color) ? 'light' : $header_caption_color;
	        $header_caption_align = get_post_meta( $post->ID, '_wae_header_caption_align', true );
	        $header_caption_align = empty($header_caption_align) ? 'left' : $header_caption_align;
	        $header_background_display = get_post_meta( $post->ID, '_wae_header_background_display', true );
	        $header_background_display = empty($header_background_display) ? 'full-screen' : $header_background_display;
	        ?>
	        <table class="form-table">
	        	<tr>
					<th>
						<label><?php echo  _e('Header Background', THEMENAME) ?></label>
					</th>
					<td>
						<!-- <input class="widefat" type="text" name="wae_header_background" value="<?php echo  $header_background ?>" /> -->
						<div id="wae_header_background_preview"><?php echo empty($header_background) ? '' : '<img style="width:100%;height:auto;" src="'.$header_background.'" />' ?></div>
	        			<input type="hidden" name="wae_header_background" id="wae_header_background" value="<?php echo $header_background  ?>" />
						<input type="button" id="wae_header_background_button" class="button image-button" value="<?php _e( 'Upload', THEMENAME )?>" />
						<input type="button" id="remove_preview_image" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label for="wae_header_caption_title"><?php _e( 'Caption Title', THEMENAME )?></label>
					</th>
					<td>
						<input type="text" class="widefat" name="wae_header_caption_title" id="wae_header_caption_title" value="<?php echo $header_caption_title  ?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label for="wae_header_caption_subtitle"><?php _e( 'Caption Subtitle', THEMENAME )?></label>
					</th>
					<td>
						<textarea rows="4" class="widefat" name="wae_header_caption_subtitle" ><?php echo $header_caption_subtitle  ?></textarea>
					</td>
				</tr>
				<tr>
        			<th>
        				<label for="wae_header_caption_color"><?php _e( 'Caption Color', THEMENAME )?></label>
        			</th>
        			<td>
        				<input  type="radio" name="wae_header_caption_color" value="light" <?php echo checked($header_caption_color, "light") ?> /> Light <br/>
    					<input  type="radio" name="wae_header_caption_color" value="dark" <?php echo checked($header_caption_color, "dark") ?> /> Dark <br/>
        			</td>
        		</tr>
        		<tr>
        			<th>
        				<label for="wae_header_caption_align"><?php _e( 'Caption Align', THEMENAME )?></label>
        			</th>
        			<td>
        				<input  type="radio" name="wae_header_caption_align" value="left" <?php echo checked($header_caption_align, "left") ?> /> <?php _e('Left', THEMENAME) ?> <br/>
    					<input  type="radio" name="wae_header_caption_align" value="center" <?php echo checked($header_caption_align, "center") ?> /> <?php _e('Center', THEMENAME) ?> <br/>
    					<input  type="radio" name="wae_header_caption_align" value="right" <?php echo checked($header_caption_align, "right") ?> /> <?php _e('Right', THEMENAME) ?> <br/>
        			</td>
        		</tr>
        		<tr>
        			<th>
        				<label for="wae_header_background_display"><?php _e( 'Background Display', THEMENAME )?></label>
        			</th>
        			<td>
        				<input  type="radio" name="wae_header_background_display" value="full-screen" <?php echo checked($header_background_display, "full-screen") ?> /> <?php _e('Full Screen', THEMENAME)?> <br/>
    					<input  type="radio" name="wae_header_background_display" value="half-screen" <?php echo checked($header_background_display, "half-screen") ?> /> <?php _e('Half Screen', THEMENAME) ?> <br/>
        			</td>
        		</tr>
	        </table>
	        <?php
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_header_settings_nonce'] ) )
			   return $post_id;

			$nonce = $_POST['wae_header_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_header_settings' ) )
			     return $post_id;

			 update_post_meta( $post_id, '_wae_header_background', $_POST['wae_header_background']);
			 update_post_meta( $post_id, '_wae_header_caption_title', $_POST['wae_header_caption_title']);
 			 update_post_meta( $post_id, '_wae_header_caption_subtitle', $_POST['wae_header_caption_subtitle']);
			 update_post_meta( $post_id, '_wae_header_caption_color', $_POST['wae_header_caption_color']);
			 update_post_meta( $post_id, '_wae_header_caption_align', $_POST['wae_header_caption_align']);
			 update_post_meta( $post_id, '_wae_header_background_display', $_POST['wae_header_background_display']);
		}	    
	}
?>