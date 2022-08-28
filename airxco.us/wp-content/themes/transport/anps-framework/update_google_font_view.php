<?php
include_once get_template_directory() . '/anps-framework/classes/Style.php';

if (isset($_GET['save_font'])) {
    $style->update_gfonts();
}
$google_fonts = $style->get_fonts('Google fonts');
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_google_font&save_font" method="post">
    <div class="content-inner">
        <h3><i class="fab fa-google"></i><?php esc_html_e('Update Google Fonts', 'transport'); ?></h3>
        <p><?php esc_html_e('As Google Fonts are not updated automatically, you can update Google Fonts by clicking the button below.', 'transport'); ?></p>
        <p><button type="submit" class="button"><?php esc_html_e('Update Google Fonts', 'transport'); ?></button></p>
        <br>
        <p class="anps-blue-c">
            <?php esc_html_e('Number of available Google fonts', 'transport'); ?>: <strong><?php echo count($google_fonts); ?></strong><br>
        </p>
    </div>
</form>