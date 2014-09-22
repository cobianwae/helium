<?php 
	class WAE_post_format_link{
		function __construct(){
			add_action("add_meta_boxes", array( $this,  "meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );    
		}

		function meta_box(){
			add_meta_box("wae_link_settings",
				esc_html__("Link Settings"),
				array($this, "format"),
				"post",
				"normal",
				"high"
				);
		}

		function format($post){
		  	wp_nonce_field( 'wae_link_settings', 'wae_link_settings_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	       	$link_url = get_post_meta( $post->ID, '_wae_link_url', true );
	       	$link_title = get_post_meta( $post->ID, '_wae_link_title', true );
	       	$link_only = get_post_meta( $post->ID, '_wae_link_only', true );
			?>  
			<table class="form-table">
				<tr>
					<th>
						<label><?php echo  _e('Link URL', THEMENAME) ?></label>
					</th>
					<td>
						<input class="widefat" type='text' name='wae_link_url' value='<?php echo  $link_url ?>' />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('Link Title', THEMENAME) ?></label>
					</th>
					<td>
						<input class="widefat" type='text' name='wae_link_title' value='<?php echo  $link_title ?>' />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo  _e('Link Only', THEMENAME) ?></label>
					</th>
					<td>
						<input  type='checkbox' name='wae_link_only' value="1" <?php checked($link_only, 1) ?> />
					</td>
				</tr>
			</table>
			<?php  
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_link_settings_nonce'] ) )
			   return $post_id;

		 	$nonce = $_POST['wae_link_settings_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_link_settings' ) )
			     return $post_id;

			update_post_meta( $post_id, '_wae_link_url', $_POST['wae_link_url']);
			update_post_meta( $post_id, '_wae_link_title', $_POST['wae_link_title']);
			update_post_meta( $post_id, '_wae_link_only', $_POST['wae_link_only']);
		}
	}
?>