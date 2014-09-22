<?php
	abstract  class WAE_component_base{
		protected $component_control;
		protected $component_form;

		function __construct(){
			add_action('wae_helper_options', array($this, 'display_control'));
			add_action('wae_helper_hidden', array($this, 'display_form'));
		}

		function display_control(){
			echo '<option value="'. $this->component_control[0] .'">'.
					$this->component_control[1] .
				'</option>';
		}

		abstract function display_form();
	}