<?php
	class WAE_header_main extends WAE_parts_base{

		function __construct(){
			parent::__construct();
			add_action( 'wp_head', array( $this, 'display_favicon' ) );
			add_action( 'wae_logo', array( $this, 'display_logo' ), 10, 1 );
			add_action( 'wae_html_head', array( $this, 'display_html_head' ) );
			add_action( 'wae_menu', array( $this, 'display_menu' ), 10, 2);
		}

		function display_favicon(){
			$options = $this->options;
			if ( !empty( $options['wae_favicon'] ) ) {
				$url = $options['wae_favicon']['url'];
				if( $url != null)   {
				  $type = "image/x-icon";
				  if(strpos( $url, '.png' )) $type = "image/png";
				  if(strpos( $url, '.gif' )) $type = "image/gif";
				  $html = '<link rel="icon" href="'.$url.'" type="'.$type.'">';
				  echo apply_filters( 'wae_favicon_display', $html );
				}
			}
		}

		function display_html_head(){
			?>
			<head>
			    <meta charset="utf-8" />
			    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		    	<link rel="profile" href="http://gmpg.org/xfn/11" />
		       	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
			    <title><?php wp_title("|",true, 'right'); ?> <?php if (!defined('WPSEO_VERSION')) { bloginfo('name'); } ?></title>
			    <?php wp_head(); ?>
		  	</head>
		  	<?php
		}

		function display_logo( $scheme ){	
			if ( empty( $this->options['wae_use_logo'] ) || 
				$this->options['wae_use_logo'] != '1' ||
				empty( $this->options['wae_logo']) ){
				echo '<a class="logo-title" href="'. get_home_url() .'">' . 
							get_bloginfo('name') . 
						'</a>';
			}else{
				if($scheme == 'light'){
					echo '<a class="logo-light" href="'. get_home_url() . '">
								<img src="' . $this->options['wae_logo']['url'] . '" 
									 alt="' .get_bloginfo('name'). '" />
							</a>';
				}else{
					echo '<a class="logo-light" href="'. get_home_url() . '">
								<img src="' . $this->options['wae_logo']['url'] . '" 
									 alt="' .get_bloginfo('name'). '" />
							</a>';
					echo '<a class="logo-dark" href="'. get_home_url() . '">
								<img src="' . $this->options['wae_dark_logo']['url'] . '" 
									 alt="' .get_bloginfo('name'). '" />
							</a>';
				}
			}
		}

		function display_menu( $location, $position ){
			require_once('includes/class.walker.top_bar.php');
			wp_nav_menu( array(
                'menu'              => 	$location,
                'theme_location'    =>  $location,
                'depth'             => 3,
                'container'         => '',
                'container_class'   => '',
        		'container_id'      => '',
        		'link_before'		=> '<span>',
        		'link_after'		=> '</span>',
                'menu_class'        => $position,
                'fallback_cb'       => 'Top_Bar_Walker::fallback',
                'walker'            => new Top_Bar_Walker())
            );
		}

	}
?>