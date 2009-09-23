<?php

/**
 * ListingPress Featured Listings widget class
 *
 * See wp-includes/default-widgets.php for more info.
 *
 */
class LP_Widget_Featured_Listings extends WP_Widget {

	function LP_Widget_Featured_Listings() {
		$widget_opts = array( 'classname' => 'lp_widget_featured_listings', 'description' => __( 'Display selected listings on your sidebar.' ) );
		$control_opts = array( 'width' => 600, 'height' => 450 );
		$this->WP_Widget('featured_listings', __('ListingPress Featured Listings'), $widget_opts, $control_opts);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = empty( $instance['title'] ) ? __( 'Featured Listings' ) : $instance['title'];
		$search = empty( $instance['search'] ) ? '' : $instance['search'];
		$width = empty( $instance['width'] ) ? '200' : $instance['width'];
		$inner = $width - 21;

		if ( !empty( $search ) ) {
			echo $before_widget;
			echo $before_title . $title . $after_title;
		
?>

		<div class="lp_featured_listings_container">
			<div class="lp_featured_listings_left_arrow neighArrow" ></div>
			<div class="lp_featured_listings_right_arrow neighArrow" ></div>
			<div class="lp_featured_listings_slide_show">
				<div class="lp_featured_listings_slide_container" id="neighSlide">
					
<?php
				$fl = new LP_Query($search);
				$total = intval( $fl->listing_count * $inner );
				if( $fl->have_listings() ): while( $fl->have_listings() ): $fl->the_listing();
?>

					<div class="lp_featured_listings_slide">
						
						<h3 class="lp_featured_listings_h3"><?php the_address(); ?></h3>
						<a href="<?php the_listing_permalink(); ?>"><?php the_primary_photo('lp_featured_listings_photo'); ?></a>

						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Asking Price:</span>
							<span class="lp_featured_listings_data_right"><?php the_sales_price(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Address:</span>
							<span class="lp_featured_listings_data_right"><?php the_address(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">City:</span>
							<span class="lp_featured_listings_data_right"><?php the_city(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">State:</span>
							<span class="lp_featured_listings_data_right"><?php the_state(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Zip Code:</span>
							<span class="lp_featured_listings_data_right"><?php the_zip_code(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Bedrooms:</span>
							<span class="lp_featured_listings_data_right"><?php the_bedrooms(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Bathrooms:</span>
							<span class="lp_featured_listings_data_right"><?php the_bathrooms(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Property Type:</span>
							<span class="lp_featured_listings_data_right"><?php the_property_type(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Sq. Ft.:</span>
							<span class="lp_featured_listings_data_right"><?php the_sqft(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">Price Per Sq. Ft.:</span>
							<span class="lp_featured_listings_data_right"><?php price_per_sqft(); ?></span>
							<span class="clear"></span>
						</div>
						<div class="lp_featured_listings_row">
							<span class="lp_featured_listings_data_left">MLS ID:</span>
							<span class="lp_featured_listings_data_right"><?php the_mls_id(); ?></span>
							<span class="clear"></span>
						</div>

					</div> <!-- //slide -->
					
				<?php endwhile; endif; ?>

				</div> <!-- //slideContainer -->
			</div> <!-- //slideShow -->
		</div>
			
		<style type="text/css">
			.clear {clear:both;}
			.lp_featured_listings_container {margin:0px;padding:0px;width:<?php echo $width; ?>px;height:400px;position:relative;}
			.lp_featured_listings_slide_show {margin:0px auto;padding:0;width:<?php echo $inner; ?>px;height:400px;overflow:hidden;position:relative;}
			.lp_featured_listings_slide_container {margin:0;padding:0;width:<?php echo $total; ?>px;height:400px;position:absolute;z-index:1;left:0px;}
			.lp_featured_listings_slide {margin:0;padding:0;width:<?php echo $inner; ?>px;height:400px;float:left;}
			.lp_featured_listings_photo {margin:0;padding:0;width:<?php echo $inner; ?>px;}
			.lp_featured_listings_photo img {margin:0;padding:0;width:<?php echo $inner; ?>px;border:0;}
			.lp_featured_listings_right_arrow {margin:0;padding:0;width:43px;height:60px;background: transparent url("<?php echo plugins_url('listingpress/resources/images/right_arrow.png'); ?>") 0px 0px no-repeat;position:absolute;top:50px;right:-15px;cursor:pointer;z-index:300;}
			.lp_featured_listings_left_arrow {margin:0;padding:0;width:38px;height:65px;background: transparent url("<?php echo plugins_url('listingpress/resources/images/left_arrow.png'); ?>") 0px 0px no-repeat;position:absolute;top:50px;left:-6px;cursor:pointer;z-index:300;}
			.lp_featured_listings_title {font-family:'Verdana';font-size:14px;color:#333333;padding:5px 0px;}
			.lp_featured_listings_row {font-family:'Verdana';font-size:10px;color:#333333;width:<?php echo $inner; ?>px;height:17px;}
			.lp_featured_listings_data_left {float:left;width:45%;margin:0;padding:0;}
			.lp_featured_listings_data_right {width:55%;float:right;margin:0;padding:0;}
			.lp_featured_listings_h3 {margin:0px 0px 0px 5px;padding:0;text-transform:uppercase;font-family:'Verdana';font-size:14px;color:#333333;font-weight:normal;}
		</style>
		
		<script type="text/javascript">
			jQuery(document).ready(function($){
				function slide_featured_listings() {
					var dist = '<?php echo $inner; ?>';
					var total = '<?php echo $total; ?>';
					var pos = $('.lp_featured_listings_slide_container').css('left').replace('px','');
					var last_pos = dist - total;

					if( $(this).hasClass('lp_featured_listings_left_arrow') ) {
						if( pos == 0 )
							var end = last_pos;
						else 
							var end = parseInt(pos) + parseInt(dist);

						$('.lp_featured_listings_slide_container').animate({'left':end + 'px'},1500);
					} else if( $(this).hasClass('lp_featured_listings_right_arrow') ) {
						if( pos == last_pos )
							var end = 0;
						else
							var end = pos - dist;
							
						$('.lp_featured_listings_slide_container').animate({'left':end + 'px'},1500);
					}
				}
				$('.lp_featured_listings_left_arrow').click(slide_featured_listings);
				$('.lp_featured_listings_right_arrow').click(slide_featured_listings);
			});
		</script>

<?php
			
			echo $after_widget;
		}
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['search'] = $new_instance['search'];
		$instance['width'] = intval($new_instance['width']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Featured Listings', 'search' => '', 'width' => '200' ) );
		$title = esc_attr( $instance['title'] );
		$search = $instance['search'];
		$width = intval($instance['width']);
	?>
	
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('search'); ?>"><?php _e( 'Search Listings:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('search'); ?>" name="<?php echo $this->get_field_name('search'); ?>" type="text" value="<?php echo $search; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e( 'Width of Widget:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
		
<?php
	}
	
}

function lp_widgets_init() {

	register_widget('LP_Widget_Featured_Listings');

}
add_action('widgets_init','lp_widgets_init');

?>