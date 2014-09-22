<?php
	class WAE_comment_main extends WAE_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'wp_enqueue_scripts', array( $this, 'reply_script' ) );
			add_action( 'wae_comment_list', array( $this, 'display' ) );
			add_action( 'wae_comment_form', array( $this, 'form' ) );
		}

		function reply_script(){
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		        // enqueue the javascript that performs in-link comment reply fanciness
		        wp_enqueue_script( 'comment-reply' );
		    }
			
		}

		function display(){
			if ( have_comments() ) :
			?>
				<ul id="comments">
					<li><?php comments_number(__('No Comments',THEMENAME), __('One Comment', THEMENAME), __('% Comments', THEMENAME) );?></li><!--
					--><li><a href="#respond" id="add-comments" onclick="javascript:document.getElementById('cancel-comment-reply-link').click()">Add Comments</a></li></ul>
				<div class="navigation">
					<div class="alignleft"><?php previous_comments_link() ?></div>
					<div class="alignright"><?php next_comments_link() ?></div>
				</div>

				<ul class="comment-list">
					<?php wp_list_comments(array('avatar_size' => 73)); ?>
				</ul>

		 	<?php else : // this is displayed if there are no comments so far ?>

			<?php if ( comments_open() ) : ?>
				<!-- If comments are open, but there are no comments. -->

			 <?php else : // comments are closed ?>
				<!-- If comments are closed. -->
				<!--<p class="nocomments">Comments are closed.</p>-->

			<?php endif;
			endif;
		}

		function form(){
			if ( comments_open() ){
				global $post;
				$commenter = wp_get_current_commenter();
				$req = get_option( 'require_name_email' );
				$aria_req = ( $req ? " aria-required='true'" : '' );
				global $current_user;
      			get_currentuserinfo();
      			$user_identity = $current_user->user_identity;
				$required_text = null;
				$args = array(
				  'id_form'           => 'commentform',
				  'id_submit'         => 'submit',
				  'title_reply'       => __( 'Leave a Comment', THEMENAME ),
				  'title_reply_to'    => __( 'Leave a Reply to %s', THEMENAME ),
				  'cancel_reply_link' => __( 'Cancel Reply', THEMENAME ),
				  'label_submit'      => __( 'Submit', THEMENAME ),

				  'comment_field' =>  '<p><label for="comment">' . __( 'Comment', THEMENAME ) .
				      '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',

				  'must_log_in' => '<p class="must-log-in">' .
				    sprintf(
				      __( 'You must be <a href="%s">logged in</a> to post a comment.', THEMENAME ),
				      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				    ) . '</p>',

				  'logged_in_as' => '<p class="logged-in-as">' .
				    sprintf(
				    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', THEMENAME ),
				      admin_url( 'profile.php' ),
				      $user_identity,
				      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				    ) . '</p>',

				  'comment_notes_before' => '<p class="comment-notes">' .
				    __( 'Your email address will not be published.', THEMENAME ) . ( $req ? $required_text : '' ) .
				    '</p>',

				  'comment_notes_after' => '',

				  'fields' => apply_filters( 'comment_form_default_fields', array(

				    'author' =>
				      '<p><label for="author">' . __( 'Name', THEMENAME ) .
				      ' <span class="required">*</span></label><br/> ' .
				      '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				      '" size="30" /></p>',

				    'email' =>
				      '<p><label for="email">' . __( 'Email', THEMENAME ) .
				      ' <span class="required">*</span></label><br/>' .
				      '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				      '" size="30" /></p>',

				    'url' =>
				      '<p><label for="url">' .
				      __( 'Website', THEMENAME ) . '</label><br/>' .
				      '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				      '" size="30" /></p>'
				    )
				  ),
				);

				comment_form($args);

			}
		}
	}
?>