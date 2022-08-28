<?php

$meta = get_post_meta(get_queried_object_id());
$sidebars = anps_parse_sidebars_from_meta($meta, 'post');

$left_sidebar = $sidebars['left_sidebar'];
$right_sidebar = $sidebars['right_sidebar'];
$num_of_sidebars = $sidebars['num_of_sidebars'];

$image_class = $num_of_sidebars > 0 ? 'large' : 'blog-full';

global $counter_blog;
/* get blog categories */
$post_categories = wp_get_post_categories(get_the_ID());

$sticky_class = "";
if (is_sticky(get_the_ID())) {
    $sticky_class = " post-sticky";
}

    $post_data = "<article class='post style-2$sticky_class'>";
    $post_data .= "<header>";
if (is_sticky(get_the_ID()) && strlen(anps_header_media(get_the_ID(), $image_class)) > 0) {
    $post_data .= "<div class='absolute stickymark'><div class='triangle-topleft hovercolor'></div><i class='nav_background_color fa fa-thumb-tack'></i></div>";
}
    $post_data .= "<a href='" . get_permalink() . "'>" . anps_header_media(get_the_ID(), $image_class) . "</a>";

    /* Post Meta */
if (
    get_option('anps_post_meta_comments') != '1' ||
        get_option('anps_post_meta_categories') != '1' ||
        get_option('anps_post_meta_author') != '1' ||
        get_option('anps_post_meta_date') != '1'
) {
    $post_data .= "<div class='post-meta'>";
    $post_data .= "<ul>";

    /* Comments */
    if (get_option('anps_post_meta_comments') != '1') {
        $post_data .= "<li class='post-meta-comments'><i class='hovercolor fa fa-comment-o'></i><a href='" . get_permalink() . "#comments'>" . get_comments_number() . " " . __("comments", 'transport') . "</a></li>";
    }

    /* Categories */
    if (get_option('anps_post_meta_categories') != '1') {
        $post_data .= "<li class='post-meta-categories'><i class='hovercolor fa fa-folder-o'></i>";
        $first_item = false;
        foreach ($post_categories as $c) {
            $cat = get_category($c);
            if ($first_item) {
                $post_data .= ", ";
            }
            $first_item = true;
            $post_data .= "<a href='" . get_category_link($c) . "'>" . $cat->name . "</a>";
        }
        $post_data .= "</li>";
    }

    /* Author */
    if (get_option('anps_post_meta_author') != '1') {
        $post_data .= "<li class='post-meta-author'><i class='hovercolor fa fa-user'></i>" . __("posted by", 'transport') . " <a href='" . get_author_posts_url(get_the_author_meta('ID')) . "' class='author'>" . get_the_author() . "</a></li>";
    }

    /* Date */
    if (get_option('anps_post_meta_date') != '1') {
        $post_data .= "<li class='post-meta-date'><i class='hovercolor fa fa-calendar'></i>" . get_the_date() . "</li>";
    }

    $post_data .= "</ul>";
    $post_data .= "</div>";
}

    $post_data .= "</header>";
if (is_sticky(get_the_ID()) && strlen(anps_header_media(get_the_ID(), $image_class)) < 1) {
    $post_data .= "<a href='" . get_permalink() . "'><h1><i class='fa fa-thumb-tack hovercolor'></i>&nbsp;" . get_the_title() . "</h1></a>";
} else {
    $post_data .= "<a href='" . get_permalink() . "''><h1>" . get_the_title() . "</h1></a>";
}

    $post_data .= "<div class='post-content clearfix'>" . apply_filters('the_excerpt', get_the_excerpt()) . "</div>";
    $post_data .= '<a class="btn btn-sm style-4" href="' . get_permalink() . '">' . __("Read more", 'transport') . '</a>';

$post_data .= "</article>";
$allowed_tags = wp_kses_allowed_html('post');
echo wp_kses($post_data, $allowed_tags); //PHPCS: XSS ok.
