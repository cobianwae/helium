<?php
	class WAE_tinymce_dialog_bootstrapper{
		function __construct(){
			$this->instantiate('admin');
			$this->load_component();
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
			WAE_tinymce_dialog_bootstrapper::load($class);
			$classname = 'WAE_tinymce_dialog_'.$class;
			return new $classname;
		}

		function load_component(){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/component/class.component.bootstrapper.php' );
			return new WAE_component_bootstrapper;
		}
	}
?>