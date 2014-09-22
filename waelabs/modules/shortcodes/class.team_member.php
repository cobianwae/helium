<?php
	class WAE_shortcodes_team_member{
		function __construct(){
			add_shortcode( 'wae_team_member', array($this, 'display') );
		}

		function display($atts, $content){
			extract(shortcode_atts(array("img_position" => "left", "img_url" => "", "social_accounts" => ""),$atts));
			ob_start();
			?>
			<div class="author-biography from-shortcode">
				<div class="author-pic <?php echo $img_position?>">
				 	<img src="<?php echo $img_url ?>" />
				 	<?php $this->social_accounts($social_accounts) ?>
				 </div>
				 <div class="desc">
					<?php echo do_shortcode($content) ?>
				</div>
				<div class="clear">
				</div>
			</div>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
		function social_accounts( $social_accounts ){
			$social_accounts = explode(',', $social_accounts);
			$length = count($social_accounts);
			if($length == 0) return;
			echo "<ul>";
			for ($i=0; $i < $length; $i+=2) { 
				$class = $social_accounts[$i];
				if( $social_accounts[$i] == 'vimeo' ){
					$class .= '-square';
				}
				if( !empty($social_accounts[$i+1] )){
					echo '<li><a href="'. $social_accounts[$i+1].'" class="'. $social_accounts[$i].'">
	               		<i class="fa fa-'.$class.'"></i>
	               		</a></li>';
				}
			}
			echo "</ul>";
		}
	}
?>