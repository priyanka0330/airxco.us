<?php
get_header();

$coming_soon = get_option('anps_coming_soon', '0');

if ($coming_soon !== '0' && !is_super_admin()) {
    $post_soon = get_post(intval($coming_soon));
    echo do_shortcode($post_soon->post_content);
} else {
    $meta = get_post_meta(get_queried_object_id());
    $sidebars = anps_parse_sidebars_from_meta($meta, 'post');
    $left_sidebar = $sidebars['left_sidebar'];
    $right_sidebar = $sidebars['right_sidebar'];
    $num_of_sidebars = $sidebars['num_of_sidebars'];
    global $row_inner;
    if ($num_of_sidebars > 0) {
        $row_inner = true;
    }
    ?>
    <section class="container">
        <div class="row">
            <?php
            if ($left_sidebar) anps_sidebar_html($left_sidebar);

            if (have_posts()) : ?>
                <div class="col-md-<?php echo esc_attr(12 - $num_of_sidebars * 3) ?>">
                    <?php
                        while (have_posts()) : the_post();
                            get_template_part('content', get_post_format());
                        endwhile;
                        the_posts_pagination(array(
                            'prev_text' => '<i class="fa fa-angle-left"></i> <span class="nav-link-label">' . esc_html__('Previous ', 'transport') . '</span>',
                            'next_text' => '<span class="nav-link-label">' . esc_html__('Next ', 'transport') . '</span> <i class="fa fa-angle-right"></i>'
                        ));
                    ?>
                </div>
            <?php endif;

            if ($right_sidebar) anps_sidebar_html($right_sidebar);
            ?>
        </div>
    </section>
    <?php
}

get_footer();
