<?php get_header(); ?>
<div class="container search-page">
    <?php if ( have_posts() ) : $num = wp_count_posts(); ?>
        <ol class="search-posts">
            <?php while ( have_posts() ) : the_post(); ?>
                <li class="search-post">
                    <a href="<?php echo the_permalink(); ?>">
                        <h2 class="search-post-title"><?php the_title(); ?></h2>
                    </a>
                    <div class="search-post-meta">
                        <?php _e('By', 'transport') ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a> <?php _e('on', 'transport') ?> <?php echo get_the_date(); ?>
                    </div>
                    <p class="search-post-desc">
                        <?php the_excerpt(); ?>
                    </p>
                </li>
            <?php endwhile; ?>
        </ol>
        <?php the_posts_pagination(array(
            'prev_text' => '<i class="fa fa-angle-left"></i> <span class="nav-link-label">' . esc_html__('Previous ', 'transport') . '</span>',
            'next_text' => '<span class="nav-link-label">' . esc_html__('Next ', 'transport') . '</span> <i class="fa fa-angle-right"></i>'
        )); ?>
    <?php else : ?>
        <h2 class="no-results"><?php _e('No results found for:', "transport"); ?> <span><?php echo esc_attr($_GET['s']); ?></span></h2>
    <?php endif; ?>
</div>
<?php get_footer();
