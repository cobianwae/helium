<?php 
	class WAE_component_team_member extends WAE_component_base{
		function __construct(){
			$this->component_control = array('team-member', __('Team Member', THEMENAME) );
			parent::__construct();
		}

		function display_form(){
			WAE::admin_resolve_scripts( array( 'media-uploader' ) );
			?>
			<div id="team-member">
				<h4><?php _e('Team Member', THEMENAME) ?></h4>
				<table class="form-table">
					<tr>
						<th>
							<label><?php echo  _e('Preview Image', THEMENAME) ?></label>
						</th>
						<td>
							<div id="member-preview-image"></div>
		        			<input  type="hidden" name="member-photo" id="member-photo" />
							<input type="button" class="button image-button" value="<?php _e( 'Upload', THEMENAME )?>" />
							<input type="button" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
						</td>
					</tr>
					<tr>
						<th><label><?php echo _e('Image Position', THEMENAME) ?></label></th>
						<td>
							<input type="radio" name="img-position" class="left-pos" value="left" /> <?php _e('Left', THEMENAME) ?>
							<input type="radio" name="img-position" class="right-pos" value="right" /> <?php _e('Right', THEMENAME) ?>
						</td>
					</tr>
					<?php
						$maps = array( 
							'facebook' => 'Facebook',
							'twitter' => 'Twitter',
							'google-plus' => 'Google Plus',
							'vimeo' => 'Vimeo',
							'dribbble ' => 'Dribbble',
							'pinterest' => 'Pinterest',
							'youtube' => 'Youtube',
							'tumblr' => 'Tumblr',
							'linkedin' => 'LinkedIn',
							'rss' => 'RSS',
							'flickr' => 'Flickr',
							'skype' => 'Skype',
							'behance' => 'Behance',
							'instagram' => 'Instagram',
							'github' => 'GitHub',
							'stack-exchange' => 'StackExchange',
							'soundcloud' => 'Soundcloud' 
						);
						foreach ($maps as $account => $label) {
					    	$value = !empty($social_accounts[$account]) ? $social_accounts[$account] : '';
					    	?>
					    	<tr>
					            <th><label for="social_accounts"><?php echo $label. ' ' .__('Account', THEMENAME); ?></label></th>
					            <td><input class="regular-text social-accounts" type="text" id="<?php echo $account ?>" 
					            name="<?php echo $account ?>" /><br />
					            <span class="description"><?php echo __('Enter your ', THEMENAME) . $label . __(' Address here. Use http:// as prefix', THEMENAME) ?></span></td>
					        </tr>
					    	<?php
					    }?>
					    <tr class="last">
					    	<td colspan="2" class="submit-holder"><a class="button submit-team-member button-primary">Add Shortcode</a></td>
					    </tr>
				</table>
			</div>
			<?php
		}
	}
?>