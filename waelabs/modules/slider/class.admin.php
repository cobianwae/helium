<?php
	class WAE_slider_admin{
		function __construct(){
			add_action( 'init', array( $this, 'register' ) );
			WAE_slider_bootstrapper::instantiate('settings_fields');
			add_filter( 'manage_edit-wae_slider_columns', array( $this, 'edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( $this, 'custom_columns' ) );

		}

		function register(){
			$labels = array(
				'name' => __( 'WAE Slider', THEMENAME  ),
					'singular_name' => __( 'Slide', THEMENAME ),
					'add_new' => __( 'Add New Slide', THEMENAME ),
					'add_new_item' => __( 'Add New Slide', THEMENAME ),
					'edit_item' => __( 'Edit Slide', THEMENAME ),
					'new_item' => __( 'New Slide', THEMENAME ),
					'all_items' => __( 'All Slides', THEMENAME ),
					'view_item' => __( 'View Slide', THEMENAME ),
					'search_items' => __( 'Search Slides', THEMENAME ),
					'not_found' => __( 'No Slides found', THEMENAME ),
					'not_found_in_trash' => __('No slides found in Trash', THEMENAME),
				);
			$args = array(
					'labels' => $labels,
					'public' => true,  
			        'show_ui' => true,  
			        'capability_type' => 'post',  
			        'hierarchical' => false,  
			        'rewrite' => true,  
			        'supports' => false,
			        'exclude_from_search' => true
			       );
			
			register_post_type( 'wae_slider' , $args );  
		}

		function edit_columns($columns){  
		    $columns = array(  
		        "cb" => "<input type=\"checkbox\" />",  
		        "thumbnail" => "Thumbnail",  
		        "caption" => "Caption",  
		        "title" => "Title",  
		        "date" => "Date",  
		    );  
		    return $columns;  
		}

		function custom_columns($column){  
	        global $post;  
	        switch ($column)  
	        {  
	            case "thumbnail":  
	               	 echo "<img height=100 src='".get_post_meta( $post->ID, '_wae_slider_image',true )."' />";
	                break;  
	            case "caption":  
	               	echo get_post_meta( $post->ID, '_wae_slider_caption_title', true );  
	                break;  
	        }  
		}  
	}
?>