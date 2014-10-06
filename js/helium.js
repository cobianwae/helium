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
		if (typeof $.fn.videofit != 'undefined'){
			 $('.videofit').videofit({
			 	container : '.wae-slider'
			 });
		}
		if (typeof $.fn.waeslider != 'undefined'){
			 $('.wae-slider').waeslider({
	            effect : 'crossfading',
	            pauseOnHover : true,
	            afterChange : function($active, $moveTo){
	            	if ( $moveTo.hasClass('light') ){
	            		var $slider = $moveTo.closest('.wae-slider');
	            		if($slider.hasClass('dark-scheme')){
	            			$slider.removeClass('dark-scheme');
	            		}
	            		$slider.addClass('light-scheme');
	            	}else{
	            		var $slider = $moveTo.closest('.wae-slider');
	            		if($slider.hasClass('light-scheme')){
	            			$slider.removeClass('light-scheme');
	            		}
	            		$slider.addClass('dark-scheme');
	            	}
	            	var nextIndex = $moveTo.index() + 1;
	            	var $slider = $moveTo.closest('.wae-slider');
	            	$slider.find('.slide-index').each(function(){
	            		$(this).html(nextIndex);
	            	});
	            }
	        });
		}
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
	  }
	});
	$(document).foundation();
}(jQuery, window));