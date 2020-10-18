(function($) {

	"use strict";
	
	/* Gallery Slider Initialize */
	aigpl_gallery_slider_init();
	
	/* Popup Gallery Initialize */
	aigpl_gallery_popup_init();

	/* Elementor Compatibility */
	$(document).on('click', '.elementor-tab-title', function() {

		var ele_control	= $(this).attr('aria-controls');
		var slider_wrap	= $('#'+ele_control).find('.aigpl-gallery-slider');

		/* Tweak for slick slider */
		$( slider_wrap ).each(function( index ) {

			var slider_id = $(this).attr('id');

			if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
				$('#'+slider_id).slick( 'setPosition' );
			}
		});
	});

	/* SiteOrigin Compatibility For Accordion Panel */
	$(document).on('click', '.sow-accordion-panel', function() {

		var ele_control	= $(this).attr('data-anchor');
		var slider_id	= $('#accordion-content-'+ele_control).find('.aigpl-gallery-slider').attr('id');

		/* Tweak for slick slider */
		if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
			$('#'+slider_id).slick( 'setPosition' );
		}
	});

	/* SiteOrigin Compatibility for Tab Panel */
	$(document).on('click focus', '.sow-tabs-tab', function() {
		var sel_index	= $(this).index();
		var cls_ele		= $(this).closest('.sow-tabs');
		var tab_cnt		= cls_ele.find('.sow-tabs-panel').eq( sel_index );
		var slider_id	= tab_cnt.find('.aigpl-gallery-slider').attr('id');

		$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

		setTimeout(function() {

			/* Tweak for slick slider */
			if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
				$('#'+slider_id).slick( 'setPosition' );
				$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
			}
		}, 300);
	});

	/* Beaver Builder Compatibility for Accordion */
	$(document).on('click', '.fl-accordion-item', function() {

		var cls_ele		= $(this).closest('.fl-accordion');
		var ele_control	= cls_ele.find('.fl-accordion-button').attr('aria-controls');
		var slider_id	= $('#'+ele_control).find('.aigpl-gallery-slider').attr('id');

		/* Tweak for slick slider */
		if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
			$('#'+slider_id).slick( 'setPosition' );
		}
	});

	/* Beaver Builder Compatibility for Tabs */
	$(document).on('click', '.fl-tabs-label', function() {

		var ele_control	= $(this).attr('aria-controls');
		var slider_id	= $('#'+ele_control).find('.aigpl-gallery-slider').attr('id');

		/* Tweak for slick slider */
		if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
			$('#'+slider_id).slick( 'setPosition' );
		}
	});
})(jQuery);

/* Function to Initialize Album Gallery Slider */
function aigpl_gallery_slider_init() {
	jQuery( '.aigpl-gallery-slider' ).each(function( index ) {

		if( jQuery(this).hasClass('slick-initialized') ) {
			return;
		}

		var slider_id   = jQuery(this).attr('id');
		var slider_conf = jQuery.parseJSON( jQuery(this).closest('.aigpl-gallery-slider-wrp').find('.aigpl-gallery-slider-conf').text());
		
		jQuery('#'+slider_id).slick({
			lazyLoad        : slider_conf.lazyload,
			dots			: (slider_conf.dots) == "true" ? true : false,
			infinite		: (slider_conf.loop) == "true" ? true : false,
			arrows			: (slider_conf.arrows) == "true" ? true : false,
			speed			: parseInt(slider_conf.speed),
			autoplay		: (slider_conf.autoplay) == "true" ? true : false,
			autoplaySpeed	: parseInt(slider_conf.autoplay_interval),
			slidesToShow	: parseInt(slider_conf.slidestoshow),
			slidesToScroll	: parseInt(slider_conf.slidestoscroll),
			rtl             : (Aigpl.is_rtl == 1) ? true : false,
			mobileFirst    	: (Aigpl.is_mobile == 1) ? true : false,
			responsive 		: [{
				breakpoint 	: 1023,
				settings 	: {
					slidesToShow 	: (parseInt(slider_conf.slidestoshow) > 3) ? 3 : parseInt(slider_conf.slidestoshow),
					slidesToScroll 	: 1,
					dots 			: (slider_conf.dots) == "true" ? true : false,
				}
			},{
				breakpoint	: 767,	  			
				settings	: {
					slidesToShow 	: (parseInt(slider_conf.slidestoshow) > 2) ? 2 : parseInt(slider_conf.slidestoshow),
					slidesToScroll 	: 1,
					dots 			: (slider_conf.dots) == "true" ? true : false,
				}
			},
			{
				breakpoint	: 479,
				settings	: {
					slidesToShow 	: 1,
					slidesToScroll 	: 1,
					dots 			: false,
				}
			},
			{
				breakpoint	: 319,
				settings	: {
					slidesToShow 	: 1,
					slidesToScroll 	: 1,
					dots 			: false,
				}
			}]
		});
	});
}

/* Function to Initialize Gallery Popup */
function aigpl_gallery_popup_init() {
	jQuery( '.aigpl-popup-gallery' ).each(function( index ) {
		
		var gallery_id 	= jQuery(this).attr('id');
		var total_item	= jQuery('#'+gallery_id+' .aigpl-cnt-wrp:not(.slick-cloned) a.aigpl-img-link').length;

		if( typeof('gallery_id') !== 'undefined' && gallery_id != '' ) { //.slick-image-slide:not(.slick-cloned) a
			jQuery('#'+gallery_id).magnificPopup({
				delegate: '.aigpl-cnt-wrp a.aigpl-img-link',
				type: 'image',
				mainClass: 'aigpl-mfp-popup',
				tLoading: 'Loading image #%curr%...',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0,1], /* Will preload 0 - before current, and 1 after the current image*/
					tCounter: ''
				},
				image: {
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
					titleSrc: function(item) {
						return item.el.closest('.aigpl-img-wrp').find('.aigpl-img').attr('title');
					}
				},
				zoom: {
					enabled: true,
					duration: 300, /* don't foget to change the duration also in CSS*/
					opener: function(element) {
						return element.closest('.aigpl-img-wrp').find('.aigpl-img');
					}
				},
				callbacks: {
					markupParse: function(template, values, item) {
						var current_indx 	= item.el.closest('.aigpl-cnt-wrp').attr('data-item-index');
						values.counter 		= current_indx+' of '+total_item;

						jQuery('body').trigger('aigpl_mfp_markup_parse', [ template, values, item ]);
					}
				},
			});
		}
	});
}