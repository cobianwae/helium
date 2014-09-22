<?php
	class WAE_post_media{
		private $type;
		function __construct( $type ){
			$this->type = $type;
		}

		function display(){
			switch ($this->type) {
				case 'audio':
					$this->display_audio();
					break;

				case 'video':
					$this->display_video();
					break;

				case 'image':
					$this->display_image();
					break;

				case 'gallery':
					$this->display_gallery();
					break;
			}
		}

		function display_audio(){
			$audio_mp3 = get_post_meta(get_the_id(), '_wae_mp3_url', true);
		    $audio_ogg = get_post_meta(get_the_id(), '_wae_oga_url', true); 
			$audio_embed = get_post_meta(get_the_id(), '_wae_audio_embedded', true );
			if(!empty($audio_ogg) || !empty($audio_mp3)) {
	        	
				$audio_output = '[wae_audio ';
				
				if(!empty($audio_mp3)) { $audio_output .= 'mp3="'. $audio_mp3 .'" '; }
				if(!empty($audio_ogg)) { $audio_output .= 'ogg="'. $audio_ogg .'"'; }
				
				$audio_output .= ']';
				
        		echo  '<div class="audio-media">'. do_shortcode($audio_output) . '</div>';	
        	}else if ( !empty( $audio_embed ) ){
        		echo '<div class="audio-media">' . do_shortcode( $audio_embed ) . '</div>';
        	}
		}

		function display_video(){
			$video_embed = get_post_meta( get_the_ID(), '_wae_embeded_video', true );
		  	$video_m4v = get_post_meta( get_the_ID(), '_wae_m4v_url', true );
		  	$video_ogv = get_post_meta( get_the_ID(), '_wae_ogv_url', true ); 
		  	$video_poster = get_post_meta( get_the_ID(), '_wae_preview_image', true); 
		  
		  	if( !empty($video_embed) || !empty($video_m4v) ){
         		$wp_version = floatval(get_bloginfo('version'));
				//video embed
				if( !empty( $video_embed ) ) {
		             echo '<div class="video-media">' . do_shortcode($video_embed) . '</div>';
		        } 
		        else {
		        	if(!empty($video_m4v) || !empty($video_ogv)) {
		        		
						$video_output = '[wae_video ';
						
						if(!empty($video_m4v)) { $video_output .= 'mp4="'. $video_m4v .'" '; }
						if(!empty($video_ogv)) { $video_output .= 'ogv="'. $video_ogv .'"'; }
						
						$video_output .= ' poster="'.$video_poster.'"]';
						
		        		echo '<div class="video-media">' . do_shortcode($video_output) . '</div>';	
		        	}
		        }	
			}
		}

		function display_image(){
			if ( has_post_thumbnail() ) {
				the_post_thumbnail('main-thumbnail');
			} 
		}

		function display_gallery(){
			$enable_gallery_slider = get_post_meta( get_the_id(), '_wae_gallery_slider', true );
			if( !is_single() || (!empty($enable_gallery_slider) && $enable_gallery_slider == 'yes') ) { 
				WAE::resolve_scripts(array('flexslider'));
				$gallery_ids = $this->grab_ids_from_gallery();
				$attr = array(
				    'class' => "attachment-full wp-post-image",
				);
				?>	
				<div class="wae-gallery flexslider"> 
					<ul class="slides">	
						 	<?php 
							foreach( $gallery_ids as $image_id ) {
							     echo  '<li>'.wp_get_attachment_image($image_id, '', false, $attr).'</li>' ;
							} ?>
					</ul>
			   	 </div>
		   	<?php } 
		}

		function grab_ids_from_gallery() {
			global $post;
			if($post != null) {
				$attachment_ids = array();  
				$pattern = get_shortcode_regex();
				$ids = array();
				if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ) { 
					$count=count($matches[3]);
					for ($i = 0; $i < $count; $i++){
						$atts = shortcode_parse_atts( $matches[3][$i] );
						if ( isset( $atts['ids'] ) ){
							$attachment_ids = explode( ',', $atts['ids'] );
							$ids = array_merge($ids, $attachment_ids);
						}
					}
				}
				return $ids;
		  	} else {
			  	$ids = array();
			  	return $ids;
		  	}
		}
	}
?>