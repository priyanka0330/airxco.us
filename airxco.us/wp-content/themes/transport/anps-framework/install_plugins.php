<?php
require_once  get_template_directory() . '/anps-framework/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'widebox_register_required_plugins');
function widebox_register_required_plugins() {
    $plugins = array(
        array(
            'name' => 'Slider Revolution',
            'slug' => 'revslider',
            'source' => 'https://astudio.si/preview/plugins/revslider.zip',
            'external_url' => 'https://revolution.themepunch.com/',
        ),
        array(
            'name' => 'Contact form 7',
            'slug' => 'contact-form-7',
        ),
        array(
            'name' => 'Anps Theme plugin',
            'slug' => 'anps_theme_plugin',
            'source' => 'https://astudio.si/preview/plugins/transport/anps_theme_plugin.zip',
            'required' => true,
        ),
        array(
            'name' => 'WPBakery Page Builder',
            'slug' => 'js_composer',
            'source' => 'https://astudio.si/preview/plugins/js_composer.zip',
            'required' => true,
            'external_url' => 'https://wpbakery.com/',
        ),
        array(
            'name' => 'Newsletter',
            'slug' => 'newsletter',
        ),
        array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
        ),
        array(
            'name' => 'Envato Market',
            'slug' => 'envato-market',
            'source' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
            'external_url' => 'https://envato.com/market-plugin/',
        ),
    );

    $config = array(
        'menu'         => 'install-required-plugins',
        'is_automatic' => true,
    );

    tgmpa($plugins, $config);
}
