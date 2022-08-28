<?php

global $anps_page_data, $row_inner;
$meta = get_post_meta(get_the_ID());
$sidebars = anps_parse_sidebars_from_meta($meta);

$left_sidebar = $sidebars['left_sidebar'];
$right_sidebar = $sidebars['right_sidebar'];
$num_of_sidebars = $sidebars['num_of_sidebars'];

$anps_row_class = $num_of_sidebars > 0 ? 'row' : 'normal';
?>
<section class="container">
    <div class="<?php echo esc_attr($anps_row_class);?>">

        <?php
            while (have_posts()) : the_post();
                if( ! strpos('pre' . get_the_content(), 'vc_row') ) {
                    echo '<div class="row">';
                }

                if ($left_sidebar) { anps_sidebar_html($left_sidebar); wp_reset_query(); } ?>

                <?php if($num_of_sidebars === 0 && strpos('pre' . get_the_content(), 'vc_row')): ?>
                    <?php
                        the_content();

                        if((comments_open() || get_comments_number()) && get_option('anps_page_comments', '0')!=='1'){
                            comments_template();
                        }
                    ?>
                <?php else: ?>
                    <div class='col-md-<?php echo 12-esc_attr($num_of_sidebars)*3; ?>'>
                        <?php
                        the_content();

                        if((comments_open() || get_comments_number()) && get_option('anps_page_comments', '0')!=='1'){
                            comments_template();
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($right_sidebar) anps_sidebar_html($right_sidebar);

                if( ! strpos('pre' . get_the_content(), 'vc_row') ) {
                    echo '</div>';
                }
            endwhile; // end of the loop. ?>
    </div>
</section>
