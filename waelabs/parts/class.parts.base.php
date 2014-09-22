<?php
	class WAE_parts_base{
		protected $options;
		function __construct(){
			global $wae;
			$this->options = $wae;
		}
	}
?>