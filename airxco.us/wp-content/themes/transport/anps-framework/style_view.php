<?php
include_once get_template_directory() . '/anps-framework/classes/Style.php';

/* Save form */
if (isset($_GET['save_style'])) {
    $style->save();
}

$all_fonts = $style->get_fonts();

$font_options = array(
    'font_type_1' => array(
        __('Font type 1', 'transport'),
        get_option('font_type_1', 'Montserrat')
    ),
    'font_type_2' => array(
        __('Font type 2', 'transport'),
        get_option('font_type_2', 'PT+Sans')
    ),
    'font_type_navigation' => array(
        __('Navigation font type', 'transport'),
        get_option('font_type_navigation', 'Montserrat')
    )
);
?>
<div class="content">
    <form action="themes.php?page=theme_options&save_style" method="post">
        <div class="content-top">
            <input type="submit" value="<?php esc_html_e("Save all changes", 'transport'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php esc_html_e("Font family", 'transport'); ?></h3>
            <h4><?php esc_html_e('Custom font styles', 'transport'); ?></h4>

            <?php foreach ($font_options as $type => $data) : ?>
            <div class="input onethird">
                <label for="<?php echo esc_attr($type); ?>"><?php esc_html($data[0]); ?></label>
                <select name="<?php echo esc_attr($type); ?>" id="<?php echo esc_attr($type); ?>">
                <?php foreach ($all_fonts as $group => $fonts) : ?>
                    <optgroup label="<?php echo esc_attr($group); ?>">
                    <?php foreach ($fonts as $font) printf(
                        '<option value="%s"%s>%s</option>',
                        esc_attr($font['value'] . '|' . $group),
                        $font['value'] === $data[1] ? ' selected' : '',
                        esc_attr($font['name'])
                    ); ?>
                    </optgroup>
                <?php endforeach; ?>
                </select>
            </div>
            <?php endforeach; ?>

            <div class="clear"></div>
            <!-- Font sizes -->
            <h3><?php esc_html_e('Font sizes', 'transport'); ?></h3>
            <div class="input onequarter">
                <label for="anps_body_font_size"><?php esc_html_e('Body Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_body_font_size" value="<?php echo esc_attr(anps_get_option('', '14', 'body_font_size')); ?>" id="anps_body_font_size" placeholder="14" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_menu_font_size"><?php esc_html_e('Menu Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_menu_font_size" value="<?php echo esc_attr(anps_get_option('', '14', 'menu_font_size')); ?>" id="anps_menu_font_size" placeholder="14" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h1_font_size"><?php esc_html_e('Content Heading 1 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_h1_font_size" value="<?php echo esc_attr(anps_get_option('', '31', 'h1_font_size')); ?>" id="anps_h1_font_size" placeholder="31" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h2_font_size"><?php esc_html_e('Content Heading 2 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_h2_font_size" value="<?php echo esc_attr(anps_get_option('', '24', 'h2_font_size')); ?>" id="anps_h2_font_size" placeholder="24" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h3_font_size"><?php esc_html_e('Content Heading 3 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_h3_font_size" value="<?php echo esc_attr(anps_get_option('', '21', 'h3_font_size')); ?>" id="anps_h3_font_size" placeholder="21" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h4_font_size"><?php esc_html_e('Content Heading 4 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_h4_font_size" value="<?php echo esc_attr(anps_get_option('', '18', 'h4_font_size')); ?>" id="anps_h4_font_size" placeholder="18" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_h5_font_size"><?php esc_html_e('Content Heading 5 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_h5_font_size" value="<?php echo esc_attr(anps_get_option('', '16', 'h5_font_size')); ?>" id="anps_h5_font_size" placeholder="16" /><span>px</span>

            </div>
            <div class="input onequarter">
                <label for="anps_page_heading_h1_font_size"><?php esc_html_e('Page Heading 1 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_page_heading_h1_font_size" value="<?php echo esc_attr(anps_get_option('', '24', 'page_heading_h1_font_size')); ?>" id="anps_page_heading_h1_font_size" placeholder="24" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_blog_heading_h1_font_size"><?php esc_html_e('Single blog page heading 1 Font Size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_blog_heading_h1_font_size" value="<?php echo esc_attr(get_option('', '28', 'blog_heading_h1_font_size')); ?>" id="anps_blog_heading_h1_font_size" placeholder="28" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="anps_top_bar_font_size"><?php esc_html_e('Top bar font size', 'transport'); ?></label>
                <input class="size" type="text" name="anps_top_bar_font_size" value="<?php echo esc_attr(get_option('anps_top_bar_font_size', '14')); ?>" id="anps_top_bar_font_size" placeholder="14" /><span>px</span>
            </div>
            <div class="clear"></div>
            <!-- Color schemes -->
            <h3><?php esc_html_e('Predefined color Scheme', 'transport'); ?></h3>
            <h4><?php esc_html_e('Choose a predefined colour scheme', 'transport'); ?></h4>
            <p><?php esc_html_e('Selecting one of this schemes will import the predefined colors below, which you can then edit as you like.', 'transport'); ?></p>
            <div class="clear"></div>
            <div class="fullwidth" id="predefined_colors">
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="default" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#153d5c;"></span><span class="colorspantext"><?php esc_html_e('Default', 'transport'); ?></span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="light_blue" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#4ab9cf;"></span><span class="colorspantext"><?php esc_html_e('Light blue', 'transport'); ?></span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="green" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#74b830;"></span><span class="colorspantext"><?php esc_html_e('Green', 'transport'); ?></span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="red" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#bf2626;"></span><span class="colorspantext"><?php esc_html_e('Red', 'transport'); ?></span></div>
                </label>

                <div class="clear"></div>
            </div>
            <!-- Main theme colors -->
            <h3><?php esc_html_e('Main theme colors', 'transport'); ?></h3>
            <h4><?php esc_html_e('Set your custom colors', 'transport'); ?></h4>
            <p><?php esc_html_e('Not satisfied with the premade color schemes? Here you can set your custom colors.', 'transport'); ?></p>
            <div class="input onequarter">
                <label for="anps_text_color"><?php esc_html_e('Text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#727272', 'text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#727272', 'text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_text_color" value="<?php echo esc_attr(anps_get_option('', '#727272', 'text_color')); ?>" id="anps_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_primary_color"><?php esc_html_e('Primary color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#292929', 'primary_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#292929', 'primary_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_primary_color" value="<?php echo esc_attr(anps_get_option('', '#292929', 'primary_color')); ?>" id="anps_primary_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_hovers_color"><?php esc_html_e('Hovers color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'hovers_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'hovers_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_hovers_color" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'hovers_color')); ?>" id="anps_hovers_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_headings_color"><?php esc_html_e('Headings color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'headings_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'headings_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_headings_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'headings_color')); ?>" id="anps_headings_color" />
            </div>

            <div class="input onequarter">
                <label for="anps_main_divider_color"><?php esc_html_e('Main divider color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_main_divider_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_main_divider_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_main_divider_color" value="<?php echo esc_attr(get_option('anps_main_divider_color', '')); ?>" id="anps_main_divider_color" />
            </div>


            <div class="input onequarter">
                <label for="anps_side_submenu_background_color"><?php esc_html_e('Side submenu background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_background_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '', 'side_submenu_background_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_side_submenu_background_color" value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_background_color')); ?>" id="anps_side_submenu_background_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_side_submenu_text_color"><?php esc_html_e('Side submenu text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_side_submenu_text_color" value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_color')); ?>" id="anps_side_submenu_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_side_submenu_text_hover_color"><?php esc_html_e('Side submenu text hover color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_side_submenu_text_hover_color" value="<?php echo esc_attr(anps_get_option('', '', 'side_submenu_text_hover_color')); ?>" id="anps_side_submenu_text_hover_color" />
            </div>
            <p>&nbsp;</p>
            <div class="clear"></div>

            <h3><?php esc_html_e('Header colors', 'transport'); ?></h3>
            <div class="input onequarter">
                <label for="anps_menu_text_color"><?php esc_html_e('Menu text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'menu_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'menu_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_menu_text_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'menu_text_color')); ?>" id="anps_menu_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_top_bar_color"><?php esc_html_e('Top bar text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#c1c1c1', 'top_bar_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#c1c1c1', 'top_bar_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_top_bar_color" value="<?php echo esc_attr(anps_get_option('', '#c1c1c1', 'top_bar_color')); ?>" id="anps_top_bar_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_top_bar_bg_color"><?php esc_html_e('Top bar background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#f9f9f9', 'top_bar_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#f9f9f9', 'top_bar_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_top_bar_bg_color" value="<?php echo esc_attr(anps_get_option('', '#f9f9f9', 'top_bar_bg_color')); ?>" id="anps_top_bar_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_nav_background_color"><?php esc_html_e('Page header background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'nav_background_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'nav_background_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_nav_background_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'nav_background_color')); ?>" id="anps_nav_background_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_submenu_background_color"><?php esc_html_e('Submenu background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'submenu_background_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'submenu_background_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_submenu_background_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'submenu_background_color')); ?>" id="anps_submenu_background_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_curent_menu_color"><?php esc_html_e('Selected main menu color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_curent_menu_color', '#153d5c')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_curent_menu_color', '#153d5c')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_curent_menu_color" value="<?php echo esc_attr(get_option('anps_curent_menu_color', '#153d5c')); ?>" id="anps_curent_menu_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_submenu_text_color"><?php esc_html_e('Submenu text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'submenu_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'submenu_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_submenu_text_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'submenu_text_color')); ?>" id="anps_submenu_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_woo_cart_items_number_bg_color"><?php esc_html_e('Cart number background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_woo_cart_items_number_bg_color" value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#26507a')); ?>" id="anps_woo_cart_items_number_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_woo_cart_items_number_color"><?php esc_html_e('Cart number text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_woo_cart_items_number_color" value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" id="anps_woo_cart_items_number_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_logo_bg_color"><?php esc_html_e('Logo background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_logo_bg_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_logo_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_logo_bg_color" value="<?php echo esc_attr(get_option('anps_logo_bg_color')); ?>" id="anps_logo_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_above_menu_bg_color"><?php esc_html_e('Above menu background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_above_menu_bg_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_above_menu_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_above_menu_bg_color" value="<?php echo esc_attr(get_option('anps_above_menu_bg_color')); ?>" id="anps_above_menu_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_page_heading_bg_color"><?php esc_html_e('Page heading background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_page_heading_bg_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_page_heading_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_page_heading_bg_color" value="<?php echo esc_attr(get_option('anps_page_heading_bg_color')); ?>" id="anps_page_heading_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_page_heading_text_color"><?php esc_html_e('Page heading text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_page_heading_text_color')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_page_heading_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_page_heading_text_color" value="<?php echo esc_attr(get_option('anps_page_heading_text_color')); ?>" id="anps_page_heading_text_color" />
            </div>
            <p>&nbsp;</p>
            <div class="clear"></div>

            <h3><?php esc_html_e('Footer colors', 'transport'); ?></h3>
            <div class="input onequarter">
                <label for="anps_footer_bg_color"><?php esc_html_e('Footer background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#0f0f0f', 'footer_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#0f0f0f', 'footer_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_bg_color" value="<?php echo esc_attr(anps_get_option('', '#0f0f0f', 'footer_bg_color')); ?>" id="anps_footer_bg_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_text_color"><?php esc_html_e('Footer text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#c4c4c4', 'footer_text_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#c4c4c4', 'footer_text_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_text_color" value="<?php echo esc_attr(anps_get_option('', '#c4c4c4', 'footer_text_color')); ?>" id="anps_footer_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_heading_text_color"><?php esc_html_e('Footer heading text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_heading_text_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_heading_text_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_heading_text_color" value="<?php echo esc_attr(get_option('anps_heading_text_color', '#fff')); ?>" id="anps_heading_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_selected_color"><?php esc_html_e('Footer selected color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_selected_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_selected_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_selected_color" value="<?php echo esc_attr(get_option('anps_footer_selected_color', '')); ?>" id="anps_footer_selected_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_hover_color"><?php esc_html_e('Footer hover color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_hover_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_hover_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_hover_color" value="<?php echo esc_attr(get_option('anps_footer_hover_color', '')); ?>" id="anps_footer_hover_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_footer_divider_color"><?php esc_html_e('Footer divider color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_footer_divider_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_footer_divider_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_footer_divider_color" value="<?php echo esc_attr(get_option('anps_footer_divider_color', '#fff')); ?>" id="anps_footer_divider_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_copyright_footer_text_color"><?php esc_html_e('Copyright footer text color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_copyright_footer_text_color', '#c4c4c4')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_copyright_footer_text_color', '#242424')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_copyright_footer_text_color" value="<?php echo esc_attr(get_option('anps_copyright_footer_text_color', '#c4c4c4')); ?>" id="anps_copyright_footer_text_color" />
            </div>
            <div class="input onequarter">
                <label for="anps_copyright_footer_bg_color"><?php esc_html_e('Copyright footer background color', 'transport'); ?></label>
                <input data-value="<?php echo esc_attr(anps_get_option('', '#242424', 'copyright_footer_bg_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#242424', 'copyright_footer_bg_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_copyright_footer_bg_color" value="<?php echo esc_attr(anps_get_option('', '#242424', 'copyright_footer_bg_color')); ?>" id="anps_copyright_footer_bg_color" />
            </div>
            <p>&nbsp;</p>
            <div class="clear"></div>
            <!-- Button styles -->
            <h3><?php esc_html_e('Button styles', 'transport'); ?></h3>
            <div class="input fullwidth">
                <p><?php esc_html_e('Button styles will refresh after clicking "Save all changes".', 'transport'); ?></p>
                <hr>
                <div class="fullwidth">
                    <h4><?php esc_html_e('Default button', 'transport'); ?></h4>
                    <a class="btn btn-sm" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_bg"><?php esc_html_e('Default button background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'default_button_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'default_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_bg" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'default_button_bg')); ?>" id="anps_default_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_color"><?php esc_html_e('Default button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'default_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_color')); ?>" id="anps_default_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_hover_bg"><?php esc_html_e('Default button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#292929', 'default_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#292929', 'default_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#292929', 'default_button_hover_bg')); ?>" id="anps_default_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_default_button_hover_color"><?php esc_html_e('Default button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'default_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_default_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'default_button_hover_color')); ?>" id="anps_default_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button style-1', 'transport'); ?></h4>
                    <a class="btn btn-sm style-1" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_bg"><?php esc_html_e('button background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_1_button_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'style_1_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_bg" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_1_button_bg')); ?>" id="anps_style_1_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_color')); ?>" id="anps_style_1_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_hover_bg"><?php esc_html_e('button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'style_1_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'style_1_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#000', 'style_1_button_hover_bg')); ?>" id="anps_style_1_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_1_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_1_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_1_button_hover_color')); ?>" id="anps_style_1_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button style-2', 'transport'); ?></h4>
                    <a class="btn btn-sm style-2" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_bg"><?php esc_html_e('button background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'style_2_button_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'style_2_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_bg" value="<?php echo esc_attr(anps_get_option('', '#000', 'style_2_button_bg')); ?>" id="anps_style_2_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_color')); ?>" id="anps_style_2_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_hover_bg"><?php esc_html_e('button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_2_button_hover_bg')); ?>" id="anps_style_2_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_2_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'style_2_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'style_2_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_2_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#000', 'style_2_button_hover_color')); ?>" id="anps_style_2_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button style-3', 'transport'); ?></h4>
                    <a class="btn btn-sm style-3" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_color')); ?>" id="anps_style_3_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_hover_bg"><?php esc_html_e('button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_hover_bg')); ?>" id="anps_style_3_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_3_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'style_3_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_3_button_hover_color')); ?>" id="anps_style_3_button_hover_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_3_button_border_color"><?php esc_html_e('button border color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_border_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_border_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_3_button_border_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_3_button_border_color')); ?>" id="anps_style_3_button_border_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button style-4', 'transport'); ?></h4>
                    <a class="btn btn-sm style-4" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_4_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_4_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'style_4_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_4_button_color" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_4_button_color')); ?>" id="anps_style_4_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_4_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#94cfff', 'style_4_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#94cfff', 'style_4_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_4_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#94cfff', 'style_4_button_hover_color')); ?>" id="anps_style_4_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button slider', 'transport'); ?></h4>
                    <a class="btn btn-sm slider" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_bg"><?php esc_html_e('button background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_slider_button_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'style_slider_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_bg" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'style_slider_button_bg')); ?>" id="anps_style_slider_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_color')); ?>" id="anps_style_slider_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_hover_bg"><?php esc_html_e('button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'style_slider_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'style_slider_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#000', 'style_slider_button_hover_bg')); ?>" id="anps_style_slider_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_slider_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_slider_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_slider_button_hover_color')); ?>" id="anps_style_slider_button_hover_color" />
                </div>
                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button style-5', 'transport'); ?></h4>
                    <a class="btn btn-sm style-5" href="#"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_bg"><?php esc_html_e('button background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#c3c3c3', 'style_style_5_button_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#c3c3c3', 'style_style_5_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_bg" value="<?php echo esc_attr(anps_get_option('', '#c3c3c3', 'style_style_5_button_bg')); ?>" id="anps_style_style_5_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_color')); ?>" id="anps_style_style_5_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_hover_bg"><?php esc_html_e('button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#737373', 'style_style_5_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#737373', 'style_style_5_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#737373', 'style_style_5_button_hover_bg')); ?>" id="anps_style_style_5_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_style_style_5_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_style_style_5_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'style_style_5_button_hover_color')); ?>" id="anps_style_style_5_button_hover_color" />
                </div>

                <div class="clear"></div>
                <hr>
            </div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php esc_html_e('Button for header style-6', 'transport'); ?></h4>
                    <a class="btn btn-sm menu-button" href="#" style="border-radius: 0;"><?php esc_html_e('Button', 'transport'); ?></a>
                </div>
                <div class="input onequarter">
                    <label for="anps_header_style_6_button_bg"><?php esc_html_e('button background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'anps_header_style_6_button_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#1874c1', 'anps_header_style_6_button_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_header_style_6_button_bg" value="<?php echo esc_attr(anps_get_option('', '#1874c1', 'anps_header_style_6_button_bg')); ?>" id="anps_header_style_6_button_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_header_style_6_button_color"><?php esc_html_e('button color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'anps_header_style_6_button_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'anps_header_style_6_button_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_header_style_6_button_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'anps_header_style_6_button_color')); ?>" id="anps_header_style_6_button_color" />
                </div>
                <div class="input onequarter">
                    <label for="anps_header_style_6_button_hover_bg"><?php esc_html_e('button hover background', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#000', 'anps_header_style_6_button_hover_bg')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#000', 'anps_header_style_6_button_hover_bg')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_header_style_6_button_hover_bg" value="<?php echo esc_attr(anps_get_option('', '#000', 'anps_header_style_6_button_hover_bg')); ?>" id="anps_header_style_6_button_hover_bg" />
                </div>
                <div class="input onequarter">
                    <label for="anps_header_style_6_button_hover_color"><?php esc_html_e('button hover color', 'transport'); ?></label>
                    <input data-value="<?php echo esc_attr(anps_get_option('', '#fff', 'anps_header_style_6_button_hover_color')); ?>" readonly style="background: <?php echo esc_attr(anps_get_option('', '#fff', 'anps_header_style_6_button_hover_color')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_header_style_6_button_hover_color" value="<?php echo esc_attr(anps_get_option('', '#fff', 'anps_header_style_6_button_hover_color')); ?>" id="anps_header_style_6_button_hover_color" />
                </div>

                <div class="clear"></div>
                <hr>
            </div>
        </div>
        <div class="clear"></div>
        <div class="content-top" style="border-style: solid none">
            <input type="submit" value="<?php esc_html_e('Save all changes', 'transport'); ?>">
            <div class="clear"></div>
        </div>
        <div class="submit-right">
            <button type="submit" class="fixsave fixed fontawesome"><i class="fa fa-floppy-o"></i></button>
            <div class="clear"></div>
    </form>
    <div class="clear"></div>
</div>