<?php get_header(); ?>
<section class="container">
<?php
	if(anps_get_option($anps_page_data, 'error_page') != '' && anps_get_option($anps_page_data, 'error_page') != 0) {
		query_posts('post_type=page&p=' . anps_get_option($anps_page_data, 'error_page'));
                
        while(have_posts()) { the_post();
            the_content();
        }
        
        wp_reset_query();
	} else {
		?>
			<h1 style="text-align: center;"><?php _e('It seems that something went wrong!', "transport"); ?></h1>
			<h6 style="text-align: center;"><span style="color: #c7c7c7;"><?php _e('This page does not exist.', "transport"); ?></span></h6>
		<?php
	}
?>
</section>
<?php get_footer(); ?>