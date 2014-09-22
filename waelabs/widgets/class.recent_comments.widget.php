<?php
class WAE_recent_comments_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'wae_recent_comments_widget', 
			'description' => __( 'Your site&#8217;s most recent comments.', THEMENAME ) );
		parent::__construct('wae-recent-comments', 'WAE - '.__('Recent Comments', THEMENAME), $widget_ops);
		$this->alt_option_name = 'wae_recent_comments';

		add_action( 'comment_post', array($this, 'flush_widget_cache') );
		add_action( 'edit_comment', array($this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array($this, 'flush_widget_cache') );
	}

	function flush_widget_cache() {
		wp_cache_delete('wae_recent_comments_widget', 'widget');
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_title = isset( $instance['show_title'] ) ? (bool) $instance['show_title'] : true;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : true;
		$thumbnail_type = isset( $instance['thumbnail_type'] ) ? $instance['thumbnail_type'] : 'square';
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',THEMENAME ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of comments to show:',THEMENAME ); ?> </label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Post Title?', THEMENAME ); ?> </label>
		<input type="checkbox" id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" value="1" <?php checked( $show_title, 1 ); ?> /></p>

		<p><label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date?', THEMENAME ); ?> </label>
		<input type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" value="1" <?php checked( $show_date, 1 ); ?> /></p>

		<p><label for="<?php echo $this->get_field_id( 'thumbnail_type' ); ?>"><?php _e( 'thumbnail_type', THEMENAME ); ?> :</label>
		<input type="radio"  name="<?php echo $this->get_field_name( 'thumbnail_type' ); ?>" value="square" <?php checked( $thumbnail_type, 'square' ); ?> /> Square<br/>
		<input type="radio"  name="<?php echo $this->get_field_name( 'thumbnail_type' ); ?>" value="circle" <?php checked( $thumbnail_type, 'circle' ); ?> /> Circle</p>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['wae_recent_comments_widget']) )
			delete_option('wae_recent_comments_widget');

		return $instance;
	}
	function widget($args, $instance) {
		global $comments, $comment;

		$cache = array();
		if ( is_preview() ) {
			$cache = wp_cache_get('wae_recent_comments_widget', 'widget');
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		extract($args, EXTR_SKIP);
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments',THEMENAME );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		/**
		 * Filter the arguments for the Recent Comments widget.
		 *
		 * @since 3.4.0
		 *
		 * @see get_comments()
		 *
		 * @param array $comment_args An array of arguments used to retrieve the recent comments.
		 */
		$comments = get_comments( apply_filters( 'widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		) ) );

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul id="wae-recent-comments">';
		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				$output .=  '<li class="wae-recent-comments">' . 
				/* translators: comments widget: 1: comment author, 2: post link */ 
				'<a href="' . 
				esc_url( get_comment_link($comment->comment_ID) ) . '">' . 
				'<div class="comment-author">'. get_avatar( $comment->comment_author_email ) . '</div>' .
				'<h4>'. $comment->comment_author . '</h4>' . 
				'<p>' .   $this->trim_words(  $comment->comment_content) . '</p>' .
				'</a></li>';
			}
		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;

		if ( is_preview() ) {
			$cache[ $args['widget_id'] ] = $output;
			wp_cache_set( 'wae_recent_comments_widget', $cache, 'widget' );
		}
	}

	function trim_words( $words ){
		if ( mb_strlen( $words, 'utf8' ) > 90 ) {
		   $last_space = strrpos( substr( $words, 0, 90 ), ' ' ); // find the last space within 35 characters
		   $words = substr($words, 0, $last_space ) . '...';
		}
		return $words;
	}
}
?>