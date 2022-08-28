<?php

/** Register sidebars by running widebox_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'anps_widgets_init');
function anps_widgets_init()
{
    // Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => __('Sidebar', 'transport'),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'transport'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Secondary Sidebar', 'transport'),
        'id' => 'secondary-widget-area',
        'description' => __('Secondary widget area', 'transport'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Top bar left', 'transport'),
        'id' => 'top-bar-left',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'transport'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Top bar right', 'transport'),
        'id' => 'top-bar-right',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'transport'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Above navigation bar', 'transport'),
        'id' => 'above-navigation-bar',
        'description' => __('This is a bar above main navigation. Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'transport'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    /* Large above menu */
    register_sidebar(array(
        'name' => esc_html__('Large above menu', 'transport'),
        'id' => 'large-above-menu',
        'description' => esc_html__('Large above menu.', 'transport'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    if (anps_get_option('', '', 'vertical_menu') != '') {
        register_sidebar(array(
            'name' => __('Vertical menu bottom widget', 'transport'),
            'id' => 'vertical-bottom-widget',
            'description' => __('This widget displays only on desktop mode in vertical menu.', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    $prefooter = anps_get_option('', '', 'prefooter');
    if ($prefooter != "") {
        $prefooter_columns = anps_get_option('', '4', 'prefooter_style');
        if ($prefooter_columns == '2' || $prefooter_columns == '5' || $prefooter_columns == '6') {
            register_sidebar(array(
                'name' => __('Prefooter 1', 'transport'),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', 'transport'),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif ($prefooter_columns == '3') {
            register_sidebar(array(
                'name' => __('Prefooter 1', 'transport'),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', 'transport'),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 3', 'transport'),
                'id' => 'prefooter-3',
                'description' => __('Prefooter 3', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif ($prefooter_columns == '4' || $prefooter_columns == '0') {
            register_sidebar(array(
                'name' => __('Prefooter 1', 'transport'),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', 'transport'),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 3', 'transport'),
                'id' => 'prefooter-3',
                'description' => __('Prefooter 3', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 4', 'transport'),
                'id' => 'prefooter-4',
                'description' => __('Prefooter 4', 'transport'),
                'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        }
    }
    $footer_columns = anps_get_option('', '4', 'footer_style');
    if ($footer_columns == '2') {
        register_sidebar(array(
            'name' => __('Footer 1', 'transport'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'transport'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif ($footer_columns == '3') {
        register_sidebar(array(
            'name' => __('Footer 1', 'transport'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'transport'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 3', 'transport'),
            'id' => 'footer-3',
            'description' => __('Footer 3', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif ($footer_columns == '4' || $footer_columns == '0') {
        register_sidebar(array(
            'name' => __('Footer 1', 'transport'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'transport'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 3', 'transport'),
            'id' => 'footer-3',
            'description' => __('Footer 3', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 4', 'transport'),
            'id' => 'footer-4',
            'description' => __('Footer 4', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    $copyright_footer = anps_get_option('', '1', 'copyright_footer');
    if ($copyright_footer == "1" || $copyright_footer == "0") {
        register_sidebar(array(
            'name' => __('Copyright footer 1', 'transport'),
            'id' => 'copyright-1',
            'description' => __('Copyright footer 1', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif ($copyright_footer == "2") {
        register_sidebar(array(
            'name' => __('Copyright footer 1', 'transport'),
            'id' => 'copyright-1',
            'description' => __('Copyright footer 1', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Copyright footer 2', 'transport'),
            'id' => 'copyright-2',
            'description' => __('Copyright footer 2', 'transport'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
}
