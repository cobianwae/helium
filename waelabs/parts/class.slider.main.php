<?php
	class WAE_slider_main extends WAE_parts_base{

		function __construct(){
			parent::__construct();
			add_action('wae_slider', array($this, 'display_slider' ));
		}

		function display_slider(){
			$options = $this->options;
			$skin = !empty($options['slider_skin']) ? $options['slider_skin'] : 'circle' ;
			WAE::resolve_scripts(array('imagesloaded', 'waeslider', 'videofit'));
			$slides = $this->get_data();
			if(!$slides) return;
			?>
			<div id="full-slider" class="wae-slider fullscreen <?php echo $skin ?>">
			  <div class="items">
			  	<?php
		  		foreach ($slides as $key => $slide):
		  			$active = $key  == 0 ? 'active' : '';
		  			$title_style = $slide['title_style'] == 'regular' ? 'regular' : 'with-'.$slide['title_style'];
		  			$subtitle_style = $slide['subtitle_style'] == 'regular' ? 'regular' : 'with-'. $slide['subtitle_style'];
		  			?>
		  			<div class="item <?php echo $active ?> <?php echo $slide['caption_color'] ?>">
		  				<?php if ( !empty($slide['mp4']) || !empty($slide['ogv']) ) : ?>
	  					 <div class="item-bg">
		  					<video class="videofit" preload="auto" autoplay="autoplay" loop="loop">
		  					  <?php if ( !empty($slide['mp4']) ) : ?>
		  					  <source src="<?php echo $slide['mp4'] ?>" type="video/mp4">
	  						  <?php endif; ?>
	  						  <?php if( !empty($slide['ogv'])  ) : ?>
		  					  <source src="<?php echo $slide['ogv'] ?>" type="video/ogg">
  							  <?php endif;?>
		  					</video>
		  				 </div>
		  				<?php else : ?>
		  				  <div class="item-bg"style="background-image:url(<?php echo $slide['image'] ?>)"></div>
		  				<?php endif; ?>
		  				<div class="item-content content-<?php echo $slide['alignment'] ?>">
		  				  <div class="animate">
			  				  <h1><span class="<?php echo $title_style ?>"><?php echo $slide['caption_title'] ?></span></h1>
			  				  <p><span class="<?php echo $subtitle_style ?>"><?php echo $slide['caption_subtitle'] ?></span></p>
		  				  </div>
		  				</div>
		  			</div>
		  		<?php
		  			endforeach;
			  	?>
			  </div>
			  <a class="left-control slider-nav" href="#full-slider">
			    <span class="icon-arrow-left"></span>
			    <?php
			    	if($skin == 'square'){
			    		echo '<div class="slide-counter">';
			    		echo '<span class="slide-index">1</span>';
			    		echo '<div class="diagonal-line"></div>';
			    		echo '<span class="slide-total">'.count($slides).'</span>';
			    		echo '</div>';
			    	}
			     ?>
			  </a>
			  <a class="right-control slider-nav" href="#full-slider">
			  	<?php
			    	if($skin == 'square'){
			    		echo '<div class="slide-counter">';
			    		echo '<span class="slide-index">1</span>';
			    		echo '<div class="diagonal-line"></div>';
			    		echo '<span class="slide-total">'.count($slides).'</span>';
			    		echo '</div>';
			    	}
			     ?>
			    <span class="icon-arrow-right"></span>
			  </a>
			  <?php $this->generate_indicators(count($slides)); ?>
			</div>
			<?php
		}

		function generate_indicators($length){
			echo "<ol class='wae-slider-indicators' >";
				echo '<li class="active"></li>';
			for($x=$length; $x > 1; $x--){
				echo "<li></li>";
			}
			echo "</ol>";
		}

		function get_data(){
			$query = new WP_Query( array( 'post_type' => 'wae_slider') );
			$results = array();
			while ($query->have_posts()) : $query->next_post();
				$results[] = array(
					  'caption_color'       	=>  get_post_meta( $query->post->ID, '_wae_slider_caption_color', true ),
					  'caption_title'       	=>  get_post_meta( $query->post->ID, '_wae_slider_caption_title', true ),
					  'title_style' 			=> get_post_meta($query->post->ID, '_wae_slider_title_style', true),
					  'title_animation'			=> get_post_meta($query->post->ID, '_wae_slider_title_animation', true),
					  'caption_subtitle'       	=>  get_post_meta( $query->post->ID, '_wae_slider_caption_subtitle', true ),
					  'subtitle_style'			=> get_post_meta($query->post->ID, '_wae_slider_subtitle_style', true ),
					  'subtitle_animation'		=> get_post_meta($query->post->ID, '_wae_slider_subtitle_animation', true),
					  'button_text_1'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_text_1', true ),
					  'button_link_1'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_link_1', true ),
					  'button_text_2'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_text_2', true ),
					  'button_link_2'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_link_2', true ),
					  'buttons_style'			=> get_post_meta( $query->post->ID, '_wae_slider_buttons_style', true ),
					  'buttons_animation'		=> get_post_meta( $query->post->ID, '_wae_slider_buttons_animation', true ),
					  'alignment' 				=>  get_post_meta( $query->post->ID, '_wae_slider_alignment', true ),
					  'active'        			=>  true,
					  'image'    				=> 	get_post_meta( $query->post->ID, '_wae_slider_image', true ),
					  'mp4'					=>  get_post_meta( $query->post->ID, '_wae_slider_mp4', true ),
					  'ogv'			        => get_post_meta( $query->post->ID, '_wae_slider_ogv', true )                 
					);
			endwhile;
			wp_reset_postdata();
			return $results;
		}

	}
?>