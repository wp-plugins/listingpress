<?php

function lp_menu_bar() {

?>

<div id="lp_menu_bar">
	<ul>
		<li><a href="javascript:;" id="menu_bar_map_search" class="tipsy_buttons lp_show_search_form" title="Map Search"></a></li>
		<!--<li><a href="javascript:;" id="menu_bar_image_search" class="tipsy_buttons" title="Image Search"></a></li>
		<li><a href="javascript:;" id="menu_bar_favorites" class="tipsy_buttons" title="My Favorite Listings"></a></li>
		<li><a href="javascript:;" id="menu_bar_recommended" class="tipsy_buttons" title="Recommended Listings"></a></li>
		<li><a href="javascript:;" id="menu_bar_connect" class="tipsy_buttons" title="Connect With Us"></a></li>
		<li><a href="javascript:;" id="menu_bar_notes" class="tipsy_buttons" title="My Notes">My Notes</a></li>
		<li><a href="javascript:;" id="menu_bar_events" class="tipsy_buttons" title="Upcoming Events">Upcoming Events</a></li>
		<li><a href="javascript:;" id="menu_bar_notifications" class="tipsy_buttons" title="Notifications">Notifications</a></li>
		<li><a href="javascript:;" id="menu_bar_chat" class="tipsy_buttons" title="Chat With Us">Chat With Us</a></li>
		<li><a href="javascript:;" id="menu_bar_contact_us" class="tipsy_buttons" title="Contact Us">Contact Us</a></li>-->
	</ul>
</div>


<?php

}
add_action('wp_footer','lp_menu_bar');

if( !is_admin() ) {
	wp_enqueue_style( 'jquery_tipsy', plugins_url('listingpress/resources/css/tipsy.css'), '', '1.0', 'screen' );
	wp_enqueue_style( 'lp_menu_bar', plugins_url('listingpress/resources/css/lp_menu_bar.css'), '', '1.0', 'screen' );
	wp_enqueue_style( 'jquery-custom', plugins_url('listingpress/resources/css/custom-theme/jquery-ui-1.7.2.custom.css'), '', '1.7.2', 'screen' );
	

	wp_enqueue_script('jquery-ui-1.7.2', plugins_url('listingpress/resources/js/jquery-ui-1.7.2.custom.min.js'), '', '1.7.2' );
	wp_enqueue_script( 'jquery_tipsy', plugins_url('listingpress/resources/js/jquery.tipsy.js'), '', '1.0' );
	wp_enqueue_script( 'lp_menu_bar', plugins_url('listingpress/resources/js/lp_menu_bar.js'), '', '1.0' );
}

?>