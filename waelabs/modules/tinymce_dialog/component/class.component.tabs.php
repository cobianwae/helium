<?php
	class WAE_component_tabs extends WAE_component_base{
		function __construct(){
			$this->component_control = array('tabs', __('Tabs', THEMENAME) );
			parent::__construct();
		}
		function display_form(){
			?>
			<div id="tabs">
				<table class="form-table">
					<tr>
						<td>
							<label><?php _e('Type', THEMENAME) ?></label>						
						</td>
						<td>
							<select name="type">
								<option value="horizontal" selected="selected"><?php _e('Horizontal', THEMENAME) ?></option>
								<option value="vertical"><?php _e('Vertical', THEMENAME) ?></option>
							</select>
						</td>
					</tr>
				</table>
				<table class="form-table">
					<tr class="tab-content">
						<td>
							<label><?php _e('Title', THEMENAME) ?></label>
							<input type="text" name="title" />
						</td>
						<td>
							<label><?php _e('Active?', THEMENAME) ?></label>
							<input type="radio" name="active" value="1" />
						</td>
						<td>
							<input type="button" class="add-tab" value="<?php _e('Add Tab', THEMENAME) ?>" />
							<input type="button" class="remove-tab" style="display:none" value="<?php _e('Remove Tab', THEMENAME) ?>"/>
						</td>
					</tr>
					<tr class="last">
						<td colspan="3" class="submit-holder"><a class="button submit-tabs button-primary"><?php _e('Add Shortcode',THEMENAME) ?></a></td>
					</tr>
				</table>
			</div>
			<?php
		}
	}
?>