<?php

require_once( dirname( dirname( dirname( dirname( dirname(__FILE__) ) ) ) ) . '/wp-load.php' );

switch($_POST['action']) {
	case 'lp_login':
		
		$errors = array();
		nocache_headers();

		$user_login = '';
		$user_pass = '';
		$using_cookie = FALSE;

		if ( $_POST ) {
			$user_login = $_POST['log'];
			$user_login = sanitize_user( $user_login );
			$user_pass  = $_POST['pwd'];
			$rememberme = $_POST['rememberme'];
		} else {
			$cookie_login = wp_get_cookie_login();
			if ( ! empty($cookie_login) ) {
				$using_cookie = true;
				$user_login = $cookie_login['login'];
				$user_pass = $cookie_login['password'];
			}
		}

		do_action_ref_array('wp_authenticate', array(&$user_login, &$user_pass));

		if ( $user_login && $user_pass && empty( $errors ) ) {
			$user = new WP_User(0, $user_login);

			if ( wp_login($user_login, $user_pass, $using_cookie) ) {
				if ( !$using_cookie )
					wp_setcookie($user_login, $user_pass, false, '', '', $rememberme);
				
				do_action('wp_login', $user_login);
				
				lp_display_user_info($user);
				
				exit();
			} else {
				if ( $using_cookie )
					$errors['expiredsession'] = __('Your session has expired.');
			}
		}

		if ( !empty( $error ) ) {
			$errors['error'] = $error;
			unset($error);
		}

		if ( !empty( $errors ) ) {
			if ( is_array( $errors ) ) {
				$newerrors = "";
				foreach ( $errors as $error ) {
					$stripped = str_replace("<strong>", "", $error);
					$stripped = str_replace("</strong>", "", $stripped);
					$newerrors .= $stripped . "\n";
				}
				$errors = $newerrors;
			}
		}

		echo apply_filters('login_errors', $errors);
		exit();
	
	break;
	case 'lp_register':
	
		$errors = array();
		nocache_headers();

		if ( FALSE == get_option('users_can_register') ) {
			echo '0';
			echo "\n";
			echo "User registration is disabled.";
			exit();
		}

		if ( $_POST ) {
			require_once('../../../wp-includes/registration.php');

			$user_login = sanitize_user( $_POST['user_login'] );
			$user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );

			// Check the username
			if ( $user_login == '' )
				$errors['user_login'] = __('<strong>ERROR</strong>: Please enter a username.');
			elseif ( !validate_username( $user_login ) ) {
				$errors['user_login'] = __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.');
				$user_login = '';
			} elseif ( username_exists( $user_login ) )
				$errors['user_login'] = __('<strong>ERROR</strong>: This username is already registered, please choose another one.');

			// Check the e-mail address
			if ($user_email == '') {
				$errors['user_email'] = __('<strong>ERROR</strong>: Please type your e-mail address.');
			} elseif ( !is_email( $user_email ) ) {
				$errors['user_email'] = __('<strong>ERROR</strong>: The email address is invalid.');
				$user_email = '';
			} elseif ( email_exists( $user_email ) )
				$errors['user_email'] = __('<strong>ERROR</strong>: This email is already registered, please choose another one.');

			do_action('register_post');

			$errors = apply_filters( 'registration_errors', $errors );

			if ( empty( $errors ) ) {
				$user_pass = substr( md5( uniqid( microtime() ) ), 0, 7);

				$user_id = wp_create_user( $user_login, $user_pass, $user_email );
				if ( !$user_id )
					$errors['registerfail'] = sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the webmaster!\n%s'), get_option('admin_email'));
				else {
					wp_new_user_notification($user_id, $user_pass);

					echo "1";
					exit();
				}
			}
		}

		if ( !empty( $error ) ) {
			$errors['error'] = $error;
			unset($error);
		}

		if ( !empty( $errors ) ) {
			if ( is_array( $errors ) ) {
				$newerrors = "";
				foreach ( $errors as $error ) {
					$stripped = str_replace("<strong>", "", $error);
					$stripped = str_replace("</strong>", "", $stripped);
					$newerrors .= $stripped . "\n";
				}
				$errors = $newerrors;
			}
		}

		echo "0";
		echo "\n";
		echo apply_filters('login_errors', $errors);
		exit();
	
	break;
	case 'lp_lost_password':
		
		$errors = array();
		nocache_headers();

		$user_login = '';
		$user_pass = '';

		if ( $_POST ) {
			if ( empty( $_POST['user_login'] ) )
				$errors['user_login'] = __('<strong>ERROR</strong>: The username field is empty.');
			if ( empty( $_POST['user_email'] ) )
				$errors['user_email'] = __('<strong>ERROR</strong>: The e-mail field is empty.');

			do_action('lostpassword_post');

			if ( empty( $errors ) ) {
				$user_data = get_userdatabylogin(trim($_POST['user_login']));
				// redefining user_login ensures we return the right case in the email
				$user_login = $user_data->user_login;
				$user_email = $user_data->user_email;

				if (!$user_email || $user_email != $_POST['user_email']) {
					$errors['invalidcombo'] = __('<strong>ERROR</strong>: Invalid username / e-mail combination.');
				} else {
					do_action('retreive_password', $user_login);  // Misspelled and deprecated
					do_action('retrieve_password', $user_login);

					// Generate something random for a password... md5'ing current time with a rand salt
					$key = substr( md5( uniqid( microtime() ) ), 0, 8);
					// Now insert the new pass md5'd into the db
					$wpdb->query("UPDATE $wpdb->users SET user_activation_key = '$key' WHERE user_login = '$user_login'");
					$message = __('Someone has asked to reset the password for the following site and username.') . "\r\n\r\n";
					$message .= get_option('siteurl') . "\r\n\r\n";
					$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
					$message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.') . "\r\n\r\n";
					$message .= get_option('siteurl') . "/wp-content/plugins/ajax-login-widget/resetpassword.php?key=$key\r\n";

					if (FALSE == wp_mail($user_email, sprintf(__('[%s] Password Reset'), get_option('blogname')), $message)) {
						echo ALW_FAILURE;
						echo "\n";
						echo "The e-mail could not be sent.";
						exit();
					} else {
						echo ALW_SUCCESS;
						exit();
					}
				}
			}
		}

		if ( !empty( $error ) ) {
			$errors['error'] = $error;
			unset($error);
		}

		if ( !empty( $errors ) ) {
			if ( is_array( $errors ) ) {
				$newerrors = "";
				foreach ( $errors as $error ) {
					$stripped = str_replace("<strong>", "", $error);
					$stripped = str_replace("</strong>", "", $stripped);
					$newerrors .= $stripped . "\n";
				}
				$errors = $newerrors;
			}
		}


		echo ALW_FAILURE;
		echo "\n";
		echo apply_filters('login_errors', $errors);
		exit();
	
	break;
	case 'lp_reset_password':
	
		$errors = array();
		nocache_headers();

		$key = preg_replace('/[^a-z0-9]/i', '', $_GET['key']);
		if ( empty( $key ) ) {
			exit();
		}

		$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_activation_key = '$key'");
		if ( empty( $user ) ) {
			exit();
		}

		do_action('password_reset');

		// Generate something random for a password... md5'ing current time with a rand salt
		$new_pass = substr( md5( uniqid( microtime() ) ), 0, 7);
		$wpdb->query("UPDATE $wpdb->users SET user_pass = MD5('$new_pass'), user_activation_key = '' WHERE user_login = '$user->user_login'");
		wp_cache_delete($user->ID, 'users');
		wp_cache_delete($user->user_login, 'userlogins');
		$message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
		$message .= sprintf(__('Password: %s'), $new_pass) . "\r\n";
		$message .= get_option('siteurl') . "\r\n";

		if (FALSE == wp_mail($user->user_email, sprintf(__('[%s] Your new password'), get_option('blogname')), $message)) {
			die('<p>' . __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') . '</p>');
		} else {
			// send a copy of password change notification to the admin
			// but check to see if it's the admin whose password we're changing, and skip this
			if ($user->user_email != get_option('admin_email')) {
				$message = sprintf(__('Password Lost and Changed for user: %s'), $user->user_login) . "\r\n";
				wp_mail(get_option('admin_email'), sprintf(__('[%s] Password Lost/Changed'), get_option('blogname')), $message);
			}

		}
		?>
		<html>
		<head>
		<title>Password is reset. Check your mail.</title>
		<script type="text/javascript">
		function alertuser() {
			alert("Your new password has been mailed to you. Please check your e-mail!");
			window.location.href="<?=get_option('siteurl')?>";
		}
		</script>
		</head>
		<body onload="alertuser();"></body>
		</html>
		
<?php
	break;
	default:
		die('You are not supposed to be here');
	break;
}

?>