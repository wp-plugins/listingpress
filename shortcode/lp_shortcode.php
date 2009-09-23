<?php
/**
 * ListingPress Shortcode
 *
 * Much of this theory and usage is taken from Wordpress
 * For more thorough documentation, please check out http://codex.wordpress.org/TinyMCE_Custom_Buttons
 *
 */

function register_lp_button($buttons) {
   array_push($buttons, "separator", "listingpress", "listingpress_vis");
   return $buttons;
}
 
function lp_tinymce_plugin($plugins) {
   	$plugins['listingpress'] = plugins_url('listingpress/shortcode/editor_plugin.js');
   	$plugins['listingpress_vis'] = plugins_url('listingpress/shortcode/editor_plugin_vis.js');
   	return $plugins;
}
 
function lp_add_buttons() {
   if( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   if( get_user_option('rich_editing') == 'true' ) {
     add_filter("mce_external_plugins", "lp_tinymce_plugin");
     add_filter('mce_buttons', 'register_lp_button');
   }
}
add_action('init', 'lp_add_buttons');

function lp_shortcode_footer() {
?>

<div id="listingpress_visualizations" style="display:none">
	<select id="lp_vis_select">
		<?php lp_vis_select_menu(); ?>
	</select>
</div>

<div id="listingpress_shortcode" style="display:none">
	<table>
		<tr>
			<td>City</td>
			<td>
				<select name="citystate" id="citystate">
					<option value="">Select a City</option>
					<?php city_state_select_menu(); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Neighborhood</td>
			<td>
				<select name="searchable_area_1" id="searchable_area_1">
					<option value="">Select a Neighborhood</option>
					<?php neighborhoods_select_menu(); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Property Type</td>
			<td>
				<select name="proptype" id="proptype">
					<option value="">Select a Property Type</option>
					<?php prop_types_select_menu(); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Bedrooms</td>
			<td>
				<select name="beds" id="beds">
					<option value="0">All Beds</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Bathrooms</td>
			<td>
				<select name="baths" id="baths">
					<option value="0">All Baths</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Minimum Price</td>
			<td>
				<select name="minprice" id="minprice">
					<option value="0">Any Price</option>
					<option value="100000">$100,000</option>
					<option value="200000">$200,000</option>
					<option value="300000">$300,000</option>
					<option value="400000">$400,000</option>
					<option value="500000">$500,000</option>
					<option value="600000">$600,000</option>
					<option value="700000">$700,000</option>
					<option value="800000">$800,000</option>
					<option value="900000">$900,000</option>
					<option value="1000000">$1,000,000</option>
					<option value="1100000">$1,100,000</option>
					<option value="1200000">$1,200,000</option>
					<option value="1300000">$1,300,000</option>
					<option value="1400000">$1,400,000</option>
					<option value="1500000">$1,500,000</option>
					<option value="1600000">$1,600,000</option>
					<option value="1700000">$1,700,000</option>
					<option value="1800000">$1,800,000</option>
					<option value="1900000">$1,900,000</option>
					<option value="2000000">$2,000,000</option>
					<option value="3000000">$3,000,000</option>
					<option value="4000000">$4,000,000</option>
					<option value="5000000">$5,000,000</option>
					<option value="6000000">$6,000,000</option>
					<option value="7000000">$7,000,000</option>
					<option value="8000000">$8,000,000</option>
					<option value="9000000">$9,000,000</option>
					<option value="10000000">$10,000,000</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Maximum Price</td>
			<td>
				<select name="maxprice" id="maxprice">
					<option value="0">Any Price</option>
					<option value="100000">$100,000</option>
					<option value="200000">$200,000</option>
					<option value="300000">$300,000</option>
					<option value="400000">$400,000</option>
					<option value="500000">$500,000</option>
					<option value="600000">$600,000</option>
					<option value="700000">$700,000</option>
					<option value="800000">$800,000</option>
					<option value="900000">$900,000</option>
					<option value="1000000">$1,000,000</option>
					<option value="1100000">$1,100,000</option>
					<option value="1200000">$1,200,000</option>
					<option value="1300000">$1,300,000</option>
					<option value="1400000">$1,400,000</option>
					<option value="1500000">$1,500,000</option>
					<option value="1600000">$1,600,000</option>
					<option value="1700000">$1,700,000</option>
					<option value="1800000">$1,800,000</option>
					<option value="1900000">$1,900,000</option>
					<option value="2000000">$2,000,000</option>
					<option value="3000000">$3,000,000</option>
					<option value="4000000">$4,000,000</option>
					<option value="5000000">$5,000,000</option>
					<option value="6000000">$6,000,000</option>
					<option value="7000000">$7,000,000</option>
					<option value="8000000">$8,000,000</option>
					<option value="9000000">$9,000,000</option>
					<option value="10000000">$10,000,000</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Features</td>
			<td>
				<select name="features" id="features">
					<option value="">Select Features</option>
					<?php features_select_menu(); ?>
				</select>
			</td>
		</tr>
	</table>
</div>

<?php
}

if( in_array( basename($_SERVER['PHP_SELF']), array('post-new.php', 'page-new.php', 'post.php', 'page.php') ) ) {
	add_action( 'admin_footer', 'lp_shortcode_footer' );
	wp_enqueue_style( 'jquery-custom', plugins_url('listingpress/resources/css/custom-theme/jquery-ui-1.7.2.custom.css'), array('vvq-jquery-ui-css'), '1.7.2', 'screen' );
	wp_enqueue_script('jquery');
}

function lp_shortcode( $atts, $content = '' ) {
	
	extract( shortcode_atts( array(
		'beds' => '0',
      	'baths' => '0'
	), $atts ) );
	
		
	return $html;
}	
add_shortcode( 'listingpress', 'lp_shortcode' );

?>