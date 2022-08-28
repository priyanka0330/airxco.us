
<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

?>
<div class="xoxo">
<?php
    /* When we call the dynamic_sidebar() function, it'll spit out
     * the widgets for that widget area. If it instead returns false,
     * then the sidebar simply doesn't exist, so we'll hard-code in
     * some default sidebar stuff just in case.
     */
    if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : ?>
    <div>
        <?php get_search_form(); ?>
    </div>

    <div>
        <h3><?php _e( 'Archives', 'transport' ); ?></h3>
        <div>
            <?php wp_get_archives( 'type=monthly' ); ?>
    </div>
    </div>

    <div>
        <h3><?php _e( 'Meta', 'transport' ); ?></h3>
        <div>
            <?php wp_register(); ?>
            <div><?php wp_loginout(); ?></div>
            <?php wp_meta(); ?>
        </div>
    </div>

    <?php endif; // end primary widget area ?>
</div>
<?php
    // A second sidebar for widgets, just because.
    if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
    <div class="xoxo">
        <?php dynamic_sidebar( 'secondary-widget-area' ); ?>
    </div>
<?php endif;
