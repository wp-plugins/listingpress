<?php

/*
 * ListingPress Admin Section 
 *
 */

if( is_admin() && ($_GET['page'] == 'lpoptions') ) {
	wp_enqueue_script('jquery');
}

function lp_ajax_header() {
	if( $_GET['page'] == 'lpoptions' ) {	
		$nonce = wp_create_nonce('listingpress-general-settings_submit');
		echo "<script type='text/javascript'>
    		jQuery(function($){
				$('input.lp_submit').click(function(){
					$('div#lp_loading').show();
					$.post('/wp-admin/admin-ajax.php', 
						{ 
							action: 'listingpress',
							lp_reg_code: $('input#lp_reg_code').val(),
							lp_per_page: $('input#lp_per_page').val(),
							lp_base: $('input#lp_base').val(),
							lp_agent: $('select#lp_agent').val(),
							lp_office: $('select#lp_office').val(),
							lp_maps: $('input#lp_maps').val(),
							lp_zillow: $('input#lp_zillow').val(),
							cookie: encodeURIComponent(document.cookie),
							_ajax_nonce: '".$nonce."' 
						},
						function(data) {
							$('div#lp_empty').hide();
							$('div#lp_loading').hide();
							$('table#full-options').slideDown('slow');
							$('div#lp_message').empty().html('<p><strong>' + data.replace(0,'') + '</strong></p>').fadeIn('slow');
						}
					);
				});
			});
    	</script>";
	}
}
add_action( 'admin_head', 'lp_ajax_header' );

function lp_ajax_post_handler() {
	if ( !current_user_can('manage_options') )
		wp_die( __('Cheatin&#8217; uh?') );

	check_ajax_referer('listingpress-general-settings_submit');		
	
	$s = get_option('ListingPressSettings');
	$q = get_option('ListingPressQuery');
	
	if( isset($_POST['lp_reg_code']) && !empty($_POST['lp_reg_code']) ) {
		$s['reg_code'] = $_POST['lp_reg_code'];
		update_option( 'lp_reg_code', $s['reg_code'] );
		update_option( 'ListingPressSettings', $s );
	}
	
	$q['lp_per_page'] = ( isset($_POST['lp_per_page']) && !empty($_POST['lp_per_page']) ) ? $_POST['lp_per_page'] : $q['lp_per_page'];
	$q['lp_base'] = ( isset($_POST['lp_base']) && !empty($_POST['lp_base']) ) ? $_POST['lp_base'] : $q['lp_base'];
	$q['lp_agent'] = ( isset($_POST['lp_agent']) && !empty($_POST['lp_agent']) ) ? $_POST['lp_agent'] : $q['lp_agent'];
	$q['lp_office'] = ( isset($_POST['lp_office']) && !empty($_POST['lp_office']) ) ? $_POST['lp_office'] : $q['lp_office'];
	$q['lp_maps'] = ( isset($_POST['lp_maps']) && !empty($_POST['lp_maps']) ) ? $_POST['lp_maps'] : $q['lp_maps'];
	$q['lp_zillow'] = ( isset($_POST['lp_zillow']) && !empty($_POST['lp_zillow']) ) ? $_POST['lp_zillow'] : $q['lp_zillow'];
			
	update_option( 'ListingPressQuery', $q );
	
	echo 'Your settings have been successfully saved!';
			
}
add_action( 'wp_ajax_listingpress', 'lp_ajax_post_handler' );


function lp_add_options() {
	add_options_page('ListingPress Options', 'ListingPress', 8, 'lpoptions', 'lp_options_page');
	add_options_page('ListingPress Forms', 'LP Forms', 8, 'lpforms', 'lp_forms_page');
}
add_action('admin_menu', 'lp_add_options');



function lp_forms_page() {
	$loading_img = plugins_url('listingpress/resources/images/ajax.gif');
	//$forms = get_option('ListingPressForms');
	
	//$fid = $_GET['lpfid'];
?>

	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2>ListingPress Forms</h2>
		
			<p class="submit">
				<input type="submit" name="submit" class="button lp_submit" value="Update Settings" />
			</p>
	</div>

<?php	
}

/*
 * Our ListingPress Settings Page
 */
function lp_options_page() {
	$loading_img = plugins_url('listingpress/resources/images/ajax.gif');
	$s = get_option('ListingPressSettings');
	$q = get_option('ListingPressQuery');
?>
	<div class="wrap">
		<div id="icon-index" class="icon32"><br /></div>
		<h2>ListingPress Settings</h2>
		
			<!-- ajax -->
			<div id="lp_message" class="updated fade" style="display:none;"></div>
			<div id="lp_invalid" class="error" style="display:none;"><p><strong>We're sorry, but unfortunately that is an invalid registration code.</strong></p></div>
			<div id="lp_loading" style="display:none;"><img src="<?php echo $loading_img; ?>" border="0" /></div>
			<!-- //ajax -->
			
<?php 
			if( !empty($s['reg_code']) ) { 
				$display = '';
			} else {
				$display = 'style="display:none;"';
				echo '<div id="lp_empty" class="updated"><p><strong>Please enter your registration code to start using ListingPress.</strong></p></div>';
			} 
?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="lp_reg_code">ListingPress Registration Code</label></th>
					<td><input type="text" name="lp_reg_code" id="lp_reg_code" size="80" value="<?php echo $s['reg_code']; ?>" /><br />This is the registration code that you were given when you first signed up.</td>
				</tr>
			</table>
			<table class="form-table" <?php echo $display; ?> id="full-options">
				<tr valign="top" style="display:none;">
					<th scope="row"><label for="lp_agent">Agent Name</label></th>
					<td>
						<select name="lp_agent" id="lp_agent">
						</select>
						<br />By selecting your Agent Name, you can ensure that your listings are filtered to the top of your sites search results.
					</td>
				</tr>
				<tr valign="top" style="display:none;">
					<th scope="row"><label for="lp_office">Office Name</label></th>
					<td>
						<select name="lp_office" id="lp_office">
						</select>
						<br />By selecting your Office Name, you can ensure that your office listings are filtered to the top of your sites search results.
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lp_per_page">Listings Per Page</label></th>
					<td>
						<input name="lp_per_page" type="text" id="lp_per_page" size="80" value="<?php echo $q['lp_per_page']; ?>" />
						<br />How many listings would you like displayed per page?
					</td>
				</tr>
				<tr valign="top" style="display:none;">
					<th scope="row"><label for="lp_base">Listings Permalink Base</label></th>
					<td>
						<input name="lp_base" type="text" id="lp_base" size="80" value="<?php echo $q['lp_base']; ?>" />
						<br />What would you like your permalink base to be? example: http://yourdomain.com/this_is_what_you_are_changing/city/state
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lp_maps">Google Maps API Key</label></th>
					<td>
						<input name="lp_maps" type="text" id="lp_maps" size="80" value="<?php echo $q['lp_maps']; ?>" />
						<br />This is your Google Maps API key so you can embed google maps on to your site. You can obtain a key by going here: <a href="http://code.google.com/apis/maps/signup.html" target="_blank">Google Maps API</a>
					</td>
				</tr>
				<tr valign="top" style="display:none;">
					<th scope="row"><label for="lp_zillow">Zillow API Key</label></th>
					<td>
						<input name="lp_zillow" type="text" id="lp_zillow" size="80" value="<?php echo $q['lp_zillow']; ?>" />
						<br />This is your Zillow API key so you can embed Zillow data on to your site. You can obtain a key by going here: <a href="https://www.zillow.com/webservice/Registration.htm" target="_blank">Zillow API</a>
					</td>
				</tr>
			</table>
			
			<p class="submit">
				<input type="submit" name="submit" class="button lp_submit" value="Update Settings" />
			</p>
	</div>
<?php
}

?>