<?php
	class WAE_component_highlight extends WAE_component_base{
		function __construct(){
			$this->component_control = array('highlight', __('Highlight', THEMENAME) );
			parent::__construct();
			add_action( 'admin_enqueue_scripts', array($this,'color_picker') );
		}
		function display_form(){
			?>
			<div id="highlight">
				<table class="form-table">
					<tr>
						<td>
							<label><?php _e('Background Color', THEMENAME) ?></label>						
						</td>
						<td>
							<input type='text' class='color-field' name="highlight-color" />
						</td>
					</tr>
					<tr>
						<td>
							<label><?php _e('Font Color', THEMENAME) ?></label>						
						</td>
						<td>
							<select class="font-color">
								<option value="light" selected="selected"><?php _e('Light', THEMENAME) ?></option>
								<option value="dark" ><?php _e('Dark', THEMENAME) ?></option>
							</select>
						</td>
					</tr>
					<tr class="last">
						<td colspan="2" class="submit-holder"><a class="button submit-highlight button-primary"><?php _e('Highlight',THEMENAME) ?></a></td>
					</tr>
				</table>
			</div>
			<?php
		}
		function color_picker( $hook ){
			if( is_admin() ) { 
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script('wp-color-picker'); 
			}
		}
	}
?>