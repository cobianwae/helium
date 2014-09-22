<?php
	class WAE_component_row extends WAE_component_base
	{
		function __construct(){
			$this->component_control = array('row', __('Row', THEMENAME) );
			parent::__construct();
		}

		function display_form(){
			?>
			<div id="row">
				<h4><?php _e('Row', THEMENAME) ?></h4>
				<table id="columns-type" class="form-table">
					<tr>
						<td class="c-1"><span class="value">1</span>1 Column<div class="bg"></div></td>
						<td class="c-2"><span class="value">2</span>2 Columns<div class="bg"></div></td>
						<td class="c-3"><span class="value">3</span>3 Columns<div class="bg"></div></td>
					</tr>
					<tr>
						<td class="c-2-3"><span class="value">2/5-3/5</span>2:3 Columns<div class="bg"></div></td>
						<td class="c-3-2"><span class="value">3/5-2/5</span>3:2 Columns<div class="bg"></div></td>
					</tr>
					<tr class="last">
						<td colspan="3" class="submit-holder"><a class="button submit-row button-primary">Add Shortcode</a></td>
					</tr>
				</table>
			</div>
			<?php
		}
	}
?>