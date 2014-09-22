<?php
	class WAE_fire_resources{
		function __construct(){
		  	add_action( 'wp_enqueue_scripts', array( $this , 'load_main_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'resolve_main_scripts') );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
    		add_action( 'wp_footer', array( $this, 'load_scripts' ) );
		}

		function register_scripts(){
			if(!is_admin()){
				wp_register_script( 'easing' ,WAE_BASE_URL . 'js/jquery.easing.js' ,array( 'jquery' ),null, $in_footer = true);
				wp_register_script( 'popup', WAE_BASE_URL . 'js/jquery.magnific-popup.min.js');
				wp_register_script( 'foundation' ,WAE_BASE_URL . 'js/foundation.min.js' ,array( 'jquery' ),null, $in_footer = true);
				wp_register_script( 'foundation-equalizer' ,WAE_BASE_URL . 'js/foundation/foundation.equalizer.js' ,array( 'jquery' ),null, $in_footer = true);
				wp_register_script( 'mediaplayer', WAE_BASE_URL . 'js/mediaelement-and-player.min.js', array( 'jquery' ));
				wp_register_script( 'modernizr' ,WAE_BASE_URL . 'js/modernizr.js' ,array( 'jquery' ), null, $in_footer = false);
				wp_register_script( 'imagesloaded', WAE_BASE_URL . 'js/imagesloaded.pkgd.min.js', array( 'jquery' ));
				wp_register_script( 'masonry', WAE_BASE_URL . 'js/masonry.pkgd.min.js', array( 'jquery', 'imagesloaded'));
				wp_register_script( 'googlemap', "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false");
				wp_register_script( 'classie', WAE_BASE_URL . 'js/classie.js', array( 'jquery'));
				wp_register_script( 'animonscroll', WAE_BASE_URL . 'js/AnimOnScroll.js', array( 'jquery'));
				wp_register_script( 'flexslider', WAE_BASE_URL . 'js/jquery.flexslider-min.js',array( 'jquery', 'imagesloaded'));
			}
		}

		function load_main_styles(){
			if(!is_admin()){
				wp_register_style( 'flexslider', WAE_BASE_URL.'css/flexslider.css' );
				wp_register_style( 'foundation', WAE_BASE_URL.'css/foundation.min.css' );
				wp_register_style( 'font-awesome', WAE_BASE_URL.'css/font-awesome.min.css' );
				wp_register_style( 'mediaplayer', WAE_BASE_URL.'css/mediaelement/mediaelementplayer.min.css');
				wp_enqueue_style( 'popup', WAE_BASE_URL.'css/magnific-popup.css');
				wp_enqueue_style( 'velavo', get_stylesheet_uri(), array('foundation', 'font-awesome', 'flexslider', 'mediaplayer') );
			}
		}

		function resolve_main_scripts(){
			global $need_scripts;
			WAE::resolve_scripts( array( 'jquery', 'easing', 'foundation', 'modernizr', 'imagesloaded' ) );
		}

		function load_scripts(){
			if(!is_admin()){
				global $need_scripts;
				wp_enqueue_script( 'velavo', WAE_BASE_URL. 'js/velavo.js', $need_scripts, null, $in_footer = true );
			}
		}

		function admin_scripts(){
			wp_register_style( 'admin-style', WAE_BASE_URL.'css/admin-style.css' );
			wp_register_style( 'font-awesome', WAE_BASE_URL.'css/font-awesome.min.css' );
			wp_enqueue_style( 'admin-style' );
			wp_enqueue_style( 'font-awesome' );
		}

	}
?>