<?php
	class WAE_post_format_admin{
		function __construct(){
			WAE_post_format_bootstrapper::instantiate('quote');
			WAE_post_format_bootstrapper::instantiate('audio');
			WAE_post_format_bootstrapper::instantiate('gallery');
			WAE_post_format_bootstrapper::instantiate('link');
			WAE_post_format_bootstrapper::instantiate('video');
			add_theme_support( 'post-formats', array( 'gallery', 'link',  'audio', 'video', 'quote' ) );
			add_theme_support( 'post-thumbnails' );
			add_action( 'admin_footer', array($this, 'post_type_scripts') );
			add_action( 'admin_head', array($this, 'post_type_style'));
			add_action("add_meta_boxes", array( $this,  "meta_box" ) );
			add_action('save_post', array( $this, 'save' ) );    
		}

		function post_type_scripts(){	
			global $typenow;
			if ( $typenow == 'post' ){
				?>
					<script type="text/javascript">
						(function($){
							$(document).ready(function(){
								$('input:radio[name="post_format"]').change(function(){
									if($(this).val() == 0){
										if($('.postbox.active').length)
											$('.postbox.active').removeClass('active');
									}else{
										if($('.postbox.active').length)
											$('.postbox.active').removeClass('active');

										var type = $(this).val();
										switch( type ){
											case 'gallery' :
												 $('#wae_gallery_settings').addClass('active');
												break;
											case 'link' :
												$('#wae_link_settings').addClass('active');
												break;
											case 'audio' :
												$('#wae_audio_settings').addClass('active');
												break;
											case 'video' :
												$('#wae_video_settings').addClass('active');
												break;
											case 'quote' : 
												$('#wae_quote_settings').addClass('active');

										}
									}
								});
								$('input:radio[name="post_format"]:checked').change();
							});
						}(jQuery));
					</script>
				<?php
			}
		}

		function post_type_style(){
			global $typenow;
			if($typenow == 'post'){
				echo '<style>
					#wae_quote_settings,
					#wae_audio_settings,
					#wae_gallery_settings,
					#wae_link_settings,
					#wae_video_settings{
						display:none;
					}
					.postbox.active{
						display:block !important;
					}
				</style>';
			}
		}

		function meta_box(){
			add_meta_box("wae_display_color",
				esc_html__("Post Display Color"),
				array($this, "format"),
				"post",
				"side",
				"core"
				);
		}

		function format($post){
			wp_nonce_field( 'wae_display_color', 'wae_display_color_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
	       	$caption_color = get_post_meta( $post->ID, '_wae_caption_color', true );
			?>  
			<table class="form-table">
				<tr>
					<td>
						<input  type="radio" name="wae_caption_color" value="light" <?php echo checked($caption_color, "light") ?> /> Light <br/>
    					<input  type="radio" name="wae_caption_color" value="dark" <?php echo checked($caption_color, "dark") ?> /> Dark <br/>
					</td>
				</tr>
			</table>
			<?php  
		}

		function save( $post_id ){
			if ( ! isset( $_POST['wae_display_color_nonce'] ) )
			   return $post_id;

		 	$nonce = $_POST['wae_display_color_nonce'];

			 // Verify that the nonce is valid.
			 if ( ! wp_verify_nonce( $nonce, 'wae_display_color' ) )
			     return $post_id;

			update_post_meta( $post_id, '_wae_caption_color', $_POST['wae_caption_color']);
		}

	}
?>