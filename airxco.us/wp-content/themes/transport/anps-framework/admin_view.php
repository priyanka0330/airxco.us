<div class="envoo-admin">
<?php $themever = wp_get_theme(get_template()); $version = $themever["Version"]; ?>
    <ul class="envoo-admin-menu">
        <li><a id="anpslogo" href="https://anpsthemes.com" target="_blank"></a><h2 class="small_lh"><?php _e("Theme Options", 'transport'); ?><br/><span id="version"><?php echo esc_attr('version: '). esc_attr($version);?></span></h2></li>

        <li><a <?php if (!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style"><i class="fa fa-tint"></i><?php _e("Theme Style", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_google_font") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_google_font"><i class="fa fa-google"></i><?php _e("Update google fonts", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_custom_font") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_custom_font"><i class="fa fa-text-height"></i><?php _e("Custom fonts", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_custom_css") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_custom_css"><i class="fa fa-code"></i><?php _e("Custom css", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options"><i class="fa fa-columns"></i><?php _e("Page layout", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_page_setup") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_page_setup"><i class="fa fa-cog"></i><?php _e("Page setup", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_media") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_media"><i class="fa fa-picture-o"></i><?php _e("Logos & Media", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "google_maps") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=google_maps"><i class="fa fa-map"></i><?php _e("Google Maps", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "dummy_content") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=dummy_content"><i class="fa fa-dropbox"></i><?php _e("Dummy Content", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_upgrade") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=theme_upgrade"><i class="fa fa-cloud-download"></i><?php _e("Theme upgrade", 'transport'); ?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "import_export") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=import_export"><i class="fa fa-file-code-o"></i><?php esc_html_e("Import/Export", 'transport');?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "import_export_widgets") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=import_export_widgets"><i class="fa fa-file-code-o"></i><?php esc_html_e("Import/Export widgets", 'transport');?></a></li>
        <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "system_req") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=system_req"><i class="fa fa-cogs"></i><?php _e("System requirements", 'transport'); ?></a></li>
    </ul>
    <?php
    if(!isset($_GET['sub_page'])) {
        $_GET['sub_page']='';
    }
    ?>
    <div class="envoo-admin-content <?php echo esc_attr($_GET['sub_page']);?>">
    <?php
    switch($_GET['sub_page']) {
        case 'options': include_once 'options_page_view.php'; break;
        case 'google_maps': include_once 'google_maps_view.php'; break;
        case 'options_page': include_once 'options_page_view.php'; break;
        case 'options_page_setup': include_once 'options_page_setup_view.php'; break;
        case 'options_media': include_once 'options_media_view.php'; break;
        case 'dummy_content': include_once 'dummy_view.php'; break;
        case 'theme_upgrade': include_once 'theme_upgrade_view.php'; break;
        case 'theme_style_google_font': include_once 'update_google_font_view.php'; break;
        case 'theme_style_custom_font': include_once 'update_custom_font_view.php'; break;
        case 'theme_style_custom_css': include_once 'custom_css_view.php'; break;
        case 'import_export': include_once(get_template_directory() . '/anps-framework/import_export_view.php'); break;
        case 'import_export_widgets': include_once(get_template_directory() . '/anps-framework/import_export_widgets_view.php'); break;
        case 'system_req': include_once 'system_req_view.php'; break;
        default: include_once 'style_view.php';
    }
    ?>
    </div>
</div>
