<div id="listingpressLoginForm">
	<div id="listingpressLoginFormInner">

<?php
  	global $user_ID;
  	$user = get_currentuserinfo();
	if (!$user_ID) {
		
		$loading = plugins_url('/ListingPress/resources/images/ajax.gif');
?>

	<div id="lp_loading" class="lp_hide">
		<div style="text-align:center;">
			<img src="<?php echo $loading; ?>" />
		</div>
	</div>

	<div id="lp_login_box" class="lp_hide">
		<table>
			<tr>
				<td><?php _e('User') ?>:</td>
				<td><input type="text" name="log" value="" size="20" /></td>
			</tr>
			<tr>
				<td><?php _e('Password') ?>:</td>
				<td><input type="password" name="pwd" value="" size="20" /></td>
			</tr>
			<tr>
    			<td class="txtright"><input type="checkbox" name="rememberme" value="forever" /></td>
				<td><?php _e("Remember me"); ?></td>
			</tr>
			<tr>
				<td colspan="2" id="login_message"></td>
			</tr>
			<tr>
				<td colspan="2" class="txtright"><button class="ui-state-default ui-corner-all" type="button" id="lp_login_button"><?php _e('Login'); ?> &raquo;</button></td>
			</tr>
	
			<tr>
				<td class="txtright"><a href="javascript:;" class="lp_click" id="lp_register" title="Register">Register</a></td>
				<td class="txtcenter"><a href="javascript:;" class="lp_click" id="lp_lost_password" title="Lost Password">Lost Password</a></td>
			</tr>
		</table>
	</div>

	<div id="lp_register_box" class="lp_hide">
		<table>
    		<tr>
				<td><?php _e('User') ?>:</td>
				<td><input type="text" name="user_login" value="" size="20" /></td>
			</tr>
			<tr>
				<td><?php _e('E-mail') ?>:</td> 
				<td><input type="text" name="user_email" value="" size="20" /></td>
			</tr>
			<tr>
				<td colspan="2" id="register_message" style="display:none">A password will be mailed to you.</td>
			</tr>
			<tr>
				<td colspan="2" class="txtright"><button class="ui-state-default ui-corner-all" type="button"><?php _e('Register'); ?> &raquo;</button></td>
			</tr>
			<tr>
				<td class="txtright"><a href="javascript:;" class="lp_click" id="lp_login" title="Login">Login</a></td>
				<td class="txtcenter"><a href="javascript:;" class="lp_click" id="lp_lost_password" title="Lost Password">Lost Password</a></td>
			</tr>
		</table>
	</div>

	<div id="lp_lost_password_box" class="lp_hide">
		<table>
			<tr>
   				<td><?php _e('User') ?>:</td>
				<td><input type="text" name="user_login" value="" size="20" /></td>
			</tr>
			<tr>
				<td><?php _e('E-mail') ?>:</td>
				<td><input type="text" name="user_email" value="" size="20" /></td>
			</tr>
			<tr>
				<td colspan="2" id="lost_password_message" style="display:none">A confirmation email will be sent to your e-mail address.</td>
			</tr>
			<tr>
				<td colspan="2" class="txtright"><button class="ui-state-default ui-corner-all" type="button"><?php _e('Retrieve Your Password'); ?> &raquo;</button></td>
			</tr>
			<tr>
				<td class="txtright"><a href="javascript:;" class="lp_click" id="lp_login" title="Login">Login</a></td>
				<td class="txtcenter"><a href="javascript:;" class="lp_click" id="lp_register" title="Register">Register</a></td>
			</tr>
		</table>
	</div>


<?php } else { ?>

<?php echo get_avatar($user->user_email,80); ?>
<a href="<?php echo get_settings('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . $_SERVER['REQUEST_URI']; ?>"><?php _e('Logout'); ?></a>


<?php } ?>

	</div> <!-- //listingpressLoginFormInner -->
</div> <!-- //listingpressLoginForm -->

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#listingpressLoginForm').dialog({
			modal: false,
			stack: true,
			title: "Login",
			height: 220,
			width: 260
		});
		$('.lp_hide').hide();
		$('#lp_login_box').show();
		$('.lp_hide button').hover(function(){
			$(this).addClass('ui-state-hover');
		}, function(){
			$(this).removeClass('ui-state-hover');
		});
		$('.lp_click').click(function(){
			var i = '#' + $(this).attr('id') + '_box';
			var t = $(this).attr('title');
			$('.lp_hide').hide();
			$(i).show();
			$('#listingpressLoginForm').dialog('option', 'title', t);
		});
		$('#lp_login_button').click(function(){
			/*
			$('#lp_loading').show();
			setTimeout( function(){
				$('#lp_loading').hide();	
			}, 2000);
			*/
		});

	});
</script>