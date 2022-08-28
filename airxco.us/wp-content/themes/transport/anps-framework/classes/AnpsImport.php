<?php

include_once get_template_directory() . '/anps-framework/classes/Framework.php';

class AnpsImport extends Framework
{
    /* Get all anps theme options */
    public function get_theme_options()
    {
        $data = array();
        foreach (wp_load_alloptions() as $name => $value) {
            if (substr($name, 0, 5) === 'anps_') {
                if (stristr($name, 'anps_custom_fonts', false) || stristr($name, 'anps_google_fonts', false)) {
                    continue;
                }
                $data[$name] = $value;
            }
        }
        return $data;
    }
    /* Get menu name from menu id */
    private function _get_menu_name($id)
    {
        $data = get_term_by('id', $id, 'nav_menu');
        return $data !== false ? $data->slug : false;
    }
    /* Get menu name from menu id */
    private function _get_menu_id($slug)
    {
        $data = get_term_by('slug', $slug, 'nav_menu');
        return $data !== false ? $data->term_id : false;
    }
    /* Get all active anps widgets */
    private function get_anps_widgets()
    {
        $sidebars = get_option('sidebars_widgets');
        unset(
            $sidebars['wp_inactive_widgets'],
            $sidebars['primary-widget-area'],
            $sidebars['array_version']
        );
        foreach ($sidebars as $area => $widgets) {
            if (empty($widgets)) {
                unset($sidebars[$area]);
                continue;
            }
            foreach ($widgets as $idx => $widget_slug) {
                $slug_parts = explode('-', $widget_slug);
                $widget_id = intval(array_pop($slug_parts));
                $widget_type = implode('-', $slug_parts);
                $widget_data = get_option('widget_' . $widget_type, array());
                foreach ($widget_data as $idx2 => $fields) {
                    if ($widget_id !== $idx2) {
                        continue;
                    }
                    if ($widget_type === 'nav_menu' || $widget_type === 'anps_menu') {
                        $menu_slug = $this->_get_menu_name($fields['nav_menu']);
                        if (!$menu_slug) {
                            continue;
                        }
                        $fields['nav_menu'] = $menu_slug;
                    }
                    $sidebars[$area][$widget_type . '-' . $widget_id] = $fields;
                }
                unset(
                    $sidebars[$area][$idx],
                    $sidebars[$area]['_multiwidget']
                );
            }
        }
        return serialize($sidebars);
    }
    /* Save file for widgets */
    public function save_file_widgets()
    {
        header('Content-Disposition: attachment; filename=anps-widgets.txt');
        header('Content-Type: text/plain');
        ob_clean();

        $allowed_tags = wp_kses_allowed_html('post');
        echo wp_kses($this->get_anps_widgets(), $allowed_tags); //PHPCS: XSS ok.
        exit;
    }
    /* Save file */
    public function save_file()
    {
        header('Content-Disposition: attachment; filename=anps-theme-options.json');
        header('Content-Type: application/json');
        ob_clean();
        echo stripslashes($_POST['anps_export']);
        exit;
    }
    /* Import theme options */
    public function import_theme_options($filename = '')
    {
        $redirect_to_form = empty($filename);
        if (isset($_FILES['import_file']['tmp_name'])) {
            $filename = $_FILES['import_file']['tmp_name'];
        }
        $data = array();
        if (!empty($filename)) {
              // TODO: Workaround for
            // https://github.com/envato/envato-theme-check/issues/63
            // Should use file_get_contents instead
            if (!defined('FS_METHOD')) {
                define('FS_METHOD', 'direct');
            }
            global $wp_filesystem;
            WP_Filesystem();
            if ($wp_filesystem->exists($filename)) {
                $data = json_decode($wp_filesystem->get_contents($filename), true);
            }
        } elseif (isset($_POST['anps_import'])) {
            $data = json_decode(stripslashes($_POST['anps_import']), true);
        }
        if (!is_array($data)) {
            return;
        }
        foreach ($data as $name => $value) {
            update_option($name, $value);
            if ($name === 'anps_custom_css' && function_exists('wp_update_custom_css_post')) {
                wp_update_custom_css_post($value);
            }
        }
        if ($redirect_to_form) {
            header("Location: themes.php?page=theme_options&sub_page=import_export");
        }
    }
    /* Import widgets data */
    public function import_widgets_data($filename = '')
    {
        $redirect_to_form = false;
        if (isset($_FILES['import_file']['tmp_name'])) {
            $filename = $_FILES['import_file']['tmp_name'];
            $redirect_to_form = true;
        }
        if (empty($filename)) {
            return;
        }
        // TODO: Workaround for
        // https://github.com/envato/envato-theme-check/issues/63
        // Should use file_get_contents instead
        if (!defined('FS_METHOD')) {
            define('FS_METHOD', 'direct');
        }
        global $wp_filesystem;
        WP_Filesystem();
        if (!$wp_filesystem->exists($filename)) {
            return;
        }
        $data = unserialize($wp_filesystem->get_contents($filename));
        $this->save_widgets_data($data);
        if ($redirect_to_form) {
            header("Location: themes.php?page=theme_options&sub_page=import_export_widgets");
        }
    }
    /* Save widgets data to db */
    public function save_widgets_data($data)
    {
        $sidebars = get_option('sidebars_widgets');
        foreach ($data as $area => $widgets) {
            if (empty($widgets)) {
                continue;
            }
            foreach ($widgets as $widget_slug => $fields) {
                $slug_parts = explode('-', $widget_slug);
                array_pop($slug_parts);
                $widget_type = implode('-', $slug_parts);
                if ($widget_type === 'nav_menu' || $widget_type === 'anps_menu') {
                    $id = $this->_get_menu_id($fields['nav_menu']);
                    if (!$id) {
                        continue;
                    }
                    $fields['nav_menu'] = $id;
                }
                $widgets_data = get_option('widget_' . $widget_type, array());
                $widget_count = count($widgets_data) + 1;
                $widgets_data[$widget_count] = $fields;
                update_option('widget_' . $widget_type, $widgets_data);
                $sidebars[$area][] = $widget_type . '-' . $widget_count;
            }
        }
        update_option('sidebars_widgets', $sidebars);
    }
}

$anps_import_export = new AnpsImport();
