<?php

/**
 * ListingPress Sitemap Addition
 * In order to create a sitemap full of blog posts as well as listings, 
 * we recommend using the Google XML Sitemaps Plugin
 * http://www.arnebrachhold.de/redir/sitemap-home/
 * 
 * This is a simple function that hooks in to the google xml sitemap plugin
 * and includes thousands of listings in the agents sitemap.
 */
function add_listingpress_links() {
	$obj = &GoogleSitemapGenerator::GetInstance(); 
	if( $obj != null ) {
		$cities = lp_lookup_cities();
		foreach( $cities as $city ){
			
			$url = site_url('/' . str_replace(',','/',$city['CITY_STATE']) . '/Real-Estate/');
			$obj->AddUrl($url,time(),"daily",0.9);
			
			$q = new LP_Query('citystate=' . $city['CITY_STATE'] . '&showlistings=1500');
			if( $q->have_listings() ): while( $q->have_listings() ): $q->the_listing();
				$uri = site_url('/' . get_the_state() . '/' . sanitize_title( get_the_city() ) . '/' . sanitize_title( get_the_address() ) . '/listing/' . get_the_listing_id() . '/');
				$obj->AddUrl($uri,time(),"daily",0.9);
			endwhile; endif;
			
		}
	}
}
add_action("sm_buildmap","add_listingpress_links");

?>