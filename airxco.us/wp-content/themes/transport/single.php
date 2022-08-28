<?php
$coming_soon = anps_get_option('', '0', 'coming_soon');
if(($coming_soon || $coming_soon!="0")&&!is_super_admin()) {
    get_header();
    $post_soon = get_post($coming_soon);
    echo do_shortcode($post_soon->post_content);
    get_footer();
} else {
get_header();
$meta = get_post_meta(get_the_ID());
$sidebars = anps_parse_sidebars_from_meta($meta, 'post');

$left_sidebar = $sidebars['left_sidebar'];
$right_sidebar = $sidebars['right_sidebar'];
$num_of_sidebars = $sidebars['num_of_sidebars'];

global $row_inner;

if ($num_of_sidebars > 0) {
    $row_inner = true;
}
?>

<section class="blog-single">
    <div class="container">
        <div class="row">
        <?php if ($left_sidebar) anps_sidebar_html($left_sidebar); ?>
        <div class="<?php if($num_of_sidebars == 1) { echo "col-md-9"; } else if($num_of_sidebars == 2) { echo "col-md-6"; } else { echo "col-md-12"; } ?>">
        <?php while(have_posts()) {
            the_post();
            get_template_part( 'content-single-blog', get_post_format() );
            wp_link_pages();
            comments_template();
        } ?>
        </div>
        <?php if ($right_sidebar) anps_sidebar_html($right_sidebar); ?>
        </div>
    </div>
</section>
<?php get_footer();
}
