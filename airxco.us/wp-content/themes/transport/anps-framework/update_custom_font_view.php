<?php
include_once get_template_directory() . '/anps-framework/classes/Style.php';

if (isset($_GET['save_font']) && isset($_FILES['font'])) {
    $style->upload_font();
} else {
    $style->update_custom_fonts();
}
$custom_fonts = $style->get_fonts('Custom fonts');
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_custom_font&save_font" method="post" enctype="multipart/form-data">
    <div class="content-inner">
        <h3><i class="fa fa-text-height"></i><?php esc_html_e("Upload custom fonts", 'transport'); ?></h3>
        <?php if ($style->error) : ?>
            <div class="alert alert-danger alert-no-icon"><?php echo esc_html($style->error); ?></div>
        <?php endif; ?>
        <p><?php esc_html_e('To maximize your customization you can upload your own typography.', 'transport'); ?></p>
        <p><strong><?php esc_html_e('Instructions', 'transport'); ?>:</strong> <?php
            printf(
                esc_html__('All fonts should be archived in a ZIP file. If you have OpenType (.otf) or TrueType (.ttf) files it\'s recommended that you also create WOFF and WOFF2 files using a tool like %s. Your archive should look something like this:', 'transport'),
                '<a href="https://cloudconvert.com/ttf-to-woff2" target="_blank">CloudConvert</a>'
            );
        ?></p><pre>
    myfonts.zip
    - MyFont-Regular.ttf
    - MyFont-Regular.woff2
    - MyFont-Bold.ttf
    - MyFont-Bold.woff2</pre>
        <?php
            $save_dir = get_template_directory() . '/fonts';
            if (!is_writable($save_dir)) : ?>
            <div class="alert alert-danger alert-no-icon">
                <?php printf(esc_html__('The directory %s must be writable.', 'transport'), '<b>' . $save_dir . '</b>'); ?>
            </div>
        <?php else : ?>
            <p>
                <input type="file" class="custom" name="font"><br>
                <button type="submit" class="button"><?php esc_html_e('Upload', 'transport'); ?></button>
            </p>
            <br>
        <?php endif; ?>
        <div class="anps-blue-c">
            <strong><?php esc_html_e('Installed custom fonts', 'transport'); ?>:</strong><br>
            <?php if (!empty($custom_fonts)) : ?>
            <ul class="small">
                <?php foreach ($custom_fonts as $font) : ?>
                <li><?php echo esc_html($font['name']); ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</form>