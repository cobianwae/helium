(function ( $ ){
	$.fn.waeslider = function( options ){
		var settings = $.extend({}, $.fn.waeslider.defaults, options);


		return this.each(function(){
			var $slide = $(this);
			var onAnimation = false;
			var activeHover = false;

			var cycleSlide = function(){
				var $active = $slide.find('.item.active');
				var $moveTo = $active.next('.item');
				if(!$moveTo.length) $moveTo = $slide.find('.item:first-child');
				move('forwards', $active, $moveTo, settings);
			}
			var timer = setInterval(cycleSlide, settings.pauseTime);

			var move = function(direction, $active, $moveTo, settings){
				if (onAnimation) return;
				if ( !activeHover ) clearInterval(timer);
				onAnimation = true;

				moveIndicator( $slide, $moveTo.index() + 1 );

				//transition before move
				$active.find('.animate').bind(
					"animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
					function(){
						switch ( settings.effect ){
							case 'crossfading':
								cross( $active, $moveTo, settings.animeSpeed );
								break;
							default :
								slide( direction, $active, $moveTo, settings.animeSpeed );
								break;
						} 
						$active.find('.animate').unbind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd");
					}
				);
				var changeState = function(){
					onAnimation = false;
					if ( !activeHover ) timer = setInterval(cycleSlide,settings.pauseTime);
					$active.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", changeState);
					settings.afterChange($active, $moveTo);
				}
				$active.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", changeState);
				
				//fire the animation
				settings.beforeChange($active, $moveTo);
				$active.find('.animate').addClass('fadeOut');
			}
			
			if(settings.pauseOnHover){
				$slide.hover(function(){
					activeHover = true;
					clearInterval(timer);
				}, function(){
					activeHover = false;
					timer = setInterval( cycleSlide, settings.pauseTime );
				});
			}

			$slide.find('.slider-nav, .wae-slider-indicators > li').click(function(e){
				e.preventDefault();
				var $triggered = $(this);
				var direction = 'forwards';
				var target = 0;
				var $active;
				var $moveTo;

				if($triggered.hasClass('active')) return;

				if ( $triggered.hasClass('left-control') ) direction = 'backwards';
				if ( $triggered.is('li') ){
					var $activeIndicator = $triggered.parent().find('li.active');
					if( $triggered.index() < $activeIndicator.index() ){
						direction = 'backwards';
					}
					target = $triggered.index() + 1;
				}
				$active = $slide.find('.item.active');
				if ( target == 0 ){
					if (direction == 'forwards'){
						$moveTo = $active.next('.item');
						if (!$moveTo.length) $moveTo = $slide.find('.item:first-child');
					}else{
						$moveTo = $active.prev('.item');
						if (!$moveTo.length) $moveTo = $slide.find('.item:last-child');
					}
				}else{
					$moveTo = $slide.find('.item:nth-child(' + target + ')');
				}

				move(direction, $active, $moveTo, settings); 
			});

			var $toAnimate = $slide.find('.item.active .animate');
			contentAppears( [], $toAnimate );

		});
	}

	$.fn.waeslider.defaults = {
		effect : 'slide',
		animeSpeed: 500,
		pauseTime: 5000,
		startSlide: 0,
		directionNav: true,
		pauseOnHover: true,
		manualAdvance: false,
		prevText : 'Prev',
		nextText : 'Next',
		beforeChange : function($active, $moveTo){},
		afterChange: function($active, $moveTo){},
		afterLoad: function(){}
	};

	

	function cross($active, $moveTo, speed){
		$active.addClass('cross-active');
		$moveTo.addClass('active cross-next');
		var crossAnime =function(){
			$active.removeClass('active cross-active cross');
			$moveTo.removeClass('cross-next cross');
			var $lastActive = $active.find('.animate');
			var $toAnimate = $active.parent().find('.item.active .animate');
			contentAppears($lastActive, $toAnimate);
			$active.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", crossAnime);
		}
		$active.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", crossAnime);
		$active.addClass('cross');
	}

	function slide(direction, $active, $moveTo, speed){
		var animeClass = direction == 'forwards' ? 'left' : 'right';
		var directionClass = direction == 'forwards' ? 'next' : 'prev';
		$moveTo.addClass(directionClass);
		var slideAnime = function(){
			$active.removeClass('active '+ animeClass);
			$moveTo.removeClass(directionClass + ' ' + animeClass);
			$moveTo.addClass('active');
			var $lastActive = $active.find('.animate');
			var $toAnimate = $active.parent().find('.item.active .animate');
			contentAppears($lastActive, $toAnimate);
			$active.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", slideAnime);
		};
		$active.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",slideAnime);
		setTimeout(function(){
			$active.addClass(animeClass);
			$moveTo.addClass(animeClass);
		});
	}

	function moveIndicator($slide, pos){
		var $active = $slide.find('li.active');
		var $next = $slide.find('li:nth-child('+pos+')') ;
		$active.removeClass('active');
		$next.addClass('active');
	}

	function contentAppears( $lastActive, $toAnimate ){
		if($lastActive.length){
			if($lastActive.hasClass('per-element')){
				$lastActive.removeClass('fadeOut');
				$lastActive.children().each(function(){
					var $element = $(this);
					var animationType = $element.data('animation');
					if ( typeof animationType == 'undefined' ) animationType = 'move-up';
					$element.removeClass(animationType);
				});
			}else{
				var animationType = $lastActive.data('animation');
				if ( typeof animationType == 'undefined' ) animationType = 'move-up';
				$lastActive.removeClass(animationType + ' fadeOut');
			}
		}
		if($toAnimate.length){
			//single animation
			if( $toAnimate.hasClass('per-element') ){
				var interval = 0;
				$toAnimate.children().each(function(){
					var $element = $(this);
					var animationType = $element.data('animation');
					if ( typeof animationType == 'undefined' ) animationType = 'move-up';
					setTimeout(function(){
						$element.addClass(animationType);
					}, interval);
					interval += 200;
				});
			}else{
				var animationType = $toAnimate.data('animation');
				if ( typeof animationType == 'undefined' ) animationType = 'move-up';
				$toAnimate.addClass(animationType);
			}
		}
	}

}( jQuery ));