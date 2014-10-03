// Common
(function($,sr){

  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize 
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

(function($,window,undefined){
	var isMobile = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i);
	    },
	    any: function() {
	        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	    }
	};
	var velavo = {};;
	$(document).ready(function(){
		 /*$('.videofit').videofit({
		 	container : '.wae-slider'
		 });
		 $('.wae-slider').waeslider({
            effect : 'crossfading',
            pauseOnHover : true
        });*/
		if(Modernizr.mq('(min-width: 40.063em)')){
	   		/* UBER MENU */  
	   		var liHeight = 0
	     	$('li.mega-menu > ul.dropdown > li').each(function(idx, val){          
				if($(this).height() > liHeight){
				 liHeight = $(this).height();
				}
	     	});

			$('li.mega-menu > ul.dropdown > li').each(function(idx, val){          
				$(this).height(liHeight);          
			}); 
	    	/* END OF UBER MENU */

	    	/* SCROLL ANIMATION */			
	        var navHeight = $('.wrapper-nav').height();
	        $('.wrapper-header-background').css('margin-top', (0 - navHeight));
	        var navClone = $('.wrapper-nav').clone(true)
				.addClass('wrapper-nav-sticky')
				.removeClass('wrapper-nav');          
	         
	        /*$('.parent-wrapper-nav-sticky > .wrapper-nav-sticky > .top-bar').height(navHeight);
	        $('.parent-wrapper-nav-sticky > .wrapper-nav-sticky > .top-bar').css('border', '1px solid red');*/
	        $('body').append(navClone);
	      
	        $(window).scroll(function() {
	          if ( $(window).scrollTop()  > $(window).height() )  {                                  
	            /*$('.wrapper-nav-sticky').css('opacity', 1);                     */
	            $('.wrapper-nav-sticky').css('display', 'block');
	          } else {
	            $('.wrapper-nav-sticky').css('display', 'none');                        
	          }
	        });
	        /* END OF SCROLL ANIMATION */

	  	}
	});
	$(document).foundation();
}(jQuery, window));