<?php
global $anps_options_data;
$prefooter = anps_get_option('', '', 'prefooter') !== '';
$footer_not_disabled = anps_get_option('', '', 'footer_disable') !== 'on' && (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4'));
$footer_copyright = is_active_sidebar('copyright-1') || is_active_sidebar('copyright-2');

if (!$prefooter && !$footer_not_disabled && !$footer_copyright) return '';

$footer_columns = get_option('anps_footer_style', '4');
$prefooter_columns = anps_get_option('', '4', 'prefooter_style');
$copyright_footer = anps_get_option('', '1', 'copyright_footer');
$footer_class = "2";
$footer_style = get_option('anps_footer_widget_style', '1');
$footer_style_class = 'style-' . $footer_style;

if(anps_get_option($anps_options_data, 'footer_columns')=="1") {
    $footer_class = "col-xs-12";
} else {
    $footer_class = "col-xs-6";
}
?>

<footer class="site-footer <?php echo esc_attr($footer_style_class);?>">
    <?php if ($prefooter) : ?>
    <div class="container">
        <div class="row">
            <?php if($prefooter_columns=='2' || $prefooter_columns=='5' || $prefooter_columns=='6') : ?>
                <div class="<?php echo esc_attr($footer_class); ?> col-md-<?php if($prefooter_columns=='2'){echo "6";}elseif($prefooter_columns=='5'){echo "9";}elseif($prefooter_columns=='6'){echo "3";} ?>"><?php dynamic_sidebar( 'prefooter-1' ); ?></div>
                <div class="<?php echo esc_attr($footer_class); ?> col-md-<?php if($prefooter_columns=='2'){echo "6";}elseif($prefooter_columns=='5'){echo "3";}elseif($prefooter_columns=='6'){echo "9";} ?>"><?php dynamic_sidebar( 'prefooter-2' ); ?></div>
            <?php elseif($prefooter_columns=='3') : ?>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-1' ); ?></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-2' ); ?></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-3' ); ?></div>
            <?php elseif($prefooter_columns=='4' || $prefooter_columns=='0') : ?>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-1' ); ?></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-2' ); ?></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-3' ); ?></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'prefooter-4' ); ?></div>
            <?php endif; ?>
	</div>
    </div>
    <?php endif; ?>
    <?php if ($footer_not_disabled) : ?>
    <div class="container">
        <div class="row">
            <?php if($footer_columns=='2') : ?>
                <div class="col-md-6 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                <div class="col-md-6 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-2' ); ?></div>
            <?php elseif($footer_columns=='3') : ?>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-3' ); ?></div>
            <?php elseif($footer_columns=='4' || $footer_columns=='0') : ?>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                <div class="col-md-3 tablets-clear <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-3' ); ?></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><?php dynamic_sidebar( 'footer-4' ); ?></div>
            <?php endif; ?>
	</div>
    </div>
    <?php endif; ?>
    <?php if ($footer_copyright) : ?>
    <div class="copyright-footer">
        <div class="container">
            <div class="row">
                <?php if($copyright_footer=="1" || $copyright_footer=="0") : ?>
                    <div class="text-center"><?php dynamic_sidebar('copyright-1'); ?></div>
                <?php elseif($copyright_footer=="2") : ?>
                    <div class="col-md-6"><div><?php dynamic_sidebar('copyright-1'); ?></div></div>
                    <div class="col-md-6 text-right"><div><?php dynamic_sidebar('copyright-2'); ?></div></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</footer>
