;(function(){

	// Menu settings
	$('#menuToggle, .menu-close').on('click', function(){
		$('#menuToggle').toggleClass('active');
		$('body').toggleClass('body-push-toleft');
		$('#theMenu').toggleClass('menu-open');
	});


	// var chartWidth =  $('.chart-container').width();
	// var chartHeight =  $('.chart-container').height();
    //
	// var windowHeight = $(window).height();

	$('#menuToggle, .menu-close').on('click', function(){
			if($('#theMenu').hasClass('menu-open')){
				// $('.filter-form').height($(window).height() - 140 - chartHeight - $(window).scrollTop());
				// filterHeight = $('.filter-form').height();
				$('#menuToggle > .fa').removeClass('fa-bars');
				$('#menuToggle > .fa').addClass('fa-arrow-right');

			}else{
				// $('.chart-container').width(chartWidth);
				// $('.chart-container > .container').removeClass('open-container');
				$('#menuToggle > .fa').removeClass('fa-arrow-right');
				$('#menuToggle > .fa').addClass('fa-bars');
			}
		// else{
		// 	if($('#theMenu').hasClass('menu-open')){
		// 		// $('.chart-container').width(chartWidth - 330);
		// 		// $('.chart-container > .container').addClass('open-container');
         //        //
		// 		// $('.filter-form').height($(window).height() - 110 - $(window).scrollTop());
        //
		// 		$('#menuToggle > .fa').removeClass('fa-bars');
		// 		$('#menuToggle > .fa').addClass('fa-arrow-right');
		// 	}else{
		// 		// $('.chart-container').width(chartWidth);
		// 		// $('.chart-container > .container').removeClass('open-container');
        //
		// 		$('#menuToggle > .fa').removeClass('fa-arrow-right');
		// 		$('#menuToggle > .fa').addClass('fa-bars');
		// 	}
        //
		// }
	});


	$(window).scroll(function(){
		if(windowHeight > 650){
			$('.filter-form').height($(window).height() - 140 - chartHeight - $(window).scrollTop());
		}else{
			$('.filter-form').height($(window).height() - 110 - $(window).scrollTop());
		}

	});


})(jQuery)