<?php
global $anps_options_data;
$page_heading_full = get_post_meta(get_queried_object_id(), $key = 'anps_page_heading_full', $single = true);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="<?php bloginfo('charset'); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php anps_theme_after_styles(); ?>
    <?php if (isset($page_heading_full) && $page_heading_full == "on") {
        add_action("wp_head", 'anps_page_full_screen_style', 1000);
    } ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(anps_boxed_or_vertical() . anps_header_margin()); ?><?php anps_body_style(); ?>>
    <?php wp_body_open(); ?>
    <?php
    $coming_soon = anps_get_option('', '0', 'coming_soon');
    if ($coming_soon == "0" || is_super_admin()) : ?>

        <div class="site-wrapper <?php if (get_option('anps_vc_legacy', "0") == "on") {
                                        echo "legacy";
                                    } ?>">
            <?php
            $anps_menu_type = get_option('anps_menu_type', '2');
            ?>

            <div class="site-search" id="site-search">
                <?php anps_get_search(); ?>
            </div>

            <?php if (isset($page_heading_full) && $page_heading_full == "on") : ?>
                <?php
                $heading_value = get_post_meta(get_queried_object_id(), $key = 'heading_bg', $single = true);

                if (is_404()) {
                    $heading_value = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key = 'heading_bg', $single = true);
                }

                /* Page heading BG color */
                $anps_heading_bg_color = get_option('anps_page_heading_bg_color', '');

                if (is_404()) {
                    $anps_heading_meta_bg_color = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key = 'heading_bg', $single = true);
                } else {
                    $anps_heading_meta_bg_color = get_post_meta(get_queried_object_id(), $key = 'anps_heading_bg_color', $single = true);
                }

                if ($anps_heading_meta_bg_color != '') {
                    $anps_heading_bg_color = $anps_heading_meta_bg_color;
                }

                if ($anps_heading_bg_color != '') {
                    $anps_heading_bg_color = ' background-color: ' . $anps_heading_bg_color . ';';
                }
                ?>

                <?php if (get_option('anps_menu_type', '2') != '5') : ?>
                    <?php
                    $height_value = get_post_meta(get_queried_object_id(), $key = 'anps_full_height', $single = true);

                    if ($height_value) {
                        $height_value = 'height: ' . $height_value . 'px; ';
                    }

                    ?>
                    <div class="paralax-header parallax-window" data-type="background" data-speed="2" style="<?php echo esc_attr($height_value); ?>background-image: url(<?php echo esc_url($heading_value); ?>);<?php echo esc_attr($anps_heading_bg_color); ?>">
                    <?php endif; ?>

                <?php endif; ?>
            <?php endif; ?>
            <?php anps_get_header(); ?>