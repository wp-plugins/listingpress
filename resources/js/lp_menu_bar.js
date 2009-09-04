jQuery(document).ready(function($){
	function resize_lp_menu() {
		var menu_width = $(window).width() - 140;
		$('#lp_menu_bar ul').css({ width: menu_width + 'px' });
	}
	resize_lp_menu();
	$(window).resize(resize_lp_menu);
	$('a.tipsy_buttons').tipsy({gravity: 's'});
});