<?php
include_once get_template_directory() . '/anps-framework/classes/Framework.php';

class Dummy extends Framework {

    public function select() {
        return get_option('anps_dummy');
    }

    public function save() {
        include_once get_template_directory() . '/anps-framework/classes/AnpsImport.php';
        $dummy_xml = "dummy1";
        if (isset($_POST['dummy2'])) {
            $dummy_xml = "dummy2";
        } elseif(isset($_POST['dummy3'])) {
            $dummy_xml = "dummy3";
        } elseif(isset($_POST['dummy4'])) {
            $dummy_xml = "dummy4";
        } elseif(isset($_POST['dummy5'])) {
            $dummy_xml = "dummy5";
        } elseif(isset($_POST['dummy6'])) {
            $dummy_xml = "dummy6";
        } elseif(isset($_POST['dummy7'])) {
            $dummy_xml = "dummy7";
        } elseif(isset($_POST['dummy8'])) {
            $dummy_xml = "dummy8";
        }

        /* Set dummy to 1 */
        update_option('anps_dummy', '1');

        $import_dir = get_template_directory() . "/anps-framework/classes/importer/{$dummy_xml}";

        /* Import theme options */
        $anps_import_export->import_theme_options($import_dir . '/anps-theme-options.json');

        /* Import dummy xml */
        include_once WP_PLUGIN_DIR . '/anps_theme_plugin/importer/wordpress-importer.php';
        $parse = new ANPS_Import();
        $parse->import($import_dir . '/dummy.xml');

        update_option('anps_post_meta_categories', '');
        update_option('anps_post_meta_author', '');

        $posts_page = get_page_by_title("News") ?: get_page_by_title("Blog");
        $front_page = get_page_by_title("Home");
        if ($posts_page) {
            update_option('page_for_posts', $posts_page->ID);
        }
        if ($front_page) {
            update_option('page_on_front', $front_page->ID);
            update_option('show_on_front', 'page');
            update_post_meta($front_page->ID, 'anps_header_options_footer_margin', 'on');
        }

        global $wp_rewrite;
        update_option('permalink_structure', '/%postname%/');
        $wp_rewrite->set_permalink_structure('/%postname%/');
        $wp_rewrite->flush_rules();

        /* Remove duplicate Woocommerce pages */
        if (class_exists('WooCommerce', false)) {
            $woo_pages = array_filter(array(
                get_option('woocommerce_shop_page_id'),
                get_option('woocommerce_cart_page_id'),
                get_option('woocommerce_checkout_page_id'),
                get_option('woocommerce_myaccount_page_id')
            ));
            foreach ($woo_pages as $woo_page) {
                $post_obj = get_post(intval($woo_page));
                $duplicated_import = get_posts(array('post_type' => 'page', 'name' => "{$post_obj->post_name}-2"));
                if (!empty($duplicated_import)) wp_delete_post($duplicated_import[0]->ID, true);
            }
        }

        /* Set menu as primary */
        $menu_id = wp_get_nav_menus();
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id[0]->term_id;
        set_theme_mod('nav_menu_locations', $locations);
        update_option('menu_check', true);

        /* Add WooCommerce shop page to menu */
        if (class_exists('WooCommerce', false)) {
            $woo_shop_page = get_option('woocommerce_shop_page_id');
            if ($woo_shop_page) {
                wp_update_nav_menu_item($menu_id[0]->term_id, 0, array(
                    'menu-item-status'    => 'publish',
                    'menu-item-type'      => 'post_type',
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => intval($woo_shop_page)
                ));
            }
        }

        /* Install all widgets */
        update_option('sidebars_widgets', array());
        $anps_import_export->import_widgets_data($import_dir . '/anps-widgets.txt');

        /* Add revolution slider demo data */
        $this->__add_revslider($import_dir . '/main-slider.zip');

        // Clear any cached theme options styles
        delete_transient('anps_theme_options_styles');
        delete_transient('anps_theme_options_styles_css');
        delete_transient('anps_theme_options_buttons');
        delete_transient('anps_theme_options_buttons_css');
    }

    protected function __add_revslider($zip) {
        if (class_exists('RevSlider', false)) {
            $slider = new RevSlider();
            $slider->importSliderFromPost(true, true, $zip);
        } else {
            echo "Revolution slider is not active. Demo data for revolution slider can't be inserted.";
        }
    }
}

$dummy = new Dummy();
