<?php
	class WAE_shortcodes_bootstrapper{
		function __construct(){
			$this->instantiate( 'audio' );
			$this->instantiate( 'video' );
			$this->instantiate( 'share' );
			$this->instantiate( 'row' );
			$this->instantiate( 'our_fields' );
			$this->instantiate( 'team_member' );
			$this->instantiate( 'accordion' );
			$this->instantiate( 'tabs' );
		}

		static function load_walker($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.walker.'.$class.'.php' );
		}

		static function load($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.'.$class.'.php' );
		}

		static function instantiate($class){
			WAE_shortcodes_bootstrapper::load($class);
			$classname = 'WAE_shortcodes_'.$class;
			return new $classname;
		}
	}
?>