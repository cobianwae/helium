<?php
	class WAE_instagram_widget extends WP_Widget{
		function __construct(){
			$widget_ops = array(
				'classname' => 'wae_instagram_widget', 
				'description' => __( "Display recent photos from instagram account.", THEMENAME) );
			parent::__construct('wae-instagram-widget', 'WAE - ' . __('Instagram', THEMENAME), $widget_ops);
			$this->alt_option_name = 'wae_instagram';
		}

		function widget($args, $instance){
			extract($args);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$username = empty($instance['username']) ? '' : $instance['username'];
			$limit = empty($instance['number']) ? 8 : $instance['number'];
			ob_start();
			echo $before_widget;
			echo $before_title . $title . $after_title;
			?>
			<div id="wae-instagram-widget">
				<?php
					if(!empty($username)){
						$media_array = $this->scrape_instagram($username, $limit);

						?>
						<ul><?php
							foreach ($media_array as $item) {
								echo '<li>
										<div class="wae-instagram-widget">
										<img src="'. esc_url($item['thumbnail']['url']) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/>
										<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><div class="instagram-likes"><span class="icon-heart"></span><p>'.$item['likes'].'</p></div></a>
										</div>
									</li>';
							}
							?>
						</ul>
						<?php
					}
				?>
				<div class="clear"></div>
			</div>
			<?php
			echo $after_widget;
		}

		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => __('Instagram', THEMENAME), 'username' => '', 'link' => __('Follow Us', THEMENAME), 'number' => 8, 'size' => 'thumbnail', 'target' => '_self') );
			$title = esc_attr($instance['title']);
			$username = esc_attr($instance['username']);
			$number = absint($instance['number']);
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', THEMENAME); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username', THEMENAME); ?>: <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos', THEMENAME); ?>: <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label></p>
			<?php

		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['username'] = trim(strip_tags($new_instance['username']));
			$instance['number'] = !absint($new_instance['number']) ? 9 : $new_instance['number'];
			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['wae_about_widget']) )
				delete_option('wae_about_widget');
			return $instance;
		}

		// based on https://gist.github.com/cosmocatalano/4544576
		function scrape_instagram($username, $slice = 8) {

			if (false === ($instagram = get_transient('instagram-media-'.sanitize_title_with_dashes($username)))) {

				$remote = wp_remote_get('http://instagram.com/'.trim($username));

				if (is_wp_error($remote))
		  			return new WP_Error('site_down', __('Unable to communicate with Instagram.', THEMENAME));

	  			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
	  				return new WP_Error('invalid_response', __('Instagram did not return a 200.', THEMENAME));

				$shards = explode('window._sharedData = ', $remote['body']);
				$insta_json = explode(';</script>', $shards[1]);
				$insta_array = json_decode($insta_json[0], TRUE);
				if (!$insta_array)
		  			return new WP_Error('bad_json', __('Instagram has returned invalid data.', THEMENAME));

				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];

				$instagram = array();

				foreach ($images as $image) {

					if ($image['user']['username'] == $username) {

						$image['link']                          = preg_replace( "/^http:/i", "", $image['link'] );
						$image['images']['thumbnail']           = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
						$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );

						$instagram[] = array(
							'description'   => $image['caption']['text'],
							'link'          => $image['link'],
							'time'          => $image['created_time'],
							'comments'      => $image['comments']['count'],
							'likes'         => $image['likes']['count'],
							'thumbnail'     => $image['images']['thumbnail'],
							'large'         => $image['images']['standard_resolution'],
							'type'          => $image['type']
						);
					}
				}

				$instagram = base64_encode( serialize( $instagram ) );
				set_transient('instagram-media-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
			}

			$instagram = unserialize( base64_decode( $instagram ) );

			return array_slice($instagram, 0, $slice);
		}
	}
?>