<?php
	class WAE_visual_composer_bootstrapper{
		function __construct(){
			$this->instantiate('fullwidth_section');
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
			WAE_visual_composer_bootstrapper::load($class);
			$classname = 'WAE_vc_'.$class;
			return new $classname;
		}
	}
?>