<?php

function anps_get_custom_styles() {
    // Try to get from cache

    $styles = get_transient('anps_theme_options_styles');
    if ($styles !== false) return $styles;

    $styles = array();
    /**
     * Get font family styles from theme options
     */
    // Set default font styles
    $styles['font_1'] = 'Montserrat';
    $styles['font_1_source'] = 'Google fonts';

    $styles['font_2'] = 'PT Sans';
    $styles['font_2_source'] = 'Google fonts';

    $styles['font_3'] = 'Montserrat';
    $styles['font_3_source'] = 'Google fonts';

    $styles['logo_font'] = 'Arial, sans-serif';
    $styles['logo_font_source'] = 'System fonts';

    // Adjust default font families based on theme options
    $valid_font_sources = array('System fonts', 'Custom fonts', 'Google fonts');

    $font_1_source = get_option('font_source_1');
    if (in_array($font_1_source, $valid_font_sources)) {
        $styles['font_1'] = urldecode(get_option('font_type_1'));
        $styles['font_1_source'] = $font_1_source;
    }

    $font_2_source = get_option('font_source_2');
    if (in_array($font_2_source, $valid_font_sources)) {
        $styles['font_2'] = urldecode(get_option('font_type_2'));
        $styles['font_2_source'] = $font_2_source;
    }

    $font_3_source = get_option('font_source_navigation');
    if (in_array($font_3_source, $valid_font_sources)) {
        $styles['font_3'] = urldecode(get_option('font_type_navigation'));
        $styles['font_3_source'] = $font_3_source;
    }

    // Adjust logo font based on theme options
    $logo_font_option = explode('|', get_option('anps_text_logo_font', ''));
    if (isset($logo_font_option[1])) {
        $styles['logo_font'] = urldecode($logo_font_option[0]);
        $styles['logo_font_source'] = $logo_font_option[1];
    }

    /**
     * Get font size styles from theme options
     */
    $styles['body_font_size'] = anps_get_option('', '14', 'body_font_size') ?: '14';
    $styles['menu_font_size'] = anps_get_option('', '14', 'menu_font_size') ?: '14';
    $styles['h1_font_size'] = anps_get_option('', '31', 'h1_font_size') ?: '31';
    $styles['h2_font_size'] = anps_get_option('', '24', 'h2_font_size') ?: '24';
    $styles['h3_font_size'] = anps_get_option('', '21', 'h3_font_size') ?: '21';
    $styles['h4_font_size'] = anps_get_option('', '18', 'h4_font_size') ?: '18';
    $styles['h5_font_size'] = anps_get_option('', '16', 'h5_font_size') ?: '16';
    $styles['page_heading_h1_font_size'] = anps_get_option('', '24', 'page_heading_h1_font_size') ?: '24';
    $styles['blog_heading_h1_font_size'] = anps_get_option('', '28', 'blog_heading_h1_font_size') ?: '28';

    /**
     * Get all colors from theme options
     */
    $styles['text_color'] = anps_get_option('', '#727272', 'text_color');
    $styles['primary_color'] = anps_get_option('', '#292929', 'primary_color');
    $styles['hovers_color'] = anps_get_option('', '#1874c1', 'hovers_color');
    $styles['menu_text_color'] = anps_get_option('', '#000000', 'menu_text_color');
    $styles['headings_color'] = anps_get_option('', '#000000', 'headings_color');
    $styles['footer_bg_color'] = anps_get_option('', '#242424', 'footer_bg_color');
    $styles['top_bar_color'] = anps_get_option('', '#c1c1c1', 'top_bar_color');
    $styles['top_bar_bg_color'] = anps_get_option('', '#f9f9f9', 'top_bar_bg_color');
    $styles['copyright_footer_text_color'] = get_option('anps_copyright_footer_text_color', '#c4c4c4');
    $styles['copyright_footer_bg_color'] = anps_get_option('', '#0f0f0f', 'copyright_footer_bg_color');
    $styles['nav_background_color'] = anps_get_option('', '#fff', 'nav_background_color');
    $styles['footer_text_color'] = anps_get_option('', '#d9d9d9', 'footer_text_color');
    $styles['footer_selected_color'] = get_option('anps_footer_selected_color', '');
    $styles['footer_hover_color'] = get_option('anps_footer_hover_color', '');
    $styles['footer_divider_color'] = get_option('anps_footer_divider_color', '#fff');
    $styles['submenu_background_color'] = anps_get_option('', '#fff', 'submenu_background_color');
    $styles['submenu_text_color'] = anps_get_option('', '#000', 'submenu_text_color');
    $styles['side_submenu_background_color'] = anps_get_option('', '#fff', 'side_submenu_background_color');
    $styles['side_submenu_text_color'] = anps_get_option('', '#000', 'side_submenu_text_color');
    $styles['side_submenu_text_hover_color'] = anps_get_option('', '#1874c1', 'side_submenu_text_hover_color');
    $styles['anps_logo_bg_color'] = get_option('anps_logo_bg_color', '');
    $styles['anps_above_menu_bg_color'] = get_option('anps_above_menu_bg_color', '#fff');
    $styles['anps_woo_cart_items_number_bg_color'] = get_option('anps_woo_cart_items_number_bg_color', $styles['primary_color']);
    $styles['anps_woo_cart_items_number_color'] = get_option('anps_woo_cart_items_number_color', '#fff');
    $styles['anps_heading_text_color'] = get_option('anps_heading_text_color', '#fff');
    $styles['curent_menu_color'] = get_option('anps_curent_menu_color', '#153d5c');
    $styles['page_heading_color'] = get_option('anps_page_heading_text_color', $styles['headings_color']);

    $styles['page_heading_single_color'] = is_404()
        ? get_post_meta(get_option('anps_error_page'), 'anps_heading_front_color', true)
        : get_post_meta(get_queried_object_id(), 'anps_heading_front_color', true);

    if ($styles['page_heading_single_color']) {
        $styles['page_heading_color'] = $styles['page_heading_single_color'];
    }

    $styles['main_divider_color'] = get_option('anps_main_divider_color', '');

    $styles['anps_front_text_color'] = get_option('anps_front_text_color', '');
    if (!$styles['anps_front_text_color']) {
        $styles['anps_front_text_color'] = $styles['menu_text_color'];
    }

    $styles['anps_front_curent_menu_color'] = get_option('anps_front_curent_menu_color', '');
    if (!$styles['anps_front_curent_menu_color']) {
        $styles['anps_front_curent_menu_color'] = $styles['curent_menu_color'];
    }

    $styles['anps_front_text_hover_color'] = get_option('anps_front_text_hover_color', '');
    if (!$styles['anps_front_text_hover_color']) {
        $styles['anps_front_text_hover_color'] = $styles['hovers_color'];
    }

    if (is_front_page() && get_option('anps_menu_type', '2') == '1' && get_option('anps_front_topbar_bg_color', '') != '') {
        $styles['top_bar_bg_color'] = get_option('anps_front_topbar_bg_color', '');
    }

    if (is_front_page() && get_option('anps_menu_type', '2') == '1' && get_option('anps_front_topbar_color', '') != '') {
        $styles['top_bar_color'] = get_option('anps_front_topbar_color', '');
    }

    $styles['anps_front_bg_color'] = get_option('anps_front_bg_color', '');
    $styles['anps_front_topbar_color'] = get_option('anps_front_topbar_color', '#fff');
    $styles['anps_front_topbar_bg_color'] = get_option('anps_front_topbar_bg_color', '');
    $styles['anps_front_topbar_hover_color'] = get_option('anps_front_topbar_hover_color', '#1874c1');

    /**
     * Get any other styles from theme options
     */
    $styles['container_width'] = intval(get_option('anps_container_width', '1170'));

    // Cache results
    set_transient('anps_theme_options_styles', $styles);

    // Return all styles in array format
    return $styles;
}

function anps_custom_styles() {
    // Try cache because compiling and formatting this css string is expensive
    $css = get_transient('anps_theme_options_styles_css');
    if ($css !== false && !empty($css)) return $css;

    $styles = anps_get_custom_styles();

    // Collect all CSS into a variable so we can cache it
    ob_start();

    // Print @font-face styles for custom (uploaded) fonts
    if ($styles['font_1_source'] === 'Custom fonts') {
        echo anps_custom_font($styles['font_1']);
    }
    if ($styles['font_2_source'] === 'Custom fonts') {
        echo anps_custom_font($styles['font_2']);
    }
    if ($styles['font_3_source'] === 'Custom fonts') {
        echo anps_custom_font($styles['font_3']);
    }
    if ($styles['logo_font_source'] === 'Custom fonts') {
        echo anps_custom_font($styles['logo_font']);
    }

    $menu_type = get_option('anps_menu_type', '2') ?: '2';
    $is_menu_type_1_or_3 = $menu_type === '1' || $menu_type === '3';

    $styles['anps_menu_height'] = get_option('anps_main_menu_height', '');
    $styles['anps_top_bar_height'] = get_option('anps_top_bar_height', '60') ?: '60';

    global $anps_media_data, $anps_page_data;

    // Output CSS to apply theme options styles
    ?>
    <?php if ($styles['primary_color']) : ?>
    ::selection, .timeline-item:before { background-color: <?php echo esc_attr($styles['primary_color']); ?>; color: #fff; }
    <?php endif; if ($styles['text_color']) : ?>
    body,
    ol.list > li > *,
    .product_meta span span {
        color: <?php echo esc_attr($styles['text_color']); ?>;
    }
    <?php endif; if ($styles['container_width']) : ?>
    @media (min-width: <?php echo esc_attr($styles['container_width'] + 30); ?>px) {
        .container {
            width: <?php echo esc_attr($styles['container_width']); ?>px;
        }
    }
    <?php endif; if ($styles['text_color']) : ?>
    .testimonials .testimonial-owl-nav button:hover {
        background: <?php echo esc_attr($styles['text_color']); ?>;
    }
    <?php endif; ?>

    @media(min-width: 992px) {
        <?php if ($styles['anps_above_menu_bg_color']) : ?>
        .site-header-style-boxed,
        .site-header-style-full-width {
            background-color: <?php echo esc_attr($styles['anps_above_menu_bg_color']); ?>;
        }
        <?php endif; if ($styles['menu_text_color']) : ?>
        .woo-header-cart .cart-contents > i,
        .nav-wrap .site-search-toggle,
        .nav-bar .site-search-toggle,
        .site-navigation a,
        .home .site-header-sticky-active .site-navigation .menu-item-depth-0 > a,
        .paralax-header .site-header-style-transparent.site-header-sticky-active .site-navigation .menu-item-depth-0 > a:not(:hover):not(:focus),
        .nav-empty {
            color: <?php echo esc_attr($styles['menu_text_color']); ?>;
        }
        <?php endif; ?>
    }

    <?php if ($styles['nav_background_color']) : ?>
    .site-header-style-normal .nav-wrap {
        background-color: <?php echo esc_attr($styles['nav_background_color']); ?>;
    }
    <?php endif; ?>

    @media(min-width: 992px) {
        <?php if ($styles['submenu_background_color']) : ?>
        .site-navigation .sub-menu {
            background-color: <?php echo esc_attr($styles['submenu_background_color']); ?>;
        }
        <?php endif; if ($styles['submenu_text_color']) : ?>
        .site-navigation .sub-menu a {
            color: <?php echo esc_attr($styles['submenu_text_color']); ?>;
        }
        <?php endif; ?>
    }
    <?php if ($styles['main_divider_color']) : ?>
    .heading-left.divider-sm span:before,
    .heading-middle.divider-sm span:before,
    .heading-left.divider-lg span:before,
    .heading-middle.divider-lg span:before {
        background-color: <?php echo esc_attr($styles['main_divider_color']); ?>;
    }
    <?php endif; ?>

    <?php if ($styles['hovers_color']) : ?>
    .site-navigation a:hover, .site-navigation a:focus,
    .testimonials.style-4 ul.testimonial-wrap .jobtitle,
    .testimonials.style-3 + .owl-navigation .owlnext:hover, .testimonials.style-3 + .owl-navigation .owlnext:focus,
    .testimonials.style-3 + .owl-navigation .owlprev:hover, .testimonials.style-3 + .owl-navigation .owlprev:focus,
    .testimonials.style-3 .testimonial-user {
        color: <?php echo esc_attr($styles['hovers_color']); ?>;
    }
    <?php endif; if ($styles['curent_menu_color']) : ?>
    .site-navigation .current-menu-item > a, .home .site-navigation .current-menu-item > a,
    .home .site-header.site-header-sticky-active .menu-item-depth-0.current-menu-item > a {
        color: <?php echo esc_attr($styles['curent_menu_color']); ?>;
    }
    <?php endif; ?>

    @media(min-width: 992px) {
        <?php if ($styles['hovers_color']) : ?>
        .site-search-toggle:hover, .site-search-toggle:focus, .site-navigation ul:not(.sub-menu) > li > a:hover,
        .site-navigation ul:not(.sub-menu) > li > a:focus{
            color: <?php echo esc_attr($styles['hovers_color']); ?>;
        }
        <?php endif; if ($styles['anps_front_bg_color']) : ?>
        .site-header-style-boxed .nav-bar-wrapper {
            background-color: <?php echo esc_attr($styles['anps_front_bg_color']); ?>;
        }
        <?php endif; ?>
    }

    @media(max-width: 991px) {
        <?php if ($styles['hovers_color']) : ?>
        .site-search-toggle:hover, .site-search-toggle:focus,
        .navbar-toggle:hover, .navbar-toggle:focus {
            background-color: <?php echo esc_attr($styles['hovers_color']); ?>;
        }
        <?php endif; if ($styles['hovers_color']) : ?>
        .site-search-toggle,
        .navbar-toggle {
            background-color: <?php echo esc_attr($styles['primary_color']); ?>;
        }
        <?php endif; ?>
    }

    <?php if (get_option('anps_menu_type', '2') == 1 || get_option('anps_menu_type', '2') == 3) : ?>
        <?php if ($styles['anps_front_text_color']) : ?>
        @media(min-width: 992px) {
            .home .site-navigation .menu-item-depth-0 > a, .home header:not(.site-header-sticky-active) .site-search-toggle:not(:hover):not(:focus),
            .nav-empty {
                color: <?php echo esc_attr($styles['anps_front_text_color']); ?>;
            }
        }
        <?php endif; if ($styles['anps_front_text_hover_color']) : ?>
        .home .site-header .menu-item-depth-0 > a:hover,
        .home .site-header .menu-item-depth-0 > a:focus {
            color: <?php echo esc_attr($styles['anps_front_text_hover_color']); ?>;
        }
        <?php endif; ?>
    <?php else : ?>
        <?php if ($styles['anps_front_bg_color']) : ?>
        .site-header-style-normal .nav-wrap {
            background-color: <?php echo esc_attr($styles['anps_front_bg_color']); ?>;
        }
        <?php endif; ?>
        @media(min-width: 992px) {
            <?php if ($styles['anps_front_bg_color']) : ?>
            .site-header-style-full-width.site-header-sticky-active .header-wrap,
            .site-header-style-full-width .header-wrap {
                background-color: <?php echo esc_attr($styles['anps_front_bg_color']); ?>;
            }
            <?php endif; if ($styles['anps_front_text_color']) : ?>
            .home .site-navigation ul:not(.sub-menu) > li > a,
            .home .nav-empty,
            .home header:not(.site-header-sticky-active) .woo-header-cart .cart-contents > i,
            .home header:not(.site-header-sticky-active) .site-search-toggle {
                color: <?php echo esc_attr($styles['anps_front_text_color']); ?>;
            }
            <?php endif; ?>
        }
        <?php if ($styles['anps_front_text_hover_color']) : ?>
        .site-navigation a:hover,
        .site-navigation a:focus,
        .site-navigation .current-menu-item > a,
        .home .site-navigation ul:not(.sub-menu) > li > a:hover,
        .home .site-navigation ul:not(.sub-menu) > li > a:focus,
        .home header:not(.site-header-sticky-active) .site-search-toggle:hover {
            color: <?php echo esc_attr($styles['anps_front_text_hover_color']); ?>;
        }
        <?php endif; ?>
    <?php endif; ?>

    @media(min-width: 992px) {
        <?php if ($styles['anps_front_curent_menu_color']) : ?>
        .home .site-header .menu-item-depth-0.current-menu-item > a {
            color: <?php echo esc_attr($styles['anps_front_curent_menu_color']); ?>;
        }
        <?php endif; if ($styles['anps_front_text_hover_color']) : ?>
        .home .site-search-toggle:focus,
        .home .site-search-toggle:hover {
            color: <?php echo esc_attr($styles['anps_front_text_hover_color']); ?>;
        }
        <?php endif; ?>
    }

    .top-bar {
        <?php if ($styles['top_bar_bg_color']) : ?>
        background-color: <?php echo esc_attr($styles['top_bar_bg_color']); ?>;
        <?php endif; ?>
        <?php if ($styles['top_bar_color']) : ?>
        color: <?php echo esc_attr($styles['top_bar_color']); ?>;
        <?php endif; ?>
    }

    <?php if ($styles['top_bar_color']) : ?>
    .top-bar a:not(:hover) {
        color: <?php echo esc_attr($styles['top_bar_color']); ?>;
    }
    <?php endif; ?>

    <?php if (is_front_page() && $styles['anps_front_topbar_hover_color']) : ?>
        .top-bar a:hover,
        .top-bar a:focus {
            color: <?php echo esc_attr($styles['anps_front_topbar_hover_color']); ?> !important;
        }
    <?php endif; ?>

    <?php //top bar font size
    ?>
    .top-bar, .top-bar a {
        font-size: <?php echo esc_attr(get_option('anps_top_bar_font_size', '14')); ?>px;
    }

    <?php if ($styles['primary_color']) : ?>
    a,
    .btn-link,
    .error-404 h2,
    .page-heading,
    .statement .style-3,
    .dropcaps.style-2:first-letter,
    .list li:before,
    ol.list,
    .post.style-2 header > span,
    .post.style-2 header .fa,
    .page-numbers span,
    .team .socialize a,
    blockquote.style-2:before,
    .panel-group.style-2 .panel-title a:before,
    .contact-info i,
    blockquote.style-1:before,
    .faq .panel-title a.collapsed:before,
    .faq .panel-title a:after,
    .faq .panel-title a,
    .filter-style-1 button.selected,
    .primary,
    .search-posts i,
    .counter .counter-number,
    #wp-calendar th,
    #wp-calendar caption,
    .testimonials blockquote p:before,
    .testimonials blockquote p:after,
    .price,
    .widget-price,
    .star-rating,
    .sidebar .widget_shopping_cart .quantity,
    .tab-pane .commentlist .meta strong, .woocommerce-tabs .commentlist .meta strong,
    .widget_recent_comments .recentcomments a:not(:hover),
    .timeline-year,
    .featured-has-icon:hover .featured-title i,
    .featured-has-icon:focus .featured-title i,
    .featured-has-icon.simple-style .featured-title i,
    a.featured-lightbox-link,
    .large-above-menu-style-2 .important {
        color: <?php echo esc_attr($styles['primary_color']); ?>;
    }

    .heading-middle span:before,
    .heading-left span:before,
    .featured-has-icon .featured-title:before,
    .large-above-menu-style-2 .widget_anpssocial a:hover,
    .large-above-menu-style-2 .widget_anpssocial a:focus,
    .woocommerce-product-gallery__trigger {
        background-color: <?php echo esc_attr($styles['primary_color']); ?>;
    }
    <?php endif; ?>

    .testimonials.white blockquote p:before,
    .testimonials.white blockquote p:after {
        color: #fff;
    }

    <?php if ($styles['footer_text_color']) : ?>
    .site-footer, .site-footer h3, .site-footer h4,
    .site-footer .widget_recent_comments .recentcomments a:not(:hover) {
    color: <?php echo esc_attr($styles['footer_text_color']); ?>;
    }
    <?php endif; if ($styles['footer_selected_color']) : ?>
    .site-footer .row .menu .current_page_item > a {
        color: <?php echo esc_attr($styles['footer_selected_color']); ?>;
    }
    <?php endif; if ($styles['footer_hover_color']) : ?>
    .site-footer .row a:hover,
    .site-footer .row a:focus {
        color: <?php echo esc_attr($styles['footer_hover_color']); ?>;
    }
    <?php endif; if ($styles['anps_heading_text_color']) : ?>
    .site-footer .row .widget-title {
        color: <?php echo esc_attr($styles['anps_heading_text_color']); ?>
    }
    <?php endif; if ($styles['primary_color']) : ?>
    .counter .wrapbox {
        border-color:<?php echo esc_attr($styles['primary_color']); ?>;
    }
    .nav .open > a:focus,
    body .tp-bullets.simplebullets.round .bullet.selected,
    .featured-content {
        border-color: <?php echo esc_attr($styles['primary_color']); ?>;
    }
    .icon i,
    .posts div a,
    .progress-bar,
    .nav-tabs > li.active:after,
    .vc_tta-style-anps_tabs .vc_tta-tabs-list > li.vc_active:after,
    .pricing-table header,
    .table thead th,
    .mark,
    .post .post-meta button,
    blockquote.style-2:after,
    .panel-title a:before,
    .carousel-indicators li,
    .carousel-indicators .active,
    .ls-michell .ls-bottom-slidebuttons a,
    .site-search,
    .twitter .carousel-indicators li,
    .twitter .carousel-indicators li.active,
    #wp-calendar td a,
    body .tp-bullets.simplebullets.round .bullet,
    .onsale,
    .plus, .minus,
    .form-submit #submit,
    .testimonials blockquote header:before,
    div.woocommerce-tabs ul.tabs li.active:before,
    mark {
        background-color: <?php echo esc_attr($styles['primary_color']); ?>;
    }
    <?php endif; if ($styles['hovers_color']) : ?>
    .important {
        color: <?php echo esc_attr($styles['hovers_color']); ?>;
    }
    <?php endif; if ($styles['anps_woo_cart_items_number_bg_color']) : ?>
    .woo-header-cart .cart-contents > span {
        background-color: <?php echo esc_attr($styles['anps_woo_cart_items_number_bg_color']); ?>;
    }
    <?php endif; if ($styles['anps_woo_cart_items_number_color']) : ?>
    .woo-header-cart .cart-contents > span {
        color: <?php echo esc_attr($styles['anps_woo_cart_items_number_color']); ?>;
    }
    <?php endif; ?>

    .testimonials.white blockquote header:before {
        background-color: #fff;
    }

    <?php if ($styles['headings_color']) : ?>
    h1, h2, h3, h4, h5, h6,
    .nav-tabs > li > a,
    .nav-tabs > li.active > a,
    .vc_tta-tabs-list > li > a span,
    .statement,
    p strong,
    .dropcaps:first-letter,
    .page-numbers a,
    .searchform,
    .searchform input[type="text"],
    .socialize a,
    .widget_rss .rss-date,
    .widget_rss cite,
    .panel-title,
    .panel-group.style-2 .panel-title a.collapsed:before,
    blockquote.style-1,
    .comment-list .comment header,
    .faq .panel-title a:before,
    .faq .panel-title a.collapsed,
    .filter button,
    .carousel .carousel-control,
    #wp-calendar #today,
    .woocommerce-result-count,
    input.qty,
    .product_meta,
    .woocommerce-review-link,
    .woocommerce-before-loop .woocommerce-ordering:after,
    .widget_price_filter .price_slider_amount .button,
    .widget_price_filter .price_label,
    .sidebar .product_list_widget li h4 a,
    .shop_table.table thead th,
    .shop_table.table tfoot,
    .headings-color,
    .product-single-header .variations label,
    .tab-pane .commentlist .meta, .woocommerce-tabs .commentlist .meta {
        color: <?php echo esc_attr($styles['headings_color']); ?>;
    }
    <?php endif; if ($styles['page_heading_color']) : ?>
    .page-heading .breadcrumbs li a:after,
    .page-heading ul.breadcrumbs a:not(:hover):not(:focus),
    .page-heading h1,
    .page-header h1 {
        color: <?php echo esc_attr($styles['page_heading_color']); ?>;
    }
    <?php endif; ?>
    .ls-michell .ls-nav-next,
    .ls-michell .ls-nav-prev {
        color:#fff;
    }

    <?php if ($styles['headings_color']) : ?>
    input:not([type="radio"]):not([type="checkbox"]):focus,
    textarea:focus {
        border-color: <?php echo esc_attr($styles['headings_color']); ?>!important;
        outline: none;
    }

    .select2-container-active.select2-drop-active,
    .select2-container-active.select2-container .select2-choice,
    .select2-drop-active .select2-results,
    .select2-drop-active {
        border-color: <?php echo esc_attr($styles['headings_color']); ?> !important;
    }

    .pricing-table header h2,
    .mark.style-2,
    .btn.dark,
    .twitter .carousel-indicators li,
    .added_to_cart
    {
        background-color: <?php echo esc_attr($styles['headings_color']); ?>;
    }
    <?php endif; if ($styles['font_2']) : ?>
    body,
    .alert .close,
    .post header {
    font-family: <?php echo anps_wrap_font(esc_attr($styles['font_2'])); ?>;
        <?php if ($styles['font_2'] === 'Montserrat') : ?>
        font-weight: 500;
        <?php endif; ?>
    }
    <?php endif; if ($styles['font_1']) : ?>
    h1, h2, h3, h4, h5, h6,
    .btn,
    .page-heading,
    .team em,
    blockquote.style-1,
    .onsale,
    .added_to_cart,
    .price,
    .widget-price,
    .woocommerce-review-link,
    .product_meta,
    .tab-pane .commentlist .meta, .woocommerce-tabs .commentlist .meta,
    .wpcf7-submit,
    .testimonial-footer span.user,
    button.single_add_to_cart_button,
    p.form-row input.button,
    .contact-number,
    .filter-style-3,
    .menu-button,
    .shipping-calculator-button {
    font-family: <?php echo anps_wrap_font(esc_attr($styles['font_1'])); ?>;
    <?php if ($styles['font_1'] === 'Montserrat') : ?>
        font-weight: 500;
    <?php endif; ?>
    }
    <?php endif; if ($styles['font_3']) : ?>
    .nav-tabs > li > a,
    .site-navigation,
    .vc_tta-tabs-list > li > a,
    .tp-arr-titleholder {
    font-family: <?php echo anps_wrap_font(esc_attr($styles['font_3'])); ?>;
    <?php if ($styles['font_3'] === 'Montserrat') : ?>
        font-weight: 500;
    <?php endif; ?>
    }
    <?php endif; if ($styles['font_1']) : ?>
    .pricing-table header h2,
    .pricing-table header .price,
    .pricing-table header .currency,
    .table thead,
    h1.style-3,
    h2.style-3,
    h3.style-3,
    h4.style-3,
    h5.style-3,
    h6.style-3,
    .page-numbers a,
    .page-numbers span,
    .nav-links a,
    .nav-links span,
    .alert,
    .comment-list .comment header,
    .woocommerce-result-count,
    .product_list_widget li > a,
    .product_list_widget li p.total strong,
    .cart_list + .total,
    .shop_table.table tfoot,
    .product-single-header .variations label {
    font-family: <?php echo anps_wrap_font(esc_attr($styles['font_1'])); ?>;
    <?php if ($styles['font_1'] === 'Montserrat') : ?>
        font-weight: 500;
    <?php endif; ?>
    }
    .site-search #searchform-header input[type="text"] {
    font-family: <?php echo anps_wrap_font(esc_attr($styles['font_1'])); ?>;
    <?php if ($styles['font_1'] === 'Montserrat') : ?>
        font-weight: 500;
    <?php endif; ?>
    }
    <?php endif; ?>

    /* footer */
    <?php if ($styles['footer_bg_color']) : ?>
    .site-footer {
        background: <?php echo esc_attr($styles['footer_bg_color']); ?>;
    }
    <?php endif; ?>

    .site-footer .copyright-footer {
        <?php if ($styles['copyright_footer_text_color']) : ?>
        color: <?php echo esc_attr($styles['copyright_footer_text_color']); ?>;
        <?php endif; if ($styles['copyright_footer_bg_color']) : ?>
        background: <?php echo esc_attr($styles['copyright_footer_bg_color']); ?>;
        <?php endif; ?>
    }

    <?php if ($styles['footer_divider_color']) : ?>
    footer.site-footer .copyright-footer > .container:before {
        background: <?php echo esc_attr($styles['footer_divider_color']); ?>;
    }
    <?php endif; ?>

    div.testimonials.white blockquote.item.active p,
    div.testimonials.white blockquote.item.active cite a,
    div.testimonials.white blockquote.item.active cite, .wpb_content_element .widget .tagcloud a {
        color: #fff;
    }

    <?php if ($styles['hovers_color']) : ?>
    a:hover,
    .icon a:hover h2,
    .nav-tabs > li > a:hover,
    .page-heading a:hover,
    .menu a:hover, .menu a:focus,
    .menu .is-active a,
    .table tbody tr:hover td,
    .page-numbers a:hover,
    .nav-links a:hover,
    .widget-categories a:hover,
    .product-categories a:hover,
    .widget_archive a:hover,
    .widget_categories a:hover,
    .widget_recent_entries a:hover,
    .socialize a:hover,
    .faq .panel-title a.collapsed:hover,
    .carousel .carousel-control:hover,
    a:hover h1, a:hover h2, a:hover h3, a:hover h4, a:hover h5,
    .site-footer a:hover,
    .ls-michell .ls-nav-next:hover,
    .ls-michell .ls-nav-prev:hover,
    body .tp-leftarrow.default:hover,
    body .tp-rightarrow.default:hover,
    .product_list_widget li h4 a:hover,
    .cart-contents:hover i,
    .icon.style-2 a:hover i,
    .team .socialize a:hover,
    .recentblog header a:hover h2,
    .scrollup a:hover,
    .hovercolor, i.hovercolor, .post.style-2 header i.hovercolor.fa,
    article.post-sticky header:before,
    .wpb_content_element .widget a:hover,
    .star-rating,
    .menu .current_page_item > a,
    .page-numbers.current,
    .widget_layered_nav a:hover,
    .widget_layered_nav a:focus,
    .widget_layered_nav .chosen a,
    .widget_layered_nav_filters a:hover,
    .widget_layered_nav_filters a:focus,
    .widget_rating_filter .star-rating:hover,
    .widget_rating_filter .star-rating:focus,
    .icon > a > i, .icon.style-2 i,
    .home .site-header.site-header-sticky-active .menu-item-depth-0 > a:hover,
    .home .site-header.site-header-sticky-active .menu-item-depth-0 > a:focus,
    #shipping_method input:checked + label::after,
    .payment_methods input[type="radio"]:checked + label::after {
        color: <?php echo esc_attr($styles['hovers_color']); ?>;
    }

    .filter-style-1 button.selected,
    .filter-style-3 button.selected {
        color: <?php echo esc_attr($styles['hovers_color']); ?>!important;
    }

    .scrollup a:hover {
        border-color: <?php echo esc_attr($styles['hovers_color']); ?>;
    }

    .tagcloud a:hover,
    .twitter .carousel-indicators li:hover,
    .added_to_cart:hover,
    .icon a:hover i,
    .posts div a:hover,
    #wp-calendar td a:hover,
    .plus:hover, .minus:hover,
    .widget_price_filter .price_slider_amount .button:hover,
    .form-submit #submit:hover,
    .onsale,
    .widget_price_filter .ui-slider .ui-slider-range,
    .newsletter-widget .newsletter-submit,
    .tnp-widget .tnp-submit,
    .testimonials .testimonial-owl-nav button,
    .woocommerce-product-gallery__trigger:hover,
    .woocommerce-product-gallery__trigger:focus,
    .large-above-menu-style-2 .widget_anpssocial a {
        background-color: <?php echo esc_attr($styles['hovers_color']); ?>;
    }

    .bypostauthor .author {
        color: <?php echo esc_attr($styles['hovers_color']); ?>;
    }
    <?php endif; ?>

    <?php if ($styles['body_font_size']) : ?>
    body { font-size: <?php echo esc_attr($styles['body_font_size']); ?>px; }
    <?php endif; if ($styles['h1_font_size']) : ?>
    h1, .h1 { font-size: <?php echo esc_attr($styles['h1_font_size']); ?>px; }
    <?php endif; if ($styles['h2_font_size']) : ?>
    h2, .h2 { font-size: <?php echo esc_attr($styles['h2_font_size']); ?>px; }
    <?php endif; if ($styles['h3_font_size']) : ?>
    h3, .h3 { font-size: <?php echo esc_attr($styles['h3_font_size']); ?>px; }
    <?php endif; if ($styles['h4_font_size']) : ?>
    h4, .h4 { font-size: <?php echo esc_attr($styles['h4_font_size']); ?>px; }
    <?php endif; if ($styles['h5_font_size']) : ?>
    h5, .h5 { font-size: <?php echo esc_attr($styles['h5_font_size']); ?>px; }
    <?php endif; if ($styles['page_heading_h1_font_size']) : ?>
    .page-heading h1 {
        font-size: <?php echo esc_attr($styles['page_heading_h1_font_size']); ?>px;
        line-height: 34px;
    }
    <?php endif; if ($styles['nav_background_color']) : ?>
    article.post-sticky header .stickymark i.nav_background_color {
        color: <?php echo esc_attr($styles['nav_background_color']); ?>;
    }
    <?php endif; if ($styles['hovers_color']) : ?>
    .triangle-topleft.hovercolor {
        border-top: 60px solid <?php echo esc_attr($styles['hovers_color']); ?>;
    }
    <?php endif; if ($styles['blog_heading_h1_font_size']) : ?>
    h1.single-blog, article.post h1.single-blog{
        font-size: <?php echo esc_attr($styles['blog_heading_h1_font_size']); ?>px;
    }
    <?php endif; ?>

    aside.sidebar ul.menu ul.sub-menu > li > a {
        <?php if ($styles['side_submenu_background_color']) : ?>
        background: <?php echo esc_attr($styles['side_submenu_background_color']); ?>;
        <?php endif; if ($styles['side_submenu_text_color']) : ?>
        color: <?php echo esc_attr($styles['side_submenu_text_color']); ?>;
        <?php endif; ?>
    }

    <?php if ($styles['side_submenu_text_hover_color']) : ?>
    aside.sidebar ul.menu ul.sub-menu > li > a:hover,
    aside.sidebar ul.sub-menu li.current_page_item > a,
    aside.sidebar ul.menu ul.sub-menu > li.current_page_item > a {
        color: <?php echo esc_attr($styles['side_submenu_text_hover_color']); ?>;
    }
    <?php endif; if (isset($styles['anps_logo_bg_color']) && $styles['anps_logo_bg_color'] != "" && get_option('anps_logo_background') == '1') : ?>
        @media(min-width: 992px) {
            .site-header .site-logo {
                color: <?php echo esc_attr($styles['anps_logo_bg_color']); ?>
            }
        }
    <?php endif; if ($styles['blog_heading_h1_font_size']) : ?>
    @media(min-width: 992px) {
        .top-bar > .container {
            min-height: <?php echo esc_attr($styles['anps_top_bar_height']); ?>px;
        }
    }
    <?php endif; if ($styles['anps_menu_height']) : ?>
        @media(min-width: 992px) {
            <?php // header type 1 ?>
            .site-header-style-normal,
            .transparent.top-bar + .site-header-style-transparent:not(.site-header-sticky-active) .nav-wrap {
                height: <?php echo esc_attr($styles['anps_menu_height'], 'auto'); ?>px;
                max-height: <?php echo esc_attr($styles['anps_menu_height'], 'auto'); ?>px;
            }
            <?php // header type 2, 3, 4 ?>
            .site-header-style-normal:not(.site-header-sticky-active) .nav-wrap,
            .site-header-style-transparent:not(.site-header-sticky-active) .nav-wrap {
                height: <?php echo esc_attr($styles['anps_menu_height'], 'auto'); ?>px;
                max-height: <?php echo esc_attr($styles['anps_menu_height'], 'auto'); ?>px;
                transition: height .3s ease-out;
            }
            <?php // header type 6 ?>
            .site-header-style-full-width .preheader-wrap, .site-header-style-boxed .preheader-wrap {
                height: <?php echo esc_attr($styles['anps_menu_height'], 'auto'); ?>px;
            }
            .site-header-style-full-width .site-logo:after, .site-header-style-boxed .site-logo:after {
                border-top: <?php echo esc_attr($styles['anps_menu_height'], 'auto'); ?>px solid currentColor;
            }
        }
    <?php endif;

    if (anps_get_option($anps_media_data, 'logo-height') != '') :
        if (anps_get_option($anps_media_data, 'auto_adjust_logo') != '') {
            $styles['nav_top_heading'] = '0';
        } else {
            $saved_option = anps_get_option($anps_media_data, 'auto_adjust_logo');
            $parsed_option = $saved_option ? intval($saved_option) : 123;
            $styles['nav_top_heading'] = ceil($parsed_option);
        }
    endif;
    //display search icon in menu?
    $styles['search_icon'] = anps_get_option('', '1', 'search_icon');
    if (!$styles['search_icon'] == '1') : ?>
    .site-navigation .fa-search {
        display:none;
    }
    <?php endif; if ($styles['logo_font']) : ?>
    .site-logo {
        font-family: <?php echo anps_wrap_font(esc_attr($styles['logo_font'])); ?>
    }
    <?php endif;

    echo get_option("anps_custom_css", "");

    // Done. Collect buffer, clean it up, cache and output
    $css_buffer = ob_get_clean();
    $css = trim(preg_replace('/\s+/', ' ', $css_buffer));

    set_transient('anps_theme_options_styles_css', $css);

    return $css;
}

function anps_get_custom_styles_buttons() {
    // Try to get from cache
    $styles = get_transient('anps_theme_options_buttons');
    if ($styles !== false) return $styles;

    $styles = array();

    $styles['default_button_bg'] = anps_get_option('', '#1874c1', 'default_button_bg');
    $styles['default_button_color'] = anps_get_option('', '#fff', 'default_button_color');
    $styles['default_button_hover_bg'] = anps_get_option('', '#292929', 'default_button_hover_bg');
    $styles['default_button_hover_color'] = anps_get_option('', '#fff', 'default_button_hover_color');

    $styles['style_1_button_bg'] = anps_get_option('', '#1874c1', 'style_1_button_bg');
    $styles['style_1_button_color'] = anps_get_option('', '#fff', 'style_1_button_color');
    $styles['style_1_button_hover_bg'] = anps_get_option('', '#292929', 'style_1_button_hover_bg');
    $styles['style_1_button_hover_color'] = anps_get_option('', '#fff', 'style_1_button_hover_color');

    $styles['style_slider_button_bg'] = anps_get_option('', '#1874c1', 'style_slider_button_bg');
    $styles['style_slider_button_color'] = anps_get_option('', '#fff', 'style_slider_button_color');
    $styles['style_slider_button_hover_bg'] = anps_get_option('', '#000', 'style_slider_button_hover_bg');
    $styles['style_slider_button_hover_color'] = anps_get_option('', '#fff', 'style_slider_button_hover_color');

    $styles['style_2_button_bg'] = anps_get_option('', '#292929', 'style_2_button_bg');
    $styles['style_2_button_color'] = anps_get_option('', '#fff', 'style_2_button_color');
    $styles['style_2_button_hover_bg'] = anps_get_option('', '#fff', 'style_2_button_hover_bg');
    $styles['style_2_button_hover_color'] = anps_get_option('', '#fff', 'style_2_button_hover_color');

    $styles['style_3_button_color'] = anps_get_option('', '#fff', 'style_3_button_color');
    $styles['style_3_button_hover_bg'] = anps_get_option('', '#fff', 'style_3_button_hover_bg');
    $styles['style_3_button_hover_color'] = anps_get_option('', '#1874c1', 'style_3_button_hover_color');
    $styles['style_3_button_border_color'] = anps_get_option('', '#fff', 'style_3_button_border_color');

    $styles['style_4_button_color'] = anps_get_option('', '#1874c1', 'style_4_button_color');
    $styles['style_4_button_hover_color'] = anps_get_option('', '#94cfff', 'style_4_button_hover_color');

    $styles['style_style_5_button_bg'] = anps_get_option('', '#c3c3c3', 'style_style_5_button_bg');
    $styles['style_style_5_button_color'] = anps_get_option('', '#fff', 'style_style_5_button_color');
    $styles['style_style_5_button_hover_bg'] = anps_get_option('', '#737373', 'style_style_5_button_hover_bg');
    $styles['style_style_5_button_hover_color'] = anps_get_option('', '#fff', 'style_style_5_button_hover_color');

    $styles['anps_header_style_6_button_bg'] = get_option('anps_header_style_6_button_bg', '#1874c1');
    $styles['anps_header_style_6_button_color'] = get_option('anps_header_style_6_button_color', '#fff');
    $styles['anps_header_style_6_button_hover_bg'] = get_option('anps_header_style_6_button_hover_bg', '#000');
    $styles['anps_header_style_6_button_hover_color'] = get_option('anps_header_style_6_button_hover_color', '#fff');

    // Cache the values
    set_transient('anps_theme_options_buttons', $styles);
    return $styles;
}

function anps_custom_styles_buttons() {
    // Try cache because compiling and formatting this css string is expensive
    $css = get_transient('anps_theme_options_buttons_css');
    if ($css !== false && !empty($css)) return $css;

    // Collect all CSS into a variable so we can cache it
    $styles = anps_get_custom_styles_buttons();
    ob_start();
    ?>
    <?php if ($styles['default_button_bg']) : ?>
    input#place_order {
        background-color: <?php echo esc_attr($styles['default_button_bg']); ?>;
    }
    <?php endif; if ($styles['default_button_hover_bg']) : ?>
    input#place_order:hover,
    input#place_order:focus {
        background-color: <?php echo esc_attr($styles['default_button_hover_bg']); ?>;
    }
    <?php endif; ?>

    .btn, .wpcf7-submit, .woocommerce .button, .post-password-form input[type="submit"] {
        -moz-user-select: none;
        background-image: none;
        border: 0;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        line-height: 1.5;
        margin-bottom: 0;
        text-align: center;
        text-transform: uppercase;
        text-decoration:none;
        transition: background-color 0.2s ease 0s;
        vertical-align: middle;
        white-space: nowrap;
    }

    .btn.btn-sm, .wpcf7-submit {
        padding: 11px 17px;
        font-size: 14px;
    }

    <?php if ($styles['default_button_bg'] && $styles['default_button_color']) : ?>
    .btn, .wpcf7-submit, button.single_add_to_cart_button,
    p.form-row input.button, .woocommerce .button,
    .post-password-form input[type="submit"] {
        border-radius: 0;
        border-radius: 4px;
        background-color: <?php echo esc_attr($styles['default_button_bg']); ?>;
        color: <?php echo esc_attr($styles['default_button_color']); ?>;
    }
    <?php endif; if ($styles['default_button_hover_bg'] && $styles['default_button_hover_color']) : ?>
    .btn:hover, p.form-row input.button:hover, p.form-row input.button:focus, .btn:active, .btn:focus, .wpcf7-submit:hover, .wpcf7-submit:active, .wpcf7-submit:focus, button.single_add_to_cart_button:hover, button.single_add_to_cart_button:active, button.single_add_to_cart_button:focus, .woocommerce .button:hover, .woocommerce .button:focus {
        background-color: <?php echo esc_attr($styles['default_button_hover_bg']); ?>;
        color: <?php echo esc_attr($styles['default_button_hover_color']); ?>;
        border:0;
    }
    <?php endif; if ($styles['style_1_button_bg'] && $styles['style_1_button_color']) : ?>
    .btn.style-1, .vc_btn.style-1 {
        border-radius: 4px;
        background-color: <?php echo esc_attr($styles['style_1_button_bg']); ?>;
        color: <?php echo esc_attr($styles['style_1_button_color']); ?>!important;
    }
    <?php endif; if ($styles['style_1_button_hover_bg'] && $styles['style_1_button_hover_color']) : ?>
    .post-password-form input[type="submit"]:hover,
    .post-password-form input[type="submit"]:focus,
    .btn.style-1:hover, .btn.style-1:active, .btn.style-1:focus, .vc_btn.style-1:hover, .vc_btn.style-1:active, .vc_btn.style-1:focus {
        background-color: <?php echo esc_attr($styles['style_1_button_hover_bg']); ?>;
        color: <?php echo esc_attr($styles['style_1_button_hover_color']); ?>!important;
    }
    <?php endif; if ($styles['style_slider_button_bg'] && $styles['style_slider_button_color']) : ?>
    .btn.slider {
        border-radius: 4px;
        background-color: <?php echo esc_attr($styles['style_slider_button_bg']); ?>;
        color: <?php echo esc_attr($styles['style_slider_button_color']); ?>;
    }
    <?php endif; if ($styles['style_slider_button_hover_bg'] && $styles['style_slider_button_hover_color']) : ?>
    .btn.slider:hover, .btn.slider:active, .btn.slider:focus {
        background-color: <?php echo esc_attr($styles['style_slider_button_hover_bg']); ?>;
        color: <?php echo esc_attr($styles['style_slider_button_hover_color']); ?>;
    }
    <?php endif; if ($styles['style_2_button_bg'] && $styles['style_2_button_color']) : ?>
    .btn.style-2, .vc_btn.style-2 {
        border-radius: 4px;
        border: 2px solid <?php echo esc_attr($styles['style_2_button_bg']); ?>;
        background-color: <?php echo esc_attr($styles['style_2_button_bg']); ?>;
        color: <?php echo esc_attr($styles['style_2_button_color']); ?>!important;
    }
    <?php endif; if ($styles['style_2_button_hover_bg'] && $styles['style_2_button_hover_color'] && $styles['style_2_button_bg']) : ?>
    .btn.style-2:hover, .btn.style-2:active, .btn.style-2:focus, .vc_btn.style-2:hover, .vc_btn.style-2:active, .vc_btn.style-2:focus {
        background-color: <?php echo esc_attr($styles['style_2_button_hover_bg']); ?>;
        color: <?php echo esc_attr($styles['style_2_button_hover_color']); ?>!important;
        border-color: <?php echo esc_attr($styles['style_2_button_bg']); ?>;
        border: 2px solid <?php echo esc_attr($styles['style_2_button_bg']); ?>;
    }
    <?php endif; if ($styles['style_3_button_border_color'] && $styles['style_3_button_color']) : ?>
    .btn.style-3, .vc_btn.style-3 {
        border: 2px solid <?php echo esc_attr($styles['style_3_button_border_color']); ?>;
        border-radius: 4px;
        background-color: transparent;
        color: <?php echo esc_attr($styles['style_3_button_color']); ?>!important;
    }
    <?php endif; if ($styles['style_3_button_border_color'] && $styles['style_3_button_hover_bg'] && $styles['style_3_button_hover_color']) : ?>
    .btn.style-3:hover, .btn.style-3:active, .btn.style-3:focus, .vc_btn.style-3:hover, .vc_btn.style-3:active, .vc_btn.style-3:focus {
        border: 2px solid <?php echo esc_attr($styles['style_3_button_border_color']); ?>;
        background-color: <?php echo esc_attr($styles['style_3_button_hover_bg']); ?>;
        color: <?php echo esc_attr($styles['style_3_button_hover_color']); ?>!important;
    }
    <?php endif; if ($styles['style_4_button_color']) : ?>
    .btn.style-4, .vc_btn.style-4 {
        padding-left: 0;
        background-color: transparent;
        color: <?php echo esc_attr($styles['style_4_button_color']); ?>!important;
        border: none;
    }
    <?php endif; if ($styles['style_4_button_hover_color']) : ?>
    .btn.style-4:hover, .btn.style-4:active, .btn.style-4:focus, .vc_btn.style-4:hover, .vc_btn.style-4:active, .vc_btn.style-4:focus {
        padding-left: 0;
        background: none;
        color: <?php echo esc_attr($styles['style_4_button_hover_color']); ?>!important;
        border: none;
        border-color: transparent;
        outline: none;
    }
    <?php endif; if ($styles['style_style_5_button_bg'] && $styles['style_style_5_button_color']) : ?>
    .btn.style-5, .vc_btn.style-5 {
        background-color: <?php echo esc_attr($styles['style_style_5_button_bg']); ?>!important;
        color: <?php echo esc_attr($styles['style_style_5_button_color']); ?>!important;
        border: none;
    }
    <?php endif;  if ($styles['style_style_5_button_hover_bg'] && $styles['style_style_5_button_hover_color']) : ?>
    .btn.style-5:hover, .btn.style-5:active, .btn.style-5:focus, .vc_btn.style-5:hover, .vc_btn.style-5:active, .vc_btn.style-5:focus {
        background-color: <?php echo esc_attr($styles['style_style_5_button_hover_bg']); ?>!important;
        color: <?php echo esc_attr($styles['style_style_5_button_hover_color']); ?>!important;
    }
    <?php endif; if ($styles['style_1_button_color'] && $styles['style_1_button_bg']) : ?>
    .post-page-numbers {
        color: <?php echo esc_attr($styles['style_1_button_color']); ?>;
        background: <?php echo esc_attr($styles['style_1_button_bg']); ?>;
    }
    <?php endif; if ($styles['style_1_button_hover_color'] && $styles['style_1_button_hover_bg']) : ?>
    .post-page-numbers:hover,
    .post-page-numbers:focus,
    .post-page-numbers.current {
        color: <?php echo esc_attr($styles['style_1_button_hover_color']); ?>;
        background: <?php echo esc_attr($styles['style_1_button_hover_bg']); ?>;
    }
    <?php endif; if ($styles['anps_header_style_6_button_bg'] && $styles['anps_header_style_6_button_color']) : ?>
    site-header a.menu-button, .menu-button {
        background-color: <?php echo esc_attr($styles['anps_header_style_6_button_bg']); ?>!important;
        color: <?php echo esc_attr($styles['anps_header_style_6_button_color']); ?>!important;
    }
    <?php endif; if ($styles['anps_header_style_6_button_hover_bg'] && $styles['anps_header_style_6_button_hover_color']) : ?>
    site-header a.menu-button:hover, site-header a.menu-button:focus, .menu-button:hover, .menu-button:focus {
        background-color: <?php echo esc_attr($styles['anps_header_style_6_button_hover_bg']); ?>!important;
        color: <?php echo esc_attr($styles['anps_header_style_6_button_hover_color']); ?>!important;
    }
    <?php endif;

    $css_buffer = ob_get_clean();
    $css = trim(preg_replace('/\s+/', ' ', $css_buffer));

    set_transient('anps_theme_options_buttons_css', $css);

    return $css;
}

function anps_custom_block_editor_styles() {
    $styles = anps_get_custom_styles();
    ob_start();
    if ($styles['font_1_source'] === 'Custom fonts') echo anps_custom_font($styles['font_1']);
    if ($styles['font_2_source'] === 'Custom fonts') echo anps_custom_font($styles['font_2']);
    ?>
    <?php if ($styles['blog_heading_h1_font_size']) : ?>
    .post-type-page .editor-styles-wrapper .editor-post-title__input {
        font-size: <?php echo esc_attr($styles['blog_heading_h1_font_size']); ?>px;
    }
    <?php endif; if ($styles['blog_heading_h1_font_size']) : ?>
    .post-type-post .editor-styles-wrapper .editor-post-title__input {
        font-size: <?php echo esc_attr($styles['blog_heading_h1_font_size']); ?>px;
    }
    <?php endif; ?>
    :root .editor-styles-wrapper {
        <?php if ($styles['text_color']) : ?>
        color: <?php echo esc_attr($styles['text_color']); ?> !important;
        <?php endif; if ($styles['body_font_size']) : ?>
        font-size: <?php echo esc_attr($styles['body_font_size']); ?>px !important;
        <?php endif; if ($styles['font_2']) : ?>
        font-family: <?php echo anps_wrap_font($styles['font_2']); ?> !important;
        <?php endif; ?>
    }
    <?php if ($styles['h1_font_size']) : ?>
    :root .editor-styles-wrapper h1.wp-block { font-size: <?php echo esc_attr($styles['h1_font_size']); ?>px; }
    <?php endif; if ($styles['h2_font_size']) : ?>
    :root .editor-styles-wrapper h2.wp-block { font-size: <?php echo esc_attr($styles['h2_font_size']); ?>px; }
    <?php endif; if ($styles['h3_font_size']) : ?>
    :root .editor-styles-wrapper h3.wp-block { font-size: <?php echo esc_attr($styles['h3_font_size']); ?>px; }
    <?php endif; if ($styles['h4_font_size']) : ?>
    :root .editor-styles-wrapper h4.wp-block { font-size: <?php echo esc_attr($styles['h4_font_size']); ?>px; }
    <?php endif; if ($styles['h5_font_size']) : ?>
    :root .editor-styles-wrapper h5.wp-block { font-size: <?php echo esc_attr($styles['h5_font_size']); ?>px; }
    <?php endif; if ($styles['headings_color']) : ?>
    :root .editor-styles-wrapper .editor-post-title__input,
    :root .editor-styles-wrapper h1,
    :root .editor-styles-wrapper h2,
    :root .editor-styles-wrapper h3,
    :root .editor-styles-wrapper h4,
    :root .editor-styles-wrapper h5,
    :root .editor-styles-wrapper h6,
    :root .editor-styles-wrapper p strong { color: <?php echo esc_attr($styles['headings_color']); ?>; }
    <?php endif; if ($styles['font_1']) : ?>
    :root .editor-styles-wrapper .editor-post-title__input,
    :root .editor-styles-wrapper h1,
    :root .editor-styles-wrapper h2,
    :root .editor-styles-wrapper h3,
    :root .editor-styles-wrapper h4,
    :root .editor-styles-wrapper h5,
    :root .editor-styles-wrapper h6 {
        font-family: <?php echo anps_wrap_font($styles['font_1']); ?>;
        <?php if ($styles['font_1'] === 'Montserrat') : ?>font-weight: 500;<?php endif; ?>
    }
    <?php endif; if ($styles['primary_color']) : ?>
    :root .editor-styles-wrapper a,
    :root .editor-styles-wrapper b,
    :root .editor-styles-wrapper .wp-block-file__textlink { color: <?php echo esc_attr($styles['primary_color']); ?>; }
    :root .editor-styles-wrapper mark:not(.has-background) {
        color: #fff !important;
        background-color: <?php echo esc_attr($styles['primary_color']); ?> !important;
    }
    <?php endif; if ($styles['hovers_color']) : ?>
    :root .editor-styles-wrapper a:hover,
    :root .editor-styles-wrapper .wp-block-file__textlink:hover { color: <?php echo esc_attr($styles['hovers_color']); ?>; }
    <?php endif;

    return ob_get_clean();
}

/** Build Google font URI */
function anps_get_google_fonts_uri($fonts_list = array()) {
    if (empty($fonts_list)) return false;
    $uri = 'https://fonts.googleapis.com/css2?display=swap';
    foreach ($fonts_list as $font) {
        $uri .= '&family=' . urlencode($font) . ':ital,wght@0,300;0,400;0,500;0,600;0,700;1,400';
    }
    return $uri;
}
