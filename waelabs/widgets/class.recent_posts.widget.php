<?php 
	class WAE_recent_posts_widget extends WP_widget {
		function __construct () {
			$widget_ops = array(
				'classname' => 'wae_recent_posts_widget', 
				'description' => __( "Your site&#8217;s most recent Posts.", THEMENAME) );
			parent::__construct('wae_recent_posts_widget', 'WAE - ' . __('Recent Posts', THEMENAME), $widget_ops);
			$this->alt_option_name = 'wae_recent_posts_widget';
		}

		

		public function widget( $args, $instance ) {
			/*$cache = array();
			if( ! $this->is_preview() ) {
				$cache = wp_cache_get( 'widget_recent_posts', 'widget' );				
			}

			if( ! is_array($cache) ) {
				$cache = array();
			}

			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}

			ob_start();*/

			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
			if ( ! $number )
				$number = 5;
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
			$show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : false;

			/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
			$r = new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true
				) ) );

			if ($r->have_posts()) :
	?>
			<?php echo $args['before_widget']; ?>
			<?php if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			} ?>

			<ul>
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				
				<?php if ( $show_thumbnail ) : ?>
					<li class="wae-recent-posts-thumbnail">
						<a href="<?php the_permalink(); ?>">					
							<div class="post_thumbnail">
								<?php echo get_the_post_thumbnail($post['ID'], array(70,70)); ?>
							</div>					
							<span class="post-title"><?php get_the_title() ? the_title() : the_ID(); ?></span>						
							<?php if ( $show_date ) : ?>
								<span class="post-date"><?php echo get_the_date(); ?></span>
							<?php endif; ?>
						</a>					
					</li>
				<?php else: ?>
					<li class="wae-recent-posts-list">
						<a href="<?php the_permalink(); ?>">											
							<?php get_the_title() ? the_title() : the_ID(); ?>
							<?php if ( $show_date ) : ?>
								<span class="post-date"><?php echo get_the_date(); ?></span>
							<?php endif; ?>
						</a>					
					</li>
					<?php endif; ?>
				
			<?php endwhile; ?>

			</ul>
			<?php echo $args['after_widget']; ?>
	<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

			endif;

			if ( ! $this->is_preview() ) {
				$cache[ $args['widget_id'] ] = ob_get_flush();
				wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
			} else {
				ob_end_flush();
			}
		
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
			$instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? (bool) $new_instance['show_thumbnail'] : false;
			$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['widget_recent_entries']) )
				delete_option('widget_recent_entries');

			return $instance;
		}

		public function flush_widget_cache() {
			wp_cache_delete('widget_recent_posts', 'widget');
		}

		public function form( $instance ) {
			$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
			$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : false;
			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

			<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>

			<p><input class="checkbox" type="checkbox" <?php checked( $show_thumbnail ); ?> id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Display thumbnail?' ); ?></label></p>
	<?php
		}		
	}
?>