<?php
global $anps_page_data, $row_inner;
$meta = get_post_meta(get_the_ID());
$sidebars = anps_parse_sidebars_from_meta($meta);

$left_sidebar = $sidebars['left_sidebar'];
$right_sidebar = $sidebars['right_sidebar'];
$num_of_sidebars = $sidebars['num_of_sidebars'];

if ($num_of_sidebars > 0) : $row_inner = true; ?>
<section class="container legacy">
    <div class="row">
<?php endif; ?>
        <?php
            while (have_posts()) : the_post();
                if( ! strpos('pre' . get_the_content(), 'vc_row') ) {
                    echo '<section class="container legacy"><div class="row">';
                }

                if ($left_sidebar) { anps_sidebar_html($left_sidebar); wp_reset_query(); } ?>

                <?php if($num_of_sidebars == 0 && strpos('pre' . get_the_content(), 'vc_row')): ?>
                    <?php the_content(); ?>
                <?php else: ?>
                    <div class='col-md-<?php echo 12-esc_attr($num_of_sidebars)*3; ?>'><?php the_content(); ?></div>
                <?php endif; ?>

                <?php if ($right_sidebar) anps_sidebar_html($right_sidebar);

                if( ! strpos('pre' . get_the_content(), 'vc_row') ) {
                    echo '</div></section>';
                }
            endwhile; // end of the loop.
        ?>
<?php if ($num_of_sidebars > 0): ?>
    </div>
</section>
<?php endif; ?>
