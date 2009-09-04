<?php 

require_once( dirname( dirname( dirname( dirname( dirname(__FILE__) ) ) ) ) . '/wp-load.php' );

function init_user_js() {
	global $current_user;
	get_currentuserinfo();
	$user =& $current_user;
	
	$post_url = admin_url('admin-ajax.php');
	$nonce = wp_create_nonce('listingpress_update_user-submit');
	$login_url = plugins_url('listingpress/users/lp_user_login.php');
	
	
	if(!$user->ID) {
?>

jQuery(document).ready(function($){
	
	function lp_login() {
		$("#lp_loading_image").show();
		var log = $("#log").val();
		var pwd = $("#pwd").val();
		var rem = ( $("#rememberme").attr('checked') ) ? $("#rememberme").val() : '';
		
		/*
		if( log == '' )
			alert(log + ' | ' + pwd + ' | ' + rem);
		if( pwd == '' )
			alert(log + ' | ' + pwd + ' | ' + rem);
		*/
		

		$.post("<?php echo $login_url; ?>",{
			action: 'lp_login',
			log: log,
			pwd: pwd,
			rememberme: rem
		}, function(data){
			$("#lp_user_ajax_container").empty().html(data);
		});
		
	}
	
	function lp_register() {
		alert('You clicked return');
	}
	
	function lp_lost_password() {
		alert('You clicked return');
	}
	
	$("#lp_login_submit").click(lp_login);
	$("#lp_register_submit").click(lp_register);
	$("#lp_login_form input").keypress(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if(code == 13)
			lp_login();
	});
	$("#lp_register_form input").keypress(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if(code == 13)
			lp_register();
	});
	$("#lp_lost_password_form input").keypress(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if(code == 13)
			lp_lost_password();
	});
	$(".change_login_view").click(function(){
		var show = $(this).attr('id');
		$(".lp_user_form").hide();
		$("#" + show + "_form").show();
	});
	
	$(".lp_bookmark_listing").click(function(){
		
		// Issue a message to the consumer that they need to be logged in to bookmark a listing
		
	});
	
	
	
});

<?php } else { ?>


jQuery(document).ready(function($){
	var user = '<?php echo $user->ID; ?>';
	var first_name = '<?php echo $user->first_name; ?>';
	
	
	
	$(".lp_bookmark_listing").click(function(){
	
		$.post("<?php echo $post_url; ?>",{
			action: "lp_update_user",
			case: "lp_listing_save",
			user_id: "<?php echo $user->ID; ?>",
			mls_id: $(this).attr('title'),
			_ajax_nonce: "<?php echo $nonce; ?>"
		}, function(data){
			for( var i = 0; i < data.length; i++) {
				alert( data[i] );
			}
		},"json");
	});
	
	
});


<?php
	}
}
init_user_js();
?>