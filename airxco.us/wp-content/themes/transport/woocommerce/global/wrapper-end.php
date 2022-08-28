<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$id = (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag())
	? intval(get_option('woocommerce_shop_page_id'))
	: get_queried_object_id();
$meta = get_post_meta($id);
$sidebars = anps_parse_sidebars_from_meta($meta);

$right_sidebar = $sidebars['right_sidebar'];
?>

</section>

<?php if ($right_sidebar) anps_sidebar_html($right_sidebar); ?>
</div></div>
