<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
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

$left_sidebar = $sidebars['left_sidebar'];
$num_of_sidebars = $sidebars['num_of_sidebars'];
?>

<div class="container"><div class="row" id="site-content">

	<?php if ($left_sidebar) anps_sidebar_html($left_sidebar); ?>

	<section class="col-md-<?php echo 12 - $num_of_sidebars * 3; ?>">
