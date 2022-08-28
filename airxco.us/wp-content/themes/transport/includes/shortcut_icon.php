<?php 
global $anps_media_data;

if (anps_get_option($anps_media_data, 'favicon') != "") : ?>
    <link rel="shortcut icon" href="<?php echo esc_url(anps_get_option($anps_media_data, 'favicon')); ?>" type="image/x-icon" />
<?php endif; ?>