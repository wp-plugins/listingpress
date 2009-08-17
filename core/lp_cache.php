<?php

/**
 * ListingPress Cache API
 *
 * The majority of this code is heavily borrowed from the Wordpress File-Based Object Caching
 * For more thorough documentation, please check out http://neosmart.net/dl.php?id=14
 *
 */

function lp_cache($file) {
	global $lp_cache;
	return $lp_cache->check($file);
}

function lp_cache_write($file, $string) {
	global $lp_cache;
	return $lp_cache->write($file, $string);
}

function lp_flush_cache() {
	global $lp_cache;
	return $lp_cache->flush();
}

function lp_cache_dir() {
	global $lp_cache;
	return $lp_cache->cache_dir;
}

function is_lp_cache_enabled() {
	global $lp_cache;
	return $lp_cache->cache_enabled;
}

function lp_cache_expire() {
	global $lp_cache;
	return $lp_cache->expiration_time;
}

class LP_Cache {
	var $cache_dir;
	var $cache_enabled = false;
	var $expiration_time = 21600;
	var $cache_hits = 0;
	var $cache_misses = 0;

	function write( $filename, $string ) {
		
		if( $this->cache_enabled ) {
			$cache_file = $this->cache_dir . $filename;
			if( !$fh = fopen( $cache_file, 'w' ) ) {
				// Issue error message to user -> Could not open {$fileName} to start writing.
				return false;
			} else {
				if( fwrite($fh, $string ) === FALSE ) {
					// Issue error message to user -> Could not write to {$fileName}.
					return false;
				} else {
					fclose( $fh );
					return true;
				}
			}
		} else {
			return false;
		}
		
	}
	
	function check( $filename ) {
		if( $this->cache_enabled ) {
			
			$cache_file = $this->cache_dir . $filename;
			if( !file_exists($cache_file) ) {
				$this->cache_misses += 1;
				return false;
			}

			$now = time();
			if( (filemtime($cache_file) + $this->expiration_time) <= $now ) {
				$this->cache_misses += 1;
				return false;
			}

			$this->cache_hits += 1;
			return true;
		
		} else {
			return false;
		}
	}
	
	function flush() {
		if( $this->cache_enabled ) {
			if( $handle = opendir( $this->cache_dir ) ) {
		    	while( false !== ($file = readdir($handle)) ) {
		        	if( $file != "." && $file != ".." ) {
		           		unlink( $this->cache_dir . '/' . $file );
		        	}
		    	}
		    	closedir($handle);
			}
		}
	}

	function stats() {
		echo "<p>";
		echo "<strong>Cache Hits:</strong> {$this->cold_cache_hits} <br />";
		echo "<strong>Cache Misses:</strong> {$this->cache_misses} <br />";
		echo "</p>";
	}
	
	function LP_Cache() {
		return $this->__construct();
	}

	function __construct() {
		global $lp_feed;

		register_shutdown_function( array(&$this, "__destruct") );

		if( defined('CACHE_PATH') ) {
			$this->cache_dir = CACHE_PATH;
		} else {
			$this->cache_dir = dirname( dirname(__FILE__) ).DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.$lp_feed.DIRECTORY_SEPARATOR;
		}

		if( is_writable($this->cache_dir) && is_dir($this->cache_dir) ) {
			$this->cache_enabled = true;
		} else if( is_writable(dirname($this->cache_dir)) && is_dir(dirname($this->cache_dir))) {
			if( !@mkdir($this->cache_dir, 0777) ) {
				$this->cache_enabled = false;
				// Message to the user -> We encountered an error trying to create your cache folder.
			} else {
				$this->cache_enabled = true;
			}
		} else {
			$this->cache_enabled = false;
			// Message to the user -> Please make sure there is a cache folder and that it is writable by the server.
		}

	}

	function __destruct() {
		return true;
	}
}

$lp_cache =& new LP_Cache();


?>