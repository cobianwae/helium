<?php
	class WAE_slider_settings_fields{
		function __construct(){
			add_action( 'add_meta_boxes', array( $this,  'add_settings_box' ) );
			add_action( 'save_post', array( $this, 'save' ) );
		}

		function add_settings_box(){
			add_meta_box("wae_slider_fields", 
				esc_html__("Slide Settings"), 
				array( $this, 'add_fields' ), 
				"wae_slider", 
				"normal", 
				"high"); 
		}

		function add_fields($post){
			wp_enqueue_media();
			WAE::admin_resolve_scripts( array('media-uploader') );
			wp_nonce_field( 'wae_slide_settings', 'wae_slide_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
        	$slide_image = get_post_meta( $post->ID, '_wae_slider_image', true );
        	$caption_title = get_post_meta( $post->ID, '_wae_slider_caption_title', true );
        	$caption_subtitle = get_post_meta( $post->ID, '_wae_slider_caption_subtitle', true );
        	$button_text_1 = get_post_meta( $post->ID, '_wae_slider_button_text_1', true );
        	$button_link_1 = get_post_meta( $post->ID, '_wae_slider_button_link_1', true );
        	$button_text_2 = get_post_meta( $post->ID, '_wae_slider_button_text_2', true );
        	$button_link_2 = get_post_meta( $post->ID, '_wae_slider_button_link_2', true );
        	$slider_alignment = get_post_meta( $post->ID, '_wae_slider_alignment', true );
        	$caption_color = get_post_meta($post->ID, '_wae_slider_caption_color', true);
	        ?>
	        <table class="form-table">
	        	<tbody>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_image"><?php _e( 'Slide Image', THEMENAME )?></label>
	        			</th>
	        			<td>

	        				<div id="wae_preview_image_thumbnail"><?php echo empty($slide_image) ? '' : '<img height=300 src="'.$slide_image.'" />' ?></div>
		        			<input type="hidden" name="wae_slider_image" id="wae_slider_image" value="<?php echo $slide_image  ?>" />
							<input type="button" id="wae_preview_image_button" class="button image-button" value="<?php _e( 'Choose or Upload an Image', THEMENAME )?>" />
							<input type="button" id="remove_preview_image" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_caption_title"><?php _e( 'Caption Title', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input type="text" class="widefat" name="wae_slider_caption_title" id="wae_slider_caption_title" value="<?php echo $caption_title  ?>" />
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_caption_subtitle"><?php _e( 'Caption Subtitle', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<textarea rows="7" class="widefat" name="wae_slider_caption_subtitle" id="wae_slider_caption_subtitle"><?php echo $caption_subtitle  ?></textarea>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_button_text_1"><?php _e( 'Button Text 1', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input class="widefat" type="text" name="wae_slider_button_text_1" id="wae_slider_button_text_1" value="<?php echo $button_text_1  ?>" />
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_button_link_1"><?php _e( 'Button Link 1', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input class="widefat" type="text" name="wae_slider_button_link_1" id="wae_slider_button_link_1" value="<?php echo $button_link_1  ?>" />
    					</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_button_text_2"><?php _e( 'Button Text 2', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input class="widefat" type="text" name="wae_slider_button_text_2" id="wae_slider_button_text_2" value="<?php echo $button_text_2  ?>" />
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_button_link_2"><?php _e( 'Button Link 2', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input class="widefat" type="text" name="wae_slider_button_link_2" id="wae_slider_button_link_2" value="<?php echo $button_link_2  ?>" />
    					</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_alignment"><?php _e( 'Slide Alignment', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input  type="radio" name="wae_slider_alignment" value="left" <?php echo checked($slider_alignment, "left") ?> /> Left <br/>
        					<input  type="radio" name="wae_slider_alignment" value="center" <?php echo checked($slider_alignment, "center") ?> /> Center <br/>
    						<input  type="radio" name="wae_slider_alignment" value="right" <?php echo checked($slider_alignment, "right") ?> /> Right <br/>
						</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_caption_color"><?php _e( 'Caption Color', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input  type="radio" name="wae_slider_caption_color" value="light" <?php echo checked($caption_color, "light") ?> /> Light <br/>
        					<input  type="radio" name="wae_slider_caption_color" value="dark" <?php echo checked($caption_color, "dark") ?> /> Dark <br/>
	        			</td>
	        		</tr>
	        	</tbody>
	        </table>
	        <?php	
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_slide_settings_nonce'] ) )
			   return $post_id;

			$nonce = $_POST['wae_slide_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_slide_settings' ) )
			     return $post_id;

			 update_post_meta( $post_id, '_wae_slider_image', $_POST['wae_slider_image']);
			 update_post_meta( $post_id, '_wae_slider_caption_title', $_POST['wae_slider_caption_title']);
 			 update_post_meta( $post_id, '_wae_slider_caption_subtitle', $_POST['wae_slider_caption_subtitle']);
			 update_post_meta( $post_id, '_wae_slider_button_text_1', $_POST['wae_slider_button_text_1']);
			 update_post_meta( $post_id, '_wae_slider_button_link_1', $_POST['wae_slider_button_link_1']);
			 update_post_meta( $post_id, '_wae_slider_button_text_2', $_POST['wae_slider_button_text_2']);
			 update_post_meta( $post_id, '_wae_slider_button_link_2', $_POST['wae_slider_button_link_2']);
			 update_post_meta( $post_id, '_wae_slider_alignment', $_POST['wae_slider_alignment']);
			 update_post_meta( $post_id, '_wae_slider_caption_color', $_POST['wae_slider_caption_color']);

		}
	}
?>