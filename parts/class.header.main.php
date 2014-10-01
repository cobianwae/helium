<?php
	class HL_header_main extends WAE_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'hl_primary_navigation', array( $this, 'display_primary_menu' ) );
			// add_filter('wp_nav_menu_items',array($this, 'search_button') );
		}

		function display_primary_menu(){
			$options = $this->options;
			if(!empty($options['nav_type'])){
				switch ($options['nav_type']) {
					case '1':
						$this->menu_with_position('right', 'left');
						break;
					
					case '2':
						$this->menu_with_position('left', 'right');
						break;
					

					default:
						$this->menu_with_position('center', '');
						break;
				}
			}
		}

		function menu_with_position($menu_side, $logo_side){
			$top_bar_side = ($menu_side == 'center') ? $menu_side : '';		

			?>

			<div class="contain-to-grid wrapper-nav header-container">
				<nav class="top-bar <?php echo $top_bar_side; ?>" data-topbar role="navigation">									
					<ul class="title-area <?php echo $logo_side?>">
				    	<li class="name">
				    		<?php do_action( 'wae_logo', 'light' ) ?>
				    	</li>
				    	<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
				    </ul>
				    <section class="top-bar-section <?php echo $this->options['hover_type'] ?>">
						<?php do_action( 'wae_menu', 'primary', $menu_side) ?>
					</section>
				</nav>
			</div>
			<div class="contain-to-grid full-screen wrapper-header-background" style="background-image:url(<?php bloginfo('template_directory'); ?>/images/5-copy.jpg)"></div>
			<div class="parent-wrapper-nav-sticky"></div>
			<?php
		}

		function search_button($items){
			return $items.'<li class="search-wrapper">
								<form role="search" method="get" id="searchform" action="'. home_url( "/" ) . '">
									<a class="search-button" title="Search" href="#"><i class="fa fa-search"></i></a>
					    			<input type="text" value="'.get_search_query().'"  autocomplete="off" name="s" id="s" />
					        		<a class="close-search-button" title="Search" href="#"><i class="fa fa-times"></i></a>
					    		</form>
							</li>';
		}


	}
?>