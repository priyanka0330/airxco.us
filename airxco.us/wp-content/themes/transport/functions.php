<?php

/* CONSTANTS */

define('ANPS_THEME_VERSION', wp_get_theme()->version);

global $no_container;
$no_container = false;

if (!isset($content_width)) {
    $content_width = 0;
}

include_once get_template_directory() . '/anps-framework/helpers.php';
include_once get_template_directory() . '/anps-framework/widgets.php';
include_once get_template_directory() . '/anps-framework/install_plugins.php';
include_once get_template_directory() . '/anps-framework/classes/Customizer.php';
include_once get_template_directory() . '/anps-framework/classes/adminBar.php';

if (is_admin()) {
    include_once get_template_directory() . '/shortcodes/shortcodes_init.php';
} else {
    include_once get_template_directory() . '/anps-framework/classes/Options.php';
    include_once get_template_directory() . '/anps-framework/classes/Contact.php';
    $anps_page_data = $options->get_page_setup_data();
    $anps_options_data = $options->get_page_data();
    $anps_media_data = $options->get_media();
    $anps_social_data = $options->get_social();
    $anps_contact_data = $contact->get_data();
    $anps_shop_data = $options->get_shop_setup_data();
}

if (function_exists('anps_portfolio')) {
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/widgets/widgets.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/shortcodes.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/team_meta.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/portfolio_meta.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/metaboxes.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/menu_meta.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/heading_meta.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/featured_video_meta.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/header_options_meta.php';
    include_once WP_PLUGIN_DIR . '/anps_theme_plugin/meta/gallery_images.php';
}

add_theme_support('wp-block-styles');
add_theme_support('align-wide');
add_theme_support('editor-styles');
add_theme_support('responsive-embeds');
add_theme_support('html5');

add_theme_support('editor-color-palette', array(
    array(
        'name' => __('Blue', 'transport'),
        'slug' => 'blue',
        'color' => '#3498db',
    ),
    array(
        'name' => __('Orange', 'transport'),
        'slug' => 'orange',
        'color' => '#fc9732',
    ),
    array(
        'name' => __('Green', 'transport'),
        'slug' => 'green',
        'color' => '#89c218',
    ),
    array(
        'name' => __('Red', 'transport'),
        'slug' => 'red',
        'color' => '#e82a2a',
    ),
    array(
        'name' => __('Yellow', 'transport'),
        'slug' => 'yellow',
        'color' => '#f7c51e',
    ),
    array(
        'name' => __('Light', 'transport'),
        'slug' => 'light',
        'color' => '#ffffff',
    ),
    array(
        'name' => __('Dark', 'transport'),
        'slug' => 'dark',
        'color' => '#242424',
    ),
));

add_theme_support('editor-font-sizes', array(
    array(
        'name' => __('H1', 'transport'),
        'size' => 31,
        'slug' => 'anps-h-1'
    ),
    array(
        'name' => __('H2', 'transport'),
        'size' => 24,
        'slug' => 'anps-h-2'
    ),
    array(
        'name' => __('H3', 'transport'),
        'size' => 21,
        'slug' => 'anps-h-3'
    ),
    array(
        'name' => __('H4', 'transport'),
        'size' => 18,
        'slug' => 'anps-h-4'
    ),
    array(
        'name' => __('H5', 'transport'),
        'size' => 16,
        'slug' => 'anps-h-5'
    ),

));

/* Override vc tabs */
if (function_exists('vc_theme_rows_inner') && get_option('anps_vc_legacy', "0") == "on") {
    function vc_theme_rows($atts, $content)
    {
        $extra_class = '';
        $extra_id = '';
        $matches = array();

        global $no_container, $row_inner, $text_only;

        wp_enqueue_script('wpb_composer_front_js');

        if ($row_inner) {
            return vc_theme_rows_inner($atts, $content);
        }

        if ($text_only) {
            return wpb_js_remove_wpautop($content);
        }

        /* Check for any user added styles */

        $css = '';
        if (isset($atts['css'])) {
            $css = $atts['css'];
        }

        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if (!empty($matches)) {
            $temp = $matches[1];

            if ($temp) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }

        /* Check for any user added classes */

        if (isset($atts['el_class']) && $atts['el_class']) {
            $extra_class .= ' ' . $atts['el_class'];
        }

        /* Check for any user added IDs */

        if (isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "' . $atts['id'] . '"';
        }

        $coming_soon = get_option('coming_soon', '0');
        if ($coming_soon == "0" || is_super_admin()) {
            if (!isset($atts['has_content']) || $atts['has_content'] == "true") {
                /* Content inside a container */
                $no_container = false;
                $no_top_margin = '';
                if (strpos($extra_class, 'no-top-margin')) {
                    $no_top_margin = ' no-top-margin';
                }
                return '<section class="wpb_row container' . $no_top_margin . '"><div ' . $extra_id . ' class="row' . $extra_class . '">' . wpb_js_remove_wpautop($content) . '</div></section>';
            } elseif ($atts['has_content'] == "inside") {
                $no_container = false;
                return '<section ' . $extra_id . ' class="wpb_row' . $extra_class . '"><div class="container no-margin"><div class="row">' . wpb_js_remove_wpautop($content) . '</div></div></section>';
            } else {
                /* Fullwidth Content */
                $no_container = true;
                return '<section ' . $extra_id . ' class="wpb_row row no-margin' . $extra_class . '"><div class="row">' . wpb_js_remove_wpautop($content) . '</div></section>';
            }
        } else {
            /* No wrappers, only when Cooming soon is active */
            $no_container = true;
            return wpb_js_remove_wpautop($content);
        }
    }
    function vc_theme_rows_inner($atts, $content)
    {

        /* Check for any user added styles */

        $style = "";
        $css = '';

        if (isset($atts['css'])) {
            $css = $atts['css'];
        }
        $extra_id = '';
        $extra_class = '';

        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if (!empty($matches)) {
            $temp = $matches[1];

            if ($temp) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }

        if (isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' ' . $atts['el_class'];
        }

        $temp2 = preg_match('/{(.*?)}/s', $css, $matches2);
        if (!empty($matches2)) {
            $temp2 = $matches2[1];
            if ($temp2) {
                $style = ' style="' . $temp2 . '"';
            }
        }

        if (isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "' . $atts['id'] . '"';
        }
        return '<div ' . $extra_id . ' class="row' . $extra_class . '"' . $style . '>' . wpb_js_remove_wpautop($content) . '</div>';
    }
    function vc_theme_columns($atts, $content = null)
    {
        if (!isset($atts['width'])) {
            $width = '1/1';
        } else {
            $width = explode('/', $atts['width']);
        }

        global $no_container, $text_only;
        $extra_id = '';
        $extra_class = '';
        if ($width[1] > 0) {
            $col = (12 / $width[1]) * $width[0];
        } else {
            $col = 12;
        }
        $css = '';
        if (isset($atts['css'])) {
            $css = $atts['css'];
        }

        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if (!empty($matches)) {
            $temp = $matches[1];

            if ($temp) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }
        $mobile_class = "";
        if (isset($atts['offset']) && $atts['offset']) {
            $mobile_class = " " . $atts['offset'];
        }

        if (isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' ' . $atts['el_class'];
        }

        if (isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "' . $atts['id'] . '"';
        }

        if ($no_container || $text_only) {
            return '<div class="wpb_column col-md-' . $col . $extra_class . $mobile_class . '">' . wpb_js_remove_wpautop($content) . "</div>";
        } else {
            return '<div ' . $extra_id . ' class="wpb_column col-md-' . $col . $extra_class . $mobile_class . '">' . wpb_js_remove_wpautop($content) . '</div>';
        }
    }
    function vc_theme_vc_row($atts, $content = null)
    {
        return vc_theme_rows($atts, $content);
    }
    function vc_theme_vc_row_inner($atts, $content = null)
    {
        return vc_theme_rows_inner($atts, $content);
    }
    function vc_theme_vc_column($atts, $content = null)
    {
        return vc_theme_columns($atts, $content);
    }
    function vc_theme_vc_column_inner($atts, $content = null)
    {
        return vc_theme_columns($atts, $content);
    }
    function vc_theme_vc_tabs($atts, $content = null)
    {
        $content2 = str_replace("vc_tab", "tab", $content);
        if (!isset($atts['type'])) {
            $atts['type'] = "";
        } else {
            $atts['type'] = $atts['type'];
        }
        return do_shortcode("[tabs type='" . $atts['type'] . "']" . $content2 . "[/tabs]");
    }
    function vc_theme_vc_column_text($atts, $content = null)
    {
        $extra_class = '';

        /* Check for any user added styles */

        $css = '';
        if (isset($atts['css'])) {
            $css = $atts['css'];
        }

        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if (!empty($matches)) {
            $temp = $matches[1];

            if ($temp) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }

        /* Check for any user added classes */

        if (isset($atts['el_class']) && $atts['el_class']) {
            $extra_class .= ' ' . $atts['el_class'];
        }

        return '<div class="text' . $extra_class . '">' . do_shortcode($content) . '</div>';
    }
}

/* Title tag theme support */
add_theme_support('title-tag');

/* Image sizes */
add_theme_support('post-thumbnails');

/* team */
add_image_size('team-3', 370, 360, false);
// Blog views
add_image_size('blog-grid', 720, 412, true);
add_image_size('blog-full', 1200);
add_image_size('blog-masonry-3-columns', 360, 0, false);
// Recent blog, portfolio
add_image_size('post-thumb', 360, 267, true);
// Portfolio random grid
add_image_size('portfolio-random-width-2', 554, 202, true);
add_image_size('portfolio-random-height-2', 262, 433, true);
add_image_size('portfolio-random-width-2-height-2', 554, 433, true);
add_image_size('anps-featured', 722, 368, true);

function anps_get_option($class, $value, $name = '')
{
    if ($name == '') {
        if (isset($class[$value])) {
            return get_option('anps_' . $value, $class[$value]);
        } else {
            return get_option('anps_' . $value, '');
        }
    } else {
        return get_option('anps_' . $name, get_option($name, $value));
    }
}

add_filter('widget_text', 'do_shortcode');

add_action('after_switch_theme', 'anps_register_custom_fonts');
function anps_register_custom_fonts()
{
    include_once get_template_directory() . '/anps-framework/classes/Style.php';
    /* Populate font options */
    $style->update_gfonts(false);
    $style->update_custom_fonts();
    /* Add default fonts */
    if (!get_option('font_type_1', '')) {
        update_option("font_type_1", "Montserrat");
        update_option("font_source_1", "Google fonts");
    }
    if (!get_option('font_type_2', '')) {
        update_option("font_type_2", "PT+Sans");
        update_option("font_source_2", "Google fonts");
    }
    if (!get_option('font_type_navigation')) {
        update_option("font_type_navigation", "Montserrat");
        update_option("font_source_navigation", "Google fonts");
    }
    update_option('sidebars_widgets', array());
}

/* Show excerpt by default */
add_filter('default_hidden_meta_boxes', 'anps_hide_meta_box', 10, 2);
function anps_hide_meta_box($hidden, $screen)
{
    //make sure we are dealing with the correct screen
    if ('post' == $screen->base) {
        //lets hide everything
        $hidden = array('slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
    }
    return $hidden;
}

/* Infinite scroll 08.07.2013 */
function anps_infinite_scroll_init()
{
    add_theme_support('infinite-scroll', array(
        'type'       => 'click',
        'footer_widgets' => true,
        'container'  => 'section-content',
        'footer'     => 'site-footer',
    ));
}
add_action('init', 'anps_infinite_scroll_init');
/* MegaMenu */
class description_walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $append = "";
        $prepend = "";
        if (get_post_meta($item->ID, 'anps-megamenu', true) == '1') {
            $megamenu_wrapper_class = ' megamenu-wrapper';
            unset($item->classes[0]);
        } else {
            $megamenu_wrapper_class = '';
        }

        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $class_names = $value = '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = ' class="' . esc_attr($class_names . $megamenu_wrapper_class) . ' menu-item-depth-' . $depth . '"';

        $output .= $indent . '<li' . $value . $class_names . '>';
        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

        $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));

        /* Description */
        $description  = !empty($item->description) ? '<span class="menu-item-desc">' . esc_attr($item->description) . '</span>' : '';
        $description = do_shortcode($description);
        if ($depth > 0) {
            $description = "";
        }
        /* END Description */
        $locations = get_theme_mod('nav_menu_locations');
        if ($locations['primary']) {
            $item_output = "";
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';

            $item_output .= $args->link_before . $prepend . apply_filters('the_title', $item->title, $item->ID) . $append;
            $item_output .= '</a>';
            $item_output .= $description . $args->link_after;
            $item_output .= $args->after;
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth = 0, $args, $args, $current_object_id = 0);
        }
    }
}

function anps_scripts_and_styles()
{
    wp_enqueue_script("jquery");
    //wp_enqueue_style("prettyphoto", get_template_directory_uri()  . "/css/prettyPhoto.css");
    wp_enqueue_style("font-awesome", get_template_directory_uri() . "/css/font-awesome.min.css");
    wp_enqueue_style("owl-css", get_template_directory_uri() . "/js/owl/assets/owl.carousel.css");
    wp_enqueue_style("transport", get_template_directory_uri() . "/css/transport.css");

    wp_register_script("fullwidth-slider", get_template_directory_uri()  . "/js/fullwidth-slider.js", '', '', true);

    wp_register_script("anps-isotope", get_template_directory_uri()  . "/js/jquery.isotope.min.js", '', '', true);

    wp_enqueue_script("bootstrap", get_template_directory_uri()  . "/js/bootstrap/bootstrap.min.js", '', '', true);
    wp_enqueue_script("woo_quantity", get_template_directory_uri() . "/js/quantity_woo23.js", array("jquery"), "", true);

    $google_maps_api = get_option('anps_google_maps', '');

    if ($google_maps_api != '') {
        $google_maps_api = '?key=' . $google_maps_api;
    }

    wp_register_script("gmap3_link", "https://maps.google.com/maps/api/js" . $google_maps_api, '', '', true);
    wp_register_script("gmap3", get_template_directory_uri()  . "/js/gmap3.min.js", '', '', true);
    wp_register_script("countto", get_template_directory_uri()  . "/js/countto.js", '', '', true);
    // wp_enqueue_script("waypoints", get_template_directory_uri()  . "/js/waypoints.js", '', '', true);
    wp_enqueue_script("parallax", get_template_directory_uri()  . "/js/parallax.js", '', '', true);
    wp_enqueue_script("functions", get_template_directory_uri()  . "/js/functions.js", array('jquery', 'fullwidth-slider', 'anps-isotope', 'bootstrap', 'countto', 'doubletap', 'owl'), ANPS_THEME_VERSION, true);
    wp_localize_script('functions', 'anps', array(
        'search_placeholder' => __('Search...', 'transport')
    ));
    wp_enqueue_script("doubletap", get_template_directory_uri()  . "/js/doubletaptogo.js", array('jquery'), '', true);
    wp_enqueue_script("owl", get_template_directory_uri() . "/js/owl/owl.carousel.js", array("jquery"), "", true);

    wp_enqueue_style("theme_main_style", get_bloginfo('stylesheet_url'));

    $google_font_sources = array();

    if (get_option('font_source_1') === 'Google fonts') {
        $google_font_sources[] = urldecode(get_option('font_type_1', 'Montserrat'));
    }
    if (get_option('font_source_2') === 'Google fonts') {
        $google_font_sources[] = urldecode(get_option('font_type_2', 'PT+Sans'));
    }
    if (get_option('font_source_navigation') === 'Google fonts') {
        $google_font_sources[] = urldecode(get_option('font_type_navigation', 'Montserrat'));
    }
    $logo_font = explode('|', get_option('anps_text_logo_font', 'Arial, sans-serif|System fonts'));
    if (isset($logo_font[1]) && $logo_font[1] === 'Google fonts') {
        $google_font_sources[] = urldecode($logo_font[0]);
    }

    $google_fonts = anps_get_google_fonts_uri(array_unique($google_font_sources));
    if ($google_fonts) {
        wp_enqueue_style('google_fonts', $google_fonts, array(), null);
    }

    wp_enqueue_style("anps_core", get_template_directory_uri() . "/css/core.css");
    wp_enqueue_style("theme_wordpress_style", get_template_directory_uri() . "/css/wordpress.css");

    $custom_css = anps_custom_styles() . anps_custom_styles_buttons();
    wp_add_inline_style('theme_wordpress_style', $custom_css);

    wp_enqueue_style("custom", get_template_directory_uri() . '/custom.css');
}
add_action('wp_enqueue_scripts', 'anps_scripts_and_styles');

load_theme_textdomain("transport", get_template_directory() . '/languages');

/* Admin only scripts */

function anps_load_custom_wp_admin_scripts($hook)
{
    wp_register_style('anps_sidebar_generator_css', get_template_directory_uri() . "/anps-framework/css/sidebar-generator.css");
    wp_register_script('anps_sidebar_generator_js', get_template_directory_uri() . "/anps-framework/js/sidebar-generator.js");
    wp_localize_script('anps_sidebar_generator_js', 'ajaxObject', array('url' => admin_url('admin-ajax.php')));
    /* Overwrite VC styling */
    wp_enqueue_style("vc_custom", get_template_directory_uri() . '/css/vc_custom.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style("wp-backend", get_template_directory_uri() . "/anps-framework/css/wp-backend.css");

    wp_enqueue_style("anps-iconpicker-css", get_template_directory_uri()  . "/anps-framework/css/iconpicker.css");
    wp_enqueue_script('anps-iconpicker-js', get_template_directory_uri() . "/anps-framework/js/iconpicker.js", array('jquery'), false, true);

    wp_register_script('ace-editor', get_template_directory_uri()  . '/js/ace.min.js', array('jquery'), '', true);

    wp_enqueue_script('hideseek_js', get_template_directory_uri() . "/anps-framework/js/jquery.hideseek.min.js", array('jquery'), false, true);
    wp_enqueue_script('wp_backend_js', get_template_directory_uri() . "/anps-framework/js/wp_backend.js", array('jquery'), false, true);
    wp_register_script('wp_colorpicker', get_template_directory_uri() . "/anps-framework/js/wp_colorpicker.js", array('wp-color-picker'), false, true);
    if ('appearance_page_theme_options' != $hook) {
        return;
    }

    $custom_css = anps_custom_styles_buttons();
    wp_add_inline_style('wp-backend', $custom_css);

    /* Theme Options Style */
    wp_register_script("clipboard", get_template_directory_uri() . '/anps-framework/js/clipboard.min.js', array('jquery'));
    wp_enqueue_style("admin-style", get_template_directory_uri() . '/anps-framework/css/admin-style.css');
    wp_enqueue_style("colorpicker", get_template_directory_uri() . '/anps-framework/css/colorpicker.css');
    wp_enqueue_script("pattern", get_template_directory_uri() . "/anps-framework/js/pattern.js");
    wp_enqueue_script("colorpicker_theme", get_template_directory_uri() . "/anps-framework/js/colorpicker.js");
    wp_enqueue_script("colorpicker_custom", get_template_directory_uri() . "/anps-framework/js/colorpicker_custom.js");
    wp_enqueue_script("contact", get_template_directory_uri() . "/anps-framework/js/contact.js");
    if (isset($_GET['sub_page']) && $_GET['sub_page'] == "contact_form") {
        wp_enqueue_script("contact", get_template_directory_uri() . "/anps-framework/js/contact.js");
    }
    wp_enqueue_script("theme-options", get_template_directory_uri() . "/anps-framework/js/theme-options.js");
    wp_localize_script('theme-options', 'anps', array(
        'theme_url' => get_template_directory_uri(),
    ));
}
add_action('admin_enqueue_scripts', 'anps_load_custom_wp_admin_scripts');


/*************************/
/*WOOCOMMERCE*/
/*************************/
if (class_exists('WooCommerce', false)) {
    add_theme_support('woocommerce');
    remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
    remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

    function anps_woocommerce_widget_shopping_cart_button_view_cart()
    {
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="btn wc-forward">' . esc_html__('View cart', 'woocommerce') . '</a>';
    }
    function anps_woocommerce_widget_shopping_cart_proceed_to_checkout()
    {
        echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="btn checkout wc-forward">' . esc_html__('Checkout', 'woocommerce') . '</a>';
    }
    add_action('woocommerce_widget_shopping_cart_buttons', 'anps_woocommerce_widget_shopping_cart_button_view_cart', 10);
    add_action('woocommerce_widget_shopping_cart_buttons', 'anps_woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

    function anps_woocommerce_cart_item_quantity($product_quantity, $cart_item_key, $cart_item)
    {
        return str_replace('</div>', '<input type="button" value="+" class="plus"><input type="button" value="-" class="minus"></div>', $product_quantity);
    }
    add_filter('woocommerce_cart_item_quantity', 'anps_woocommerce_cart_item_quantity', 10, 3);

    if (get_option('anps_product_zoom', '1') == '1') {
        add_theme_support('wc-product-gallery-zoom');
    }
    if (get_option('anps_product_lightbox', '1') == '1') {
        add_theme_support('wc-product-gallery-lightbox');
    }
    add_theme_support('wc-product-gallery-slider');

    add_filter('woocommerce_enqueue_styles', '__return_false');

    function anps_products_per_page()
    {
        return get_option('anps_products_per_page', '12');
    }
    add_filter('loop_shop_per_page', 'anps_products_per_page', 20);


    function anps_loop_columns()
    {
        return get_option('anps_woo_columns', '4');
    }
    add_filter('loop_shop_columns', 'anps_loop_columns');

    function anps_woocommerce_header()
    {
        global $woocommerce;
        global $anps_shop_data;
        if (isset($anps_shop_data['shop_hide_cart']) && $anps_shop_data['shop_hide_cart'] === "on") {
            return '';
        }
        ?>
        <div class="woo-header-cart" id="anps-mini-cart">
            <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'transport'); ?>"><span><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span> <i class="fa fa-shopping-cart"></i></a>
        </div>
        <?php
    }

    // Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
    add_filter('woocommerce_add_to_cart_fragments', 'anps_woocommerce_add_to_cart_fragments');
    function anps_woocommerce_add_to_cart_fragments($fragments)
    {
        global $woocommerce;
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();
        $fragments['#anps-mini-cart'] = sprintf(
            '<div class="woo-header-cart" id="anps-mini-cart">
                <a class="cart-contents" href="%s" title="%s"><span>%d</span> <i class="fa fa-shopping-cart"></i></a>
                <div class="mini-cart">%s</div>
            </div>',
            wc_get_cart_url(),
            esc_html__('View your shopping cart', 'transport'),
            $woocommerce->cart->cart_contents_count,
            $mini_cart
        );
        return $fragments;
    }

    define("WOOCOMMERCE_USE_CSS", false);

    add_filter('woocommerce_output_related_products_args', 'jk_related_products_args');
    function jk_related_products_args($args)
    {
        global $anps_shop_data;
        /* old code, there are no such and option in theme options */
        if (!isset($anps_shop_data['shop_related_per_page']) || $anps_shop_data['shop_related_per_page'] == "") {
            $per_page = 3;
        } else {
            $per_page = $anps_shop_data['shop_related_per_page'];
        }
        $args['posts_per_page'] = $per_page;
        return $args;
    }

    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10, 0);
    add_filter('woocommerce_show_page_title', '__return_false');

    function anps_before_loop_open()
    {
        echo '<div class="woocommerce-before-loop">';
    }
    add_action('woocommerce_before_shop_loop', 'anps_before_loop_open', 15);

    function anps_before_loop_close()
    {
        echo '</div>';
    }
    add_action('woocommerce_before_shop_loop', 'anps_before_loop_close', 40);

    /* Remove add to cart button */
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 0);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5, 0);


    /* Pagination */
    function filter_woocommerce_pagination_args($array)
    {
        $array['prev_text'] = '';
        $array['next_text'] = '';
        return $array;
    };

    add_filter('woocommerce_pagination_args', 'filter_woocommerce_pagination_args', 10, 1);
    add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display', 20);

    /* Replaces content-product-cat.php template override */
    function anps_product_cat_class($classes)
    {
        switch (get_option('anps_woo_columns', '4')) {
            case '2':
                $classes[] = 'col-sm-6';
                break;
            case '3':
                $classes[] = 'col-sm-4';
                break;
            default:
                $classes[] = 'col-sm-3';
        }
        return $classes;
    }
    add_filter('product_cat_class', 'anps_product_cat_class');

    /* Replaces global/breadcrumb.php template override */
    function anps_woocommerce_breadcrumb_defaults($args)
    {
        $args['before'] = '<li>';
        $args['after'] = '</li>';
        $args['delimiter'] = '';
        return $args;
    }
    add_filter('woocommerce_breadcrumb_defaults', 'anps_woocommerce_breadcrumb_defaults');
}
/*************************/
/*END WOOCOMMERCE*/
/*************************/

/* Set Revolution Slider as Theme */
if (function_exists('set_revslider_as_theme')) {
    add_action('init', 'anps_set_rev_as_theme');
    function anps_set_rev_as_theme()
    {
        set_revslider_as_theme();
    }
}

/* Change comment form position (WordPress 4.4) */
function anps_comment_field_to_bottom($fields)
{
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter('comment_form_fields', 'anps_comment_field_to_bottom');

/* WooCommerce 2.5 remove link around products */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

function anps_cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'anps_cc_mime_types');

/* Remove Newsletter styling */
add_filter('newsletter_enqueue_style', '__return_false');

function anps_parse_sidebars_from_meta($meta, $fallback_for = 'page')
{
    $left_sidebar = false;
    $right_sidebar = false;
    $num_of_sidebars = 0;

    if ($meta === false) {
        $left_option = get_option("anps_{$fallback_for}_sidebar_left", '0');
        $left_sidebar = $left_option !== '0' ? $left_option : false;
        $right_option = get_option("anps_{$fallback_for}_sidebar_right", '0');
        $right_sidebar = $right_option !== '0' ? $right_option : false;
    } else {
        if (isset($meta['sbg_selected_sidebar']) && is_array($meta['sbg_selected_sidebar']) && count($meta['sbg_selected_sidebar'])) {
            $option = $meta['sbg_selected_sidebar'][0] === '0' // when 0, single doesn't override globals so get that
                ? get_option("anps_{$fallback_for}_sidebar_left", '0')
                : $meta['sbg_selected_sidebar'][0];
            $left_sidebar = $option !== '0' && $option !== '-1' ? $option : false;
        }
        if (isset($meta['sbg_selected_sidebar_replacement']) && is_array($meta['sbg_selected_sidebar_replacement']) && count($meta['sbg_selected_sidebar_replacement'])) {
            $option = $meta['sbg_selected_sidebar_replacement'][0] === '0'
                ? get_option("anps_{$fallback_for}_sidebar_right", '0')
                : $meta['sbg_selected_sidebar_replacement'][0];
            $right_sidebar = $option !== '0' && $option !== '-1' ? $option : false;
        }
    }

    if ($left_sidebar) {
        $num_of_sidebars++;
    }
    if ($right_sidebar) {
        $num_of_sidebars++;
    }

    return array(
        'left_sidebar' => $left_sidebar,
        'right_sidebar' => $right_sidebar,
        'num_of_sidebars' => $num_of_sidebars
    );
}

function anps_sidebar_html($sidebar)
{
    ?>
    <aside class="sidebar col-md-3">
        <?php dynamic_sidebar($sidebar); ?>
    </aside>
    <?php
}

function anps_left_sidebar($id)
{
    $meta = get_post_meta($id);
    $sidebars = anps_parse_sidebars_from_meta($meta);
    if ($sidebars['left_sidebar']) {
        anps_sidebar_html($sidebars['left_sidebar']);
    }
}

function anps_right_sidebar($id)
{
    $meta = get_post_meta($id);
    $sidebars = anps_parse_sidebars_from_meta($meta);
    if ($sidebars['right_sidebar']) {
        anps_sidebar_html($sidebars['right_sidebar']);
    }
}

function anps_num_sidebars($id)
{
    $meta = get_post_meta($id);
    $sidebars = anps_parse_sidebars_from_meta($meta);
    return $sidebars['num_of_sidebars'];
}
/** Add Gutenberg editor styles */
function apns_block_editor_style_override()
{
    $rtl_suffix = is_rtl() ? '-rtl' : '';
    wp_enqueue_style('anps_block_editor_style', get_template_directory_uri() . '/css/block-editor-style' . $rtl_suffix . '.css', array('wp-block-editor'));

    // Load google font if needed
    $fonts = array();
    if (get_option('font_source_1') === 'Google fonts') {
        $fonts[] = urldecode(get_option('font_type_1', 'Montserrat'));
    }
    if (get_option('font_source_2') === 'Google fonts') {
        $fonts[] = urldecode(get_option('font_type_2', 'PT+Sans'));
    }
    $google_fonts = anps_get_google_fonts_uri(array_unique($fonts));
    wp_enqueue_style('editor_google_fonts', $google_fonts, array(), null);

    // Load CSS from theme configuration
    $theme_css = anps_custom_block_editor_styles();
    wp_add_inline_style('anps_block_editor_style', $theme_css);
}
add_action('enqueue_block_editor_assets', 'apns_block_editor_style_override');

function anps_admin_notices()
{
    if (class_exists('FortAwesome\FontAwesome_Loader', false)) : ?>
        <div class="notice notice-error is-dismissible">
            <p><?php printf(esc_html__('%sFont Awesome%s ships with the theme therefore the plugin should be %sdeactivated%s and/or removed.', 'transport'), '<b>', '</b>', '<a href="' . admin_url('plugins.php') . '">', '</a>'); ?></p>
        </div>
    <?php endif;
}
add_action('admin_notices', 'anps_admin_notices');

/** Disable widgets block support */
function disable_widgets_block_support()
{
    remove_theme_support('widgets-block-editor');
}
add_action('after_setup_theme', 'disable_widgets_block_support');
