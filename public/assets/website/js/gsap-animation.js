gsap.registerPlugin(ScrollTrigger, SplitText);
gsap.config({
    nullTargetWarn: false,
    trialWarn: false
});
/*----  Functions  ----*/

//** Staticbox Hover **//
function pbmit_staticbox_hover() {
	var pbmit_var = jQuery('.pbmit-element-service-style-2, .pbmit-element-service-style-3, .pbmit-element-static-box-style-1, .pbmit-element-static-box-style-2, .pbmit-element-static-box-style-4');
	if (!pbmit_var.length) {
		return;
	}
	pbmit_var.each(function() {
		var pbmit_Class = ' .pbmit-element-posts-wrapper > .pbmit-ele-static-box, .swiper-static-slide-nav li, .pbmit-hover-inner li';
		jQuery(this)
			.find(pbmit_Class).first()
			.addClass('pbmit-active');
		jQuery(this)
			.find(pbmit_Class)
			.on('mouseover', function() {
				jQuery(this).addClass('pbmit-active').siblings().removeClass('pbmit-active');
			});
	});
}

//** Service Bg Hover **//
var pbmit_service_bg_hover = function() {
	if (typeof Swiper !== 'undefined') {
		var pbmit_hover = new Swiper(".pbmit-hover-image-faded", {
			speed: 6000,
			effect: 'fade',
		});
	}
	jQuery('.pbmit-main-hover-faded li').hover(function(e) {
		e.preventDefault();
		var myindex = jQuery(this).index();
		pbmit_hover.slideTo(myindex, 1000, false);
	});
}

var pbmit_hover_slide = function() {
	
	if (typeof Swiper !== 'undefined') {
		var pbmit_hover1 = new Swiper(".pbmit-hover-image", {
			grabCursor: true,
			effect: "slide",
			allowTouchMove: false
		});
		var pbmit_hover2 = new Swiper(".pbmit-short-description", {
			grabCursor: true,
			effect: "creative",
			creativeEffect: {
				prev: {
					translate: [0, "-170%", 1],
				},
				next: {
					translate: [0, "100%", 0],
				},
			},
			allowTouchMove: false
		});
		jQuery('.pbmit-main-hover-slider li').hover(function(e) {
			e.preventDefault();
			var myindex = jQuery(this).index();
			pbmit_hover1.slideTo(myindex, 500, false);
			pbmit_hover2.slideTo(myindex, 500, false);
		});
	}
}

//** Image animation **//
function pbmit_img_animation() {
    const boxes = gsap.utils.toArray('.pbmit-animation-style1,.pbmit-animation-style2,.pbmit-animation-style3,.pbmit-animation-style4,.pbmit-animation-style5,.pbmit-animation-style6');
    boxes.forEach(img => {
        gsap.to(img, {
            scrollTrigger: {
                trigger: img,
                start: "top 70%",
                end: "bottom bottom",
                toggleClass: "active",
                once: true,
            }
        });
    });
}

//** Button Hover Move **//
function pbmit_button_hover() {
	const all_btns = gsap.utils.toArray(".pbmit-btn-style-text.pbmit-btn-shape-outline .elementor-button-wrapper,.pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button-wrapper");
	if (all_btns.length > 0) {
	  var all_btn = gsap.utils.toArray(".pbmit-btn-style-text.pbmit-btn-shape-outline .elementor-button-wrapper,.pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button-wrapper");
	}
	else {
	  var all_btn = gsap.utils.toArray("#elementor-button-wrapper");
	}
	const all_btn_cirlce = gsap.utils.toArray(".pbmit-btn-style-text.pbmit-btn-shape-outline .elementor-button, .pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button");
	all_btn.forEach((btn, i) => {
	  jQuery(btn).mousemove(function (e) {
		callParallax(e);
	  });
	  function callParallax(e) {
		parallaxIt(e, all_btn_cirlce[i], 10);
	  }
  
	  function parallaxIt(e, target, movement) {
		var $this = jQuery(btn);
		var relX 	= e.pageX - $this.offset().left; 
		var relY	= e.pageY - $this.offset().top;
  
		gsap.to(target, 0.5, {
		  x: ((relX - $this.width() / 2) / $this.width()) * movement,
		  y: ((relY - $this.height() / 2) / $this.height()) * movement,
		  ease: Power2.easeOut,
		});
	  }
	  jQuery(btn).mouseleave(function (e) {
		gsap.to(all_btn_cirlce[i], 0.5, {
		  x: 0,
		  y: 0,
		  ease: Power2.easeOut,
		});
	  });
	});
}


function pbmit_button_hover_move() {
	jQuery('.pbmit-btn-style-text.pbmit-btn-shape-outline .elementor-button, .pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button').on('mouseenter', function (e) {
	   var x = e.pageX - jQuery(this).offset().left;
	   var y = e.pageY - jQuery(this).offset().top;
   
	   jQuery(this).find('.pbmit-button-hover').css({
		 top: y,
		 left: x
	   });
	 });
   
	 jQuery('.pbmit-btn-style-text.pbmit-btn-shape-outline .elementor-button, .pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button').on('mouseout', function (e) {
	   var x = e.pageX - jQuery(this).offset().left;
	   var y = e.pageY - jQuery(this).offset().top;
   
	   jQuery(this).find('.pbmit-button-hover').css({
		 top: y,
		 left: x
	   });
	 });
}

var pbmit_button_hover_span = function() {
	if( jQuery('.pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button .pbmit-button-text').length > 0 ){
		jQuery('.pbmit-btn-style-text.pbmit-btn-shape-outline .pbmit-button .pbmit-button-text').each(function(e){
			var buttton_span = document.createElement('span');
			jQuery(buttton_span).addClass('pbmit-button-hover').prependTo(jQuery( this ));
		});
	}
}

function getpercentage(x, y, elm) {
	elm.find('.pbmit-fid-inner').html(y + '/' + x);
	var cal = Math.round((y * 100) / x);
	return cal;
}

//** Title animation **//
function pbmit_title_animation() {

	ScrollTrigger.matchMedia({
		"(min-width: 991px)": function() {

		var pbmit_var = $('.pbmit-heading, .pbmit-heading-subheading');
		if (!pbmit_var.length) {
			return;
		}
		const quotes = document.querySelectorAll(".pbmit-heading-subheading .pbmit-title, .pbmit-heading .pbmit-title");

			quotes.forEach(quote => {

				//Reset if needed
				if (quote.animation) {
					quote.animation.progress(1).kill();
					quote.split.revert();
				}

				var getclass = quote.closest('.pbmit-heading-subheading, .pbmit-heading').className;
				var animation = getclass.split('animation-');
				if (animation[1] == "style4") return

				quote.split = new SplitText(quote, {
					type: "lines,words,chars",
					linesClass: "split-line"
				});
				gsap.set(quote, { perspective: 400 });

				if (animation[1] == "style1") {
					gsap.set(quote.split.chars, {
						opacity: 0,
						y: "90%",
						rotateX: "-40deg"
					});
				}
				if (animation[1] == "style2") {
					gsap.set(quote.split.chars, {
						opacity: 0,
						x: "50"
					});
				}
				if (animation[1] == "style3") {
					gsap.set(quote.split.chars, {
						opacity: 0,
					});
				}
				quote.animation = gsap.to(quote.split.chars, {
					scrollTrigger: {
						trigger: quote,
						start: "top 90%",
					},
					x: "0",
					y: "0",
					rotateX: "0",
					opacity: 1,
					duration: 1,
					ease: Back.easeOut,
					stagger: .02
				});
			});
		},
	});
}

//** Pbmit Sticky Col **//
function pbmit_sticky() {

	ScrollTrigger.matchMedia({
		"(min-width: 1200px)": function() {
			let pbmit_sticky_container = jQuery(".pbmit-sticky-col");
			let section = pbmit_sticky_container.closest('section');
			if (!section[0]) {
				section = pbmit_sticky_container.closest('.pbmit-sticky-section');
			} 
			let tl = gsap.timeline({
				scrollTrigger: {
					pin: pbmit_sticky_container,
					scrub: 1,
					start: "top top", 
					trigger: section,
					end: () => "+=" + ((section.height() + 250) - window.innerHeight), 
					invalidateOnRefresh: true
				},
				defaults: { ease: "none", duration: 1 }
			});
		},
	}); 
}

//** Pbmit Sticky Col **//
// function pbmit_sticky() {
// 	ScrollTrigger.matchMedia({
// 		"(min-width: 768px)": function() {

// 			let pbmit_sticky_container = jQuery(".pbmit-sticky-col");
// 			let section = pbmit_sticky_container.closest('section');
// 			if (!section[0]) {
// 				section = pbmit_sticky_container.closest('.pbmit-sticky-section');
// 			}

// 			let tl = gsap.timeline({
// 				scrollTrigger: {
// 					pin: true,
// 					scrub: 1,
// 					trigger: pbmit_sticky_container,
// 					end: () => "+=" + ((section.height() + 200) - document.documentElement.clientHeight)
// 				},
// 				defaults: { ease: "none", duration: 1 }
// 			});
// 		},
// 	});
// }

//** Pbmit Splite Slide **//
// function pbmit_splite_slide() {
// 	if (!jQuery(".pbmit-element-split-slide-style-1")[0]) {
// 		return
// 	}
// 	ScrollTrigger.matchMedia({
// 		"(min-width: 991px)": function() {

// 			let container = jQuery(".pbmit-element-split-slide-style-1 .pbmit-img");
// 			let section = jQuery(".pbmit-element-split-slide-style-1 .pbmit-element-split-slide-wrapper");
// 			var indicators = gsap.utils.toArray('.pbmit-element-split-slide-style-1 .pbmit-split-slide-item-image');
// 			var points = gsap.utils.toArray('.pbmit-element-split-slide-style-1 .pbmit-bg-imgbox .pbmit-split-slide-box');

// 			var gap = points.length * 30;

// 			let tl = gsap.timeline({
// 				scrollTrigger: {
// 					pin: true,
// 					scrub: 1,
// 					trigger: container,
// 					end: () => "+=" + ((section.height() + gap) - document.documentElement.clientHeight),
// 					onUpdate: (self) => {
// 						let per = parseInt(self.progress * 100);
// 						if (per > 99) indicators[points.length - 1].classList.add('last');
// 						else indicators[points.length - 1].classList.remove('last');
// 						if (per < 1) indicators[0].classList.add('first');
// 						else indicators[0].classList.remove('first');

// 					}
// 				},
// 				defaults: { ease: "none", duration: 1 }
// 			});

// 			points.forEach((sct, i) => {
// 				let pos = indicators[i];
// 				ScrollTrigger.create({
// 					trigger: sct,
// 					start: "top center",
// 					end: () => '+=' + sct.offsetHeight,
// 					toggleClass: { targets: pos, className: "active" }
// 				});
// 			});
// 			jQuery('.pbmit-element-split-slide-style-1 .pbmit-bg-imgbox .pin-spacer .pbmit-split-slide-item-image:first-child').addClass('active');
// 		},
// 		"(max-width:991px)": function() {
// 			ScrollTrigger.getAll().forEach(pin => pin.kill(true));
// 		}
// 	});
// }

ScrollTrigger.matchMedia({
	"(max-width: 1200px)": function() {
		ScrollTrigger.getAll().forEach(t => t.kill());
	}
});

// function pbmit_row_class() {
// 	jQuery(".wpem-row,#event-listing-view").addClass("row");
// }

// var pbmit_hover_slide = function() {
// 	if (typeof Swiper !== 'undefined') {
// 		var pbmit_hover = new Swiper(".pbmit-hover-image", {
// 			fadeEffect: { crossFade: true },
// 			virtualTranslate: true,
// 			autoplay: 2500,
// 			speed: 1000,
// 			autoplayDisableOnInteraction: true,
// 			slidersPerView: 1,
// 			effect: "fade"
// 		});		
// 	}
// 	jQuery('.pbmit-main-hover-slider li').hover(function(e) {
// 		e.preventDefault();
// 		var myindex = jQuery(this).index();
// 		pbmit_hover.slideTo(myindex, 500, false);
// 	});
// }

//** Pbmit Card Verticel Pinning **//
// function pbmit_card_verticel_pinning() {
// 	var pbmit_var = jQuery('.pbmit-element-card-box-style-1');
// 	if (!pbmit_var.length) {
// 		return;
// 	}
// 	ScrollTrigger.matchMedia({
// 		"(min-width: 992px)": function() {

// 			let pbmitpanels = gsap.utils.toArray(".pbmit-element-card-box-style-1 .pbmit-card-box-wrapper");
// 			const spacer = 0;
		
// 			let pbmitheight = pbmitpanels[0].offsetHeight + 120;
// 			pbmitpanels.forEach((pbmitpanel, i) => { 
// 			TweenMax.set(pbmitpanel, {top: i * 50});
// 			const tween = gsap.to(pbmitpanel, {
// 				scrollTrigger: {
// 				  trigger: pbmitpanel,
// 				  start: () => `top bottom-=100`,
// 				  end: () => `top top+=40`,
// 				  scrub: true, 
// 				  invalidateOnRefresh: true
// 				},
// 				ease: "none",
// 				scale: () => 1 - (pbmitpanels.length - i) * 0.025
// 			});
// 				ScrollTrigger.create({
// 					trigger: pbmitpanel, 
// 					start: () => "top 140px", 
// 					endTrigger: '.pbmit-element-card-box-style-1', 
// 					end: `bottom top+=${pbmitheight + (pbmitpanels.length * spacer)}`,
// 					pin: true, 
// 					pinSpacing: false, 
// 				});
// 			});
// 		},
// 		"(max-width:1025px)": function() {
// 			ScrollTrigger.getAll().forEach(pbmitpanels => pbmitpanels.kill(true));
// 		}
// 	});
// }

// on ready
$(document).ready(function() {
	pbmit_staticbox_hover();
	pbmit_service_bg_hover();
	pbmit_hover_slide();
	pbmit_button_hover_span();
	pbmit_button_hover();
});

// on resize
$(window).resize(function() {
	
});

// on load
$(window).on('load', function(){
	pbmit_img_animation();
	pbmit_button_hover_move();
	pbmit_title_animation();
	pbmit_sticky();
	// pbmit_title_animation();
	// pbmit_img_animation();
	// pbmit_sticky();
	// pbmit_splite_slide();
	// pbmit_hover_slide();
	// pbmit_card_verticel_pinning();
	// setTimeout(cleaning, 500);
	// function cleaning(){
	// 	ScrollTrigger.refresh(); 
	// }
});

