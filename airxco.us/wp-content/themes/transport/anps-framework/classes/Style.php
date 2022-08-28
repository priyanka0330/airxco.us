<?php
include_once get_template_directory() . '/anps-framework/classes/Framework.php';

class Style extends Framework {
    public $error = null;

    /* Update google fonts */
    public function update_gfonts($redirect = true) {
        // Get google fonts
        $gfonts = wp_remote_get('https://astudio.si/preview/gfonts/get_fonts.php');
        if (is_wp_error($gfonts)) {
            return null;
        } else {
            $json_data = json_decode($gfonts['body'], true);
            $this->set_option($json_data['items'], 'google_fonts');
            if ($redirect) {
                header("Location: themes.php?page=theme_options&sub_page=theme_style_google_font");
            }
        }
    }

    /* Upload custom font */
    public function upload_font() {
        if (!isset($_FILES['font']['error'])) {
            $this->error = __('Invalid upload!', 'transport');
            return;
        }
        switch ($_FILES['font']['error']) {
            case UPLOAD_ERR_OK:
                break;
            default:
                $this->error = __('Invalid upload!', 'transport');
                return;
        }

        $explode_file_upload = explode(".", $_FILES['font']['name']);
        if ($explode_file_upload[1] !== 'zip') {
            $this->error = __('Only ZIP uploads are supported!', 'transport');
            return;
        }

        $fonts_zip_target = get_template_directory() . '/fonts/' . $_FILES['font']['name'];
        if (file_exists($fonts_zip_target)) {
            $this->error = __('File with same name already exists.', 'transport');
            return;
        }

        // Change upload directory
        add_filter('upload_dir', array($this, 'upload_directory'));

        $movefile = wp_handle_upload($_FILES['font'], array('test_form' => false));
        if (isset($movefile['error']) && !empty($movefile['error'])) {
            $this->error = $movefile['error'];
            return;
        }

        $zip = new ZipArchive();
        $x = $zip->open($fonts_zip_target);
        if ($x === true) {
            $zip->extractTo(get_template_directory() . '/fonts');
            $zip->close();
            unlink($fonts_zip_target);
        }

        $this->update_custom_fonts();
        header("Location: themes.php?page=theme_options&sub_page=theme_style_custom_font");
    }

    /* Get all font files and save it to options */
    public function update_custom_fonts() {
        $dir = get_template_directory() . '/fonts';
        $fonts = array();
        if ($handle = opendir($dir)) {
            while (($entry = readdir($handle)) !== false) {
                if (is_dir("{$dir}/${entry}")) continue;
                $parts = explode('.', $entry);
                $fonts[$parts[0]] = $parts[0];
            }
            closedir($handle);
        }
        $this->set_option($fonts, 'custom_fonts');
    }

    /* New upload directory */
    public function upload_directory($upload) {
        $upload['subdir'] = '/fonts';
        $upload['path'] = get_template_directory() . $upload['subdir'];
        $upload['url'] = get_template_directory_uri() . $upload['subdir'];
        $upload['error'] = $upload['error'];
        return $upload;
    }

    /* Get all fonts */
    public function get_fonts($type = 'all') {
        $fonts = array();
        $fonts['System fonts'] = array(
            array('value' => 'Arial, Helvetica, sans-serif', 'name' => 'Arial'),
            array('value' => 'Arial+Black, Gadget, sans-serif', 'name' => 'Arial black'),
            array('value' => 'Comic+Sans+MS, cursive, sans-serif', 'name' => 'Comic Sans MS'),
            array('value' => 'Courier+New, Courier, monospace', 'name'=> 'Courier New'),
            array('value' => 'Georgia, serif', 'name' => 'Georgia'),
            array('value' => 'Impact, Charcoal, sans-serif', 'name'=>'Impact'),
            array('value' => 'Lucida+Console, Monaco, monospace', 'name'=> 'Lucida Console'),
            array('value' => 'Lucida+Sans+Unicode, "Lucida Grande", sans-serif', 'name'=>'Lucida Sans Unicode'),
            array('value' => 'Palatino+Linotype, Book+Antiqua, Palatino, serif', 'name'=> 'Palatino Linotype'),
            array('value' => 'Tahoma, Geneva, sans-serif', 'name'=> 'Tahoma'),
            array('value' => 'Trebuchet+MS, Helvetica, sans-serif', 'name'=> 'Trebuchet MS'),
            array('value' => 'Times+New+Roman, Times, serif', 'name' => 'Times New Roman'),
            array('value' => 'Verdana, Geneva, sans-serif', 'name'=> 'Verdana')
        );
        $fonts['Custom fonts'] = get_option($this->prefix . 'custom_fonts') ?: array();
        $fonts['Google fonts'] = get_option($this->prefix . 'google_fonts') ?: array();
        return isset($fonts[$type]) ? $fonts[$type] : $fonts;
    }

    /* Save style options */
    public function save() {
        $font_options = array('font_type_1', 'font_type_2', 'font_type_navigation');
        foreach ($_POST as $name => $value) {
            // Save any non-font option
            if (!in_array($name, $font_options)) {
                update_option($name, $value);
                continue;
            }
            // Handle font options separately
            $fonts = explode('|', $value);
            update_option($name, $fonts[0]);
            update_option(str_replace('type', 'source', $name), $fonts[1]);
        }
        // Clear caches after saving options
        delete_transient('anps_theme_options_styles');
        delete_transient('anps_theme_options_styles_css');
        delete_transient('anps_theme_options_buttons');
        delete_transient('anps_theme_options_buttons_css');
        // Reload page
        header("Location: themes.php?page=theme_options&sub_page=theme_style");
    }
}

$style = new Style();