<?php
	class WAE_shortcodes_tabs{
		function __construct(){
			add_shortcode('wae_tabs', array($this, 'display_tabs'));
			add_shortcode('wae_tab', array($this, 'display_tab'));
			global $tab_header;
			global $tab_content;
			$tab_header = 0;
			$tab_content = 0;
		}

		function display_tabs($atts, $content){
			extract(shortcode_atts(array("type" => "" ),$atts));
			ob_start();
			$content_header = str_replace('[wae_tab', '[wae_tab is_header="1"', $content);
			?>
			<div class="tabs-wrapper">
			<dl class="tabs <?php echo $type ?>" data-tab>
				<?php echo do_shortcode($content_header) ?>
			</dl>
			<div class="tabs-content <?php echo $type ?>">
				<?php echo do_shortcode($content) ?>
			</div>
			<div class="clear"></div>
			</div>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
		function display_tab($atts, $content){
			global $tab_header;
			global $tab_content;
			extract(shortcode_atts(array("title" => "", "is_header" =>"0", "active"=>"0" ),$atts));
			$active_class = '';
			if($active == '1') $active_class = 'active';
			ob_start();
			if($is_header == '1'){
				?>
				<dd class="<?php echo $active_class ?>"><a href="#tab<?php echo $tab_header ?>"><?php echo $title ?></a></dd>
				<?php
			}else{
				?>
				 <div class="content <?php echo $active_class ?>" id="tab<?php echo $tab_content ?>">
				    <?php echo $content ?>
				  </div>
				<?php
			}
			$result = ob_get_contents();
			ob_end_clean();
			if($is_header){
				$tab_header++;
			}else{
				$tab_content++;
			}
			return $result;
		}
	}