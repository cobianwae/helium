<?php
	class WAE_popular_posts_widget extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname' => 'wae_popular_posts_widget', 
				'description' => __( "Your site&#8217;s most Popular Posts.", THEMENAME) );
			parent::__construct('wae-popular-posts', 'WAE - ' . __('Popular Posts', THEMENAME), $widget_ops);
			$this->alt_option_name = 'wae_popular_posts_entries';
			add_action( 'save_post', array($this, 'flush_widget_cache') );
			add_action( 'deleted_post', array($this, 'flush_widget_cache') );
			add_action( 'switch_theme', array($this, 'flush_widget_cache') );
			add_action( 'wp_head', array($this, 'count_post_view') );
			add_action( 'admin_footer', array( $this, 'add_scripts' ) );
		}

		function widget($args, $instance) {
			$cache = array();
			if ( ! is_preview() ) {
				$cache = wp_cache_get( 'wae_popular_posts_widget', 'widget' );
			}

			if ( ! is_array( $cache ) ) {
				$cache = array();
			}

			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}

			ob_start();
			extract($args);

			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Popular Posts', THEMENAME );

			/** This filter is documented in wp-includes/default-widgets.php */
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
			$order_by = !empty( $instance['order_by'] ) ? $instance['order_by'] : 'comment-count';
			$style = !empty( $instance['style'] ) ? $instance['style'] : 'compact-list';

			if ( $style == 'compact-list' ){
				$compact_options['show_thumbnail'] = !empty( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : false;
				$compact_options['show_title'] = !empty( $instance['show_title'] ) ? $instance['show_title'] : false;
				$compact_options['show_date'] = !empty( $instance['show_date'] ) ? $instance['show_date'] : false;
				$compact_options['show_excerpt'] = !empty( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : false;
			}

			/**
			 * Filter the arguments for the Popular Posts widget.
			 *
			 * @since 3.4.0
			 *
			 * @see WP_Query::get_posts()
			 *
			 * @param array $args An array of arguments used to retrieve the Popular Posts.
			 */
			if ( $order_by == 'comment-count' ){
				$r = new WP_Query( apply_filters( 'widget_posts_args', array(
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'orderby' => $order_by,
					'ignore_sticky_posts' => true
				) ) );
			}else{
				$r = new WP_Query( apply_filters( 'widget_posts_args', array(
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'orderby' => 'meta_value_num',
					'meta_key' => '_wae_post_views',
					'ignore_sticky_posts' => true
				) ) );
				if ( !$r->have_posts()) {
					$r = new WP_Query( apply_filters( 'widget_posts_args', array(
						'posts_per_page'      => $number,
						'no_found_rows'       => true,
						'post_status'         => 'publish',
						'orderby' => $order_by,
						'ignore_sticky_posts' => true
					) ) );
				}
			}
			

			if ($r->have_posts()) :
			?>
			<?php echo $before_widget; ?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul id="wae-popular-posts" class="<?php echo $style ?>">
			<?php while ( $r->have_posts() ) : $r->the_post();
				if ( $style == 'compact-list' ){
					$this->compact_list_display( $compact_options );
				}else{
					$this->thumbnail_list_display();
				}
			endwhile; ?>
			</ul>
			<?php echo $after_widget; ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

			endif;

			if ( !is_preview() ) {
				$cache[ $args['widget_id'] ] = ob_get_flush();
				wp_cache_set( 'wae_popular_posts_widget', $cache, 'widget' );
			} else {
				ob_end_flush();
			}
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			$instance['order_by'] = isset( $new_instance['order_by'] ) ? $new_instance['order_by'] : 'comment_count';
			$instance['style'] = isset( $new_instance['style'] ) ? $new_instance['style'] : 'compact-list';
			$instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? (bool) $new_instance['show_thumbnail'] : false;
			$instance['show_title'] = isset( $new_instance['show_title'] ) ? (bool) $new_instance['show_title'] : false;
			$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
			$instance['show_excerpt'] = isset( $new_instance['show_excerpt'] ) ? (bool) $new_instance['show_excerpt'] : false;
			$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['wae_popular_posts_widget']) )
				delete_option('wae_popular_posts_widget');
			return $instance;
		}

		function flush_widget_cache() {
			wp_cache_delete('wae_popular_posts_widget', 'widget');
		}

		function form( $instance ) {
			$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			$order_by = isset( $instance['order_by'] ) ? $instance['order_by'] : 'comment_count';
			$style = isset( $instance['style'] ) ? $instance['style'] : 'compact-list';
			$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
			$show_title = isset( $instance['show_title'] ) ? (bool) $instance['show_title'] : true;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
			$show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : true;
			$compact_list_options_display = $style == 'compact-list' ? 'block' : 'none';
			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEMENAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', THEMENAME ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

			<p><label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order By', THEMENAME ); ?></label>
			<select id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>" >
				<option value="comment-count" <?php selected( $order_by, "comment-count" ); ?>><?php _e('Comment Count', THEMENAME) ?></option>
				<option value="post-views" <?php selected( $order_by, "post-views" ); ?>><?php _e('Post Views', THEMENAME) ?></option>
			</select></p>

			<p><label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style type', THEMENAME ); ?></label>
			<select class="wpp-style-type" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" >
				<option value="compact-list" <?php selected( $style, "compact-list" ); ?>><?php _e('Compact List', THEMENAME) ?></option>
				<option value="thumbnail-only" <?php selected( $style, "thumbnail-only" ); ?>><?php _e('Thumbnail Only', THEMENAME) ?></option>
			</select></p>

			<div class="compact-list-options" style="display:<?php echo $compact_list_options_display ?>">
				<p><label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Show Thumbnail?', THEMENAME ); ?></label>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" value="1" <?php checked( $show_thumbnail, 1 ); ?> /></p>
				
				<p><label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title?', THEMENAME ); ?></label>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1" <?php checked( $show_title, 1 ); ?> /></p>

				<p><label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date?', THEMENAME ); ?></label>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" value="1" <?php checked( $show_date, 1 ); ?> /></p>

				<p><label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Show Excerpt?', THEMENAME ); ?></label>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" value="1" <?php checked( $show_excerpt, 1 ); ?> /></p>
			</div>
			<?php
		}

		private function post_icon(){
			$post_format = get_post_format();
			if (!$post_format) $post_format = 'standard';
			$maps = array(
				'standard' => 'icon-pen',
				'link' => 'icon-clip',
				'quote' => 'icon-bulb',
				'gallery'=> 'icon-photo',
				'video' => 'icon-video',
				'audio' => 'icon-music'
 			);
 			$icon = $maps[$post_format];
			echo "<span class='$icon'></span>";

		}

		function the_excerpt_max_charlength($charlength) {
			$excerpt = get_the_excerpt();
			$charlength++;

			if ( mb_strlen( $excerpt ) > $charlength ) {
				$subex = mb_substr( $excerpt, 0, $charlength - 5 );
				$exwords = explode( ' ', $subex );
				$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
				if ( $excut < 0 ) {
					echo mb_substr( $subex, 0, $excut );
				} else {
					echo $subex;
				}
				echo '...';
			} else {
				echo $excerpt;
			}
		}

		function compact_list_display( $compact_options ){
			?>
				<li class="wae-popular-posts">
					<a href="<?php the_permalink(); ?>">
						<?php 
							if ( $compact_options['show_thumbnail'] ){
								if( has_post_thumbnail() ){
									the_post_thumbnail();
								}else{
									echo '<div class="no-image">';
									$this->post_icon();
									echo '</div>';
								}
							}
						?>
						<?php
							if ( $compact_options['show_title'] ){
								echo '<h4>';
								the_title();
								echo '</h4>';
							}
						?>
						<?php
							if ( $compact_options['show_date'] ){
								echo '<p class="post-date">';
								the_time( get_option('date_format') );
								echo '</p>';
							}
						?>
						<?php
							if ( $compact_options['show_excerpt'] ){
								$this->the_excerpt_max_charlength(90);
							}
						?>
					</a>
				</li>
			<?php
		}

		function thumbnail_list_display(){
			?>
				<li class="wae-popular-posts">
					<?php 
							if( has_post_thumbnail() ){
								the_post_thumbnail('landscape');
							}else{
								echo '<div class="no-image">';
								$this->post_icon();
								echo '</div>';
							} 
					?>
					<a href="<?php the_permalink(); ?>"><h4><?php the_title() ?></h4></a>
				</li>
			<?php
		}

		function count_post_view(){
			if( is_page() || !is_single() ) return;
			global $post;

			$key = '_wae_post_views';
			$post_views = get_post_meta( $post->ID, $key, true  );
			if ( empty( $post_views ) ){
				add_post_meta( $post->ID, $key, 0 );
			}else{
				$post_views++;
				update_post_meta( $post->ID, $key, $post_views);
			}
		}

		function add_scripts(){
			?>
				<script type="text/javascript">
					(function($,window,undefined){
						$(document).ready(function(){
							var runScript = function(){
								$('.wpp-style-type').change(function(){
									var val = $(this).val();
									if(val == 'compact-list'){
										$(this).closest('form').find('.compact-list-options').show();
									}else{
										$(this).closest('form').find('.compact-list-options').hide();
									}
								});
							};

							runScript();

							$( document ).ajaxStop( function() {
						        runScript();
						    });
						});
					}(jQuery,window));
				</script>
			<?php
		}
	}

?>