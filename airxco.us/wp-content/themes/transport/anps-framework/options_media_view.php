<?php
include_once get_template_directory() . '/anps-framework/classes/Options.php';

if (isset($_GET['save_media'])) {
    if (!isset($_POST['auto_adjust_logo'])) {
        $_POST['auto_adjust_logo'] = '';
    }
    $options->save_media();
}

include_once get_template_directory() . '/anps-framework/classes/Style.php';

wp_register_script('my-upload', get_template_directory_uri() . 'anps-framework/upload_image.js', array('jquery', 'media-upload', 'thickbox'));
wp_enqueue_style('thickbox');

$anps_media_data = $options->get_media();
?>
<form action="themes.php?page=theme_options&sub_page=options_media&save_media" method="post">
    <div class="content-top"><input type="submit" value="<?php esc_html_e('Save all changes', "transport"); ?>" />
        <div class="clear"></div>
    </div>
    <div class="content-inner">
        <h3><?php esc_html_e('Heading background:', 'transport'); ?></h3>
        <!-- Heading background -->
        <div class="input floatleft onehalf anps_upload">
            <label for="anps_heading_bg"><?php esc_html_e('Page heading background', 'transport'); ?></label>
            <input id="anps_heading_bg" type="text" size="36" name="anps_heading_bg" value="<?php echo anps_get_option($anps_media_data, 'heading_bg'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e('Enter an URL or upload an image for the page heading background.', 'transport'); ?></p>
            <div class="clear"></div>
        </div>
        <!-- Search heading background -->
        <div class="input onehalf anps_upload">
            <label for="search_heading_bg"><?php esc_html_e('Search page heading background', 'transport'); ?></label>
            <input id="anps_search_heading_bg" type="text" size="36" name="anps_search_heading_bg" value="<?php echo anps_get_option($anps_media_data, 'search_heading_bg'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e('Enter an URL or upload an image for the search page heading background.', 'transport'); ?></p>
            <div class="clear"></div>
        </div>
        <hr>
        <h3><?php esc_html_e('Favicon and logo:', 'transport'); ?></h3>
        <p><?php esc_html_e('If you would like to use your logo and favicon, upload them to your theme here.', 'transport'); ?></p>

        <!-- Logo -->
        <div class="input onehalf floatleft anps_upload">
            <label for="anps_logo"><?php esc_html_e('Logo', 'transport'); ?></label>
            <?php
            $logo_width = 158;
            $logo_height = 33;

            $anps_logo_width = anps_get_option($anps_media_data, 'logo-width');
            $anps_logo_height = anps_get_option($anps_media_data, 'logo-height');
            if (isset($anps_logo_width) && $anps_logo_width != '') {
                $logo_width = anps_get_option($anps_media_data, 'logo-width');
            }
            if (isset($anps_logo_height) && $anps_logo_height != '') {
                $logo_height = anps_get_option($anps_media_data, 'logo-height');
            }

            if (anps_get_option($anps_media_data, 'logo') != '') :
            ?>
                <div class="preview"><img width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo anps_get_option($anps_media_data, 'logo'); ?>"></div>
            <?php endif; ?>
            <input id="anps_logo" type="text" size="36" name="anps_logo" value="<?php echo anps_get_option($anps_media_data, 'logo'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e('Enter an URL or upload an image for the logo.', 'transport'); ?></p>

            <div class="input fullwidth" style="min-height:0;">
                <?php
                $checked = '';
                if (get_option('auto_adjust_logo', 'on') == "on") {
                    $checked = 'checked';
                }
                ?>
                <label class="onehalf floatleft" for="auto_adjust_logo"><?php esc_html_e('Auto adjust logo size?', 'transport'); ?></label>
                <div class="onehalf floatleft last" style="text-align:left; margin-top: 3px;">
                    <input id="auto_adjust_logo" class="small_input" style="margin-left: 0px; margin-top: 10px;" type="checkbox" name="auto_adjust_logo" <?php echo esc_attr($checked); ?> />
                </div>
            </div>

            <div class="input onehalf floatleft first addspace onoff">
                <label for="logo-width"><?php esc_html_e('Logo width', 'transport'); ?></label>
                <input style="width: 100px;" id="logo-width" type="text" name="anps_logo-width" value="<?php echo esc_attr($logo_width); ?>" /> <span class="unit">px</span>
            </div>

            <div class="input onehalf floatleft last addspace onoff">
                <label for="logo-height"><?php esc_html_e('Logo height', 'transport'); ?></label>
                <input style="width: 100px;" id="logo-height" type="text" name="anps_logo-height" value="<?php echo esc_attr($logo_height); ?>" /> <span class="unit">px</span>
            </div>
        </div>
        <!-- Sticky logo -->
        <div class="input onehalf stickylogo anps_upload">
            <label for="anps_sticky_logo"><?php esc_html_e('Sticky logo', 'transport'); ?></label>
            <?php if (anps_get_option($anps_media_data, 'sticky_logo') != '') : ?>
                <div class="preview onehalf"><img width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo anps_get_option($anps_media_data, 'sticky_logo'); ?>"></div>
            <?php endif; ?>
            <input class="wninety" id="anps_sticky_logo" type="text" size="36" name="anps_sticky_logo" value="<?php echo anps_get_option($anps_media_data, 'sticky_logo'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p clasS="fullwidth"><?php esc_html_e('Enter an URL or upload an image for the logo.', 'transport'); ?></p>
        </div>
        <div class="clear"></div>
        <hr>
        <!-- Favicon -->
        <div class="input onehalf anps_upload">
            <label for="favicon"><?php esc_html_e('Favicon', 'transport'); ?></label>
            <?php if (anps_get_option($anps_media_data, 'favicon') != "") : ?>
                <div class="preview"><img src="<?php echo anps_get_option($anps_media_data, 'favicon'); ?>"></div>
            <?php endif; ?>
            <input id="anps_favicon" type="text" size="36" name="anps_favicon" value="<?php echo anps_get_option($anps_media_data, 'favicon'); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php esc_html_e('Enter an URL or upload an image for the favicon.', 'transport'); ?></p>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('Text based logo', 'transport'); ?></h3>
        <div class="input twothirds">
            <label for="anps_text_logo"><?php esc_html_e('Text based logo', 'transport'); ?></label>
            <?php $value2 = get_option('anps_text_logo', '');
            wp_editor(str_replace('\\"', '"', $value2), 'anps_text_logo', array(
                'wpautop' => true,
                'media_buttons' => false,
                'quicktags' => false,
                'textarea_name' => 'anps_text_logo',
                'tinymce' => array(
                    'toolbar1' => 'bold, italic, underline, forecolor, fontsizeselect',
                    'toolbar2' => ''
                )
            )); ?>
        </div>
        <div class="input onethird">
            <label for="anps_text_logo_font"><?php esc_html_e('Logo font', 'transport'); ?></label>
            <select name="anps_text_logo_font" id="anps_text_logo_font">
                <?php
                    $all_fonts = $style->get_fonts();
                    $logo_font = get_option('anps_text_logo_font');
                    foreach ($all_fonts as $group => $fonts) : ?>
                    <optgroup label="<?php echo esc_attr($group); ?>">
                        <?php foreach ($fonts as $font) :
                            $optval = esc_attr($font['value'] . '|' . $group);
                            printf(
                                '<option value="%s"%s>%s</option>',
                                $optval,
                                $optval === $logo_font ? ' selected' : '',
                                esc_attr($font['name'])
                            );
                        endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>
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