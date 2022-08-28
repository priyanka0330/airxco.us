<?php get_header(); ?>
<section class="container" id="site-content">
    <div class="row">
        <div class="col-md-9">
        <?php
        if( have_posts() ) :
            while (have_posts()) : the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
            the_posts_pagination(array(
                'prev_text' => '<i class="fa fa-angle-left"></i> ' . esc_html__( 'Previous ', 'transport' ),
                'next_text' => esc_html__( 'Next', 'transport' ) . ' <i class="fa fa-angle-right"></i>',
            ));
        endif;
        ?>
        </div>
        <aside class="sidebar col-md-3"><?php dynamic_sidebar("sidebar"); ?></aside>
    </div>
</section>
<?php get_footer();
