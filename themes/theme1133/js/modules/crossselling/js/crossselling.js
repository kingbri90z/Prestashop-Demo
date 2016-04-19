$(document).ready(function() {
	if (typeof productColumns != 'undefined') {
		if ($(document).width() >= 768) {
			if(productColumns == 1){minSlides=6}else if(productColumns == 2){minSlides=5} else {minSlides = 3}
			maxSlides = 6;
		}else{
			minSlides = 3;
			maxSlides = 3;	
		}
	}else {
		minSlides = 2,
		maxSlides = 6
	}
	if (!!$.prototype.bxSlider)
		slider1= $('#crossselling_list_car').bxSlider({
			minSlides: minSlides,
			maxSlides: maxSlides,
			slideWidth: 178,
			slideMargin: 20,
			pager: false,
			nextText: '',
			prevText: '',
			moveSlides:1,
			infiniteLoop:false,
			hideControlOnEnd: true
		});
		if($('#crossselling_list_car').length) {
			$(window).resize( function(){
				if($(document).width() <= 767) {
					slider1.reloadSlider({
						minSlides: 3,
						maxSlides: 3,
						slideWidth: 178,
						slideMargin: 20,
						pager: false,
						nextText: '',
						prevText: '',
						moveSlides:1,
						infiniteLoop:false,
						hideControlOnEnd: true
					})
				} else if ($(document).width() >= 768){
					if (typeof productColumns != 'undefined') {
						if(productColumns == 1){minSlides=6}else if(productColumns == 2){minSlides=5} else {minSlides = 3}
						} else {
							minSlides = 2	
						}
						slider1.reloadSlider({
							minSlides: minSlides,
							maxSlides: 6,
							slideWidth: 178,
							slideMargin: 20,
							pager: false,
							nextText: '',
							prevText: '',
							moveSlides:1,
							infiniteLoop:false,
							hideControlOnEnd: true
						})	
					}
				})
			}
});
