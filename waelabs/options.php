<?php
	class WAE_options{
		function get_general_options(){
			$general_sections = array(
				'icon' => 'el-icon-cogs',
				'title' => __('General Settings', THEMENAME),
				'fields' => array(
					array(
						'id' => 'wae_favicon',
						'type' => 'media',
						'title' => __('Favicon Upload', THEMENAME),
						'compiler' => 'true',
						'mode' => false,
						'subtitle' =>  __('Upload a 16px x 16px .ico image that will be your favicon', THEMENAME)   
					),
					array(
						'id' => 'wae_use_logo',
						'type' => 'switch',
						'title' => __('Use Image for logo?', THEMENAME),
						'subtitle' =>  __('If left unchecked, plain text will be used instead (generated from site name).', THEMENAME),
						'desc' => ''
					),
					array(
                        'id' => 'wae_logo',
                        'type' => 'media',
                        'required'  => array('wae_use_logo', '=', '1'), 
                        'title' => __('Logo Upload', THEMENAME), 
                        'subtitle' => __('Upload your logo here and enter the height of it below', THEMENAME),
                        'desc' => '' 
                    ),
                    array(
                        'id' => 'wae_dark_logo',
                        'type' => 'media',
                        'required'  => array('wae_use_logo', '=', '1'), 
                        'title' => __('Dark Logo Upload', THEMENAME), 
                        'subtitle' => __('You can pload different logo for dark scheme header. Upload your logo here and enter the height of it below', THEMENAME),
                        'desc' => '' 
                    ),
                    array(
                        'id' => 'wae_logo_height', 
                        'type' => 'text', 
                        'title' => __('Logo Height', THEMENAME),
                        'sub_desc' => __('Don\'t include "px" in the string. e.g. 30', THEMENAME),
                        'desc' => '',
                        'validate' => 'numeric'
                    ),
                    array(
                    	'id' => 'wae_css_code',
                    	'type' => 'ace_editor',
                    	'mode' => 'css',
                    	'title' => __('CSS Code', THEMENAME),
                    	'subtitle' => __('Paste your css code here', THEMENAME)
                    ),
                    array(
                    	'id' => 'wae_js_code',
                    	'type' => 'ace_editor',
                    	'mode' => 'javascript',
                    	'title' => __('Javascript Code', THEMENAME),
                    	'subtitle' => __('Paste your javascript code here', THEMENAME)
                    )
				)
			);
			return $general_sections;
		}

		function get_social_media_options(){
			$socmed_options = array(
                'icon' => 'el-icon-globe',
                'title' => __('Social Media Options', THEMENAME),
                'desc' => __('Enter in your social media locations here and then activate which ones you would like to display in your footer options & header options tabs. <br/><br/> <strong>Remember to include the "http://" in all URLs!</strong>', THEMENAME),
                'fields' => array(
                    array(
                        'id' => 'wae_facebook_url', 
                        'type' => 'text', 
                        'title' => __('Facebook URL', THEMENAME),
                        'subtitle' => __('Please enter in your Facebook URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_twitter_url', 
                        'type' => 'text', 
                        'title' => __('Twitter URL', THEMENAME),
                        'subtitle' => __('Please enter in your Twitter URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_google-plus_url', 
                        'type' => 'text', 
                        'title' => __('Google+ URL', THEMENAME),
                        'subtitle' => __('Please enter in your Google+ URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_vimeo_url', 
                        'type' => 'text', 
                        'title' => __('Vimeo URL', THEMENAME),
                        'subtitle' => __('Please enter in your Vimeo URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_dribbble_url', 
                        'type' => 'text', 
                        'title' => __('Dribbble URL', THEMENAME),
                        'subtitle' => __('Please enter in your Dribbble URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_pinterest_url', 
                        'type' => 'text', 
                        'title' => __('Pinterest URL', THEMENAME),
                        'subtitle' => __('Please enter in your Pinterest URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_youtube_url', 
                        'type' => 'text', 
                        'title' => __('Youtube URL', THEMENAME),
                        'subtitle' => __('Please enter in your Youtube URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_tumblr_url', 
                        'type' => 'text', 
                        'title' => __('Tumblr URL', THEMENAME),
                        'subtitle' => __('Please enter in your Tumblr URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_linkedin_url', 
                        'type' => 'text', 
                        'title' => __('LinkedIn URL', THEMENAME),
                        'subtitle' => __('Please enter in your LinkedIn URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_rss_url', 
                        'type' => 'text', 
                        'title' => __('RSS URL', THEMENAME),
                        'subtitle' => __('If you have an external RSS feed such as Feedburner, please enter it here. Will use built in Wordpress feed if left blank.', THEMENAME),
                        'desc' => ''
                    ),
                     array(
                        'id' => 'wae_flickr_url',
                        'type' => 'text',
                        'title' => __('Flickr URL', THEMENAME), 
                        'subtitle' =>__('Please enter in your Flickr URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_skype_url',
                        'type' => 'text',
                        'title' => __('Skype URL', THEMENAME), 
                        'subtitle' => __('Please enter in your Skype URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_behance_url', 
                        'type' => 'text', 
                        'title' => __('Behance URL', THEMENAME),
                        'subtitle' => __('Please enter in your Behance URL.', THEMENAME),
                        'desc' => ''
                    ),
                    
                    array(
                        'id' => 'wae_instagram_url', 
                        'type' => 'text', 
                        'title' => __('Instagram URL', THEMENAME),
                        'subtitle' => __('Please enter in your Instagram URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_github_url', 
                        'type' => 'text', 
                        'title' => __('GitHub URL', THEMENAME),
                        'subtitle' => __('Please enter in your GitHub URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_stack-exchange_url', 
                        'type' => 'text', 
                        'title' => __('StackExchange URL', THEMENAME),
                        'subtitle' => __('Please enter in your StackExchange URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'wae_soundcloud_url', 
                        'type' => 'text', 
                        'title' => __('SoundCloud URL', THEMENAME),
                        'subtitle' => __('Please enter in your SoundCloud URL.', THEMENAME),
                        'desc' => ''
                    )
                )
            );
			return $socmed_options;
		}

		function use_social_media_in( $settings ){
			$section = $settings['section'];
		 	$use_socmed_in = array(
                'icon' => $settings['icon'],
                'title' => $settings['title'],
                'desc' => $settings['subtitle'],
                'fields' => array(  
                    array(
                        'id' => $section . '_use_facebook',
                        'type' => 'checkbox',
                        'title' => __('Use Facebook Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_twitter',
                        'type' => 'checkbox',
                        'title' => __('Use Twitter Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_google-plus',
                        'type' => 'checkbox',
                        'title' => __('Use Google+ Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_vimeo',
                        'type' => 'checkbox',
                        'title' => __('Use Vimeo Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_dribbble',
                        'type' => 'checkbox',
                        'title' => __('Use Dribbble Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_pinterest',
                        'type' => 'checkbox',
                        'title' => __('Use Pinterest Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_youtube',
                        'type' => 'checkbox',
                        'title' => __('Use Youtube Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_tumblr',
                        'type' => 'checkbox',
                        'title' => __('Use Tumblr Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_linkedin',
                        'type' => 'checkbox',
                        'title' => __('Use LinkedIn Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_rss',
                        'type' => 'checkbox',
                        'title' => __('Use RSS Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),

                    array(
                        'id' => $section . '_use_flickr',
                        'type' => 'checkbox',
                        'title' => __('Use Flickr Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_skype',
                        'type' => 'checkbox',
                        'title' => __('Use Skype Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_behance',
                        'type' => 'checkbox',
                        'title' => __('Use Behance Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_instagram',
                        'type' => 'checkbox',
                        'title' => __('Use Instagram Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_github',
                        'type' => 'checkbox',
                        'title' => __('Use GitHub Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_stack-exchange',
                        'type' => 'checkbox',
                        'title' => __('Use StackExchange Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => $section . '_use_soundcloud',
                        'type' => 'checkbox',
                        'title' => __('Use SoundCloud Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                )
            );
			return $use_socmed_in;
		}

        function get_contact_options(){
            return array(
                'icon' => ' el-icon-map-marker',
                'title' => __('Contact Options', THEMENAME),
                'desc' => __('All contact page related options are listed here.', THEMENAME),
                'fields' => array( 
                    array(
                        'id' => 'map_zoom_level',
                        'type' => 'text',
                        'title' => __('Defautl Map Zoom Level', THEMENAME), 
                        'subtitle' => __('Value should be between 1-18, 1 being the entire earth and 18 being right at street level.', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'default' => '15' 
                    ),
                    array(
                        'id' => 'map_enable_zoom',
                        'type' => 'checkbox',
                        'title' => __('Enable Map Zoom In/Out', THEMENAME), 
                        'subtitle' => __('Do you want users to be able to zoom in/out on the map?', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'default' => '0' 
                    ),
                    array(
                        'id' => 'map_marker',
                        'type' => 'media',
                        'title' => __('Use local image as a marker', THEMENAME),
                        'subtitle' => __('Upload your custom marker here', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'map_coordinate',
                        'type' => 'text',
                        'title' => __('Map center Coordinate', THEMENAME), 
                        'subtitle' => __('Please enter the coordinate for the maps center point. example : (-6.907342,107.645399) ', THEMENAME),
                        'desc' => __('', THEMENAME)
                    ),
                    array(
                        'id'=>'map_positions',
                        'type' => 'multi_text',
                        'title' => __('Locations', THEMENAME),
                        'subtitle' => __('Add your locations coordinate. example : (-6.907342,107.645399)', THEMENAME),
                        'desc' => __('', THEMENAME)
                    ),
                    array(
                        'id'=>'map_position_infos',
                        'type' => 'multi_text',
                        'title' => __('Location Infos', THEMENAME),
                        'subtitle' => __('Add your location info according to location input order', THEMENAME),
                        'desc' => __('', THEMENAME)
                    ),      
                    array(
                        'id'=>'map_type',
                        'type' => 'radio',
                        'title' => __('Map Type', THEMENAME),
                        'subtitle' => __('Choose your type of map display', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'options' => array(
                            'styled' => 'Styled',
                            'regular' => 'Regular'
                        ),
                        'default' => 'regular'
                    ),
                    array(
                        'id' => 'map_color',
                        'required' => array('map_type', '=', 'styled'), 
                        'type' => 'select', 
                        'title' => __('Map Color', THEMENAME),
                        'subtitle' => __('Determine the color of styled map', THEMENAME),
                        'options' => array(
                            'primary_color' => 'Primary Color',
                            'secondary_color' => 'Secondary Color',
                            'secondary_complement_color' => 'Secondar Complement Color'
                        ),
                        'default' => 'primary_color'
                    ),
                    array(
                        'id' => 'contact_address_label',
                        'type' => 'text',
                        'title' => __('Address Label', THEMENAME),
                        'subtitle' => __('Will be displayed as heading title for address section', THEMENAME),
                        'default' => __('Our Humble Headquarter', THEMENAME)
                    ),
                    array(
                        'id' => 'contact_address',
                        'type' => 'editor',
                        'title' => __('Contact Address', THEMENAME),
                        'subtitle' => __('Your office address', THEMENAME),
                        'args'   => array(
                                'teeny'            => true,
                                'textarea_rows'    => 10
                            )
                    ), 
                    array(
                        'id' => 'contact_social_label',
                        'type' => 'text',
                        'title' => __('Social Accounts Label', THEMENAME),
                        'subtitle' => __('Will be displayed as heading title for social accounts section', THEMENAME),
                        'default' => __('Also Find Us On', THEMENAME)
                    ),
                    array(
                        'id' => 'contact_form_label',
                        'type' => 'text',
                        'title' => __('Contact Form Label', THEMENAME),
                        'subtitle' => __('Will be displayed as heading title for contact form section', THEMENAME),
                        'default' => __('Drop Us A Message. Will Ya ?', THEMENAME)
                    ),                                
                )
            );
        }
	}
?>