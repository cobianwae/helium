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
	var velavo = {};
	velavo.media = function(){
		$('video, audio').each(function(){
			$(this).mediaelementplayer({
			});
		});
	}
	velavo.embededResize = function(){
		var $allVideos = $("iframe[src*='player.vimeo.com'], iframe[src*='www.youtube.com'], object, embed"),
		$fluidEl = $("article:first-child");
		$allVideos.each(function() {

			$(this)
				    // jQuery .data does not work on object/embed elements
				    .attr('data-aspectRatio', this.height / this.width)
				    .removeAttr('height')
				    .removeAttr('width');

		});

		$(window).resize(function() {
			var newWidth = $fluidEl.width();
			$allVideos.each(function() {
				var $el = $(this);
				$el
				.width(newWidth)
				.height(newWidth * $el.attr('data-aspectRatio'));
			});
		});
	}

	velavo.masonry = function(){
		if(Modernizr.mq('(max-width: 40em)')) return;
		if(!$('.masonry').length) return;
		var gallery = $('.wae-gallery');
		if(gallery.length > 0) return;
		new AnimOnScroll( document.getElementById( 'masonry' ), {
			minDuration : 0.4,
			maxDuration : 0.7,
			viewportFactor : 0.2
		} );
	}

	velavo.fixHeight = function(byPass){
		if( isMobile.any()) return;
		$('.main-content').imagesLoaded(function(){
			if($('.main-content > .large-8').length && $('.main-content > .large-4').length){
				$('.main-content > .large-8,.main-content > .large-4').removeAttr('style');
					var maxHeight =  $('.main-content > .large-4').height();
					$('.main-content > .large-8,.main-content > .large-4').css('min-height' , maxHeight + 'px');
			}
		})
	}

	velavo.googleMap = function(){
		var $mapHolder = $('#map-holder');
		if ( $mapHolder.length ==  0) return;
		var zoomLevel = $mapHolder.data('zoom-level');
			zoomLevel = $.trim(zoomLevel) == '' ?  15 : parseInt(zoomLevel);
		var enableZoom = $mapHolder.data('enable-zoom');
			enableZoom = $.trim(enableZoom) == 'false' ? false : true;
		var markerImg = $mapHolder.data('marker-img');
		var centerCoordinate = $mapHolder.data('center-coordinate');
		var positions = $mapHolder.data('positions');
		var positionInfos = $mapHolder.data('position-infos');
		var mapType = $mapHolder.data('map-type');
		var accentColor = $mapHolder.data('accent-color');
		if($.trim(centerCoordinate) == '') return;
		var arrCenterCoordinate = centerCoordinate.split(',');
		var centerLatitude = parseFloat(arrCenterCoordinate[0]);
		var centerLongitude = parseFloat(arrCenterCoordinate[1]);

		var arrPositions = positions.split(';');
		var arrPositionCoordinates = [];
		for(var i = 0; i< arrPositions.length; i++){
			var arrPoint = arrPositions[i].split(',');
			var coordinate = {};
			coordinate.lat = parseFloat(arrPoint[0]);
			coordinate.lng = parseFloat(arrPoint[1]);
			arrPositionCoordinates.push(coordinate);
		}

		var arrPositionInfos= [];
		if($.trim(positionInfos) != ''){
			arrPositionInfos =  positionInfos.split('#;#');	
		}
		var infoWindows = [];

		var animationDelay = 0;
		var enableAnimation;
		if(  $(window).width() > 690 ) { animationDelay = 180; enableAnimation = google.maps.Animation.BOUNCE } else { enableAnimation = null; }
		var map;
		function initialize() {

			var styles = [
			    {
			      stylers: [
			        { hue: accentColor },
			        { saturation: -10 }
			      ]
			    },{
			      featureType: "road",
			      elementType: "geometry",
			      stylers: [
			        { lightness: 100 },
			        { visibility: "simplified" }
			      ]
			    },{
			      featureType: "road",
			      elementType: "labels",
			      stylers: [
			        { visibility: "off" }
			      ]
			    }
			  ];

			  // Create a new StyledMapType object, passing it the array of styles,
			  // as well as the name to be displayed on the map type control.
			  var styledMap = new google.maps.StyledMapType(styles,
		    	{name: "Styled Map"});


			  var mapOptions = {
			    zoom: zoomLevel,
			    scrollwheel: false,
		       	panControl: false,
		       	mapTypeControl: false,
		  		scaleControl: false,
		  		streetViewControl: false,
		  		mapTypeControlOptions: {
			      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
			    },
	     	// mapTypeId: [google.maps.MapTypeId.ROADMAP,'map_style'],
			    zoomControl:enableZoom,
			    zoomControlOptions: {
		        	style: google.maps.ZoomControlStyle.LARGE,
		        	position: google.maps.ControlPosition.LEFT_CENTER
		   	  	},
		    	center: new google.maps.LatLng(centerLatitude, centerLongitude)
		  }
  			map = new google.maps.Map(document.getElementById('map-holder'),
		      mapOptions);

  			if(mapType == 'styled'){
		  		map.mapTypes.set('map_style', styledMap);
				map.setMapTypeId('map_style');
			}

		  	google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
		
				//don't start the animation until the marker image is loaded if there is one
				if(markerImg.length > 0) {
					var markerImgLoad = new Image();
					markerImgLoad.src = markerImg;
					
					$(markerImgLoad).load(function(){
						 setMarkers(map);
					});
				}
				else {
					setMarkers(map);
				}
    		});
		  	// setMarkers(map);
		}

		 function setMarkers(map) {
			for (var i = 1; i <= arrPositionCoordinates.length; i++) {  
				
				(function(i) {
					setTimeout(function() {
					
				      var marker = new google.maps.Marker({
				      	position: new google.maps.LatLng(arrPositionCoordinates[i-1].lat, arrPositionCoordinates[i-1].lng),
				        map: map,
						infoWindowIndex : i - 1,
						animation: enableAnimation,
						icon: markerImg,
						optimized: false
				      });
					  
					  setTimeout(function(){marker.setAnimation(null);},200);
					  if(arrPositionInfos.length != 0 && arrPositionInfos.length <= i){
					      //infowindows 
					      var infowindow = new google.maps.InfoWindow({
					   	    content: arrPositionInfos[i-1],
					    	maxWidth: 300
						  });
						  
						  infoWindows.push(infowindow);
					      
					      google.maps.event.addListener(marker, 'click', (function(marker, i) {
					        return function() {
					        	infoWindows[this.infoWindowIndex].open(map, this);
					        }
					        
					      })(marker, i));
						}
			     	
			         }, i * animationDelay);
			         
			         
			     }(i));
			     

			 }//end for loop
		}//setMarker
		initialize();
		// google.maps.event.addDomListener(window, 'load', initialize);
	}

	velavo.socialShare = function(){
	
		if( $('a.facebook-share').length > 0 || $('a.twitter-share').length > 0 || $('a.pinterest-share').length > 0) {
			$('a.facebook-share').each(function(){
				var $this = $(this);
				$.getJSON("http://graph.facebook.com/?id="+ $this.data('target') +'&callback=?', function(data) {
					if((data.shares != 0) && (data.shares != undefined) && (data.shares != null)) { 
						$this.find('a span.count, span.count').html( data.shares );	
					}
					else {
						$this.find('a span.count, span.count').html( 0 );	
					}
				});
			});
			
			$('.facebook-share').click(function(e){
				var $this = $(this);
				window.open( 'https://www.facebook.com/sharer/sharer.php?u='+ $this.data('target'), "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" ) 
				return false;
			});
			
			$('a.twitter-share').each(function(){
				var $this = $(this);
				$.getJSON('http://urls.api.twitter.com/1/urls/count.json?url='+$this.data('target')+'&callback=?', function(data) {
					if((data.count != 0) && (data.count != undefined) && (data.count != null)) { 
						$this.find('a span.count, span.count').html( data.count );
					}
					else {
						$this.find('a span.count, span.count').html( 0 );
					}
				});
			});
			
			$('.twitter-share').click(function(e){
				e.preventDefault();
				var $this = $(this);
				var article = $this.closest('article');
				var $pageTitle = article.find('.entry-title a').length ?
					encodeURIComponent($.trim(article.find('.entry-title a').text())) :
					encodeURIComponent($.trim(article.find('.entry-title').text())) ;
				window.open( 'http://twitter.com/intent/tweet?text='+ $.trim($pageTitle) +' '+$this.data('target'), "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" );
				return false;
			});
			
			$('.pinterest-share').each(function(){
				var $this = $(this);
				$.getJSON('http://api.pinterest.com/v1/urls/count.json?url='+$this.data('target')+'&callback=?', function(data) {
					if((data.count != 0) && (data.count != undefined) && (data.count != null)) { 
						$this.find('a span.count, span.count').html( data.count );
					}
					else {
						$this.find('a span.count, span.count').html( 0 );
					}
				});
			});
			
			$('.pinterest-share').click(function(e){
				e.preventDefault();
				var $this = $(this);
				var article = $this.closest('article');
				var $sharingImg = article.find('.post-media img').length ? article.find('.post-media img').attr('src') : '';
				var $pageTitle = article.find('.entry-title a').length ?
					encodeURIComponent($.trim(article.find('.entry-title a').text())) :
					encodeURIComponent($.trim(article.find('.entry-title').text())) ;
				window.open( 'http://pinterest.com/pin/create/button/?url='+$this.data('target')+'&media='+$sharingImg+'&description='+$.trim($pageTitle), "pinterestWindow", "height=640,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0" ); 
				return false;
			});
		}
	}

	velavo.gallery = function(){
		var gallery = $('.wae-gallery');
		if(gallery.length == 0) return;
		// if(typeof manualInvoked == 'undefined' && $('video').length > 0) return;
		gallery.imagesLoaded(function(){
			gallery.flexslider({
				animation : "slide",
				directionNav: false,
				start: function(){
					if(Modernizr.mq('(max-width: 40em)')) return;
					var $container = $('.masonry');
					if($container.length == 0) return;
					new AnimOnScroll( document.getElementById( 'masonry' ), {
						minDuration : 0.4,
						maxDuration : 0.7,
						viewportFactor : 0.2
					} );
				},
			});
		});
	}

	velavo.mobileSearch = function(){
		$('.search-at-top').click(function(){
			if ($('.top-bar').hasClass('active-search')){
				$('.top-bar').prop('class', 'top-bar');
			}else{
				$('.top-bar').prop('class','top-bar active-search');
				$('.mobile-search input').focus();
			}
		});
		$('.toggle-topbar').click(function(){
			if($('.top-bar').hasClass('active-search')){
				$('.top-bar').removeClass('active-search');
			}
		});
		$('.cross-icon').click(function(){
			$('.top-bar').prop('class', 'top-bar');
		});
	}

	velavo.searchHeader = function(){
		var width = $('.search-wrapper').closest('ul').width();
		$('.search-wrapper form').width(width+40);
		$('.search-wrapper form input').width(width-56);
		$('.search-button').click(function(e){
			e.preventDefault();
			$('.search-wrapper').closest('section').css('overflow','hidden');
			$('.search-wrapper').closest('ul').animate({
					marginLeft:-width
			});
			$('.search-wrapper').animate({width:width+40},function(){
				$('.search-wrapper input').focus();
			});
			
		});
		$('.close-search-button').click(function(e){
			e.preventDefault();
			$('.search-wrapper').closest('ul').animate({
					marginLeft:0
			});
			$('.search-wrapper').animate({width:25},function(){
				$('.search-wrapper').closest('section').removeAttr('style');
			});
		});
	}

	velavo.smoothDropdown = function(){
		$('.top-bar-section > ul > li.has-dropdown').mouseenter(function(){
			var $this = $(this);
			var interval = 200;
			$this.find('ul.dropdown > li:not(.back)').each(function(){
				var $li = $(this);
				setTimeout(function(){
					$li.fadeIn({
						duration : 'slow',
						easing : 'easeInOutSine'
					});
				},interval);
				interval +=  200;
			});
		});
		$('.top-bar-section > ul > li.has-dropdown').mouseleave(function(){
			var $this = $(this);
			$this.find('ul.dropdown > li:not(.back)').hide();
		});
	}

	velavo.galleryPopup = function(){
		var galleryHolder = $('.tiled-gallery');
		if(galleryHolder.length == 0 ) return;
		galleryHolder.magnificPopup({
		  delegate : '.tiled-gallery-item > a',
		  type: 'image',
		  gallery:{
		    enabled:true
		  }
		});
	}

	velavo.ourFields = function(){
		$('.our-fields-wrapper').click(function(){
			$(this).closest('.row').find('.our-fields-wrapper.active').removeClass('active');
			$(this).addClass('active');
		});
	}

	velavo.masonry();
	$(document).ready(function(){
		velavo.media();
		velavo.embededResize();
		velavo.googleMap();
		velavo.socialShare();
		velavo.gallery();
		velavo.mobileSearch();
		velavo.searchHeader();
		velavo.smoothDropdown();
		velavo.galleryPopup();
		velavo.fixHeight();
		velavo.ourFields();
		$(window).resize();
	});
	$(document).foundation();
}(jQuery, window));