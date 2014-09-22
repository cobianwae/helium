<?php
	class WAE_post_format_quote{
		function __construct(){
			add_action("add_meta_boxes", array( $this,  "quote_meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );    
		}

		function quote_meta_box(){
			add_meta_box("wae_quote_settings",
				esc_html__("Quote Settings"),
				array($this, "quote_format"),
				"post",
				"normal",
				"high"
				);
		}

		function quote_format($post){
		  	wp_nonce_field( 'wae_quote_settings', 'wae_quote_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	       	$content = get_post_meta( $post->ID, '_wae_quote_content', true );
	       	$author = get_post_meta( $post->ID, '_wae_quote_author', true );
	       	$quote_only = get_post_meta( $post->ID, '_wae_quote_only', true );
			?>  
			<table class="form-table">
				<tr>
					<th>
						<label><?php echo  _e('Quote Content', THEMENAME) ?></label>
					</th>
					<td>
						<textarea class="widefat" rows="10" name="wae_quote_content"><?php echo  $content ?></textarea>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('Quote Author', THEMENAME) ?></label>
					</th>
					<td>
						<input type="text" class="widefat" name="wae_quote_author" value="<?php echo  $author ?>" />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('Quote Only?', THEMENAME) ?></label>
					</th>
					<td>
						<input type="checkbox" name="wae_quote_only" value="1" <?php checked( $quote_only, 1 ) ?> />
					</td>
				</tr>
			</table>
			<?php  
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_quote_settings_nonce'] ) )
			   return $post_id;

		 	$nonce = $_POST['wae_quote_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_quote_settings' ) )
			     return $post_id;

			update_post_meta( $post_id, '_wae_quote_content', $_POST['wae_quote_content']);
			update_post_meta( $post_id, '_wae_quote_author', $_POST['wae_quote_author']);
			update_post_meta( $post_id, '_wae_quote_only', $_POST['wae_quote_only']);
		}
	}
?>