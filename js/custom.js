jQuery(document).ready( 
	function(){
		jQuery('.portfolioitem').hover(
			function(){
				jQuery(this).parent('section').prepend('<div class="portfolio-overlay">Test</div>');
			}
		);
		jQuery('.portfolioitem').mouseout(
			function(){
				jQuery('.portfolio-overlay').remove();
			}
		);
	}
);
