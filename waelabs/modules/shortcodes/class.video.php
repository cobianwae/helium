<?php
	class WAE_shortcodes_video{
		function __construct(){
			add_shortcode('wae_video', array( $this, 'player'));
		}

		function player($atts, $content){
			WAE::resolve_scripts( array( 'mediaplayer' ) );
			extract(shortcode_atts(array("mp4" => "std-blog-sidebar", "ogv" => "", "poster" => ""),$atts));
			ob_start();
			?>
				<video controls="controls" style="width: 100%; height: 100%;" poster="<?php echo  $poster ?>">

					<source src="<?php echo  $mp4 ?>" type="video/mp4" title="mp4">
					<!-- <source src="../media/echo-hereweare.webm" type="video/webm" title="webm"> -->
					<source src="<?php echo  $ogv ?>" type="video/ogg" title="ogg"> -->
					<p>Your browser leaves much to be desired.</p>
					<object  width="100%"   type="application/x-shockwave-flash" data="<?php echo  LC_BASE_URL.'/js/' ?>flashmediaelement.swf">
						<param name="movie" value="<?php echo  LC_BASE_URL.'/js/' ?>flashmediaelement.swf" />
						<param name="flashvars" value="controls=true&file=<?php echo  $mp4 ?>" />
						<!-- Image as a last resort -->
						<img src="<?php echo  $poster ?>" width="100%" title="No video playback capabilities" />
					</object>
				</video>
					

			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
	}
?>