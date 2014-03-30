jQuery(document).ready( 
	function(){
		var imagewidth = jQuery('.portfolioitem img').width();
    	jQuery('.portfolio-overlay').css('width',imagewidth);
    	console.log(imagewidth);

		jQuery('.portfolio').hover( function() {
        	jQuery(this).find('.portfolio-overlay').fadeIn(300);

    	}, function() {
        	jQuery(this).find('.portfolio-overlay').fadeOut(100);
    	});

    	
	}
);
