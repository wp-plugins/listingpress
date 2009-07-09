<?php

/**
 * ListingPress AJAX Login and Registration
 *
 * Some code and theory taken from Jonas Einarsson's AJAX Login 
 * http://jonas.einarsson.net/ajaxlogin
 *
 */

function lp_ajax_login_header() {
?>
	<script type="text/javascript">
	
	</script>

<?php	
}
add_action('wp_head','lp_ajax_login_header');

function lp_ajax_login_form() {
	if( file_exists(TEMPLATEPATH . '/login-form.php') ) {
		include( TEMPLATEPATH . '/login-form.php');
	} else {
		include('includes/login-form.php');
	}
}

function lp_ajax_login_widget() {
	get_ajaxlogin();
}

function lp_ajax_login_widget_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;

	register_sidebar_widget('ListingPress Login Form', 'lp_ajax_login_widget');
}
add_action('plugins_loaded', 'lp_ajax_login_widget_init');

?>