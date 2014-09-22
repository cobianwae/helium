<?php
	class WAE_component_accordion extends WAE_component_base{
		function __construct(){
			$this->component_control = array('accordion', __('Accordion', THEMENAME) );
			parent::__construct();
		}

		function display_form(){
			?>
			<div id="accordion">
				<h4><?php _e('Accordion', THEMENAME) ?></h4>
				<table class="form-table">
					<tr class="accordion-content">
						<td>
							<label><?php _e('Title', THEMENAME) ?></label>
							<input type="text" name="title" />
						</td>
						<td>
							<label><?php _e('Active?', THEMENAME) ?></label>
							<input type="radio" name="active" value="1" />
						</td>
						<td>
							<input type="button" class="add-accordion" value="<?php _e('Add Accordion', THEMENAME) ?>" />
							<input type="button" class="remove-accordion" style="display:none" value="<?php _e('Remove Accordion', THEMENAME) ?>"/>
						</td>
					</tr>
					<tr class="last">
						<td colspan="3" class="submit-holder"><a class="button submit-accordion button-primary"><?php _e('Add Shortcode',THEMENAME) ?></a></td>
					</tr>
				</table>
			</div>
			<?php
		}
	}
?>