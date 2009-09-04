<?php

/**
 * ListingPress Shortcode
 *
 * Much of this theory and usage is borrowed from Viper's Video Quicktags
 * For more thorough documentation, please check out http://www.viper007bond.com/wordpress-plugins/vipers-video-quicktags/
 *
 */

if( in_array( basename($_SERVER['PHP_SELF']), array('post-new.php', 'page-new.php', 'post.php', 'page.php') ) ) {
	add_action( 'admin_footer', 'lp_admin_footer' );
	wp_enqueue_style( 'lpshortcode', plugins_url('listingpress/resources/css/lpshortcode.css'), array('wp-admin', 'global', 'colors'), '1.0', 'screen' );
	if ( $wp_db_version < 8601 ) {
		wp_deregister_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-core', plugins_url('listingpress/resources/jquery-ui/ui.core.js'), array('jquery'), '1.5.2' );
	}
	wp_enqueue_script( 'jquery-ui-draggable', plugins_url('listingpress/resources/js/ui.draggable.js'), array('jquery-ui-core'), '1.5.2' );
	wp_enqueue_script( 'jquery-ui-resizable', plugins_url('listingpress/resources/js/ui.resizable.js'), array('jquery-ui-core'), '1.5.2' );
}

function lp_tiny_mce_version( $version ) {
	return $version . '-listingpress';
}
add_filter( 'tiny_mce_version', 'lp_tiny_mce_version' );

function lp_mce_external_plugins( $plugins ) {
	$plugins['listingpress'] = plugins_url('listingpress/resources/tinymce/editor_plugin.js');
	return $plugins;
}
add_filter( 'mce_external_plugins', 'lp_mce_external_plugins' );

function lp_mce_buttons( $buttons ) {
	array_push( $buttons, 'listingpress' );
	return $buttons;
}
add_filter( 'mce_buttons', 'lp_mce_buttons' );

function lp_add_button() {
?>

<script type="text/javascript">
// <![CDATA[

	function lp_submit_form() {
		var add = jQuery('#lp_address').val(),
			city = jQuery('#lp_city').val(),
			state = jQuery('#lp_state').val(),
			zip = jQuery('#lp_zip_code').val(),
			beds = jQuery('#lp_bedrooms').val(),
			baths = jQuery('#lp_bathrooms').val(),
			min_price = jQuery('#lp_min_price').val(),
			max_price = jQuery('#lp_max_price').val(),
			dom = jQuery('#lp_dom').val(),
			min_sqft = jQuery('#lp_min_sqft').val(),
			max_sqft = jQuery('#lp_max_sqft').val(),
			min_yb = jQuery('#lp_min_year_built').val(),
			max_yb = jQuery('#lp_max_year_built').val(),
			min_lot = jQuery('#lp_min_lot_size').val(),
			max_lot = jQuery('#lp_max_lot_size').val(),
			limit = jQuery('#lp_limit').val(),
			mls = jQuery('#lp_mls_ids').val();
			
		var sc = '[listingpress ';
			sc += (mls != '') ? 'mlsids="' + mls + '"' : '';
			sc += (add != '') ? 'address="' + add + '" ' : '';
			sc += (city != '') ? 'city="' + city + '" ' : '';
			sc += (state != '') ? 'state="' + state + '" ' : '';
			sc += (zip != '') ? 'zip="' + zip + '" ' : '';
			sc += (beds != '') ? 'beds="' + beds + '" ' : '';
			sc += (baths != '') ? 'baths="' + baths + '" ' : '';
			sc += (min_price != '') ? 'min_price="' + min_price + '" ' : '';
			sc += (max_price != '') ? 'max_price="' + max_price + '" ' : '';
			sc += (dom != '') ? 'dom="' + dom + '" ' : '';
			sc += (min_sqft != '') ? 'min_size="' + min_sqft + '" ' : '';
			sc += (max_sqft != '') ? 'max_size="' + max_sqft + '" ' : '';
			sc += (min_yb != '') ? 'min_year_built="' + min_yb + '" ' : '';
			sc += (max_yb != '') ? 'max_year_built="' + max_yb + '" ' : '';
			sc += (min_lot != '') ? 'min_lot_size="' + min_lot + '" ' : '';
			sc += (max_lot != '') ? 'max_lot_size="' + max_lot + '" ' : '';
			sc += (limit != '') ? 'limit="' + limit + '" ' : '';
			sc += ']';
			

		if ( typeof tinyMCE != 'undefined' && ( ed == tinyMCE.activeEditor ) && !ed.isHidden() ) {
			ed.focus();
			if (tinymce.isIE) {
				ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
			}
			ed.execCommand('mceInsertContent', false, sc);
		} else {
			edInsertContent(edCanvas, sc);
		}
		
		lp_close_form();
	}
	
	function lp_open_form() {
		var w = jQuery(window).width();
		var l = (w / 2) - 225;
		jQuery('#ListingPress').css({ left: l }).show();
	}
	
	function lp_close_form() {
		jQuery('#ListingPress').hide();
		jQuery('.ui-draggable-iframeFix').remove();
	}
	
	jQuery(document).ready(function($){
		$("#ed_toolbar").append('<input type="button" class="ed_button" title="Embed A Listing" value="listingpress" />');
		
		$('#ListingPress').draggable({ 
			handle: '.hndle', 
			iframeFix: true
		});
		
		$('#lp_cancel').click(lp_close_form);
		$("#lp_embed").click(lp_submit_form);
		
		$("#ListingPress :input").keyup(function(event){
			if ( 13 == event.keyCode ) { // 13 == Enter
				lp_submit_form();
			}
		});
		
		$('#mls_search').hide();
		$('#lp_search_by').change(function(){
			if( $(this).val() == 'mls' ) {
				$('#all_search').hide();
				$('#mls_search').show();
			} 
			else if( $(this).val() == 'city' ) {
				$('#lp_add, #mls_search').hide();
				$('#all_search').show();
			}
			else if( $(this).val() == 'zip' ) {
				$('#lp_add, #mls_search, #lp_cit, #lp_stat, #lp_sta').hide();
				$('#all_search').show();
			}
			else {
				$('#mls_search').hide();
				$('#all_search').show();
			}
		});
		
	});
// ]]>
</script>

<?php
}
add_action( 'edit_form_advanced', 'lp_add_button' );
add_action( 'edit_page_form', 'lp_add_button' );
	
function lp_shortcode( $atts, $content = '' ) {
	
	/*
	extract( shortcode_atts( array(
		'attr_1' => 'attribute 1 default',
      	'attr_2' => 'attribute 2 default'
	), $atts ) );
	*/
	
		
	$atts['minprice'] = str_replace( array( '$', ',' ), array( '', '' ), $atts['minprice'] );
	$atts['maxprice'] = str_replace( array( '$', ',' ), array( '', '' ), $atts['maxprice'] );	
		
	return $html;
}	
add_shortcode( 'listingpress', 'lp_shortcode' );

function lp_admin_footer() {
?>
<div id="ListingPress" class="meta-box-draggables" style="display:none">
	<div class="postbox">
		<div class="emptyparentelement">
			<h3 class="hndle"><span>ListingPress Embed A Search</span></h3>
		</div>
		<div class="inside">
			<div class="submitbox">
				<div id="minor-publishing">
					<form id="lp_shortcode_form">
					<div id="misc-publishing-actions">
						<div class="misc-pub-section">
							<div class="lp_label">Search By:</div>
							<div class="lp_input">
								<select id="lp_search_by">
									<option value="add" SELECTED>Street Address</option>
									<option value="city">City</option>
									<option value="zip">Zip Code</option>
									<option value="mls">MLS ID's</option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div id="mls_search">
							<div class="misc-pub-section" id="mls">
								<div class="lp_label">MLS ID's:</div>
								<div class="lp_input"><input type="text" id="lp_mls_ids" /></div>
								<div class="clear"></div>
							</div>
						</div>
						<div id="all_search">
							<div class="misc-pub-section" id="lp_add">
								<div class="lp_label">Address:</div>
								<div class="lp_input"><input type="text" id="lp_address" tabindex="1" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section" id="lp_cit">
								<div class="lp_label">City:</div> 
								<div class="lp_input"><input type="text" id="lp_city" tabindex="2" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label" id="lp_sta">State:</div>
								<div class="lp_input_small" id="lp_stat"><input type="text" id="lp_state" tabindex="3" /></div>
								<div class="lp_label">Zip Code:</div> 
								<div class="lp_input_small"><input type="text" id="lp_zip_code" tabindex="4" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label pushR w80">Bedrooms:</div> 
								<div class="lp_input_small pushR"><input type="text" id="lp_bedrooms" tabindex="5" /></div> 
								<div class="lp_label pushR w80">Bathrooms:</div>
								<div class="lp_input_small"><input type="text" id="lp_bathrooms" tabindex="6" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label pushR">Min Price:</div> 
								<div class="lp_input_small pushR"><input type="text" id="lp_min_price" tabindex="7" /></div> 
								<div class="lp_label pushR">Max Price:</div>
								<div class="lp_input_small"><input type="text" id="lp_max_price" tabindex="8" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">Property Type: <br /><br />
								<table>
									<tr>
<?php
								$props = lp_lookup_property_types(); 
								for( $i = 0; $i < count($props); $i++ ) {
									if( !is_float($i / 2) && $i != 0 ) 
										echo '</tr><tr>';
										
									$id = str_replace(' ','_',$props[$i]['LISTING_TYPE']);
									echo '<td><input type="checkbox" id="lp_'.$id.'" /> <label for="lp_'.$id.'">' . $props[$i]['LISTING_TYPE'] . '</label></td>';
								}
?>
									</tr>
								</table>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label">DOM:</div>
								<div class="lp_input_small"><input type="text" id="lp_dom" tabindex="9" /></div>
								<span class="howto">Example: &lt;10 or &gt;10 or =10
									<div class="clear"></div>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label pushR w80">Min SQFT:</div> 
								<div class="lp_input_small pushR"><input type="text" id="lp_min_sqft" tabindex="10" /></div> 
								<div class="lp_label pushR w80">Max SQFT:</div>
								<div class="lp_input_small"><input type="text" id="lp_max_sqft" tabindex="11" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label pushR w100">Min Yr Built:</div> 
								<div class="lp_input_small pushR"><input type="text" id="min_year_built" tabindex="12" /></div> 
								<div class="lp_label pushR w100">Max Yr Built:</div>
								<div class="lp_input_small"><input type="text" id="max_year_built" tabindex="13" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">
								<div class="lp_label pushR w100">Min Lot Size:</div> 
								<div class="lp_input_small pushR"><input type="text" id="min_lot_size" tabindex="14" /></div> 
								<div class="lp_label pushR w100">Max Lot Size:</div>
								<div class="lp_input_small"><input type="text" id="max_lot_size" tabindex="15" /></div>
								<div class="clear"></div>
							</div>
							<div class="misc-pub-section">Features: <br /><br />
								<table>
									<tr>
<?php
								$feats = lp_lookup_searchable_features();  
								for( $i = 0; $i < count($feats); $i++ ) {
									if( !is_float($i / 2) && $i != 0 ) 
										echo '</tr><tr>';
										
									$id = str_replace(' ','_',$feats[$i]['FEATURENAME']);
									echo '<td><input type="checkbox" id="lp_'.$id.'" /> <label for="lp_'.$id.'">' . $feats[$i]['FEATURENAME'] . '</label></td>';
								}
?>
									</tr>
								</table>
							</div>
							<div class="misc-pub-section misc-pub-section-last">
								<div class="lp_label w220">Number of Listings to Display:</div> 
								<div class="lp_input_small"><input type="text" id="lp_limit" tabindex="16" /></div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div id="major-publishing-actions">
						<div id="publishing-action">
							<input name="cancel" type="button" class="button" id="lp_cancel" value="Cancel" />
							<input name="embed" type="submit" class="button" id="lp_embed" value="Embed Listings" />
						</div>
					<div class="clear"></div>
					</form>
				</div><!-- //minor-publishing -->
			</div><!-- //submitbox -->
		</div><!-- //inside -->
	</div><!-- //postbox -->
</div><!-- //meta-box-draggables -->

<?php
}

?>