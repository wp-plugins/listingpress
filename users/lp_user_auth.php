<?php

function lp_update_ajax_requests() {
	check_ajax_referer('listingpress_update_user-submit');
	switch( $_POST['case'] ) {
		case 'lp_listing_save':
			$mls = $_POST['mls_id'];
			$user = $_POST['user_id'];
			$saved = get_usermeta($user, 'lp_saved_listings'); 
			array_push($saved,$mls);
			update_usermeta($user, 'lp_saved_listings', $saved);
			echo json_encode( $saved );
		break;
		case 'lp_listing_remove':
		
		
		break;
		default:
		
		break;
	}
	exit();
}
add_action('wp_ajax_lp_update_user','lp_update_ajax_requests');


function lp_update_personal_options($user_id) {
	
	$saved_listings = explode( ',', $_POST['lp_saved_listings'] );
	update_usermeta($user_id, 'lp_saved_listings', $saved_listings);
	
	$recommended_listings = explode( ',', $_POST['lp_recommended_listings'] );
	update_usermeta($user_id, 'lp_recommended_listings', $recommended_listings);
	
	$message = $_POST['lp_agent_message'];
	update_usermeta($user_id, 'lp_agent_message', $message);
	
}
add_action('edit_user_profile_update','lp_update_personal_options');
add_action('personal_options_update','lp_update_personal_options');

function lp_personal_options($user) {
	$saved = $user->lp_saved_listings;
	$save = implode( ',', $saved );
	
	$recommended = $user->lp_recommended_listings;
	$reco = implode( ',', $recommended );
?>
	</table>
	<h3 style="margin-top:40px;">ListingPress Options</h3>

	<table class="form-table">
		<tr>
			<th><label for="lp_saved_listings">Saved Listings</label></th>
			<td><input type="text" name="lp_saved_listings" id="lp_saved_listings" value="<?php echo $save; ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="lp_recommended_listings">Recommended Listings</label></th>
			<td><input type="text" name="lp_recommended_listings" id="lp_recommended_listings" value="<?php echo $reco; ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="lp_agent_message">A Message to the User</label></th>
			<td><textarea name="lp_agent_message" id="lp_agent_message" rows="5" cols="30"><?php echo $user->lp_agent_message; ?></textarea><br />
			<span class="description">Make sure to leave a little note to this user about contacting you if they need any help searching for homes.</span></td>
		</tr>

<?php
}
add_action('personal_options','lp_personal_options');

function lp_login_form() {
	$load_img = plugins_url('listingpress/resources/images/ajax.gif');

?>

<div id="lp_login_form" class="lp_user_form">
	<div id="lp_loading_image" style="display:none;"><img src="<?php echo $load_img; ?>" /></div>
	<table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="log" id="log" size="20" /></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="pwd" id="pwd" size="20" /></td>
        </tr>
    </table>
    <p>
    	<input type="checkbox" name="rememberme" id="rememberme" value="forever" /> <label for="rememberme">Remember Me</label> <a href="javascript:;" class="change_login_view" id="lp_lost_password">Forgot Your Password?</a>

		<div class="clear"></div>
		<a href="javascript:;" class="change_login_view" id="lp_register">Register</a> 
        <a href="javascript:;" id="lp_login_submit">Login</a> 
		<div class="clear"></div>
		
    </p>
</div>

<div id="lp_register_form" class="lp_user_form" style="display:none;">
	<table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user_login" size="20" /></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="user_email" size="20" /></td>
        </tr>
    </table>
    <p>
    	<span id="alw_registerMessage">A password will be mailed to you.<br/></span> <a href="javascript:;" class="change_login_view" id="lp_lost_password">Lost password?</a><br/>
		
		<a href="javascript:;" class="change_login_view" id="lp_login"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/login_gray.png" border="0" /></a> 
        <a href="javascript:;" id="lp_register_submit"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/register.png" border="0" /></a>


    </p>
</div>

<div id="lp_lost_password_form" class="lp_user_form" style="display:none;">
	<table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="user_login" size="20" /></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="user_email" size="20" /></td>
        </tr>
    </table>
    <p>
    	<span id="alw_lostPasswordMessage">A message will be sent to your e-mail address.<br/></span>
        <a href="javascript:;" class="change_login_view" id="lp_login">Log In</a> 
		| <a href="javascript:;" class="change_login_view" id="lp_register">Register</a><br/>
        <input type="button" name="submit" value="Retrieve Your Password &raquo;" id="lp_lost_password_submit" />
        
		<span id="alw_loading_lost" style="display:none; height:22px; width:22px; vertical-align:bottom">
        	<img src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/ajax-login-widget/alw_loading.gif" alt="Loading"/> Looking up your credentials ...
        </span>

    </p>
</div>


<?php

}
add_action('listingpress_login_form','lp_login_form');

function lp_display_user_info($u) {

?>

	<div id="lp_user_info">
		
		<?php echo get_avatar($u->ID,'70'); ?>
		
		<p class="welcome_message">Howdy <?php echo $u->first_name; ?>! <span id="lp_logout">(<a href="<?php echo wp_logout_url(); ?>">log out</a>)</span></p>
		<ul class="lp_user_details">
			<li class="lp_user_phone"><a href="javascript:;">phone number</a></li>
			<li class="lp_user_email"><a href="javascript:;">email</a></li>
			<li></li>
		</ul>
		<div class="clear"></div>
	
		<?php

			$agent_message = get_usermeta($u->ID, 'lp_agent_message');
			if( !empty($agent_message) ) {
				echo '<p class="lp_agent_message">' . $agent_message . '</p>';
			}

		?>
	
	
		<h3>Saved Properties</h3>
		<ul class="lp_saved_listings">	
<?php 
	
	$saved = get_usermeta($u->ID, 'lp_saved_listings'); 
	foreach( $saved as $save ) { $s_query .= trim($save) . '|'; }
	$saved_query = rtrim($s_query,'|');
	if( !empty($saved_query) ) :
		$sq = new LP_Query('mlsids='.$saved_query);
		if( $sq->have_listings() ) : while( $sq->have_listings() ) : $sq->the_listing();
			echo '<li><a href="' . the_listing_permalink(true) . '" class="lp_saved_photo"><img src="' . get_the_primary_photo('',true) . '" border="0" /></a></li>';
		endwhile;
		else:
			echo '<li>You haven\'t saved any listings yet.</li>';
		endif;
	else: 
		echo '<li>You haven\'t saved any listings yet.</li>';
	endif;

?>
		</ul>
		
		<h3 class="reco">Recommended Listings</h3>
		<ul class="lp_recommended_listings">	
<?php 
	
	$reco = get_usermeta($u->ID, 'lp_recommended_listings'); 
	foreach( $reco as $rec ) { $r_query .= trim($rec) . '|'; }
	$reco_query = rtrim($r_query,'|');
	if( !empty($reco_query) ) :
		$rq = new LP_Query('mlsids='.$reco_query);
		if( $rq->have_listings() ) : while( $rq->have_listings() ) : $rq->the_listing();
			echo '<li><a href="' . the_listing_permalink(true) . '" class="lp_reco_photo"><img src="' . get_the_primary_photo('',true) . '" border="0" /></a></li>';
		endwhile;
		else:
			// If not recommended listings, then maybe should recommend some based off of the consumers search preferneces?
		endif;
	else:
		// If not recommended listings, then maybe should recommend some based off of the consumers search preferneces?
	endif;

?>
		</ul>
		



	</div> <!-- //lp_user_info -->

<?php	

}
add_action('listingpress_display_user','lp_display_user_info');

function lp_user_init(){
	global $current_user;
	get_currentuserinfo();
	if(!$current_user->ID) {
		do_action('listingpress_login_form');
	} else {
		do_action('listingpress_display_user',$current_user);
	}
}
add_action('listingpress_user','lp_user_init');

$js = plugins_url('listingpress/users/lp_user_js.php');
wp_enqueue_script('lp_user_js',$js,array('jquery'),'1.0');

/*
 * Let's define two more roles
 */
add_role( 'lead', 'Leads', array('read' => '1', 'level_0' => '1') );
add_role( 'client', 'Clients', array('read' => '1', 'level_0' => '1') );
update_option('default_role', 'lead');


?>