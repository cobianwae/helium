<?php
	class WAE_profile_extras_admin{
		function __construct(){
			add_action('show_user_profile', array( $this, 'social_accounts' ) );
			add_action('personal_options_update', array( $this, 'social_accounts_update' ) );
		}

		function social_accounts(){
			global $user_ID;
			$social_accounts = get_user_meta($user_ID, "social_accounts");
			if(is_array($social_accounts))
			        $social_accounts = $social_accounts[0];
			$maps = array( 
				'facebook' => 'Facebook',
				'twitter' => 'Twitter',
				'google-plus' => 'Google Plus',
				'vimeo' => 'Vimeo',
				'dribbble ' => 'Dribbble',
				'pinterest' => 'Pinterest',
				'youtube' => 'Youtube',
				'thumblr' => 'Thumblr',
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
			?>
		    <h3><?php _e('Social Accounts', THEMENAME) ?></h3>
		    <table class="form-table">
		    <?php 
		    foreach ($maps as $account => $label) {
		    	$value = !empty($social_accounts[$account]) ? $social_accounts[$account] : '';
		    	?>
		    	<tr>
		            <th><label for="social_accounts[<?php echo $account ?>]">
		            	<?php echo $label ?></label></th>
		            <td><input class="regular-text" type="text" id="social_accounts[<?php echo $account ?>]" 
		            name="social_accounts[<?php echo $account ?>]" 
		            value="<?php echo $value ?>" /><br />
		            <span class="description"><?php echo __('Enter your ', THEMENAME) . $label . __(' Address here', THEMENAME) ?></span></td>
		        </tr>
		    	<?php
		    }?>
		    </table>
		    <?php
		}

		function social_accounts_update(){
			global $user_ID;
    		update_user_meta($user_ID, "social_accounts",$_POST['social_accounts']); 
		}
	}
?>