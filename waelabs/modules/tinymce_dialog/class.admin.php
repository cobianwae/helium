<?php
	class WAE_tinymce_dialog_admin{
		function __construct(){
			add_action('init', array( $this, 'button_hooks' ) );
			add_action( 'admin_footer', array( $this, 'dialog_content' ) );
			add_action( 'after_setup_theme', array($this, 'editor_style' ));
		}

		function button_hooks(){
			if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
				add_filter("mce_external_plugins", array( $this, "register_scripts" ) );
				add_filter('mce_buttons', array ( $this, 'register_buttons' ) );
			}
		}

		function register_scripts(){
			$plugin_array['wae_editor_helper'] =   WAE_BASE_URL .'js/tinymce-button.js';
			return $plugin_array;
		}

		function register_buttons( $buttons ){
			array_push( $buttons, 'wae_editor_helper', 'dropcap' );
			return $buttons;
		}

		function dialog_content(){
			?>
			<div id="wae_editor_helper" style="display:none">
				<div class="header">
					<table class="form-table">
						<tr>
							<th>
								<label><?php _e( 'Choose Component', THEMENAME) ?>:</label>
							</th>
							<td>
								<select id="select-component" class="widefat">
									<?php do_action('wae_helper_options') ?>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="active-area">
					<?php do_action('wae_helper_active') ?>
				</div>
				<div class="hidden-area">
					<?php do_action('wae_helper_hidden') ?>
				</div>
			</div>
			<?php
		}

		function editor_style(){
			add_editor_style( WAE_BASE_URL .'css/admin-style.css' );
		}

	}
?>