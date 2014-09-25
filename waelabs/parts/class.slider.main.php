<?php
	class WAE_slider_main extends WAE_parts_base{

		function __construct(){
			parent::__construct();
			add_action('wae_slider', array($this, 'display_slider' ));
		}

		function display_slider(){
			WAE::resolve_scripts(array('imagesloaded'));
			$slides = get_data();
			if(!$slides) return;
			?>
			<div id="full-slider" class="wae-slider fullscreen">
			  <div class="items">
			  	<?php
		  		foreach ($slides as $key => $slide) {
		  			$active = $key  == 0 ? 'active' : '';
		  			?>
		  			<div calss="item <?php echo $active ?>">
		  				<?php if ( !empty($slide['image']) ) : ?>

		  				<?php else : ?>

		  				<?php endif; ?>
		  				<div class="item-content content-center">
		  				  <div class="animate">
		  				  <h2>We'll Help Manage Your Business</h2>
		  				  <p>Curiousity is the greatest quality human ever has</p>
		  				  <a class="wae-button" href="http://google.com">See More</a>
		  				  <a class="wae-button" href="http://google.com">See More</a>
		  				  </div>
		  				</div>
		  			</div>
		  		}
			  	?>
			    <div class="item active" >
			        <div class="item-bg"style="background-image:url(images/slide1.jpg)"></div>
			        <div class="item-content content-center">
			          <div class="animate">
			          <h2>We'll Help Manage Your Business</h2>
			          <p>Curiousity is the greatest quality human ever has</p>
			          <a class="wae-button" href="http://google.com">See More</a>
			          <a class="wae-button" href="http://google.com">See More</a>
			          </div>
			        </div>
			    </div>
			    <div class="item">
			        <div class="item-bg" id="video-bg">
			        </div>
			        <div class="item-content content-center">
			          <div class="animate per-element">
			            <h2 data-animation="move-up">Your Second Title - Place it here!</h2>
			            <p data-animation="move-up">Lorem ipsum dolor sit amet</p>
			            <a data-animation="move-up" class="wae-button" href="http://google.com">See More</a>
			            </div>
			        </div>
			    </div>
			    <div class="item" style="background-color:green">
			        <div class="item-bg" style="background-image:url()"></div>
			        <div class="item-content content-right">
			            <div class="animate" data-animation="move-up">
			              <h2>Your Second Title - Place it here!</h2>
			              <p>Lorem ipsum dolor sit amet</p>
			              <a class="wae-button" href="http://google.com">See More</a>
			            </div>
			        </div>
			    </div>
			  </div>
			  <a class="left-control slider-nav" href="#full-slider">
			    <span class="icon-arrow-left"></span>
			  </a>
			  <a class="right-control slider-nav" href="#full-slider">
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
					  'caption_subtitle'       	=>  get_post_meta( $query->post->ID, '_wae_slider_caption_subtitle', true ),
					  'button_text_1'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_text_1', true ),
					  'button_link_1'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_link_1', true ),
					  'button_text_2'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_text_2', true ),
					  'button_link_2'   		=>  get_post_meta( $query->post->ID, '_wae_slider_button_link_2', true ),
					  'alignment' 				=>  get_post_meta( $query->post->ID, '_wae_slider_alignment', true ),
					  'active'        			=>  true,
					  'image'    				=> 	get_post_meta( $query->post->ID, '_wae_slider_image', true ),
					  'video'					=>  get_post_meta( $query->post->ID, '_wae_slider_video', true );			                            
					);
			endwhile;
			wp_reset_postdata();
			return $results;
		}

	}
?>