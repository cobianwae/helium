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
        	$slide_mp4 = get_post_meta( $post->ID, '_wae_slider_mp4', true );
        	$slide_ogv = get_post_meta( $post->ID, '_wae_slider_ogv', true );
        	$caption_title = get_post_meta( $post->ID, '_wae_slider_caption_title', true );
        	$caption_subtitle = get_post_meta( $post->ID, '_wae_slider_caption_subtitle', true );
        	$button_text_1 = get_post_meta( $post->ID, '_wae_slider_button_text_1', true );
        	$button_link_1 = get_post_meta( $post->ID, '_wae_slider_button_link_1', true );
        	$button_text_2 = get_post_meta( $post->ID, '_wae_slider_button_text_2', true );
        	$button_link_2 = get_post_meta( $post->ID, '_wae_slider_button_link_2', true );
        	$slider_alignment = get_post_meta( $post->ID, '_wae_slider_alignment', true );
        	$caption_color = get_post_meta($post->ID, '_wae_slider_caption_color', true);
        	$title_style = get_post_meta($post->ID, '_wae_slider_title_style', true);
        	$title_animation = get_post_meta($post->ID, '_wae_slider_title_animation', true);
        	$subtitle_style = get_post_meta($post->ID, '_wae_slider_subtitle_style', true);
        	$subtitle_animation = get_post_meta($post->ID, '_wae_slider_subtitle_animation', true);
        	$buttons_style = get_post_meta($post->ID, '_wae_slider_buttons_style', true);
        	$buttons_animation = get_post_meta($post->ID, '_wae_slider_buttons_animation', true);
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
	        				<label for="wae_slider_video"><?php _e( 'Slide Video', THEMENAME )?></label>
	        			</th>
	        			<td>
		        			<input type="text" name="wae_slider_mp4" id="wae_slider_mp4" value="<?php echo $slide_mp4  ?>" />
							<input type="button" id="wae_slider_mp4_button" class="button video-button" value="<?php _e( 'Mp4 file', THEMENAME )?>" />
							<input type="button" id="wae_slider_remove_mp4" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
							<br/>
		        			<input type="text" name="wae_slider_ogv" id="wae_slider_ogv" value="<?php echo $slide_ogv  ?>" />
							<input type="button" id="wae_slider_ogv_button" class="button video-button" value="<?php _e( 'Ogv file', THEMENAME )?>" />
							<input type="button" id="wae_slider_remove_ogv" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_caption_title"><?php _e( 'Title', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input type="text" class="widefat" name="wae_slider_caption_title" id="wae_slider_caption_title" value="<?php echo $caption_title  ?>" />
    						<table class="form-table">
    							<tr>
    								<td>
			    						<label>Style :</label> 
		    							<select name="wae_slider_title_style">
		    								<option value="regular" <?php selected($title_style, 'regular', true)  ?>>Regular</option>
		    								<option value="border" <?php selected($title_style, 'border', true)  ?>>Border</option>
		    								<option value="background" <?php selected($title_style, 'background', true)  ?>>Background</option>
										</select>		
    								</td>
    								<td>
    									<label>Animation :</label>
										<select name="wae_slider_title_animation">
											<option value="move-up" <?php selected($title_animation, 'move-up', true) ?>>Move Up</option>
											<option value="fade-in" <?php selected($title_animation, 'fade-in', true) ?>>Fade In</option>
										</select>
    								</td>
    							</tr>
    						</table>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_caption_subtitle"><?php _e( 'Subtitle', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<textarea rows="7" class="widefat" name="wae_slider_caption_subtitle" id="wae_slider_caption_subtitle"><?php echo $caption_subtitle  ?></textarea>
	        				<table class="form-table">
    							<tr>
    								<td>
			    						<label>Style :</label> 
		    							<select name="wae_slider_subtitle_style">
		    								<option value="regular" <?php selected($subtitle_style, 'regular', true)  ?>>Regular</option>
		    								<option value="border" <?php selected($subtitle_style, 'border', true)  ?>>Border</option>
		    								<option value="background" <?php selected($subtitle_style, 'background', true)  ?>>Background</option>
										</select>		
    								</td>
    								<td>
    									<label>Animation :</label>
										<select name="wae_slider_subtitle_animation">
											<option value="move-up" <?php selected($subtitle_animation, 'move-up', true) ?>>Move Up</option>
											<option value="fade-in" <?php selected($subtitle_animation, 'fade-in', true) ?>>Fade In</option>
										</select>
    								</td>
    							</tr>
    						</table>
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
    						<table class="form-table">
    							<tr>
    								<td>
			    						<label>Style :</label> 
		    							<select name="wae_slider_buttons_style">
		    								<option value="regular" <?php selected($buttons_style, 'regular', true)  ?>>Regular</option>
		    								<option value="border" <?php selected($buttons_style, 'border', true)  ?>>Border</option>
		    								<option value="background" <?php selected($buttons_style, 'background', true)  ?>>Background</option>
										</select>		
    								</td>
    								<td>
    									<label>Animation :</label>
										<select name="wae_slider_buttons_animation">
											<option value="move-up" <?php selected($buttons_animation, 'move-up', true) ?>>Move Up</option>
											<option value="fade-in" <?php selected($buttons_animation, 'fade-in', true) ?>>Fade In</option>
										</select>
    								</td>
    							</tr>
    						</table>
    					</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_alignment"><?php _e( 'Alignment', THEMENAME )?></label>
	        			</th>
	        			<td>
	        				<input  type="radio" name="wae_slider_alignment" value="left" <?php echo checked($slider_alignment, "left") ?> /> Left <br/>
        					<input  type="radio" name="wae_slider_alignment" value="center" <?php echo checked($slider_alignment, "center") ?> /> Center <br/>
    						<input  type="radio" name="wae_slider_alignment" value="right" <?php echo checked($slider_alignment, "right") ?> /> Right <br/>
						</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<label for="wae_slider_caption_color"><?php _e( 'Font Color', THEMENAME )?></label>
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
			 update_post_meta( $post_id, '_wae_slider_mp4', $_POST['wae_slider_mp4']);
			 update_post_meta( $post_id, '_wae_slider_ogv', $_POST['wae_slider_ogv']);
			 update_post_meta( $post_id, '_wae_slider_caption_title', $_POST['wae_slider_caption_title']);
 			 update_post_meta( $post_id, '_wae_slider_caption_subtitle', $_POST['wae_slider_caption_subtitle']);
			 update_post_meta( $post_id, '_wae_slider_button_text_1', $_POST['wae_slider_button_text_1']);
			 update_post_meta( $post_id, '_wae_slider_button_link_1', $_POST['wae_slider_button_link_1']);
			 update_post_meta( $post_id, '_wae_slider_button_text_2', $_POST['wae_slider_button_text_2']);
			 update_post_meta( $post_id, '_wae_slider_button_link_2', $_POST['wae_slider_button_link_2']);
			 update_post_meta( $post_id, '_wae_slider_alignment', $_POST['wae_slider_alignment']);
			 update_post_meta( $post_id, '_wae_slider_caption_color', $_POST['wae_slider_caption_color']);
			 update_post_meta( $post_id, '_wae_slider_title_style', $_POST['wae_slider_title_style']);
			 update_post_meta( $post_id, '_wae_slider_title_animation', $_POST['wae_slider_title_animation']);
			 update_post_meta( $post_id, '_wae_slider_subtitle_style', $_POST['wae_slider_subtitle_style']);
			 update_post_meta( $post_id, '_wae_slider_subtitle_animation', $_POST['wae_slider_subtitle_animation']);
			 update_post_meta( $post_id, '_wae_slider_buttons_style', $_POST['wae_slider_buttons_style']);
			 update_post_meta( $post_id, '_wae_slider_buttons_animation', $_POST['wae_slider_buttons_animation']);

		}
	}
?>