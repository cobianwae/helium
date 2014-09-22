<?php
	class WAE_shortcodes_audio{
		function __construct(){
			add_shortcode('wae_audio', array($this, 'player'));
		}
		
		function player($atts, $content){
			WAE::resolve_scripts( array( 'mediaplayer' ) );
			extract(shortcode_atts(array("mp3" => "", "ogg" => ""),$atts));
			ob_start();
			?>
				<audio class="kv-audio" controls="controls" style="width: 100%;">
					<source src="<?php echo  $mp3 ?>" type="audio/mp3">
					<source src="<?php echo  $ogg ?>" type="audio/ogg">
				</audio>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
	}
?>