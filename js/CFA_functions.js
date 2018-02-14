/* custom CFA Functions
================================================== */


var browserWidth = jQuery('html').width();
var themepath = '/cfa/wp-content/themes/CFA_v4.0/'
var modal = jQuery('#modal');
var modalSwiper = '';
var fogliaSwiper = '';


////////////////////////////////////
// Homepage Functions
////////////////////////////////////

// Home: sballa larghezza delle immagini per creare un po' di casino.
function randomFromInterval(from,to) {
    return Math.floor(Math.random()*(to-from+1)+from);
}

// Home: ridimensiona layout dopo window load/resize
//===============================
function okresize() {
	if (browserWidth > 767) {

	  jQuery('.newitem img').each(function() {
	    var blockwidth = jQuery(this).width();
	    var blockheight = jQuery(this).height();
	    //console.log('pppp'+blockwidth);
	    var percent;
	    if (blockwidth === 0 ) {blockwidth = 640; }
	    if (blockwidth>=480) {
	      if (blockwidth>blockheight) {
	        percent = randomFromInterval(0,5);
	      } else {
	        percent = randomFromInterval(0,30);
	      }
	    }
	    var resizedwidth = blockwidth-((percent*blockwidth)/100);
	    //console.log('resizedwidth: '+resizedwidth);
	    jQuery(this).css('width',resizedwidth+'px');

	    jQuery(this).parent().parent().removeClass('newitem');
	  });

	}
}


// Home: custom layout mode: spineAlign
//===============================

if (browserWidth>767) {
	jQuery.Isotope.prototype._spineAlignReset = function() {
	  this.spineAlign = {
	    colA: 0,
	    colB: 0
	  };
	};

	jQuery.Isotope.prototype._spineAlignLayout = function( $elems ) {
	  var instance = this,
	      props = this.spineAlign,
	      gutterWidth = Math.round( this.options.spineAlign && this.options.spineAlign.gutterWidth ) || 0,
	      centerX = Math.round(this.element.width() / 2);


	  $elems.each(function(){
	    var $this = jQuery(this),
	        isColA = props.colA <= props.colB,
	        x = isColA ?
	          centerX - ( $this.outerWidth(true) + gutterWidth / 2 ) : // left side
	          centerX + gutterWidth / 2, // right side
	        y = isColA ? props.colA : props.colB;
	    instance._pushPosition( $this, x, y );
	    props[( isColA ? 'colA' : 'colB' )] += $this.outerHeight(true);
	    //if(isColA) {
	      //$this.children('.pinbin-image, .pinbin-text').addClass('postright');
	    //}
	  });
	};


	jQuery.Isotope.prototype._spineAlignGetContainerSize = function() {
	  var size = {};
	  size.height = this.spineAlign[( this.spineAlign.colB > this.spineAlign.colA ? 'colB' : 'colA' )];
	  return size;
	};

	jQuery.Isotope.prototype._spineAlignResizeChanged = function() {

	  return true;
	};
}

// Home: actions at window resize
//===============================

jQuery(window).resize(function() {
  browserWidth = jQuery('html').width();
  //console.log(browserWidth);

  if (browserWidth>767) {
        jQuery('#post-area').isotope({
        layoutMode: 'spineAlign',
        //disable resizing
        resizable: false,
        spineAlign: {
          gutterWidth: 10
        }
      });

      setTimeout(function(){
        jQuery('#post-area.isotope').isotope('reLayout');
      },1000)
  }
  else if(browserWidth<=767 && browserWidth>640){
    jQuery('#post-area.isotope').isotope('destroy');
  }
  else if(browserWidth<=640){
    jQuery('#post-area.isotope').isotope('destroy');
  }
});

// Home: actions at window load
//===============================

jQuery(window).load(function(){

  console.log('done with page load.');
  var $container = jQuery('#post-area');
	// effetto hover su immagini in hp (idem a #234)
	if(browserWidth>1024){
		jQuery('article.post .pinbin-image').each( function() {
					jQuery(this).hoverdir({speed : 1000});
		});

	}
	okresize();



	$container.imagesLoaded().done( function( instance ) {
    console.log('all images successfully loaded');
    jQuery('#whitecurtain').addClass('transparent');

		setTimeout(function(){
	    jQuery('#whitecurtain').addClass('hidden').removeClass('transparent');
		},2000);

    if (browserWidth>767) {

      $container.isotope({
        layoutMode: 'spineAlign',
        //disable resizing
        resizable: false,
        spineAlign: {
          gutterWidth: 10
        }
      });
      $container.isotope('reLayout');


    }
  }).fail( function() {
    console.log('all images loaded, at least one is broken');
		jQuery('#whitecurtain').fadeOut(2000); //anyway..
  });

  var pageNum = 0;
  $container.infinitescroll({
    loading: {
      finished: undefined,
      finishedMsg: "<em>No other items to load.</em>",
      img: themepath+"images/tiny_red.gif",
      msg: null,
      msgText: "",
      selector: null,
      speed: 'fast',
      start: undefined
    },
    state: {
      isDuringAjax: false,
      isInvalidPage: false,
      isDestroyed: false,
      isDone: false, // For when it goes all the way through the archive.
      isPaused: false,
      currPage: 1
    },
    navSelector  : '#nav-below',    // selector for the paged navigation
    nextSelector : '#nav-below .view-previous a',  // selector for the NEXT link (to page 2)
    itemSelector : '.post',     // selector for all items you'll retrieve
    animate      : false,
    extraScrollPx: 250,
    bufferPx     : 50,
    errorCallback: function(){$container.isotope('reLayout');}
  },
  // call Isotope as a callback
  function( newElements ) {
    pageNum++;

		if(browserWidth>1024){
      jQuery('article.post .pinbin-image').each( function() {
        jQuery(this).hoverdir({speed : 1000});
      });
		}

    okresize();

    scan_urls();

    if (jQuery("#post-area").hasClass('isotope')) {
      $container.children('.newitem').hide();

      $container.children('.newitem').fadeIn(500);
      $container.isotope( 'appended', jQuery( newElements ) );
      setTimeout(function(){$container.isotope('reLayout');}, 1500);
    }

    ga('send', 'pageview', '/scroll/'+pageNum);
    //console.log('scroll/'+pageNum);
  });


});




////////////////////////////////////
// Foglia Functions
////////////////////////////////////


var CFAslidersettings = {
	init: false,
  direction: 'horizontal',
	autoHeight: true,
  loop: true,
	keyboard: true,
	preloadImages: false,
  lazy: {
    loadPrevNext: true,
  },
	fadeEffect: {
    crossFade: true
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
		clickable: true
  },

  // Navigation arrows
  navigation: {
    nextEl: '.nextContainer',
    prevEl: '.prevContainer',
  }
}


// Foglia: actions at window load
//===============================

jQuery(window).load(function(){
  console.log('done with page load.');
  jQuery('article.post .pinbin-image').addClass('newitem');
  okresize();

  jQuery('.archive-month-container').isotope({
    columnWidth: 160
  });


	// Foglia: that fantastic lightbox!
	//===============================

  if (jQuery('body').hasClass('single')) {
    jQuery('.posttags a').attr('target','_parent'); // ???
  }
  else {
		jQuery('article.post').click(function(e) {

			e.preventDefault();

			modal.removeClass('hidden');

			var theUrl = jQuery(this).find('.pinbin-image > a').attr('href');
			var theID = jQuery(this).attr('id');
			var header = "<div id=\"main-nav-wrapper\" class=\"left on\">\n<div id=\"logo\"></div>\n<div id=\"closecard\">\n<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" x=\"0px\" y=\"0px\" viewBox=\"0 0 16 20\"><g><path d=\"m1 11v-6h7v-4l7 7-7 7v-4z\"/></g></div>\n</div>";

			modal.load( theUrl+" #"+theID, function( response, status, xhr ) {
				// console.debug(status);

				if ( status == "success" ) {

					modal.prepend(header);
					modal.removeClass('empty');

					// chiudi tutto
					jQuery('#modal #logo, #modal #closecard').click(function(){
						console.debug('click logo');
						parent.update_url("/");
						modal.addClass('hidden empty');
						setTimeout(function(){
							modal.html('');
						},1000);

					});

					// modal: Swiper init (see also @ line #348: fogliaSwiper )
					modalSwiper = new Swiper ('.CFAslider', CFAslidersettings );
					//console.debug('modalSwiper init');
					modalSwiper.init();
					setTimeout(function(){
						//console.debug('modalSwiper slideTo1');
						modalSwiper.update();
					},1000);

					modalSwiper.on('lazyImageReady', function () {
						modalSwiper.update();
					});

				}

				if ( status == "error" ) {
			    var msg = "<div class=\"post\"><p>Apologies, the article at "+theUrl+" is not available</p>\n<p>You'll be redirected to the home page in 5 seconds.</p></div>";
			    jQuery( modal ).html( header +"<h2>"+ xhr.status + ' ' + xhr.statusText +"</h2>"+ msg  );
					setTimeout(function(){
						modal.addClass('hidden empty');
					},5000);

			  }

			});
		});

  }


  // Foglia: LAZYLOAD (actually is unveil.js)
	//===============================
  jQuery("img.unveil").unveil();


	// Foglia: add print button - borrowed by Shareaholic
	//===============================

  setTimeout(function(){
  jQuery('ul.crafty-social-buttons-list').append('<li style="margin-left: 40px !important;"><a class="crafty-social-button csb-print" href="?print=enabled" target="_blank" title="Print this Page" rel="nofollow"><img class="crafty-social-button-image" alt="Print this Page" width="48" height="48" src="'+themepath+'images/print.png"></a></li>');
  }, 3000);

});


// Foglia: Swiper init (see also @ line #308: modalSwiper )
//===============================
if (jQuery('body').hasClass('single')) {
	//console.debug('swiper init for single page');
	fogliaSwiper = new Swiper ('.CFAslider', CFAslidersettings );
	//console.debug('fogliaSwiper init');
	fogliaSwiper.init();
	setTimeout(function(){
		//console.debug('fogliaSwiper slideTo1');
		fogliaSwiper.update();
	},1000);

	fogliaSwiper.on('lazyImageReady', function () {
		fogliaSwiper.update();
	});

}


////////////////////////////////////
// Logo & Menu Functions
////////////////////////////////////

function CFA_toggle_menu(what) {
	var topoffset = jQuery('#wrap').offset().top;

	//reset iniziale
	jQuery('#menu-pad li.menurev2').removeClass('show');
	jQuery('#blackcurtain').attr('class','');
	jQuery('#blackcurtain > div').addClass('hidden');

  setTimeout(function(){
		if(browserWidth<640) {
			jQuery('body').removeClass('menu_open');
		} else {
			//jQuery('.home #site-navigation').toggleClass('menumode');
			jQuery('#'+what+'-btn').removeClass('hidden').toggleClass('show');
		}
	},400);
  jQuery('#blackcurtain').toggleClass('show').toggleClass(what);
  jQuery('#wrap').toggleClass('fixd');
  jQuery('.sections_menu').parent().click();
  jQuery('#'+what+'-coldx, #'+what+'-colsx').toggleClass('hidden');
  jQuery('.home #'+what).delay(300).fadeIn(300);
	//tienimi sotto la posizione in cui mi trovo
	//jQuery('#wrap').css('top',(topoffset+95)+'px');
}



// update the url if you click on a post
function scan_urls() {
  var link = jQuery('div.pinbin-image a');
  link.each(function() {
    jQuery(this).click(function() {
      update_url( jQuery(this).attr('href') );
    });
  });
}

function update_url(getUrl) {
  var stateObj = window.location.href;
  history.pushState(stateObj, '', getUrl);
}

window.addEventListener('popstate', function(event) {
  console.log('popstate..');
  //window.location.reload();
});

jQuery(document).ready(function($){

	jQuery('#logo').click(function(){
	  if (modal.children().length !== 0) {
			console.debug('click logo');
      parent.update_url("/");
			modal.addClass('hidden empty').delay(1000).html('');
	  } else {
			window.location.href = "/";
		}
	});

	// NAV MENU
	jQuery('#menu_handle').click(function(){
		jQuery('body').toggleClass('menu_open');
		jQuery('#blackcurtain > div').addClass('hidden');
		jQuery('#blackcurtain').attr('class','');
	});
	jQuery('#site-navigation #menu-pad li').click(function(){
		var menuID = jQuery(this).attr('data-menu');
		CFA_toggle_menu(menuID);
	});

  scan_urls();

	jQuery('#menu-coldx .clickable').click(function(){
    jQuery(this).next().slideToggle();
  });

  var searchfieldVal = jQuery('#s').val();
  if (searchfieldVal == 'search') {
    jQuery('#s').val('');
  }

});
