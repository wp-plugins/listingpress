<?php

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
	$q['lp_education'] = ( isset($_POST['lp_education']) && !empty($_POST['lp_education']) ) ? $_POST['lp_education'] : $q['lp_education'];
	$q['lp_menu_bar'] = $_POST['lp_menu_bar'];		
	$q['lp_admin_email'] = ( isset($_POST['lp_admin_email']) && !empty($_POST['lp_admin_email']) ) ? $_POST['lp_admin_email'] : $q['lp_admin_email'];
	$q['lp_lead_note'] = ( isset($_POST['lp_lead_note']) && !empty($_POST['lp_lead_note']) ) ? $_POST['lp_lead_note'] : $q['lp_lead_note'];
	update_option( 'ListingPressQuery', $q );
	echo 'Your settings have been successfully saved!';
}
add_action( 'wp_ajax_listingpress', 'lp_ajax_post_handler' );

function lp_general_settings() {
	$loading_img = plugins_url('listingpress/resources/images/ajax.gif');
	$ajax_url = admin_url('admin-ajax.php');
	$nonce = wp_create_nonce('listingpress-general-settings_submit');
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
			<input type="hidden" id="lp_settings_nonce" value="<?php echo $nonce; ?>" />
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
				<tr valign="top">
					<th scope="row"><label for="lp_zillow">Zillow API Key</label></th>
					<td>
						<input name="lp_zillow" type="text" id="lp_zillow" size="80" value="<?php echo $q['lp_zillow']; ?>" />
						<br />This is your Zillow API key so you can embed Zillow data on to your site. You can obtain a key by going here: <a href="https://www.zillow.com/webservice/Registration.htm" target="_blank">Zillow API</a>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lp_education">Education.com API Key</label></th>
					<td>
						<input name="lp_education" type="text" id="lp_education" size="80" value="<?php echo $q['lp_education']; ?>" />
						<br />This is your Education.com API key so you can embed local school data in to your site. You can obtain a key by going here: <a href="http://www.education.com/schoolfinder/tools/webservice/" target="_blank">Education.com API Key</a>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">ListingPress Menu Bar</th>
					<td>
						<select name="lp_menu_bar" id="lp_menu_bar"> 
							<option value="show" <?php if( $q['lp_menu_bar'] == 'show' ) { echo 'SELECTED'; } ?>>Yes &nbsp;</option> 
							<option value="hide" <?php if( $q['lp_menu_bar'] == 'hide' ) { echo 'SELECTED'; } ?>>No &nbsp;</option> 
						</select>
						&nbsp; <label for="lp_menu_bar">Would you like to display the ListingPress Menu Bar?</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lp_admin_email">Send Emails Here:</label></th>
					<td>
						<input name="lp_admin_email" type="text" id="lp_admin_email" size="80" value="<?php echo $q['lp_admin_email']; ?>" />
						<br />Send email communication to this address. (You can enter multiple email addresses separated by commas)
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lp_lead_note">Message When Someone Leaves A Note:</label></th>
					<td>
						<textarea name="lp_lead_note" id="lp_lead_note" cols="72" rows="6"><?php echo $q['lp_lead_note']; ?></textarea>
						<br />A note to the consumer when they send you a message. Something like: Thanks for contacting me, I will get back to you soon. You can call me at 123-123-1234.
					</td>
				</tr>
			</table>
			
			<p class="submit">
				<input type="submit" name="submit" class="button lp_submit" value="Update Settings" />
			</p>
	</div>
	
	<script type="text/javascript">
		jQuery(function($){
			$('input.lp_submit').click(function(){
				$('div#lp_loading').show();
				$.post('<?php echo $ajax_url; ?>', 
					{ 
						action: 'listingpress',
						lp_reg_code: $('input#lp_reg_code').val(),
						lp_per_page: $('input#lp_per_page').val(),
						lp_base: $('input#lp_base').val(),
						lp_agent: $('select#lp_agent').val(),
						lp_office: $('select#lp_office').val(),
						lp_maps: $('input#lp_maps').val(),
						lp_zillow: $('input#lp_zillow').val(),
						lp_education: $('input#lp_education').val(),
						lp_menu_bar: $('select#lp_menu_bar').val(),
						lp_admin_email: $('#lp_admin_email').val(),
						lp_lead_note: $('#lp_lead_note').val(),
						cookie: encodeURIComponent(document.cookie),
						_ajax_nonce: $('input#lp_settings_nonce').val()
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
	</script>
	
<?php

}

function lp_general_settings_init() {
	add_options_page('ListingPress Settings', 'ListingPress', 8, 'lp_general_settings', 'lp_general_settings');
}
add_action('admin_menu', 'lp_general_settings_init');

if( is_admin() && $_GET['page'] == 'lp_general_settings' ) {
	wp_enqueue_script('jquery');
}

?>