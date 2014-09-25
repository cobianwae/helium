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
						$this->menu_on_side('right', 'left');
						break;
					
					case '2':
						$this->menu_on_side('left', 'right');
						break;
					

					default:
						$this->menu_on_center();
						break;
				}
			}
		}

		function menu_on_side($menu_side, $logo_side){
			?>
			<div class="contain-to-grid">
				<nav class="top-bar" data-topbar>
					<ul class="title-area <?php echo $logo_side?>">
				    	<li class="name">
				    		<?php do_action( 'wae_logo', 'light' ) ?>
				    	</li>
				    	<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
				    </ul>
				    <section class="top-bar-section">
						<?php do_action( 'wae_menu', 'primary', $menu_side) ?>
					</section>
				</nav>
			</div>
			<?php
		}

		function menu_on_center(){
			?>
			<div class="contain-to-grid">
				<nav class="top-bar center" data-topbar>
						<ul class="title-area">
						    	<li class="name">
						    		<?php do_action( 'wae_logo', 'light' ) ?>
						    	</li>
						    	<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
					    </ul>
				    <section class="top-bar-section">
						<?php do_action( 'wae_menu', 'primary','center') ?>
					</section>
				</nav>
			</div>
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