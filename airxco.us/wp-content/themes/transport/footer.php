<?php

$coming_soon = anps_get_option('', '0', 'coming_soon');
if ((!$coming_soon || $coming_soon == "0") || is_super_admin()) {
    get_sidebar('footer');
}

global $anps_parallax_slug;
if (!is_array($anps_parallax_slug)) $anps_parallax_slug = array();
if (count($anps_parallax_slug)>0) : ?>
<script>
jQuery(function($) {
    <?php for ($i = 0; $i < $anps_parallax_slug_count; $i++) : ?>
    $("#<?php echo esc_js($anps_parallax_slug[$i]); ?>").parallax("50%", 0.6);
    <?php endfor; ?>
});
</script>
<?php endif; ?>
</div>

<div id="scrolltop" class="fixed scrollup"><a class="js--scroll" href="#top" title="Scroll to top"><i class="fa fa-angle-up"></i></a></div>
<input type="hidden" id="theme-path" value="<?php echo get_template_directory_uri(); ?>">
<?php wp_footer(); ?>
</body>
</html>
