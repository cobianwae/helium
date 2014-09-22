<?php
	class WAE_social_main extends WAE_parts_base{
		function __construct(){
			parent::__construct();
			add_action('social_in', array($this, 'display_social_in'), 10, 1);
			add_action('wae_social_share', array($this, 'social_share' ) ) ;
		}

		function display_social_in( $section ){
			$options = $this->options;
			echo "<ul class='$section-social-media'>";
			$social_accounts_array = array('facebook','twitter','google-plus','vimeo','dribbble','pinterest',
											'youtube','tumblr','linkedin','rss','flickr', 'skype', 
											'behance','instagram','github','stack-exchange','soundcloud'  
										);
			$options = $this->options;
			foreach ($social_accounts_array as $key => $social_account) {
				if( !empty($options[ $section . '_use_'. $social_account]) &&  
					$options[ $section . '_use_'.$social_account] == '1'  ){
					$social_account_opt = !empty($options['wae_'.$social_account.'_url']) ? $options['wae_'.$social_account.'_url'] : '#';
					if ($social_account == 'vimeo'){
						$this->social_account('vimeo', $social_account_opt, '-square');
					}else{
						$this->social_account($social_account, $social_account_opt);
					}
				}
			}
			echo "</ul>";
		}

		private function social_account($type, $link, $additional_type = ''){
			echo '<li><a href="'.$link.'" class="'.$type.'" title="'.$link.'">
               		<i class="fa fa-'.$type.$additional_type.'"></i>
               		</a></li>';
		}

		function social_share(){
			$options = $this->options;
			$social_share_array = array();
			if(empty($options['blog_social']) || !$options['blog_social']) return;

			if( !empty($options['blog_facebook_sharing']) &&  $options['blog_facebook_sharing'] == '1' ) array_push( $social_share_array, 'facebook' );
			if( !empty($options['blog_twitter_sharing']) && $options['blog_twitter_sharing'] == '1' ) array_push( $social_share_array, 'twitter' );
			if( !empty($options['blog_pinterest_sharing']) && $options['blog_pinterest_sharing'] == '1' ) array_push( $social_share_array, 'pinterest' );
			
			if( !empty($social_share_array) ) echo  do_shortcode( '[wae_share media="'. implode( ',' , $social_share_array ). '"]' ) ;
		}
	}
?>