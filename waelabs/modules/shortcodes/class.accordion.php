<?php
	class WAE_shortcodes_accordion{
		function __construct(){
			add_shortcode('accordion_content', array($this, 'display'));
			add_shortcode('wae_accordion', array($this, 'display_accordion'));
			global $accordion_index;
			$accordion_index = 0;
		}
		
		function display($atts, $content){
			global $accordion_index;
			extract(shortcode_atts(array("title" => "", "active" =>"0" ),$atts));
			ob_start();
			$active_class = '';
			if($active == '1'){
				$active_class = 'active';
			}
			?>
			<dd class="accordion-navigation <?php echo $active_class ?>">
			    <a href="#accordion<?php echo $accordion_index ?>"><?php echo $title ?></a>
			    <div id="accordion<?php echo $accordion_index ?>" class="content <?php echo $active_class ?>">
			     	<?php echo $content ?>
			    </div>
		  	</dd>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			$accordion_index++;
			return $result;
		}

		function display_accordion($atts, $content){
			WAE::resolve_scripts( array( 'accordion' ) );
			ob_start();
			?>
			<dl class="accordion" data-accordion>
				<?php echo do_shortcode( $content )?>
			</dl>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
	}
?>