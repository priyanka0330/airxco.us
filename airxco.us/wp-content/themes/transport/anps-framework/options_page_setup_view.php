<?php
include_once 'classes/Options.php';
$anps_page_data = $options->get_page_setup_data();
if (isset($_GET['save_page_setup'])) {
    $options->save_page_setup();
}
?>
<form action="themes.php?page=theme_options&sub_page=options_page_setup&save_page_setup" method="post">
    <div class="content-top">
        <input type="submit" value="<?php esc_html_e('Save all changes', 'transport'); ?>" />
        <div class="clear"></div>
    </div>
    <div class="content-inner">
        <!-- Page setup -->
        <h3><?php esc_html_e('Page setup', 'transport'); ?></h3>
        <!-- Coming soon page -->
        <div class="input onehalf">
            <label for="anps_coming_soon"><?php esc_html_e('Coming soon page', 'transport'); ?></label>
            <select name="anps_coming_soon" id="anps_coming_soon">
                <option value="0"><?php esc_html_e('*** Select ***', 'transport'); ?></option>
                <?php $pages = get_pages();
                foreach ($pages as $item) : ?>
                    <option value="<?php echo esc_attr($item->ID); ?>" <?php if (anps_get_option($anps_page_data, 'coming_soon') == $item->ID) {
                                                                            echo esc_attr('selected');
                                                                        } else {
                                                                            echo '';
                                                                        } ?>><?php echo esc_html($item->post_title); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Error page -->
        <div class="input onehalf">
            <label for="anps_error_page"><?php esc_html_e('404 error page', 'transport'); ?></label>
            <select name="anps_error_page" id="anps_error_page">
                <option value="0"><?php esc_html_e('*** Select ***', 'transport'); ?></option>
                <?php $pages = get_pages();
                foreach ($pages as $item) : ?>
                    <option value="<?php echo esc_attr($item->ID); ?>" <?php if (anps_get_option($anps_page_data, 'error_page') == $item->ID) {
                                                                            echo esc_attr('selected');
                                                                        } else {
                                                                            echo '';
                                                                        } ?>><?php echo esc_html($item->post_title); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('WooCommerce', 'transport'); ?></h3>
        <div class="input onethird">
            <label for="anps_shopping_cart_header"><?php esc_html_e('Display shopping cart icon in header?', 'transport'); ?></label>
            <select name="anps_shopping_cart_header" id="anps_shopping_cart_header">
                <?php $pages = array("hide" => 'Never display', "shop_only" => 'only on Woo pages', "always" => 'Display everywhere');
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', 'shop_only', 'shopping_cart_header') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input onethird">
            <label for="anps_woo_columns"><?php esc_html_e('Shop pages product columns', 'transport'); ?></label>
            <select name="anps_woo_columns">
                <?php $pages = array('2' => esc_html__('2 columns', 'transport'), '3' => esc_html__('3 columns', 'transport'), '4' => esc_html__('4 columns', 'transport'));
                foreach ($pages as $key => $item) :
                    $selected = '';
                    if ($key == get_option('anps_woo_columns', '4')) {
                        $selected = 'selected';
                    }
                ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- WooCommerce products per page -->
        <div class='input onethird'>
            <label for='anps_products_per_page'><?php esc_html_e('Products per page', 'transport'); ?></label>
            <input type='text' value='<?php echo get_option('anps_products_per_page', '12'); ?>' name='anps_products_per_page' id='anps_products_per_page' />
        </div>
        <div class="clear"></div>
        <!-- WooCommerce Product Zoom -->
        <div class="input onethird">
            <label for="anps_product_zoom"><?php esc_html_e('Product image zoom', 'transport'); ?></label>
            <input type='hidden' value='' name='anps_product_zoom' />
            <input id="anps_product_zoom" class="small_input" value="1" style="margin-left: 25px" type="checkbox" name="anps_product_zoom" <?php if (get_option('anps_product_zoom', '1') == "1") {
                                                                                                                                                echo esc_attr('checked');
                                                                                                                                            } else {
                                                                                                                                                echo '';
                                                                                                                                            } ?> />
        </div>
        <!-- WooCommerce Product image lightbox -->
        <div class="input onethird">
            <label for="anps_product_zoom"><?php esc_html_e('Product image lightbox', 'transport'); ?></label>
            <input type='hidden' value='' name='anps_product_lightbox' />
            <input id="anps_product_lightbox" class="small_input" value="1" style="margin-left: 25px" type="checkbox" name="anps_product_lightbox" <?php if (get_option('anps_product_lightbox', '1') == "1") {
                                                                                                                                                        echo esc_attr('checked');
                                                                                                                                                    } else {
                                                                                                                                                        echo '';
                                                                                                                                                    } ?> />
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('Portfolio', 'transport'); ?></h3>
        <!-- Portfolio single style -->
        <div class="input onethird">
            <label for="anps_portfolio_single"><?php esc_html_e('Portfolio single style', 'transport'); ?></label>
            <select name="anps_portfolio_single" id="anps_portfolio_single">
                <?php $pages = array('style-1' => esc_html__('Style 1', 'transport'), 'style-2' => esc_html__('Style 2', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', '', 'portfolio_single') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Portfolio single footer -->
        <div class="input twothird">
            <label for="anps_portfolio_single_footer"><?php esc_html_e('Portfolio single footer', 'transport'); ?></label>
            <?php $value2 = anps_get_option('', '', 'portfolio_single_footer');
            wp_editor(str_replace('\\"', '"', $value2), 'anps_portfolio_single_footer', array(
                'wpautop' => true,
                'media_buttons' => false,
                'textarea_name' => 'anps_portfolio_single_footer',
                'textarea_rows' => 10,
                'teeny' => true
            )); ?>
        </div>
        <div class="clear"></div>
        <!-- Menu -->
        <h3><?php esc_html_e('Front page Top Menu', 'transport'); ?></h3>
        <!-- Menu -->
        <div class="input fullwidth" id="headerstyle">
            <?php
            $i = 1;
            $images_array = array(
                'top-transparent-menu',
                'top-background-menu',
                'bottom-transparent-menu',
                'bottom-background-menu',
                'full-length-menu',
                'boxed-menu',
            );
            foreach ($images_array as $item) :
            ?>
                <label class="onequarter" id="head-<?php echo esc_attr($i); ?>"><input type="radio" name="anps_menu_type" value="<?php echo esc_attr($i); ?>" <?php if (get_option('anps_menu_type', 2) == $i) {
                                                                                                                                                                    echo " checked";
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                } ?>><img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/<?php echo esc_html($item); ?>.jpg"></label>
            <?php $i++;
            endforeach; ?>
        </div>
        <!-- Hidden -->
        <div class="anps_menu_type_font fullwidth ">
            <div class="input onethird">
                <label for="anps_front_text_color"><?php esc_html_e('Text color', 'transport'); ?></label>
                <input data-value="<?php echo get_option('anps_front_text_color'); ?>" readonly style="background: <?php echo get_option('anps_front_text_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_text_color" value="<?php echo get_option('anps_front_text_color'); ?>" id="anps_front_text_color" />
            </div>
            <div class="input onethird">
                <label for="anps_front_text_hover_color"><?php esc_html_e('Text hover color', 'transport'); ?></label>
                <input data-value="<?php echo get_option('anps_front_text_hover_color'); ?>" readonly style="background: <?php echo get_option('anps_front_text_hover_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_text_hover_color" value="<?php echo get_option('anps_front_text_hover_color'); ?>" id="anps_front_text_hover_color" />
            </div>
            <div class="input onethird">
                <label for="anps_front_curent_menu_color"><?php esc_html_e('Selected main menu color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_front_curent_menu_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_front_curent_menu_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_curent_menu_color" value="<?php echo esc_attr(get_option('anps_front_curent_menu_color', '')); ?>" id="anps_curent_menu_color" />
            </div>
            <div class="onoff input head-2 head-4 head-5 head-6 onethird">
                <label for="anps_front_bg_color"><?php esc_html_e('Background color', 'transport'); ?></label>
                <input data-value="<?php echo get_option('anps_front_bg_color'); ?>" readonly style="background: <?php echo get_option('anps_front_bg_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_bg_color" value="<?php echo get_option('anps_front_bg_color'); ?>" id="anps_front_bg_color" />
            </div>
            <div class="onoff input head-1 onethird">
                <label for="anps_front_topbar_color"><?php esc_html_e('Front page top bar color', 'transport'); ?></label>
                <input data-value="<?php echo get_option('anps_front_topbar_color'); ?>" readonly style="background: <?php echo get_option('anps_front_topbar_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_topbar_color" value="<?php echo get_option('anps_front_topbar_color'); ?>" id="anps_front_topbar_color" />
            </div>
            <div class="onoff input head-1 onethird">
                <label for="anps_front_topbar_bg_color"><?php esc_html_e('Front page top bar background color', 'transport'); ?></label>
                <input data-value="<?php echo get_option('anps_front_topbar_bg_color'); ?>" readonly style="background: <?php echo get_option('anps_front_topbar_bg_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_topbar_bg_color" value="<?php echo get_option('anps_front_topbar_bg_color'); ?>" id="anps_front_topbar_bg_color" />
            </div>
            <div class="onoff input head-1 onethird">
                <label for="anps_front_topbar_hover_color"><?php esc_html_e('Front page top bar link hover color', "transport"); ?></label>
                <input data-value="<?php echo get_option('anps_front_topbar_hover_color'); ?>" readonly style="background: <?php echo get_option('anps_front_topbar_hover_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_topbar_hover_color" value="<?php echo get_option('anps_front_topbar_hover_color'); ?>" id="anps_front_topbar_hover_color" />
            </div>

            <div class="onoff input head-1 head-3 twothirds">
                <label for="anps_front_logo"><?php esc_html_e('Front page logo', 'transport'); ?></label>
                <input id="anps_front_logo" type="text" size="36" name="anps_front_logo" value="<?php echo get_option('anps_front_logo'); ?>" />
                <input id="_btn" class="upload_image_button width-105" type="button" value="Upload" />
                <p class="fullwidth"><?php esc_html_e('This option is meant for logo color adjustments if needed. Please make sure, the logo is exact same size as logo on other pages.', 'transport'); ?></p>
                <div class="clear"></div>
            </div>
            <div class="onoff input head-5 head-6 twothirds">
                <label for="anps_large_above_menu_style"><?php esc_html_e('Large above menu style', 'transport'); ?></label>
                <select name="anps_large_above_menu_style" id="anps_above_nav_bar">
                    <?php $items = array('1' => esc_html__('Style 1', 'transport'), '2' => esc_html__('Style 2', 'transport'));
                    foreach ($items as $key => $item) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('anps_large_above_menu_style') == $key) {
                                                                            echo esc_attr('selected');
                                                                        } else {
                                                                            echo '';
                                                                        } ?>><?php echo esc_attr($item); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="onoff input head-6 fullwidth">
                <div class="onethird dimm-master">
                    <label for="anps_menu_button"><?php esc_html_e('Menu button', 'transport'); ?></label>
                    <input type="hidden" value="" name="anps_menu_button" />
                    <input id="anps_menu_button" value="1" class="small_input" type="checkbox" name="anps_menu_button" <?php if (get_option('anps_menu_button') != '') {
                                                                                                                            echo esc_attr('checked');
                                                                                                                        } else {
                                                                                                                            echo '';
                                                                                                                        } ?> />
                </div>
                <div class="onethird dimm">
                    <label for="anps_menu_button_text"><?php esc_html_e('Menu button text', 'transport'); ?></label>
                    <input type="text" name="anps_menu_button_text" id="anps_menu_button_text" value="<?php echo get_option('anps_menu_button_text', ''); ?>" />
                </div>
                <div class="onethird dimm">
                    <label for="anps_menu_button_url"><?php esc_html_e('Menu button url', 'transport'); ?></label>
                    <input type="text" name="anps_menu_button_url" id="anps_menu_button_url" value="<?php echo get_option('anps_menu_button_url', ''); ?>" />
                </div>
            </div>
        </div>
        <div class="onoff anps_full_screen input fullwidth head-3 head-4">
            <label for="anps_full_screen"><?php esc_html_e('Full screen content', 'transport'); ?></label>
            <?php $value2 = get_option('anps_full_screen', '');
            wp_editor(str_replace('\\"', '"', $value2), 'anps_full_screen', array(
                'wpautop' => true,
                'media_buttons' => false,
                'textarea_name' => 'anps_full_screen',
                'textarea_rows' => 10,
                'teeny' => true
            )); ?>
            <p style="margin-top: 20px;">
                <?php printf(esc_html__('%s Important! %s The textarea above is meant for the slider shortcode. It will be shown on the home page before the rest of the site. Add slider shortcode inside the content area above for tis menu type to work. %s If you imported our demo, you will also need to remove the slider on your homepage and remove the negative margin on first row (check the screenshot below).', 'transport'), '<h2>', '</h2>', '<br>'); ?><br />
            </p>
        </div>
        <!-- END Hidden -->
        <div class="clearfix"></div>
        <h3><?php esc_html_e('General Top Menu Settings', 'transport'); ?></h3>
        <!-- Top menu -->
        <div class="input onequarter">
            <label for="anps_topmenu_style"><?php esc_html_e('Display top bar?', 'transport'); ?></label>
            <select name="anps_topmenu_style" id="anps_topmenu_style">
                <?php $pages = array('1' => esc_html__('Yes', 'transport'), '2' => esc_html__('Only on tablet/mobile', 'transport'), '4' => esc_html__('Only on desktop', 'transport'), '3' => esc_html('No', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', '', 'topmenu_style') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class='input onequarter'>
            <label for='anps_top_bar_height'><?php esc_html_e('Top bar height in pixels', 'transport'); ?></label>
            <input type='text' value='<?php echo get_option('anps_top_bar_height', '60'); ?>' name='anps_top_bar_height' id='anps_top_bar_height' />

        </div>
        <div class="input onequarter">
            <label for="anps_above_nav_bar"><?php esc_html_e('Display above menu bar?', 'transport'); ?></label>
            <select name="anps_above_nav_bar" id="anps_above_nav_bar">
                <?php $pages = array('1' => esc_html__('Yes', 'transport'), '0' => esc_html__('No', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('anps_above_nav_bar') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input onequarter">
            <label for="anps_menu_style"><?php esc_html_e('Menu', 'transport'); ?></label>
            <select name="anps_menu_style" id="anps_menu_style">
                <?php $pages = array('1' => esc_html__('Normal', 'transport'), '2' => esc_html__('Description', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', '', 'menu_style') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Menu centered -->
        <div class="input onequarter">
            <label for="anps_menu_center"><?php esc_html_e('Menu centered', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_menu_center" />
            <input id="anps_menu_center" value="1" class="small_input" type="checkbox" name="anps_menu_center" <?php if (anps_get_option('', '', 'menu_center') != "") {
                                                                                                                    echo esc_attr('checked');
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                } ?> />
        </div>
        <!-- Sticky menu -->
        <div class="input onequarter">
            <label for="anps_sticky_menu"><?php esc_html_e('Sticky menu', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_sticky_menu" />
            <input id="anps_sticky_menu" value="1" class="small_input" type="checkbox" name="anps_sticky_menu" <?php if (anps_get_option('', '', 'sticky_menu') != "") {
                                                                                                                    echo esc_attr('checked');
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                } ?> />
        </div>
        <div class="input onequarter">
            <label for="anps_search_icon"><?php esc_html_e('Display search icon in menu (desktop)?', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_search_icon" />
            <input id="anps_search_icon" value="1" class="small_input" type="checkbox" name="anps_search_icon" <?php if (anps_get_option('', 'on', 'search_icon') != "") {
                                                                                                                    echo esc_attr('checked');
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                } ?> />
        </div>
        <div class="input onequarter">
            <label for="anps_search_icon_mobile"><?php esc_html_e('Display search on mobile and tablets?', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_search_icon_mobile" />
            <input id="anps_search_icon_mobile" value="1" class="small_input" type="checkbox" name="anps_search_icon_mobile" <?php if (anps_get_option('', 'on', 'search_icon_mobile') != "") {
                                                                                                                                    echo esc_attr('checked');
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?> />
        </div>
        <div class="input onequarter">
            <label for="anps_global_menu_walker"><?php esc_html_e('Enable menu walker (mega menu)', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_global_menu_walker" />
            <input id="anps_global_menu_walker" value="1" class="small_input" type="checkbox" name="anps_global_menu_walker" <?php if (get_option('anps_global_menu_walker', '1') != "") {
                                                                                                                                    echo esc_attr('checked');
                                                                                                                                } else {
                                                                                                                                    echo '';
                                                                                                                                } ?> />
        </div>
        <div class="input onequarter">
            <label for="anps_logo_background"><?php esc_html_e('Display background color behind logo', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_logo_background" />
            <input id="anps_logo_background" value="1" class="small_input" type="checkbox" name="anps_logo_background" <?php if (get_option('anps_logo_background', '1') != "") {
                                                                                                                            echo esc_attr('checked');
                                                                                                                        } else {
                                                                                                                            echo '';
                                                                                                                        } ?> />
        </div>
        <div class="clear"></div>
        <!-- Main menu settings -->
        <h3><?php esc_html_e('Main menu settings', 'transport'); ?></h3>
        <div class='input onequarter'>
            <label for='anps_main_menu_height'><?php esc_html_e('Main menu height in pixels', 'transport'); ?></label>
            <input type='text' value='<?php echo get_option('anps_main_menu_height', ''); ?>' name='anps_main_menu_height' id='anps_main_menu_height' />
        </div>
        <div class="input onequarter">
            <label for="anps_main_menu_selection"><?php esc_html_e('Dropdown selection states', 'transport'); ?></label>
            <select id="anps_main_menu_selection" name="anps_main_menu_selection">
                <option value="0" <?php if (get_option('anps_main_menu_selection', '0') == '0') {
                                        echo ' ' . esc_attr('selected');
                                    } ?>><?php esc_html_e('Hover color & bottom border', 'transport'); ?></option>
                <option value="1" <?php if (get_option('anps_main_menu_selection', '0') == '1') {
                                        echo ' ' . esc_attr('selected');
                                    } ?>><?php esc_html_e('Hover color', 'transport'); ?></option>
            </select>
        </div>
        <div class="clear"></div>
        <!-- Prefooter -->
        <h3><?php esc_html_e('Prefooter', 'transport'); ?></h3>
        <div class="input onehalf">
            <label for="anps_prefooter"><?php esc_html_e("Prefooter", "transport"); ?></label>
            <input type="hidden" value="" name="anps_prefooter" />
            <input id="anps_prefooter" value="1" class="small_input" type="checkbox" name="anps_prefooter" <?php if (anps_get_option('', '', 'prefooter') != "") {
                                                                                                                echo esc_attr('checked');
                                                                                                            } else {
                                                                                                                echo '';
                                                                                                            } ?> />
        </div>
        <div class="input onehalf">
            <label for="anps_prefooter_style"><?php esc_html_e('Prefooter style', 'transport'); ?></label>
            <select name="anps_prefooter_style" id="anps_prefooter_style">
                <option value="0"><?php esc_html_e('*** Select ***', 'transport'); ?></option>
                <?php $pages = array('5' => esc_html__('2/3 + 1/3', 'transport'), '6' => esc_html__('1/3 + 2/3', 'transport'), '2' => esc_html__('2 columns', 'transport'), '3' => esc_html('3 columns', 'transport'), '4' => esc_html__('4 columns', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', '', 'prefooter_style') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('Footer', 'transport'); ?></h3>
        <!-- Disable footer -->
        <div class="input onethird">
            <label for="anps_footer_disable"><?php esc_html_e('Disable footer', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_footer_disable" />
            <input id="anps_footer_disable" class="small_input" type="checkbox" name="anps_footer_disable" <?php if (anps_get_option('', '', 'footer_disable') != "") {
                                                                                                                echo esc_attr('checked');
                                                                                                            } else {
                                                                                                                echo '';
                                                                                                            } ?> />
        </div>
        <!-- Footer style -->
        <div class="input onethird">
            <label for="anps_footer_style"><?php esc_html_e('Footer columns', 'transport'); ?></label>
            <select name="anps_footer_style" id="anps_footer_style">
                <option value="0"><?php esc_html_e('*** Select ***', 'transport'); ?></option>
                <?php $pages = array('2' => esc_html__('2 columns', 'transport'), '3' => esc_html__('3 columns', 'transport'), '4' => esc_html('4 columns', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', '', 'footer_style') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Footer style -->
        <div class="input onethird">
            <label for="anps_footer_widget_style"><?php esc_html_e('Footer style', 'transport'); ?></label>
            <select name="anps_footer_widget_style" id="anps_footer_widget_style">
                <?php $pages = array('1' => esc_html__('style 1', 'transport'), '2' => esc_html__('style 2', 'transport'), '3' => esc_html__('style 3', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('anps_footer_widget_style', '1') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Copyright footer -->
        <div class="input onethird">
            <label for="anps_copyright_footer"><?php esc_html_e('Copyright footer', 'transport'); ?></label>
            <select name="anps_copyright_footer">
                <option value="0"><?php esc_html_e('*** Select ***', 'transport'); ?></option>
                <?php $pages = array('1' => esc_html__('1 column', 'transport'), '2' => esc_html__('2 columns', 'transport'));
                foreach ($pages as $key => $item) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php if (anps_get_option('', '', 'copyright_footer') == $key) {
                                                                        echo esc_attr('selected');
                                                                    } else {
                                                                        echo '';
                                                                    } ?>><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('Visual composer', 'transport'); ?></h3>
        <p><?php esc_html_e('Only for backwards compatibility. Do not use on fresh install.', 'transport'); ?></p>
        <!-- Legacy mode -->
        <div class="input onethird">
            <?php
            if (get_option('anps_vc_legacy') == "on") {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            ?>
            <label for="anps_vc_legacy"><?php esc_html_e('Legacy mode', 'transport'); ?></label>
            <input type="hidden" value="" name="anps_vc_legacy" />
            <input id="anps_vc_legacy" class="small_input" type="checkbox" name="anps_vc_legacy" <?php echo esc_attr($checked); ?> />
        </div>
        <!-- END Legacy mode -->
        <div class="clear"></div>
        <!-- Post meta enable/disable -->
        <h3><?php esc_html_e('Disable Post meta elements', 'transport'); ?></h3>
        <p><?php esc_html_e('This allows you to disable post meta on all blog elements and pages. By default no field is checked, so that all meta elements are displayed.', 'transport'); ?></p>

        <?php
        $post_meta_arr = array(
            'anps_post_meta_comments'   => 'Comments',
            'anps_post_meta_categories' => 'Categories',
            'anps_post_meta_author'     => 'Author',
            'anps_post_meta_date'       => 'Date'
        );
        ?>
        <?php foreach ($post_meta_arr as $key => $item) : ?>
            <div class="input onequarter">
                <label for="<?php echo esc_attr($key); ?>"><?php echo esc_attr($item); ?></label>
                <input type='hidden' value='' name='<?php echo esc_attr($key); ?>' />
                <input type="checkbox" value='1' name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" <?php checked(get_option($key), "1") ?> />
            </div>
        <?php endforeach; ?>

        <div class="clear"></div>
    </div>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php esc_html_e('Save all changes', 'transport'); ?>">
        <div class="clear"></div>
    </div>
    <div class="submit-right">
        <button type="submit" class="fixsave fixed fontawesome"><i class="fa fa-floppy-o"></i></button>
        <div class="clear"></div>
</form>