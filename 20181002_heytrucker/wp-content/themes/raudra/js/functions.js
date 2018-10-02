/**
 * Functionality specific to Roudra
 *
 * Provides helper functions to enhance the theme experience.
 */

jQuery(document).ready(function($) {
	if( $('.pre-raudra-setup').length > 0 ) {
		
		$('.ibanner').removeClass('nxs-semitrans').addClass('nxs-excel19 nxs-left');
		$('#da-slider').data('slider-height', '100');
		$('#da-slider').data('slider-reduct', '32');
		
		$('img.normal-logo').each(function() {					
			var iexcel_logo_normal_url = $(this).attr('src');
			var raudra_logo_normal_url = raudra_url+'/images/logo-black.png';
			$(this).attr('src', $(this).attr('src').replace(iexcel_logo_normal_url, raudra_logo_normal_url));
		});
		
		$('img.trans-logo').each(function() {					
			var iexcel_logo_trans_url = $(this).attr('src');
			var raudra_logo_trans_url = raudra_url+'/images/logo-white.png';
			$(this).attr('src', $(this).attr('src').replace(iexcel_logo_trans_url, raudra_logo_trans_url));
		}); 				
	}
});
