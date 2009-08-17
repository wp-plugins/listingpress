<?php

/**
 * ListingPress Registration Class
 * 
 */

function lp_access_token() {
	global $lp_registration;
	return $lp_registration->access_token;
}

function lp_current_version() {
	global $lp_registration;
	return $lp_registration->current_version;
}

function lp_host() {
	global $lp_registration;
	return $lp_registration->host;
}

function lp_feed() {
	global $lp_registration;
	return $lp_registration->feed;
}

function lp_is_registered() {
	global $lp_registration;
	return $lp_registration->is_registered;
}

class LP_Registration {
	
	var $registration_code;
	var $access_token;
	var $last_access;
	var $current_version;
	var $host;
	var $feed;
	var $is_registered = false;
	
	function init() {
		$settings 					= get_option('ListingPressSettings');
		$this->registration_code	= $settings['reg_code'];
		$this->access_token 		= $settings['access_token'];
		$this->last_access 			= $settings['last_access'];
		$this->this_version 		= $settings['this_version'];
		$this->new_version 			= $settings['new_version'];
		$this->host 				= $settings['host'];
		$this->feed 				= $settings['feed'];
		$this->is_registered		= false;
	}
	
	function update() {
		$new = array(
			'reg_code' 		=> $this->registration_code,
			'access_token' 	=> $this->access_token,
			'last_access' 	=> $this->last_access,
			'this_version'	=> $this->this_version,
			'new_version'	=> $this->new_version,
			'host'			=> $this->host,
			'feed'			=> $this->feed
		);
		update_option('ListingPressSettings',$new);
	}
	
	function revalidate() {
		$url = 'http://www.listingpress.com/dev-lp-access-token.php?rc=' . $this->registration_code . '&dm=' . urlencode( $_SERVER['HTTP_HOST'] ) . '&vn=' . urlencode( $this->current_version );
		$http = new WP_Http();
		$validate = $http->request($url);
		$xml = $validate['body'];
		if( !empty($xml) ) {
			$atpat 		= '/\<accessToken\>(.*?)\<\/accessToken\>/';
			$feedpat 	= '/\<feedID\>(.*?)\<\/feedID\>/';
			$verpat 	= '/\<version\>(.*?)\<\/version\>/';
			$hostpat	= '/\<host\>(.*?)\<\/host\>/';
			preg_match( $atpat, $xml, $at );
			preg_match( $feedpat, $xml, $feed );
			preg_match( $verpat, $xml, $ver );
			preg_match( $hostpat, $xml, $host );
			$this->access_token 	= $at[1];
			$this->feed				= $feed[1];
			$this->new_version		= $ver[1];
			$this->host				= $host[1];
			$this->last_access		= time();
			$this->is_registered 	= true;
			$this->update();
		} else {
			// Need to issue error that they have entered an invalid registration code
		}	
	}
	
	function __destruct() {
		return true;
	}
	
	function __construct() {
		register_shutdown_function(array(&$this, "__destruct"));
		$this->init();
		if( !empty($this->access_token) && ($this->last_access + 3600) > time() ) {
			$this->is_registered = true;
		} else if( !empty($this->registration_code) ) {
			$this->revalidate();
		} else {
			$reg_code = get_option('lp_reg_code');
			if( isset($reg_code) && !empty($reg_code) ) {
				$this->registration_code = $reg_code;
				$this->revalidate();
			} else {
				// Need to issue a message to user about entering the registration code to use the product
				//echo 'we have no registration code';
			}
		}
	}
	
	function LP_Registration() {	
		return $this->__construct();
	}
	
}

$lp_registration =& new LP_Registration();

?>