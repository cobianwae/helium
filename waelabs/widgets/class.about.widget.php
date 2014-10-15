<?php
	class WAE_about_widget extends WP_Widget{
		function __construct(){
			$widget_ops = array(
				'classname' => 'wae_about_widget', 
				'description' => __( "The description about your site or profile.", THEMENAME) );
			parent::__construct('wae-about-widget', 'WAE - ' . __('About', THEMENAME), $widget_ops);
			$this->alt_option_name = 'wae_present_widget';
			add_action( 'admin_footer', array( $this, 'add_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'media_uploader' ));
		}

		function widget($args, $instance) {
			ob_start();
			extract($args);
			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'About', THEMENAME );
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$show_title = !empty( $instance['show_title'] ) ? (bool)$instance['show_title'] : false;
			$image_options['type'] = !empty($instance['image_source']) ? $instance['image_source'] : 'gravatar';
			$image_options['email'] = !empty($instance['email']) ? $instance['email'] : '';
			$image_options['url'] = !empty($instance['image_url']) ? $instance['image_url'] : '';
			$about_title = !empty($instance['about_title']) ? $instance['about_title'] : '';
			$image_options['title'] = $about_title;
			$about_description = !empty($instance['about_description']) ? $instance['about_description'] : '';
			$facebook_url = !empty($instance['facebook_url']) ? $instance['facebook_url'] : '';
			$twitter_url = !empty($instance['twitter_url']) ? $instance['twitter_url'] : '';
			$instagram_url = !empty($instance['instagram_url']) ? $instance['instagram_url'] : '';
			$pinterest_url = !empty($instance['pinterest_url']) ? $instance['pinterest_url'] : '';
			$googleplus_url = !empty($instance['googleplus_url']) ? $instance['googleplus_url'] : '';
			
			echo $before_widget;
			if ( $title  && $show_title) echo $before_title . $title . $after_title;
			?>
			<div id="wae-about-widget">
				<?php $this->display_image( $image_options ); ?>
				<h4><?php echo $about_title ?></h4>
				<p><?php echo $about_description ?></p>
				<ul class="about-social-media">
				<?php if ($facebook_url != '') : ?>
					<li>
						<a href="<?php echo $facebook_url; ?>" class="facebook" title="Facebook">
	               			<i class="fa fa-facebook"></i>
	               		</a>
					</li>
				<?php endif; ?>

				<?php if ($twitter_url != '') : ?>
					<li>
						<a href="<?php echo $twitter_url; ?>" class="twitter" title="Twitter">
	               			<i class="fa fa-twitter"></i>
	               		</a>
					</li>
				<?php endif; ?>

				<?php if ($instagram_url != '') : ?>
					<li>
						<a href="<?php echo $instagram_url; ?>" class="instagram" title="Facebook">
	               			<i class="fa fa-instagram"></i>
	               		</a>
					</li>
				<?php endif; ?>

				<?php if ($pinterest_url != '') : ?>
					<li>
						<a href="<?php echo $pinterest_url; ?>" class="pinterest" title="Pinterest">
	               			<i class="fa fa-pinterest"></i>
	               		</a>
					</li>
				<?php endif; ?>

				<?php if ($googleplus_url != '') : ?>
					<li>
						<a href="<?php echo $googleplus_url; ?>" class="google-plus" title="Google +">
	               			<i class="fa fa-google-plus"></i>
	               		</a>
					</li>
				<?php endif; ?>
				</ul>
			</div>
			<?php
			echo $after_widget;
			ob_end_flush();
		}

		function form( $instance ) {
			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'About', THEMENAME );
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$show_title = !empty($instance['show_title']) ? (bool)$instance['show_title'] : false;
			$image_source = !empty($instance['image_source']) ? $instance['image_source'] : 'gravatar';
			$email = !empty($instance['email']) ? $instance['email'] : '';
			$image_url = !empty($instance['image_url']) ? $instance['image_url'] : '';
			$about_title = !empty($instance['about_title']) ? $instance['about_title'] : '';
			$about_description = !empty($instance['about_description']) ? $instance['about_description'] : '';
			$facebook_url = !empty($instance['facebook_url']) ? $instance['facebook_url'] : '';
			$twitter_url = !empty($instance['twitter_url']) ? $instance['twitter_url'] : '';
			$instagram_url = !empty($instance['instagram_url']) ? $instance['instagram_url'] : '';
			$pinterest_url = !empty($instance['pinterest_url']) ? $instance['pinterest_url'] : '';
			$googleplus_url = !empty($instance['googleplus_url']) ? $instance['googleplus_url'] : '';
			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title?', THEMENAME ); ?> </label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1" <?php checked( $show_title, 1 ); ?> /></p>

			<p><label for="<?php echo $this->get_field_id( 'image_source' ); ?>"><?php _e( 'Image Source', THEMENAME ); ?></label>
			<select class="image-source" id="<?php echo $this->get_field_id( 'image_source' ); ?>" name="<?php echo $this->get_field_name( 'image_source' ); ?>" >
				<option value="gravatar" <?php selected( $image_source, "gravatar" ); ?>><?php _e('Gravatar', THEMENAME) ?></option>
				<option value="local-image" <?php selected( $image_source, "local-image" ); ?>><?php _e('Local Image', THEMENAME) ?></option>
				<option value="embedded-image" <?php selected( $image_source, "embedded-image" ); ?>><?php _e('Embedded Image', THEMENAME) ?></option>
			</select></p>

			<p class="email-field"><label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $email; ?>" /></p>

			<div class="image-selector"><label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'Image Url', THEMENAME ); ?></label>
			<p class="image-preview">
				<img style="width:100%;height:auto" src="<?php echo $image_url ?>" alt="<?php echo $about_title ?>" />
			</p>
			<input class="widefat image-url" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" type="text" value="<?php echo $image_url; ?>" />
			<input type="button" class="about-image-button" value="Select Image" />
			<input type="button" class="about-remove-image" value="Remove" />
			</div>

			<p><label for="<?php echo $this->get_field_id( 'about_title' ); ?>"><?php _e( 'About Title', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'about_title' ); ?>" name="<?php echo $this->get_field_name( 'about_title' ); ?>" type="text" value="<?php echo $about_title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'about_description' ); ?>"><?php _e( 'About Description', THEMENAME ); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'about_description' ); ?>" name="<?php echo $this->get_field_name( 'about_description' ); ?>"><?php echo $about_description; ?></textarea> </p>

			<p><label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook Url', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text" value="<?php echo $facebook_url; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter Url', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text" value="<?php echo $twitter_url; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'pinterest_url' ); ?>"><?php _e( 'Pinterest Url', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest_url' ); ?>" name="<?php echo $this->get_field_name( 'pinterest_url' ); ?>" type="text" value="<?php echo $pinterest_url; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php _e( 'instagram Url', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram_url' ); ?>" name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" type="text" value="<?php echo $instagram_url; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'googleplus_url' ); ?>"><?php _e( 'Google Plus Url', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'googleplus_url' ); ?>" name="<?php echo $this->get_field_name( 'googleplus_url' ); ?>" type="text" value="<?php echo $googleplus_url; ?>" /></p>
			
			<?php
		}

		function update( $new_instance, $old_instance ) {

			$instance['title'] = strip_tags($new_instance['title']);
			$instance['email'] = strip_tags($new_instance['email']);
			$instance['image_source'] = strip_tags($new_instance['image_source']);
			$instance['image_url'] = strip_tags($new_instance['image_url']);
			$instance['about_title'] = strip_tags($new_instance['about_title']);
			$instance['about_description'] = strip_tags($new_instance['about_description']);
			$instance['facebook_url'] = strip_tags($new_instance['facebook_url']);
			$instance['twitter_url'] = strip_tags($new_instance['twitter_url']);
			$instance['instagram_url'] = strip_tags($new_instance['instagram_url']);
			$instance['pinterest_url'] = strip_tags($new_instance['pinterest_url']);
			$instance['googleplus_url'] = strip_tags($new_instance['googleplus_url']);

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['wae_about_widget']) )
				delete_option('wae_about_widget');
			return $instance;
		}

		private function display_image( $options ){
			switch ($options['type']) {
				case 'gravatar':
					echo get_avatar( $options['email'], 300, '', $options['title'] );
					break;
				default:
					?>
					<img src="<?php echo $options['url'] ?>" alt="<?php echo $options['title'] ?>" />
					<?php
					break;
			}
		}

		function add_scripts(){
			?>
				<script type="text/javascript">
					(function($,window,undefined){
						$(document).ready(function(){

							var inNecessaryFields =  function( $changer ){
								var val = $changer.val();
								var form = $changer.closest('form');
								if(val == 'gravatar'){
									form.find('.image-selector').hide();
									form.find('.email-field').show();
								}else if(val == 'local-image'){
									form.find('.image-url').prop('readonly', true);
									form.find('.image-selector').show();
									form.find('.image-button').show();
									form.find('.about-remove-image').show();
									form.find('.email-field').hide();
								}else{
									form.find('.email-field').hide();
									form.find('.image-url').prop('readonly', false);
									form.find('.image-selector').show();
									form.find('.image-button').hide();
									form.find('.about-remove-image').hide();
								}
							}

							var runScript = function(){
								$('.image-source').change(function(){
									var form = $(this).closest('form');
									form.find('.about-remove-image').click();
									form.find('.email-field input').val('');
									form.find('.image-url').val('');
									inNecessaryFields( $(this) );
								});
							};

							runScript();
							$('.image-source').each(function(){
								inNecessaryFields( $(this) );
							});

							$( document ).ajaxStop( function() {
						        runScript();
								$('.image-source').each(function(){
									inNecessaryFields( $(this) );
								});
						    });
						});
						
						var tgm_media_frame;
						$(document.body).on('click', '.about-image-button', function(e){
						    e.preventDefault();
						    var type = 'image';
						    var $trigger = $(this);
						    tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
						        className: 'media-frame tgm-media-frame',
						        frame: 'select',
						        multiple: false,
						        title: '<?php echo _e("Select Image", THEMENAME) ?>',
						        library: {
						            type: type
						        },
						        button: {
						            text:  '<?php echo _e("Select",THEMENAME) ?>'
						        }
						    });
						    tgm_media_frame.on('select', function(){
						        var media_attachment = tgm_media_frame.state().get('selection').first().toJSON(); 
					            $('<img src="'+ media_attachment.url +'">').load(function() {
					                $trigger.prev().prev().html($(this).width('100%').height('auto'));
					            });
					            $trigger.prev().val(media_attachment.url); 
						    });
							tgm_media_frame.open();
						});
						 $(document.body).on('click', '.about-remove-image',function(e){
						    $(this).prev().prev().val('');
						    $(this).prev().prev().prev().html('');
						 }); 
					}(jQuery,window));
				</script>
			<?php
		}

		function media_uploader(){
	  		 wp_enqueue_media();
		}
	}
?>