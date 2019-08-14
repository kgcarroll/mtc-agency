(function () {
  "use strict";

  var isMobileWidth = false;

  function checkMobileWidth(){
    isMobileWidth = ($(window).width() <= 768);
  }

	function setHeights() {
		// Set height of carousel.
		var carouselHeight = $('.carousel div').outerHeight(),
				wrapper = $('.carousels-wrapper');
		wrapper.css('height',carouselHeight);

		// Set height of About Us rows.
		var rowHeight = $('#about-us-content .content-row .content').outerHeight(),
				background = $('#about-us-content .content-row .background');
		background.css('height',rowHeight);
	}

  function jumpLink(){
    $('.jump').on({
      click:function(e){
        e.preventDefault();
        $('html, body').animate({
          scrollTop: $( $.attr(this, 'href') ).offset().top - 57
        }, 750);
      }
    });
  }

  function menu() {
    $("#nav-trigger").on({
      click:function(){
      	$("body").addClass('fixed');
        $("#navigation-container").addClass('open');
        $(this).toggleClass('active inactive');
      }
    });

    // Menu Close
    $("#close-wrap").on({
      click:function(){
      	$("body").removeClass('fixed');
      	$("#navigation-container").removeClass('open');
      }
    });
  }

	function initInstagramCarousel() {
	  $('.instagram-carousel').slick({

	  	dots: false,
  	  infinite: true,
  	  speed: 500,
		  slidesToShow: 3,
		  slidesToScroll: 3,
  	  variableWidth: true,
  	  adaptiveHeight: true,
			centerPadding: '15px',
			centerMode: true,
			prevArrow: '<div class="slick-prev"><span class="icon-gallery-nav ease"></span></div>',
			nextArrow: '<div class="slick-next"><span class="icon-gallery-nav ease"></span></div>',
			responsive: [
			 {
			   breakpoint: 768,
			   settings: {
			     centerPadding: '5px',
			     slidesToShow: 2
			   }
			 },
			 {
			   breakpoint: 480,
			   settings: {
			     slidesToShow: 1
			   }
			 }
			]
	  });
	}

	function initCaseStudiesCarousel() {
	  $('.case-studies-wrap').slick({
	  	dots: false,
  	  infinite: true,
  	  speed: 500,
			centerPadding: '0px',
			prevArrow: '<div class="slick-prev"><span class="icon-gallery-nav ease"></span></div>',
			nextArrow: '<div class="slick-next"><span class="icon-gallery-nav ease"></span></div>'
	  });
	}

	function initStandardGallery() {
	  $('.gallery').slick({
	  	dots: false,
  	  // infinite: true,
  	  speed: 500,
			centerPadding: '0px',
			prevArrow: '<div class="slick-prev"><span class="icon-gallery-nav ease"></span></div>',
			nextArrow: '<div class="slick-next"><span class="icon-gallery-nav ease"></span></div>'
	  });
	}


	function initCarousel(id) {
		var imgs = $('.carousel.row-'+id).find('div'),
	    	i = 0;
		function changeImage(){
	    var next = (++i % imgs.length);
	    $(imgs.get(next - 1)).fadeOut(125);
	    $(imgs.get(next)).fadeIn(125);
		}
		var interval = setInterval(changeImage, 350);
	}

	// Responsive images
	function resizeImages(){
	  // Responsive background image
	  $('.responsive-bg').each(function(){
	    var desktop = $(this).attr('data-d'),
	        tablet = $(this).attr('data-t'),
	        mobileL = $(this).attr('data-m-l'),
	        mobile = $(this).attr('data-m');
	    if($(window).width() < 480) {
	      $(this).attr('style', 'background-image: url("'+ mobile +'")');
	    } else if($(window).width() < 767) {
	      $(this).attr('style', 'background-image: url("'+ mobileL +'")');
	    }	else if($(window).width() < 1023) {
	      $(this).attr('style', 'background-image: url("'+ tablet +'")');
	    } else {
	      $(this).attr('style', 'background-image: url("'+ desktop +'")');
	    }
	  });

	  // Responsive Image
	  $('.responsive-img').each(function(){
	    var desktop = $(this).attr('data-d'),
	        tablet = $(this).attr('data-t'),
	        mobileL = $(this).attr('data-m-l'),
	        mobile = $(this).attr('data-m');
	    if($(window).width() < 480) {
	      $(this).attr('src', mobile );
	    } else if($(window).width() < 767) {
	      $(this).attr('src', mobileL );
	    } else if($(window).width() < 1023) {
	      $(this).attr('src', tablet );
	    } else {
	      $(this).attr('src', desktop );
	    }
	  });

	  $('.responsive-height').each(function(){
	    var desktop = $(this).attr('data-d'),
	        tablet = $(this).attr('data-t'),
	        mobileL = $(this).attr('data-m-l'),
	        mobile = $(this).attr('data-m');
	    if($(window).width() < 480) {
	      $(this).attr('height', mobile );
	    } else if($(window).width() < 767) {
	      $(this).attr('height', mobileL );
	    } else if($(window).width() < 1023) {
	      $(this).attr('height', tablet );
	    } else {
	      $(this).attr('height', desktop );
	    }
	  });

	}

	// Do stuff on document ready
	$(document).ready(function(){
		// Add description to featured image meta box.
		$('#postimagediv .inside').prepend('<p>Your image should be a 16/9 aspect ratio, at least 1200px by 675px.</p>');

	  // Initiate goodies.
    resizeImages();
	  setHeights();
	  initCarousel(1);
	  initCarousel(2);
	  initCarousel(3);
	  initInstagramCarousel();
	  initCaseStudiesCarousel();
	  jumpLink();
	  menu();

	  initStandardGallery();

	  // if($(window).width() <= 768){
	  // }
	});

	// Do stuff on Window resize
	$(window).on({
	  resize:function(){
	  	setHeights();
      checkMobileWidth();
      resizeImages();
	    // if($(window).width() <= 768){
	    // }
	  },

	  // Do stuff on Window scroll
	  scroll:function(){
	  }
	})

	// $(window).load(function(){
	//   if($(window).height() > $(window).scrollTop()){
	//     setTimeout(function(){
	//       lazyLoad();
	//     },140);
	//   }
	// });

}());