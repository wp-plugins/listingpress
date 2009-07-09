<?php 

header("Content-type: text/xml"); 
echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>';

?>

<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
	
<?php if (have_listings()) : ?>
	<?php while (have_listings()) : the_listing(); ?>
		
		<?php if( listing_has_images() ) : ?>
    
    	<item>
            <title><?php the_address(); ?></title>
            <media:description><?php the_bedrooms(); ?> Beds, <?php the_bathrooms(); ?> Baths in <?php the_city(); ?> for <?php the_sales_price(); ?></media:description>
            <link><?php the_listing_permalink() ?></link>

<?php
	$thumb = get_the_listing_photos('1','medium');
	$large = get_the_listing_photos('1','large');
?>

            <media:thumbnail url="<?php echo $thumb[0]; ?>" />
            <media:content url="<?php echo $large[0]; ?>" />
        </item> 
		
		<?php endif; ?>
		
<?php endwhile; endif; ?>
    
	</channel>
</rss>
