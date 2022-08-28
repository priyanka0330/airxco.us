<?php
/* Blog shortcode */
function anps_blog_func($atts, $content)
{
    extract(shortcode_atts(array(
        'category' => '',
        'orderby' => '',
        'order' => '',
        'type' => '',
        'columns' => ''
    ), $atts));
    global $wp_rewrite;

    wp_enqueue_script('anps-isotope');

    if (get_query_var('paged') > 1) {
        $current = get_query_var('paged');
    } elseif (get_query_var('page') > 1) {
        $current = get_query_var('page');
    } else {
        $current = 1;
    }
    $args = array(
        'posts_per_page'   => $content,
        'category_name'    => $category,
        'orderby'          => $orderby,
        'order'            => $order,
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'paged'            => $current
    );

    $posts = new WP_Query($args);

    $pagination = array(
        'base' => @esc_url(add_query_arg('page', '%#%')),
        'format' => '',
        'total' => $posts->max_num_pages,
        'current' => $current,
        'show_all' => false,
        'prev_text'    => '',
        'next_text'    => '',
        'type' => 'list',
    );

    switch ($type) {
        case "":
            $blog_type = "content";
            break;
        case "grid":
            $blog_type = "content-blog-grid";
            break;
        case "masonry":
            $blog_type = "content-blog-masonry";
            break;
    }
    global $blog_columns;
    switch ($columns) {
        case "3":
            $blog_columns = " col-md-4";
            break;
        case "4":
            $blog_columns = " col-md-3";
            break;
        default:
            $blog_columns = " col-md-4";
            break;
    }
    $post_text = "";
    if ($posts->have_posts()) :
        if ($type == "masonry") {
            $post_text .= "<div class='blog-masonry'>";
        } else  if ($type == "grid") {
            $post_text .= "<div class='row'>";
        } else {
            $post_text .= "<div>";
        }

        global $counter_blog;
        $counter_blog = 1;
        while ($posts->have_posts()) :
            $posts->the_post();
            ob_start();
            get_template_part($blog_type, get_post_format());
            $counter_blog++;
            $post_text .= ob_get_clean();
        endwhile;
        if ($wp_rewrite->using_permalinks()) {
            $pagination['base'] = user_trailingslashit(trailingslashit(esc_url(remove_query_arg('s', get_pagenum_link(1)))) . 'page/%#%/', 'paged');
        }
        if (!empty($wp_query->query_vars['s'])) {
            $pagination['add_args'] = array('s' => get_query_var('s'));
        }
        $post_text .= "</div>";
        $post_text .= paginate_links($pagination);
        wp_reset_postdata();
    else :
        $post_text .= "<h2>" . __('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'transport') . "</h2>";
    endif;
    return $post_text;
}
add_shortcode("blog", "anps_blog_func");
/* Recent portfolio slider shortcode */
function anps_recent_portfolio_slider_func($atts, $content)
{
    extract(shortcode_atts(array(
        'recent_title' => "",
        'title_color' => "#c1c1c1",
        'nex_prev_color' => "#c1c1c1",
        'nex_prev_bg_color' => "#3d3d3d",
        'image_size' => 'post-thumb',
        'number' => '',
        'number_in_row' => "4",
        'category' => '',
        'orderby' => 'post_date',
        'order' => 'DESC'
    ), $atts));
    $tax_query = '';
    if ($category && $category != '0') {
        $tax_query = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => (int)$category
            )
        );
    }

    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $number,
        'tax_query' => $tax_query
    );
    $portfolio_posts = new WP_Query($args);

    $portfolio_data = "";
    $portfolio_data .= "<div class='container'>";
    $portfolio_data .= "<div class='row owly'><div class='col-md-6 col-xs-6'>";
    if ($recent_title) {
        $portfolio_data .= "<h2 style='color:$title_color;'>" . $recent_title . "</h2>";
    }
    $portfolio_data .= "</div><div class='col-xs-6 col-md-6 align-right'><a class='owlprev' style='background:" . $nex_prev_bg_color . ";'><i class='fa fa-chevron-left' style='color:" . $nex_prev_color . ";'></i></a><a class='owlnext' style='background:" . $nex_prev_bg_color . ";'><i class='fa fa-chevron-right' style='color:" . $nex_prev_color . ";'></i></a></div>";
    $portfolio_data .= "</div></div>";

    $portfolio_data .= "<ul class='owl-carousel recentportfolio clearfix' data-col=" . $number_in_row . ">";
    while ($portfolio_posts->have_posts()) :
        $portfolio_posts->the_post();
        $portfolio_cat = "";
        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if ($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= strtolower(str_replace(" ", "-", $cat->name));
            }
        }
        if (has_post_thumbnail(get_the_ID())) {
            $image = get_the_post_thumbnail(get_the_ID(), $image_size);
            //$image = wp_get_attachment_image( get_post_thumbnail_id(), 'full' );
        } elseif (get_post_meta(get_the_ID(), $key = 'gallery_images', $single = true)) {
            $exploded_images = explode(',', get_post_meta(get_the_ID(), $key = 'gallery_images', $single = true));
            $image_url = wp_get_attachment_image_src($exploded_images[0], array(360, 267));
            $image = "<img src='" . $image_url[0] . "' />";
        }
        $portfolio_data .= "<li class='item item-type-line'>";
        $portfolio_data .= "<div class='mask'></div>";
        $portfolio_data .= "<div class='item-info'>";
        $portfolio_data .= "<div class='headline'>";
        //$portfolio_data .= "<a class='item-hover' href=".get_permalink().">";
        $portfolio_data .= "<h3><a class='item-hover' href=" . get_permalink() . ">" . get_the_title() . "</a></h3>";
        $portfolio_data .= "<a class='btn btn-sm' href=" . get_permalink() . ">" . __("Read more", "transport") . "</a>";
        //$portfolio_data .= "</a>";
        $portfolio_data .= "</div>";
        $portfolio_data .= "</div>";
        $portfolio_data .=  "<div class='item-img'>" . $image . "</div>";
        $portfolio_data .= "</li>";
    endwhile;
    wp_reset_postdata();
    $portfolio_data .= "</ul>";
    return $portfolio_data;
}
add_shortcode("recent_portfolio_slider", "anps_recent_portfolio_slider_func");
/* Recent portfolio shortcode */
function anps_recent_portfolio_func($atts, $content)
{
    extract(shortcode_atts(array(
        'number' => '5',
        'category' => '',
        'image_size' => 'post-thumb',
        'orderby' => 'post_date',
        'order' => 'DESC',
        'mobile_class' => '2'
    ), $atts));
    $tax_query = '';
    if ($category && $category != '0') {
        $tax_query = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => (int)$category
            )
        );
    }

    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $number,
        'tax_query' => $tax_query
    );
    $portfolio_posts = new WP_Query($args);

    if ($mobile_class == "2") {
        $m_class = " col-xs-6";
    } else {
        $m_class = " col-xs-12";
    }
    $portfolio_data = "";
    $portfolio_data .= "<ul class='recentportfolio clearfix'>";
    while ($portfolio_posts->have_posts()) :
        $portfolio_posts->the_post();
        $portfolio_cat = "";
        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if ($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= strtolower(str_replace(" ", "-", $cat->name));
            }
        }
        if (has_post_thumbnail(get_the_ID())) {
            $image = get_the_post_thumbnail(get_the_ID(), $image_size);
        } elseif (get_post_meta(get_the_ID(), $key = 'gallery_images', $single = true)) {
            $exploded_images = explode(',', get_post_meta(get_the_ID(), $key = 'gallery_images', $single = true));
            $image_url = wp_get_attachment_image_src($exploded_images[0], array(360, 267));
            $image = "<img src='" . $image_url[0] . "' />";
        }
        $portfolio_data .= "<li class='item item-type-line$m_class'>";
        // $portfolio_data .= "<a class='item-hover' href=".get_permalink().">";
        $portfolio_data .= "<div class='mask'></div>";
        $portfolio_data .= "<div class='item-info'>";
        $portfolio_data .= "<div class='headline'>";
        //$portfolio_data .= "<a class='item-hover' href=".get_permalink().">";
        $portfolio_data .= "<h3><a class='item-hover' href=" . get_permalink() . ">" . get_the_title() . "</a></h3>";
        $portfolio_data .= "<a class='btn btn-sm' href=" . get_permalink() . ">" . __("Read more", "transport") . "</a>";
        //$portfolio_data .= "</a>";
        $portfolio_data .= "</div>";
        //$portfolio_data .= "<div class='headline'><h2>".get_the_title()."</h2></div>";
        //$portfolio_data .= "</div></a>";
        $portfolio_data .= "</div>";
        $portfolio_data .=  "<div class='item-img'>" . $image . "</div>";
        $portfolio_data .= "</li>";
    endwhile;
    wp_reset_postdata();
    $portfolio_data .= "</ul>";
    return $portfolio_data;
}
add_shortcode("recent_portfolio", "anps_recent_portfolio_func");
/* Portfolio shortcode */
function anps_portfolio_func($atts, $content)
{
    extract(shortcode_atts(array(
        'filter' => 'on',
        'columns' => '4',
        'image_size' => 'post-thumb',
        'category' => '',
        'orderby' => '',
        'order' => '',
        'type' => 'classic',
        'style' => 'filter-style-1',
        'per_page' => -1,
        'mobile_class' => '2',
        'filter_color' => '#000000'
    ), $atts));

    wp_enqueue_script('anps-isotope');

    $type_class = "";
    if ($type == "classic") {
        $type_class = " classic";
    } elseif ($type == "random") {
        $type_class = " random";
    } else {
        $type_class = " default";
    }
    $tax_query = '';
    $parent_cat = "";
    if ($category && $category != '0') {
        $parent_cat = $category;
        $tax_query = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => (int)$category
            )
        );
    }

    $args = array(
        'post_type' => 'portfolio',
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $per_page,
        'tax_query' => $tax_query
    );
    $portfolio_posts = new WP_Query($args);

    /*desktop-class*/
    if ($type != "random") {
        $mdclass = " col-md-3";
        if ($columns == "3") {
            $mdclass = " col-md-4";
        } elseif ($columns == "6") {
            $mdclass = " col-md-2";
        } elseif ($columns == "2") {
            $mdclass = " col-md-6";
        } elseif ($columns == "4") {
            $mdclass = " col-md-3";
        }
    } else {
        $mdclass = "";
    }



    /* Mobile class */
    if ($mobile_class == "2") {
        $m_class = " col-xs-6";
    } else {
        $m_class = " col-xs-12";
    }

    /* Portfolio isotope filter */

    $portfolio_data = "";
    if ($filter == "on") {
        $portfolio_data .= "<ul class='filter " . $style . "'>";
        if ($style != 'filter-style-3') {
            $portfolio_data .= '<li><i style="color: ' . $filter_color . ';" class="fa fa-filter"></i></li>';
        }
        $portfolio_data .= '<li><button class="selected" style="color: ' . $filter_color . ';" data-filter="*">' . __("All", "transport") . "</button></li>";
        $filters = get_terms('portfolio_category', "orderby=none&hide_empty=true&parent=$parent_cat");
        foreach ($filters as $item) {
            if ($style != 'filter-style-3') {
                $portfolio_data .= '<li><span style="color: ' . $filter_color . ';">/</span></li>';
            }
            $portfolio_data .= '<li><button style="color: ' . $filter_color . ';" data-filter="' . strtolower(str_replace(" ", "-", $item->name)) . '">' . $item->name . '</button></li>';
        }
        $portfolio_data .= "</ul>";
    }
    if ($type == "random") {
        $i = 1;
    }

    /* Portfolio isotope filter enabled posts */
    if ($type != "random") {
        $portfolio_data .= "<ul class='portfolio isotope" . $type_class . "'>";
    } else {
        $portfolio_data .= "<ul class='isotope" . $type_class . "'>";
    }

    while ($portfolio_posts->have_posts()) :
        $portfolio_posts->the_post();
        $portfolio_cat = "";
        if (get_the_terms(get_the_ID(), 'portfolio_category')) {
            $first_item = false;
            foreach (get_the_terms(get_the_ID(), 'portfolio_category') as $cat) {
                if ($first_item) {
                    $portfolio_cat .= " ";
                }
                $first_item = true;
                $portfolio_cat .= strtolower(str_replace(" ", "-", $cat->name));
            }
        }
        $portfolio_subtitle = get_post_meta(get_the_ID(), $key = 'anps_subtitle', $single = true);

        $rand_class = "";
        $image_class = $image_size;
        if ($type == "random") {
            switch ($i) {
                case 1:
                    $rand_class = " width-2";
                    $image_class = "portfolio-random-width-2-height-2";
                    break;
                case 4:
                    $rand_class = " height-2";
                    $image_class = "portfolio-random-width-2-height-1";
                    break;
                case 5:
                    $rand_class = " width-2 height-2";
                    $image_class = "portfolio-random-width-4-height-4";
                    break;
                case 10:
                    $rand_class = " width-2";
                    $image_class = "portfolio-random-width-2-height-2";
                    break;
            }
        }
        if (has_post_thumbnail(get_the_ID())) {
            $image = get_the_post_thumbnail(get_the_ID(), $image_class);
        } elseif (get_post_meta(get_the_ID(), $key = 'gallery_images', $single = true)) {
            $exploded_images = explode(',', get_post_meta(get_the_ID(), $key = 'gallery_images', $single = true));
            $image_url = wp_get_attachment_image_src($exploded_images[0], $image_class);
            $image = "<img src='" . $image_url[0] . "' />";
        }



        if ($type != "random") {
            $portfolio_data .= "<li class='isotope-item " . $portfolio_cat . $rand_class . $m_class . $mdclass . "'><article class='inner'>";
            $portfolio_data .= "<div class='item-hover '>";
            $portfolio_data .= "<div class='mask'></div>";
            $portfolio_data .= "<div class='item-info item item-type-line'>";

            if ($type == "default") {
                $portfolio_data .= "<div class='headline'>";
                $portfolio_data .= "<a href=" . get_permalink() . ">";
                $portfolio_data .= "<h3><i class='fa fa-link'></i></h3>";
                $portfolio_data .= "</a>";
                $portfolio_data .= "</div>";
            } else {
                $portfolio_data .= "<div class='headline'>";
                $portfolio_data .= "<h3><a class='item-hover' href=" . get_permalink() . ">" . get_the_title() . "</a></h3>";
                $portfolio_data .= "<a class='btn btn-sm' href=" . get_permalink() . ">" . __("Read more", "transport") . "</a>";
                $portfolio_data .= "</div>";
            }

            //$portfolio_data .= "<div class='line'></div>";
            //$portfolio_data .= "<div class='fa fa-search'></div>";
            $portfolio_data .= "</div></div>";
            $portfolio_data .=  "<div class='item-img'>" . $image . "</div>";
            $portfolio_data .= "</article>";

            if ($type == "default") {
                $portfolio_data .= "<a class='portfolio-title' href=" . get_permalink() . "><h3 class='text-center'>" . get_the_title() . "</h3></a>";
                $portfolio_data .= "<div class='subtitle text-center'>" . $portfolio_subtitle . "</div>";
            }

            $portfolio_data .= "</li>";
        } else {
            $portfolio_data .= "<li class='isotope-item " . $portfolio_cat . $rand_class . $mdclass . "'>";
            $portfolio_data .= "<article class='inner'>";
            //$portfolio_data .= "<a class='item-hover' href=".get_permalink().">";
            $portfolio_data .= "<div class='mask'></div>";
            $portfolio_data .= "<div class='item-info'>";
            //$portfolio_data .= "<div class='headline'><h2>".get_the_title()."</h2></div>";
            $portfolio_data .= "<div class='headline'>";
            $portfolio_data .= "<h3><a class='item-hover' href=" . get_permalink() . ">" . get_the_title() . "</a></h3>";
            $portfolio_data .= "<a class='btn btn-sm' href=" . get_permalink() . ">" . __("Read more", "transport") . "</a>";
            $portfolio_data .= "</div>";

            //$portfolio_data .= "<div class='line'></div>";
            //$portfolio_data .= "<div class='fa fa-search'></div>";
            $portfolio_data .= "</div>";
            //$portfolio_data .="</a>";
            $portfolio_data .=  "<div class='item-img'>" . $image . "</div>";






            //$portfolio_data .= $image;
            // $portfolio_data .= "<div>";
            // $portfolio_data .= "<h2>".get_the_title()."</h2>";
            // $portfolio_data .= "<p>".get_post_meta( get_the_ID(), $key = 'anps_portfolio_shorttext', $single = true )."</p>";
            // $portfolio_data .= "<a href='".get_permalink()."' class='fa fa-link'></a>";
            // $portfolio_data .= "</div>";
            // $portfolio_data .= "</header>";
            // $portfolio_data .= "<h2>".get_post_meta( get_the_ID(), $key = 'anps_subtitle', $single = true )."</h2>";
            $portfolio_data .= "</article>";
            $portfolio_data .= "</li>";
        }


        if ($type == "random") {
            $i++;
        }
    endwhile;
    wp_reset_postdata();
    $portfolio_data .= "</ul>";
    return $portfolio_data;
}
add_shortcode("portfolio", "anps_portfolio_func");
/* Featured Horizontal content */
function anps_featured_horizontal_content_func($atts, $content)
{
    extract(shortcode_atts(array(
        'title' => '',
        'image_u' => '',
        'link' => '',
    ), $atts));

    $image = '';
    $link_el_start = '';
    $link_el_end = '';

    if ($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }

    if ($link) {
        $link_el_start = "<a href='$link'>";
        $link_el_end = "</a>";
    }

    $output = "<div class='featured-horizontal'>";
    $output .= "<div class='featured-horizontal-header'>";
    $output .= "$link_el_start<img alt='$title' src='$image'>$link_el_end";
    $output .= "</div>";
    $output .= "<div class='featured-horizontal-content'>";
    $output .= "$link_el_start<h3 class='featured-horizontal-title'>$title</h3>$link_el_end";
    $output .= "<p class='featured-horizontal-desc'>$content</p>";
    $output .= "</div>";
    $output .= "</div>";

    return $output;
}
add_shortcode('anps_featured_horizontal', 'anps_featured_horizontal_content_func');
/* Image */
function anps_image_func($atts, $content)
{
    extract(shortcode_atts(array(
        'alt' => '',
        'url' => '',
        'target' => '_blank'
    ), $atts));

    $url = str_replace("&quot;", "", $url);
    $alt = str_replace("&quot;", "", $alt);
    $target = str_replace("&quot;", "", $target);
    $img_data = "";
    if ($url) {
        $img_data .= "<a href='" . $url . "' target='" . $target . "'>";
    }
    $img_data .= "<img alt='" . $alt . "' src='" . $content . "' />";
    if ($url) {
        $img_data .= "</a>";
    }
    return $img_data;
}
add_shortcode("image", "anps_image_func");
/* END Image */
/* Team shortcode */
function anps_team_func($atts, $content)
{
    extract(shortcode_atts(array(
        'columns' => '4',
        'category' => '',
        'ids' => '',
        'number_items' => '-1'
    ), $atts));

    $tax_query = '';
    if ($category && $category != 'All' && $category != '0') {
        $tax_query = array(
            array(
                'taxonomy' => 'team_category',
                'field' => 'id',
                'terms' => (int)$category
            )
        );
    }
    /* Select team by member id */
    $array_ids = "";
    $order_by = "date";
    if ($ids) {
        $array_ids = explode(",", $ids);
        $array_ids = array_map("trim", $array_ids);
        $order_by = "post__in";
    }


    $args = array(
        'post_type' => 'team',
        'showposts' => $number_items,
        'columns' => $columns,
        'post__in' => $array_ids,
        'tax_query' => $tax_query,
        'orderby' => $order_by
    );
    global $text_only;
    $class = "6";
    $class_lg = "3";
    $image_class = "team-3";

    $team_class = 'team';

    if ($columns == "3") {
        $class = "4";
        $class_lg = "4";
        $image_class = "team-3";
    } elseif ($columns == "6") {
        $class = "4";
        $class_lg = "2";
        $image_class = "team-3";
    } elseif ($columns == "2") {
        $class = "6";
        $class_lg = "6";
        $image_class = "team-2";
    }

    $team_posts = new WP_Query($args);
    $team_data = "<div class='row'>";
    $text_only = true;
    while ($team_posts->have_posts()) :
        $team_posts->the_post();

        if (get_the_content() != '') {
            $team_class .= ' team-hover';
        }

        $subtitle = get_post_meta(get_the_ID(), $key = 'anps_team_subtitle', $single = true);
        $team_data .= "<div class='col-lg-" . $class_lg . " col-sm-" . $class . "'><div class='" . $team_class . "'>";
        $team_data .= "<header>";
        $team_data .= get_the_post_thumbnail(get_the_ID(), $image_class);
        if (get_the_content() != '') {
            $team_data .= "<div class='hover'>" . do_shortcode(get_the_content()) . "</div>";
        }
        $team_data .= "</header>";
        $team_data .= "<h2>" . get_the_title() . "</h2>";
        $team_data .= "<em>" . $subtitle . "</em>";
        $team_data .= "</div></div>";
    endwhile;
    wp_reset_postdata();
    $text_only = false;
    $team_data .= "</div>";
    return $team_data;
}
add_shortcode("team", "anps_team_func");
/* Recent blog posts */
function anps_recent_blog_func($atts, $content)
{
    extract(shortcode_atts(array(
        'number' => '',
        'col_number' => '',
    ), $atts));
    switch ($col_number) {
        case "2":
            $blog_columns = " col-lg-6 col-md-6 col-sm-6 col-xs-12";
            break;
        case "3":
            $blog_columns = " col-lg-4 col-md-6 col-sm-6 col-xs-12";
            break;
        case "4":
            $blog_columns = " col-lg-3 col-md-6 col-sm-6 col-xs-12";
            break;
        case "6":
            $blog_columns = " col-lg-2 col-md-6 col-sm-6 col-xs-12";
            break;
        default:
            $blog_columns = " col-lg-4 col-md-6 col-sm-6 col-xs-12";
            break;
    }
    $args = array(
        'posts_per_page'   => $number,
        'orderby'          => "date",
        'order'            => "DESC",
        'post_type'        => 'post',
        'post_status'      => 'publish'
    );
    $posts = new WP_Query($args);
    $recent_post_text = "";
    if ($posts->have_posts()) :
        $recent_post_text .= '<div class="recent-posts">';
        while ($posts->have_posts()) :
            $posts->the_post();
            global $more;
            $more = 0;
            $recent_post_text .= "<article class='recentblog" . $blog_columns . "'>";
            if (get_the_post_thumbnail(get_the_ID()) != "") {
                $recent_post_text .= "<header>";
                $recent_post_text .= "<a class='post-hover' href='" . get_permalink() . "'>";

                $recent_post_text .=  "<div class='mask'></div>";
                $recent_post_text .=  "<div class='item-info'>";
                //$recent_post_text .=  "<div class='headline'><h2>".get_the_title()."</h2></div>";
                //$recent_post_text .=  "<div class='line'></div>";
                $recent_post_text .=  "<div class='fa fa-search'></div>";
                $recent_post_text .=  "</div>";
                $recent_post_text .= "</a>";
                $recent_post_text .= "<div class='item-img'>" . get_the_post_thumbnail(get_the_ID(), 'post-thumb') . "</div>";
                $recent_post_text .= "</header>";
            }
            $recent_post_text .= "<div class='titlemichelle'>";
            $recent_post_text .= "<a href='" . get_permalink() . "'><h2>" . get_the_title() . "</h2></a>";
            $recent_post_text .= "<span>" . get_the_date("j.m.Y") . "</span> <span class='by'>/ " . __("by", "transport") . " " . get_the_author() . "</span> / <span>" . get_comments_number() . " " . __("comments", "transport") . "</span>";
            $recent_post_text .= "</div>";
            $recent_post_text .= "<div class='post-content'>" . apply_filters('the_excerpt', get_the_excerpt()) . "</div>";
            $recent_post_text .= "</article>";
        endwhile;
        $recent_post_text .= "</div>";
    endif;
    wp_reset_postdata();
    return $recent_post_text;
}
add_shortcode("recent_blog", "anps_recent_blog_func");
/* Progress */
function anps_progress_func($atts, $content)
{
    extract(shortcode_atts(array(
        'procent' => "0",
        'striped' => "",
        'active' => "",
        'color_class' => 'progress-bar-success'
    ), $atts));

    if ($striped) {
        if ($active) {
            $active = " active";
        }
        $striped = " progress-striped" . $active;
    }
    $progress_data = "";

    if ($content) {
        $progress_data .= "<h4>" . $content . "</h4>";
    }

    $progress_data .= "<div class='progress" . $striped . "'>";
    $progress_data .= "<div class='progress-bar " . $color_class . "' role='progressbar' aria-valuenow='" . $procent . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $procent . "%;'></div>";
    $progress_data .= "</div>";
    return $progress_data;
}
add_shortcode("progress", "anps_progress_func");
/* Counter */
function anps_counter_func($atts, $content)
{
    extract(shortcode_atts(array(
        'icon' => '',
        'icon_type' => '',
        'icon_fontawesome' => '',
        'icon_openiconic' => '',
        'icon_typicons' => '',
        'icon_entypo' => '',
        'icon_linecons' => '',
        'icon_monosocial' => '',
        'max' => '',
        'min' => "0",
        "icon_color" => '',
        "number_color" => '',
        "subtitle_color" => '',
        "border_color" => ''
    ), $atts));

    wp_enqueue_script('countto');
    $icon_style = '';
    $number_style = '';
    $subtitle_style = '';
    $border_style = '';
    $icon_class = 'fa fa-' . $icon;

    /* Check for VC icon types */
    if ($icon_type) {
        if (function_exists('vc_icon_element_fonts_enqueue')) {
            vc_icon_element_fonts_enqueue($icon_type);
        }
        $icon_type = 'icon_' . $icon_type;
        if ($$icon_type) {
            $icon_class = $$icon_type;
        }
    }

    /* Check styles */
    if ($icon_color) {
        $icon_style = " style='color:" . $icon_color . "'";
    }
    if ($number_color) {
        $number_style = " style='color:" . $number_color . "'";
    }
    if ($subtitle_color) {
        $subtitle_style = " style='color:" . $subtitle_color . "'";
    }
    if ($border_color) {
        $border_style = " style='border-color:" . $border_color . "'";
    }
    return "<div class='counter'>
            <div class='wrapbox'$border_style>
                <i class='" . $icon_class . "'$icon_style></i>
                <h2 class='counter-number' data-to='" . $max . "'$number_style>" . $min . "</h2>
                <h3$subtitle_style>" . $content . "</h3>
            </div>

            </div>";
}
add_shortcode("counter", "anps_counter_func");
/* Newsletter widget */
function newsletter_widget_func($atts)
{
    global $wp_widget_factory;
    extract(shortcode_atts(array(
        'widget_name' => "NewsletterWidget"
    ), $atts));

    $widget_name = esc_html($widget_name);

    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')) :
        $wp_class = 'WP_Widget_' . ucwords(strtolower($class));

        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')) :
            return '<p>' . sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct", "transport"), '<strong>' . $class . '</strong>') . '</p>';
        else :
            $class = $wp_class;
        endif;
    endif;

    ob_start();
    the_widget($widget_name, $instance = array(), array(
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('newsletter', 'newsletter_widget_func');
/* Coming soon */
function anps_coming_soon_func($atts, $content)
{
    extract(shortcode_atts(array(
        'image_u' => "",
        'image' => "",
        'title' => "",
        'subtitle' => "",
        'date' => ""
    ), $atts));

    $img_bg = '';

    if ($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }
    if ($image) {
        $img_bg = " style='background-image: url(" . $image . ");'";
    }
    return '<div class="coming-soon"' . $img_bg . '>
		<h1>' . $title . '</h1>
		<h2 class="primary">' . $subtitle . '</h2>
		<ul class="countdown primary"></ul>' .
        do_shortcode($content)
        . '</div>
	<script src="' . get_template_directory_uri()  . "/js/countdown.js" . '"></script>
        <script>
		jQuery(".countdown").countdown("' . $date . '", function(event) {
		     jQuery(this).html(event.strftime("<li>%D<label>days</label></li><li>%H<label>hours</label></li><li>%M <label>minutes</label></li><li>%S<label>seconds</label></li>"));
		});
	</script>';
}
add_shortcode("coming_soon", "anps_coming_soon_func");
/* Twitter */
global $anps_parallax_slug;
$anps_parallax_slug = array();
function anps_twitter_func($atts, $content)
{
    extract(shortcode_atts(array(
        'title' => 'Stay informed',
        'parallax' => 'false',
        'parallax_overlay' => '',
        'image' => '',
        'color' => '',
        'slug' => '',
        'image_u' => ''
    ), $atts));
    if ($image_u) {
        $image = wp_get_attachment_image_src($image_u, 'full');
        $image = $image[0];
    }
    global $anps_parallax_slug;
    $parallax_class = "";
    $parallax_id = "";
    if ($parallax == "true") {
        $parallax_class = " parallax";
        $parallax_id = " $slug";
        $anps_parallax_slug[] = $slug;
    }

    $parallax_overlay_class = "";
    if ($parallax_overlay == "true") {
        $parallax_overlay_class = " parallax-overlay";
    }

    $style = '';
    if ($image) {
        $style = "background-image: url('$image');";
    } elseif ($color) {
        $style = "background-color: $color;";
    }

    load_template(WP_PLUGIN_DIR . '/anps_theme_plugin/TwitterAPIExchange.php');
    $settings = array(
        'oauth_access_token' => "1485322933-oo8YU1ZTz5E4Zt92hTTbCdJoZxIJIabghjnsPkX",
        'oauth_access_token_secret' => "RfXHN2OXMkBYp3IaEqrBmPhUYR2N61P8pyHf8QXqM",
        'consumer_key' => "Zr397FLlTFM4RVBsoLVgA",
        'consumer_secret' => "3Z2wNAG2vvunam2mfJATxnJcThnqw1qu02Xy8QlqFI"
    );
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $content . '&count=3';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $tweets = json_decode($twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest());
    $return = '<section id="carousel' . $parallax_id . '" class="carousel slide twitter' . $parallax_class . $parallax_overlay_class . '" style="' . $style . '" data-ride="carousel">';
    $return .= '<h1>' . $title . '</h1>';
    $return .= '<div class="carousel-inner">';
    $j = 0;
    foreach ($tweets as $tweet) {
        if ($j == "0") {
            $class_active = ' active';
        } else {
            $class_active = '';
        }
        $tweet_text = $tweet->text;
        $tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $tweet_text); //replace links
        $tweet_text = preg_replace('/@([a-z0-9_]+)/i', '<a href="http://twitter.com/$1" target="_blank">@$1</a>', $tweet_text); //replace users
        $return .= '<div class="item' . $class_active . '">' . $tweet_text . '</div>';
        $j++;
    }
    $return .= "</div>";
    $return .= "<ol class='carousel-indicators'>";
    for ($i = 0; $i < count($tweets); $i++) {
        if ($i == 0) {
            $active_class = "active";
        } else {
            $active_class = "";
        }
        $return .= "<li data-target='#carousel' data-slide-to='" . $i . "' class='" . $active_class . "'></li>";
    }
    $return .= "</ol>";
    $return .= "<a class='btn btn-md' href='http://twitter.com/" . $content . "'><i class='fa fa-twitter'></i>" . __("Follow us", "transport") . "</a>";
    $return .= '</section>';
    return $return;
}
add_shortcode("twitter", "anps_twitter_func");
/* END twitter */
/*************************************
 ****** Column layout shortcodes ******
 **************************************/
function content_half_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'id' => '',
        'class' => ''
    ), $atts));
    $content = do_shortcode(shortcode_unautop($content));
    if (
        '</p>' == substr($content, 0, 4)
        and '<p>' == substr($content, strlen($content) - 3)
    )
        $content = substr($content, 4, strlen($content) - 7);

    if ($id == "first") {
        return '<div class="row">
                <div class="col-md-6 ' . $class . '">' . $content . '</div>';
    } elseif ($id == "last") {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>
                </div>';
    } else {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode('content_half', 'content_half_func');
function content_third_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'id' => '',
        'class' => ''
    ), $atts));
    $content = do_shortcode(shortcode_unautop($content));
    if (
        '</p>' == substr($content, 0, 4)
        and '<p>' == substr($content, strlen($content) - 3)
    )
        $content = substr($content, 4, strlen($content) - 7);
    if ($id == "first") {
        return '<div class="row">
                <div class="col-sm-4 ' . $class . '">' . $content . '</div>';
    } elseif ($id == "last") {
        return '<div class="col-sm-4 ' . $class . '">' . $content . '</div>
                </div>';
    } else {
        return '<div class="col-sm-4 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode('content_third', 'content_third_func');
function content_two_third_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'id' => '',
        'class' => ''
    ), $atts));
    $content = do_shortcode(shortcode_unautop($content));
    if (
        '</p>' == substr($content, 0, 4)
        and '<p>' == substr($content, strlen($content) - 3)
    )
        $content = substr($content, 4, strlen($content) - 7);
    if ($id == "first") {
        return '<div class="row">
                <div class="col-sm-8 ' . $class . '">' . $content . '</div>';
    } elseif ($id == "last") {
        return '<div class="col-sm-8 ' . $class . '">' . $content . '</div>
                </div>';
    } else {
        return '<div class="col-sm-8 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode('content_two_third', 'content_two_third_func');
function content_quarter_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'id' => '',
        'class' => ''
    ), $atts));
    $content = do_shortcode(shortcode_unautop($content));
    if (
        '</p>' == substr($content, 0, 4)
        and '<p>' == substr($content, strlen($content) - 3)
    )
        $content = substr($content, 4, strlen($content) - 7);
    if ($id == "first") {
        return '<div class="row">
                <div class="col-md-3 ' . $class . '">' . $content . '</div>';
    } elseif ($id == "last") {
        return '<div class="col-md-3 ' . $class . '">' . $content . '</div>
                </div>';
    } else {
        return '<div class="col-md-3 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode('content_quarter', 'content_quarter_func');
function content_two_quarter_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'id' => '',
        'class' => ''
    ), $atts));
    $content = do_shortcode(shortcode_unautop($content));
    if (
        '</p>' == substr($content, 0, 4)
        and '<p>' == substr($content, strlen($content) - 3)
    )
        $content = substr($content, 4, strlen($content) - 7);
    if ($id == "first") {
        return '<div class="row">
                <div class="col-md-6 ' . $class . '">' . $content . '</div>';
    } elseif ($id == "last") {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>
                </div>';
    } else {
        return '<div class="col-md-6 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode('content_two_quarter', 'content_two_quarter_func');
function content_three_quarter_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'id' => '',
        'class' => ''
    ), $atts));
    $content = do_shortcode(shortcode_unautop($content));
    if (
        '</p>' == substr($content, 0, 4)
        and '<p>' == substr($content, strlen($content) - 3)
    )
        $content = substr($content, 4, strlen($content) - 7);
    if ($id == "first") {
        return '<div class="row">
                <div class="col-md-9 ' . $class . '">' . $content . '</div>';
    } elseif ($id == "last") {
        return '<div class="col-md-9 ' . $class . '">' . $content . '</div>
                </div>';
    } else {
        return '<div class="col-md-9 ' . $class . '">' . $content . '</div>';
    }
}
add_shortcode('content_three_quarter', 'content_three_quarter_func');
/*************************************
 **** END Column layout shortcodes ****
 **************************************/
/* Icon shortcode */
function icon_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'url' => '',
        'target' => '_self',
        'icon' => '',
        'icon_type' => '',
        'icon_fontawesome' => '',
        'icon_openiconic' => '',
        'icon_typicons' => '',
        'icon_entypo' => '',
        'icon_linecons' => '',
        'icon_monosocial' => '',
        'title' => '',
        'subtitle' => '',
        'position' => '',
        'class' => '',
        'title_color' => '',
        'subtitle_color' => '',
        'icon_color' => '',
        'icon_bg_color' => '',
        'image_u' => ''
    ), $atts));

    if ($class == "style-2") {
        switch ($position) {
            case '':
                $position = "icon-left";
                break;
            case "left":
                $position = "icon-left";
                break;
            case "right":
                $position = "icon-right";
                break;
        }
    } else {
        $position = '';
    }
    $title_c = '';
    $subtitle_c = '';
    $icon_c = '';
    $el_pre = '<span>';
    $el_after = '</span>';
    $icon_type_class = 'fa fa-' . $icon;

    /* Check if VC icon is added */
    if ($icon_type) {
        if (function_exists('vc_icon_element_fonts_enqueue')) {
            vc_icon_element_fonts_enqueue($icon_type);
        }
        $icon_type = 'icon_' . $icon_type;
        if ($$icon_type) {
            $icon_type_class = $$icon_type;
        }
    }

    /* Title Color */
    if ($title_color) {
        $title_c = " style='color: " . $title_color . ";'";
    }

    /* Sub Title Color */
    if ($subtitle_color) {
        $subtitle_c = " style='color: " . $subtitle_color . ";'";
    }

    /* Iitle Colors */
    if ($icon_color && $icon_bg_color == '') {
        $icon_c = " style='color: " . $icon_color . ";'";
    } elseif ($icon_color == '' && $icon_bg_color && $class != "style-2") {
        $icon_c = " style='background-color: " . $icon_bg_color . "'";
    } elseif ($icon_color && $icon_bg_color) {
        if ($class != "style-2") {
            $icon_c = " style='color: " . $icon_color . ";background-color: " . $icon_bg_color . "'";
        } else {
            $icon_c = " style='color: " . $icon_color . ";'";
        }
    }

    $icon_el = '<i class="' . $icon_type_class . '"' . $icon_c . '></i>';

    if ($image_u) {
        $icon_el = '<div class="icon-img">' . wp_get_attachment_image($image_u, 'full') . '</div>';
    }

    /* Check if URL */
    if ($url) {
        $el_pre = ' <a href="' . $url . '" target="' . $target . '">';
        $el_after = '</a>';
    }

    /* Return shortcode */
    return '<div class="icon ' . $class . ' ' . $position . '">
            ' . $el_pre . '
                ' . $icon_el . '
                <h2' . $title_c . '>' . $title . '</h2>
                <h3 class="style-2"' . $subtitle_c . '>' . $subtitle . '</h3>
            ' . $el_after . '
            <p>' . $content . '</p>
    </div>';
}
add_shortcode('anps_icon', 'icon_func');
/* Quote */
function quote_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'style' => "style-1"
    ), $atts));
    return '<blockquote class="' . $style . '"><p>' . $content . '</p></blockquote>';
}
add_shortcode('quote', 'quote_func');
/* Color (mark) */
function color_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'style' => '',
        'custom' => ''
    ), $atts));
    $custom = ' style="color: ' . $custom . '"';
    if ($style && $style != "") {
        return '<span' . $custom . ' class="mark ' . $style . '">' . do_shortcode($content) . '</span>';
    } else {
        return '<span' . $custom . ' class="mark">' . do_shortcode($content) . '</span>';
    }
}
add_shortcode('color', 'color_func');
/* Vimeo */
function vimeo_func($atts,  $content)
{
    return '<div class="video-wrapper"><iframe src="https://player.vimeo.com/video/' . $content . '" width="320" height="240" style="border: none !important"></iframe></div>';
}
add_shortcode('vimeo', 'vimeo_func');
/* Youtube */
function youtube_func($atts,  $content)
{
    return '<div class="video-wrapper"><iframe src="https://www.youtube.com/embed/' . $content . '?wmode=transparent" width="560" height="315" style="border: none !important"></iframe></div>';
}
add_shortcode('youtube', 'youtube_func');
/* Button */
global $button_counter;
$button_counter = 0;
function button_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'link'       => '',
        'target'     => '_self',
        'size'       => 'small',
        'style_button'      => 'style-1',
        'color'      => '',
        'background' => '',
        'color_hover' => '',
        'background_hover' => '',
        'icon' => '',
        'icon_type' => '',
        'icon_fontawesome' => '',
        'icon_openiconic' => '',
        'icon_typicons' => '',
        'icon_entypo' => '',
        'icon_linecons' => '',
        'icon_monosocial' => ''
    ), $atts));
    global $button_counter;

    $style_attr = '';
    if ($color && $color != "#ffffff") {
        $style_attr .= "color: " . $color . ";";
    }
    if ($background) {
        $style_attr .= "background-color: " . $background . ";";
        if ($style_button == 'style-3') {
            $style_attr .= "border-color: " . $background . ";";
        }
    }
    if ($target != '' && $link) {
        $target = ' target="' . $target . '"';
    } else {
        $target = '';
    }

    switch ($size) {
        case "large":
            $size = "btn-lg";
            break;
        case "medium":
            $size = "btn-md";
            break;
        case "small":
            $size = "btn-sm";
            break;
    }

    $icon_type_class = 'icon_' . $icon_type;
    $icon_el = '';
    $icon_class = '';

    if ($icon || ($icon_type && $$icon_type_class)) {
        $icon_class = 'fa fa-' . $icon;

        /* Check if VC icon is added */
        if ($icon_type) {
            if (function_exists('vc_icon_element_fonts_enqueue')) {
                vc_icon_element_fonts_enqueue($icon_type);
            }
            if ($$icon_type_class) {
                $icon_class = $$icon_type_class;
            }
        }

        $icon_el = "<i class='" . $icon_class . "'></i>";
    }

    $style_id = "custom-id-" . $button_counter;
    $button_counter++;
    $style_css = '';
    if (!$link) {
        $style_css .= '<button' . $target . ' class="btn ' . $size . ' ' . $style_button . '" id="' . $style_id . '" style="' . $style_attr . '">' . $icon_el . $content . '</button>';
    } else {
        $style_css .= '<a' . $target . ' href="' . $link . '" class="btn ' . $size . ' ' . $style_button . '" id="' . $style_id . '" style="' . $style_attr . '">' . $icon_el . $content . '</a>';
    }
    return $style_css;
}
add_shortcode('button', 'button_func');
/* Error 404 */
function error_404_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'title' => '',
        'sub_title' => ''
    ), $atts));

    return '<div class="error-404">
                    <h1>' . $title . '</h1>
                    <h2>' . $sub_title . '</h2>
                    <a href="javascript:javascript:history.go(-1)" class="btn btn-wide">' . $content . '</a>
                </div>';
}
add_shortcode('error_404', 'error_404_func');
/* Alert */
function anps_alert_func($atts, $content)
{
    extract(shortcode_atts(array(
        'type' => ''
    ), $atts));
    wp_enqueue_script('alert');
    switch ($type) {
        case "":
            $type_class = "";
            $icon = "bell-o";
            break;
        case "warning":
            $type_class = " alert-warning";
            $icon = "exclamation";
            break;
        case "info":
            $type_class = " alert-info";
            $icon = "info";
            break;
        case "success":
            $type_class = " alert-success";
            $icon = "check";
            break;
        case "useful":
            $type_class = " alert-useful";
            $icon = "lightbulb-o";
            break;
        case "normal":
            $type_class = " alert-normal";
            $icon = "hand-o-right";
            break;
    }
    return '<div class="alert' . $type_class . '" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="fa fa-' . $icon . '"></i> ' . $content . '
            </div>';
}
add_shortcode('alert', 'anps_alert_func');
/* Dropcaps */
function anps_dropcaps_func($atts, $content)
{
    extract(shortcode_atts(array(
        'style' => ''
    ), $atts));
    $style_class = "";
    if ($style) {
        $style_class = " style-2";
    }
    return '<p class="dropcaps' . $style_class . '">' . $content . '</p>';
}
add_shortcode("dropcaps", "anps_dropcaps_func");
/* Load VC shortcodes support */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (function_exists('vc_add_shortcode_param')) {
    load_template(WP_PLUGIN_DIR . '/anps_theme_plugin/vc_shortcodes_map.php');

    /* Set as theme (no licence message) */
    add_action('vc_before_init', 'anps_vcSetAsTheme');
    function anps_vcSetAsTheme()
    {
        vc_set_as_theme(true);
    }
    /* END Set as theme (no licence message) */
} else {
    function remove_wpautop($content, $autop = false)
    {
        if ($autop) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
            $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n");
        }
        return do_shortcode(shortcode_unautop($content));
    }
    /* Google maps */
    $google_maps_counter = 0;
    function google_maps_func($atts,  $content)
    {
        global $google_maps_counter;
        $google_maps_counter++;
        extract(shortcode_atts(array(
            'zoom'   => '15'
        ), $atts));
        preg_match_all('#\](.*?)\[/google_maps_item]#', $content, $matches);
        $location = $matches[1][0];
        wp_enqueue_script('gmap3_link');
        wp_enqueue_script('gmap3');
        return "<script>
            jQuery(document).ready(function( $ ) {
                    $('#map$google_maps_counter').gmap3({
                        map:{
                            options:{
                                zoom: $zoom
                            }
                        },
                        marker:{
                          values:[
                            " . do_shortcode($content) . "
                          ],
                          options:{
                            draggable: false
                          },
                          events: {
                            mouseover: function(marker, event, context){
                                var map = $(this).gmap3('get'),
                                infowindow = $(this).gmap3({get:{name:'infowindow'}});
                                if (infowindow){
                                  infowindow.open(map, marker);
                                  infowindow.setContent(context.data);
                                } else {
                                  $(this).gmap3({
                                    infowindow:{
                                      anchor:marker,
                                      options:{content: context.data}
                                    }
                                  });
                                }
                              },
                            mouseout: function(){
                                var infowindow = $(this).gmap3({get:{name:'infowindow'}});
                                if (infowindow){
                                  infowindow.close();
                                }
                              }
                          }
                        },
                        getlatlng:{
                            address: '" . $location . "',
                            callback: function(results){
                                if(!results) return;
                                $(this).gmap3({
                                    map:{
                                        options: {
                                            center: [results[0].geometry.location.lat(), results[0].geometry.location.lng()]
                                        }
                                    }
                                });
                            }
                        }
                    });
                });
            </script>
            <div class='map' id='map$google_maps_counter'></div>";
    }
    add_shortcode('google_maps', 'google_maps_func');
    function anps_google_maps_item($atts,  $content)
    {
        extract(shortcode_atts(array(
            'info' => '',
            'pin' => ''
        ), $atts));
        $info = preg_replace('/[\n\r]+/', "", $info);
        if (isset($pin) && $pin != "") {
            $pin_icon = wp_get_attachment_image_src($pin, 'full');
            $pin_icon = $pin_icon[0];
        } else {
            $pin_icon = get_template_directory_uri() . "/images/gmap/map-pin.png";
        }
        return "{address: '$content', data:'" . $info . "', options:{icon:'$pin_icon'}},";
    }
    add_shortcode('google_maps_item', 'anps_google_maps_item');
    /* Section */
    function section_func($atts, $content)
    {
        return "<div class='container'>
                <div class='row'>
                    <div class='col-md-12'>" .
            do_shortcode($content) . "
                    </div>
                </div>
            </div>";
    }
    add_shortcode('section', 'section_func');
    /* VC single image */
    function anps_vc_single_image($atts, $content)
    {
        extract(shortcode_atts(array(
            'image' => '',
            'border_color' => '',
            'img_link_target' => '',
            'img_size' => '',
            'el_class' => ''
        ), $atts));

        if ($image) {
            $image_src = wp_get_attachment_image_src($image, 'full');
            $image_src = $image_src[0];
        }
        $data = "";
        $data .= "<img src='" . $image_src . "' />";
        return $data;
    }
    add_shortcode('vc_single_image', 'anps_vc_single_image');
    /* VC layer slider */
    function anps_vc_layer_slider($atts, $content)
    {
        return do_shortcode("[layerslider id='" . $atts['id'] . "']");
    }
    add_shortcode('layerslider_vc', 'anps_vc_layer_slider');
    /* VC rev slider */
    function anps_vc_rev_slider($atts, $content)
    {
        return do_shortcode("[rev_slider id='" . $atts['alias'] . "']");
    }
    add_shortcode('rev_slider_vc', 'anps_vc_rev_slider');
    /* VC Row */
    function vc_theme_rows($atts, $content)
    {
        $extra_class = '';
        $extra_id = '';
        $matches = array();

        global $no_container, $row_inner, $text_only;

        if ($row_inner) {
            return vc_theme_rows_inner($atts, $content);
        }

        if ($text_only) {
            return do_shortcode(shortcode_unautop($content));
        }

        /* Check for any user added styles */

        $css = '';
        $style = "";
        if (isset($atts['css'])) {
            $css = $atts['css'];
        }
        $temp = preg_match('/\.vc_custom_(.*?){(.*?)}/s', $css, $matches);
        if (!empty($matches)) {
            $temp = $matches[1];
            $temp_style = $matches[2];

            if ($temp) {
                $extra_class .= ' vc_custom_' . $temp;
            }
            if ($temp_style) {
                $style = 'style="' . $temp_style . '"';
            }
        }

        /* Check for any user added classes */

        if (isset($atts['el_class']) && $atts['el_class']) {
            $extra_class .= ' ' . $atts['el_class'];
        }

        /* Check for any user added IDs */

        if (isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "' . $atts['id'] . '"';
        }

        $coming_soon = anps_get_option('', '0', 'coming_soon');

        if ($coming_soon == "0" || is_super_admin()) {
            if (!isset($atts['has_content']) || $atts['has_content'] == "true") {
                /* Content inside a container */
                $no_container = false;
                return '<section class="container"><div ' . $extra_id . ' class="row' . $extra_class . '" ' . $style . '>' . do_shortcode(shortcode_unautop($content)) . '</div></section>';
            } elseif ($atts['has_content'] == "inside") {
                $no_container = false;
                return '<section ' . $extra_id . ' class="' . $extra_class . '" ' . $style . '><div class="container no-margin"><div class="row">' . do_shortcode(shortcode_unautop($content)) . '</div></div></section>';
            } else {
                /* Fullwidth Content */
                $no_container = true;
                return '<section ' . $extra_id . ' class="row no-margin' . $extra_class . '" ' . $style . '>' . do_shortcode(shortcode_unautop($content)) . '</section>';
            }
        } else {
            /* No wrappers, only when Cooming soon is active */
            $no_container = true;
            return do_shortcode(shortcode_unautop($content));
        }
    }
    function vc_theme_rows_inner($atts, $content)
    {

        /* Check for any user added styles */

        $style = "";

        $css = '';

        if (isset($atts['css'])) {
            $css = $atts['css'];
        }

        $temp = preg_match('/{(.*?)}/s', $css, $matches);
        if (!empty($matches)) {
            $temp = $matches[1];
            if ($temp) {
                $style = 'style="' . $temp . '"';
            }
        }

        return '<div class="row"' . $style . '>' . do_shortcode(shortcode_unautop($content)) . '</div>';
    }
    function vc_theme_vc_row($atts, $content = null)
    {
        return vc_theme_rows($atts, $content);
    }
    function vc_theme_vc_row_inner($atts, $content = null)
    {
        return vc_theme_rows_inner($atts, $content);
    }
    add_shortcode('vc_row', 'vc_theme_rows');
    add_shortcode('vc_row_inner', 'vc_theme_rows_inner');
    /* VC Columns */
    function vc_theme_columns($atts, $content = null)
    {
        if (!isset($atts['width'])) {
            $width = '1/1';
        } else {
            $width = explode('/', $atts['width']);
        }

        global $no_container, $text_only;

        if ($width[1] > 0) {
            $col = (12 / $width[1]) * $width[0];
        } else {
            $col = 12;
        }
        $extra_class = '';

        if (isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' ' . $atts['el_class'];
        }

        if ($no_container || $text_only) {
            return do_shortcode(shortcode_unautop($content));
        } else {
            return '<div class="col-md-' . $col . $extra_class . '">' . do_shortcode(shortcode_unautop($content)) . '</div>';
        }
    }
    add_shortcode('vc_column', 'vc_theme_columns');
    add_shortcode('vc_column_inner', 'vc_theme_columns');
    /* VC Column Text */
    function vc_column_text_func($atts, $content = null)
    {
        return do_shortcode(force_balance_tags($content));
    }
    add_shortcode('vc_column_text', 'vc_column_text_func');
    /* VC Tabs */
    function vc_tabs_func($atts, $content = null)
    {
        if (!isset($atts['type'])) {
            $atts['type'] = "";
        } else {
            $atts['type'] = $atts['type'];
        }
        $content2 = str_replace("vc_tab", "tab", $content);
        return do_shortcode("[tabs type='" . $atts['type'] . "']" . $content2 . "[/tabs]");
    }
    add_shortcode('vc_tabs', 'vc_tabs_func');
    /* Logos */
    function anps_logos_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'in_row' => '3',
            'style' => 'style-1'
        ), $atts));
        $logos_array = explode("[/logo]", $content);
        foreach ($logos_array as $key => $item) {
            if ($item == "") {
                unset($logos_array[$key]);
            }
        }
        $data_col = "";
        $logos_class = "";
        $count_logos = count($logos_array);
        if ($count_logos > $in_row && $style == 'style-2') {
            $data_col = "data-col=" . $in_row;
            $logos_class = 'owl-carousel';
        }

        $return = "<div class='logos-wrapper $style'>";
        $return .= "<ul class='logos " . $logos_class . "' " . $data_col . ">";

        $i = 0;
        foreach ($logos_array as $item) {
            if ($i % $in_row == 0 && $i != 0 && $style == 'style-1') {
                $return .= "</ul><ul class='logos'>" . do_shortcode($item . "[/logo]");
            } else {
                $return .= do_shortcode($item . "[/logo]");
            }
            $i++;
        }
        $return .= "</ul></div>";
        return $return;
    }
    add_shortcode('logos', 'anps_logos_func');
    /* Single logo */
    function anps_logo_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'url' => '',
            'alt' => '',
            'image_u' => '',
            'image_u_hover' => '',
            'img_hover' => '',
            'alt_hover' => ''
        ), $atts));
        if ($image_u) {
            $content = wp_get_attachment_image_src($image_u, 'full');
            $content = $content[0];
        }

        if ($image_u_hover) {
            $img_hover = wp_get_attachment_image_src($image_u_hover, 'full');
            $img_hover = $img_hover[0];
        }
        if ($url) {
            return "<li><a href='" . $url . "' target='_blank'><img src='" . $content . "' alt='" . $alt . "'><span class='hover'><img src='" . $img_hover . "' alt='" . $alt_hover . "'></span></a></li>";
        } else {
            return "<li><span><img src='" . $content . "' alt='" . $alt . "'><span class='hover'><img src='" . $img_hover . "' alt='" . $alt_hover . "'></span></span></li>";
        }
    }
    add_shortcode('logo', 'anps_logo_func');
    /* List */
    global $list_number;
    $list_number = false;
    function anps_list_func($atts, $content)
    {
        extract(shortcode_atts(array(
            'class' => ''
        ), $atts));

        global $list_number;

        if ($class == "number") {
            $list_number = true;
            $return = "<ol class='list'>" . do_shortcode($content) . "</ol>";
            $list_number = false;
            return $return;
        }
        return "<ul class='list " . $class . "'>" . do_shortcode($content) . "</ul>";
    }
    add_shortcode('anps_list', 'anps_list_func');
    /* List item */
    function anps_list_item_func($atts, $content)
    {
        global $list_number;
        if ($list_number) {
            return "<li><span>" . $content . "</span></li>";
        } else {
            return "<li>" . $content . "</li>";
        }
    }
    add_shortcode('list_item', 'anps_list_item_func');
    /* Social icons */
    function anps_social_icons_func($atts,  $content)
    {
        return "<ul class='socialize'>" . do_shortcode($content) . "</ul>";
    }
    add_shortcode('social_icons', 'anps_social_icons_func');
    /* Single social icon */
    function anps_social_icon_item_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'url' => '#',
            'icon' => '',
            'target' => '_blank'
        ), $atts));
        return "<li><a href='" . $url . "' target='" . $target . "' class='fa fa-" . $icon . "'></a></li>";
    }
    add_shortcode('social_icon_item', 'anps_social_icon_item_func');
    /* Statement */
    function statement_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'parallax' => 'false',
            'parallax_overlay' => 'false',
            'image' => '',
            'color' => '',
            'container' => 'false',
            'slug' => '',
            'image_u' => ''
        ), $atts));
        if ($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        }
        global $anps_parallax_slug;
        $parallax_class = "";
        $parallax_id = "";
        if ($parallax == "true") {
            $parallax_class = " parallax";
            $anps_parallax_slug[] = $slug;
            $parallax_id = "id='$slug'";
        }
        $parallax_overlay_class = "";
        if ($parallax_overlay == "true") {
            $parallax_overlay_class = " parallax-overlay";
        }
        $containe_class = "";
        $container_before = "";
        $container_after = "";
        $container_class = '';
        if ($container == "true") {
            $container_before = '<div class="container text-center">';
            $container_after = '</div>';
        }
        $style = '';
        if ($image) {
            $style = "background-image: url('$image');";
        } elseif ($color) {
            $style = "background-color: $color;";
        }
        return '<section ' . $parallax_id . ' class="statement' . $parallax_class . $parallax_overlay_class . '" style="' . $style . '">' . $container_before . do_shortcode($content) . $container_after . '</section>';
    }
    add_shortcode('statement', 'statement_func');
    /* END statement */
    /* Tabs shortcodes */
    global $tabs_counter, $indiv_tab_counter;
    $tabs_counter = 0;
    $indiv_tab_counter = 0;
    function tabs_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'type' => ''
        ), $atts));
        wp_enqueue_script('tab');
        global $tabs_counter, $indiv_tab_counter, $tabs_single;
        $tabs_counter++;
        $sub_tabs_counter = 1;
        $indiv_tab_counter = 0;
        $tabs_single = 0;
        /* Everything inside [tab] shortcode */
        preg_match_all('#\[tab(.*?)\]#', $content, $matches);
        if (isset($matches[1])) {
            $tab_titles = $matches[1];
        }
        $class = "";
        $class_before = "";
        $class_after = "";
        $class_content = "";
        if ($type == 'vertical') {
            $class = ' vertical';
            $class_before = "<div class='col-2-5'>";
            $class_after = "</div>";
            $class_content = " col-9-5";
        }
        $tabs_menu = '';
        $tabs_menu .= $class_before;
        $tabs_menu .= '<ul class="nav nav-tabs' . $class . '" id="tab-' . $tabs_counter . '">';
        $i = 0;
        foreach ($tab_titles as $tab) {
            preg_match_all('/title="(.*?)\"/', $tab, $title_match);
            preg_match_all('/icon="(.*?)\"/', $tab, $icon_match);
            if (isset($icon_match[1][0])) {
                $icon[$i] = " <i class='fa fa-" . $icon_match[1][0] . "'></i>";
            } else {
                $icon[$i] = "";
            }
            if ($sub_tabs_counter == 1) {
                $tabs_menu .= '<li class="active"><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0] . $icon[$i] . '</a></li>';
            } else {
                $tabs_menu .= '<li><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0] . $icon[$i] . '</a></li>';
            }
            $i++;
            $sub_tabs_counter++;
        }
        $tabs_menu .= '</ul>';
        $tabs_menu .= $class_after;
        return $tabs_menu . '<div class="tab-content' . $class_content . '">' . do_shortcode($content) . '</div>';
    }
    add_shortcode('tabs', 'tabs_func');
    /* Tab */
    function tab_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            "title" => "",
            "icon" => ""
        ), $atts));
        global $tabs_counter, $tabs_single;
        $active = "";
        if ($tabs_single == 0) {
            $active = " active";
        }
        //$content = str_replace('&nbsp;', '<p class="blank-line clearfix"><br /></p>', $content);
        $tabs_single++;
        return '<div id="tab' . $tabs_counter . '-' . $tabs_single . '" class="tab-pane' . $active . '">' . do_shortcode($content) . '</div>';
    }
    add_shortcode('tab', 'tab_func');
    $accordion_counter = 0;
    $accordion_opened = false;
    function accordion_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            "opened" => "false",
            'style' => ''
        ), $atts));
        wp_enqueue_script('collapse');
        global $accordion_counter, $accordion_opened;
        $accordion_counter++;
        if ($opened == "true") {
            $accordion_opened = true;
        }
        $style_class = "";
        if ($style == "style-2") {
            $style_class = " style-2 collapsed";
        }
        return '<div class="panel-group' . $style_class . '" id="accordion' . $accordion_counter . '">' .  do_shortcode($content) . '</div>';
    }
    add_shortcode('accordion', 'accordion_func');
    $accordion_item_counter = 0;
    function accordion_item_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'title' => ''
        ), $atts));
        $opened_class = "";
        global $accordion_item_counter, $accordion_opened;
        if ($accordion_opened) {
            $opened_class = " in";
            $closed_class = "";
            $accordion_opened = false;
        } else {
            $closed_class = " class='collapsed'";
        }
        $accordion_item_counter++;
        return '<div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" ' . $closed_class . ' href="#collapse' . $accordion_item_counter . '">' . $title . '</a>
                    </h4>
                </div>
                <div id="collapse' . $accordion_item_counter . '" class="panel-collapse collapse' . $opened_class . '">
                    <div class="panel-body">' .  do_shortcode($content) . '</div>
                </div>
            </div>';
    }
    add_shortcode('accordion_item', 'accordion_item_func');
    /* Contact info */
    function anps_contact_info_func($atts,  $content)
    {
        return "<ul class='contact-info'>" . do_shortcode($content) . "</ul>";
    }
    add_shortcode('contact_info', 'anps_contact_info_func');
    /* Contact info item */
    function anps_contact_info_item_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'icon' => '',
            'icon_type' => '',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypo' => '',
            'icon_linecons' => '',
            'icon_monosocial' => '',
        ), $atts));

        $icon_class = 'fa fa-' . $icon;
        /* Check for VC icon types */
        if ($icon_type) {
            if (function_exists('vc_icon_element_fonts_enqueue')) {
                vc_icon_element_fonts_enqueue($icon_type);
            }
            $icon_type = 'icon_' . $icon_type;
            if ($$icon_type) {
                $icon_class = $$icon_type;
            }
        }

        return "<li><i class='" . $icon_class . "'></i>" . $content . "</li>";
    }
    add_shortcode('contact_info_item', 'anps_contact_info_item_func');
    /* Faq */
    $faq_counter = 0;
    function anps_faq_func($atts, $content)
    {
        wp_enqueue_script('collapse');
        global $faq_counter;
        $faq_counter++;
        return "<div class='panel-group faq' id='accordion" . $faq_counter . "'>" . do_shortcode($content) . "</div>";
    }
    add_shortcode('faq', 'anps_faq_func');
    /* Faq item */
    $faq_item_counter = 0;
    function anps_faq_item_func($atts, $content)
    {
        extract(shortcode_atts(array(
            'title' => '',
            'answer_title' => ''
        ), $atts));
        global $faq_counter;
        global $faq_item_counter;
        $faq_item_counter++;
        $faq_data = "<div class='panel'>";
        $faq_data .= "<div class='panel-heading'>";
        $faq_data .= "<h4 class='panel-title'>";
        $faq_data .= "<a class='collapsed' data-toggle='collapse' data-parent='#accordion" . $faq_counter . "' href='#collapse" . $faq_item_counter . "'>" . $title . "</a>";
        $faq_data .= "</h4>";
        $faq_data .= "</div>";
        $faq_data .= "<div id='collapse" . $faq_item_counter . "' class='panel-collapse collapse'>";
        $faq_data .= "<div class='panel-body'>";
        $faq_data .= "<h4>" . $answer_title . "</h4>";
        $faq_data .= "<p>" . $content . "</p>";
        $faq_data .= "</div>";
        $faq_data .= "</div>";
        $faq_data .= "</div>";
        return $faq_data;
    }
    add_shortcode('faq_item', 'anps_faq_item_func');
    /* Pricing table */
    function anps_pricing_table_func($atts,  $content)
    {
        extract(shortcode_atts(array(
            'title' => '',
            'currency' => '&euro;',
            'price' => '0',
            'period' => '',
            'button_text' => '',
            'button_url' => '',
            'featured' => ""
        ), $atts));

        if ($button_text != '') {
            $button_text = '<li><a class="btn btn-md" href="' . $button_url . '">' . $button_text . '</a></li>';
        }
        $exposed_class = "";
        if ($featured) {
            $exposed_class = " exposed";
        }
        $pricing_data = "<div class='pricing-table$exposed_class'>";
        $pricing_data .= "<header>";
        $pricing_data .= "<h2>" . $title . "</h2>";
        $pricing_data .= "<span class='currency'>" . $currency . "</span><span class='price'>" . $price . "</span>";
        if ($period) {
            $pricing_data .= "<div class='date'>" . $period . "</div>";
        }
        $pricing_data .= "</header>";
        $pricing_data .= "<ul>" . do_shortcode($content) . $button_text . "</ul>";
        $pricing_data .= "</div>";
        return $pricing_data;
    }
    add_shortcode('pricing_table', 'anps_pricing_table_func');
    /* END Pricing table */
    /* Pricing item */
    function anps_pricing_table_item_func($atts,  $content)
    {
        extract(shortcode_atts(array(), $atts));
        return '<li>' . $content . "</li>";
    }
    add_shortcode('pricing_table_item', 'anps_pricing_table_item_func');
    /* Testimonials */
    global $testimonial_counter, $testimonials_style;
    $testimonial_counter = 0;
    function anps_testimonials($atts,  $content)
    {
        extract(shortcode_atts(array(
            'testimonialheading' => '',
            'style' => ''
        ), $atts));
        $testimonials_number = substr_count($content, "[testimonial");
        $class = "testimonials";
        $data_return = "";
        $style_class = "";
        $randomid = substr(md5(rand()), 0, 7);
        if ($style == 'style-3') {
            //accounting style
            global $testimonials_style;
            $testimonials_style = 'style-3';
            $data_return .= '<div class="relative-wrapper">';
            $data_return .= "<div id='" . $randomid . "' class='owl-carousel " . $class . "' data-col='2'>";
            $data_return .= do_shortcode($content);
            $data_return .= "</div>";

            if ($testimonials_number > 2) {
                $data_return .= '<div class="owl-navigation">';
                $data_return .= '<a class="owlprev"><i class="fa fa-chevron-left"></i> <span class="sr-only">' . __('Previous', 'transport') . '<span></a>';
                $data_return .= '<a class="owlnext"><i class="fa fa-chevron-right"></i> <span class="sr-only">' . __('Next', 'transport') . '<span></a>';
                $data_return .= '</div>';
            }
            $data_return .= '</div>';
        } elseif ($style == 'style-4') {
            //industrial style
            $data_return = '';
            $data_return .= '<div class="testimonials">';
            $data_return .= "<h3 class='title'>" . $testimonialheading . "</h3>";
            $data_return .= '<ul class="testimonial-wrap owl-carousel">';
            $data_return .= do_shortcode($content);
            $data_return .= '</ul>';
            /* Slider left/right navigation buttons */
            if ($testimonials_number > 1) {
                $data_return .= '<div class="testimonial-owl-nav owl-nav-pull-right">';
                $data_return .= '<button class="owlprev"><i class="fa fa-angle-left"></i></button>';
                $data_return .= '<button class="owlnext"><i class="fa fa-angle-right"></i></button>';
                $data_return .= '</div>';
            }
            /* END Slider left/right navigation buttons */
            $data_return .= '</div>';
        } else {
            //old style
            if ($style == "white") {
                $class = "testimonials white";
            }
            if ($testimonials_number > "1") {
                $class = "carousel-inner";
                $data_return .= "<div id='" . $randomid . "' class='carousel testimonials slide' data-ride='carousel'>";
            }
            global $testimonial_counter;
            $testimonial_counter = 0;
            $data_return .= '<div class="' . $class . '">' . do_shortcode($content) . '</div>';
            if ($testimonials_number > "1") {
                $data_return .= '<a class="left carousel-control" href="#' . $randomid . '" data-slide="prev">';
                $data_return .= '<span class="fa fa-chevron-left"></span>';
                $data_return .= "</a>";
                $data_return .= '<a class="right carousel-control" href="#' . $randomid . '" data-slide="next">';
                $data_return .= '<span class="fa fa-chevron-right"></span>';
                $data_return .= '</a>';
                $data_return .= "</div>";
            }
        }
        return $data_return;
    }
    add_shortcode('testimonials', 'anps_testimonials');
    /* Testimonial item */
    $testimonial_counter = 0;
    function anps_testimonial($atts,  $content)
    {
        extract(shortcode_atts(array(
            'image' => '',
            'image_u' => "",
            'user_name' => '',
            'user_url' => '',
            'position' => '',
        ), $atts));
        global $testimonial_counter, $testimonials_style;
        $testimonial_counter++;
        $class = "";
        if ($testimonial_counter == "1") {
            $class = " active";
        }

        if ($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        }
        $data = "";
        if ($testimonials_style == 'style-3') {
            //accounting style
            $data .= "<blockquote class='testimonial item" . $class . "'>";
            $data .= '<div class="row">';
            if ($image) {
                $data .= '<div class="col-md-6">';
                $data .= "<img class='testimonial-image' src='" . $image . "' alt='" . $user_name . "' >";
                $data .= '</div>';
                $data .= '<div class="col-md-6">';
            } else {
                $data .= '<div class="col-md-12">';
            }
            $data .= "<h4 class='testimonial-user'>";
            $data .= $user_name;
            $data .= '</h4>';
            if ($position) {
                $data .= "<p class='testimonial-position'>" . $position . "</p>";
            }
            $data .= "<p class='testimonial-content'>" . $content . "</p>";
            $data .= '</div>';
            $data .= '</div>';
        } elseif ($testimonials_style == 'style-4') {
            //industrial style
            $data .= '<li class="clearfix row">';
            $data .= '<div class="user pull-left">';
            if ($image) {
                $data .= '<div class="user-image">';
                $data .= "<img class='user-photo' src='" . $image . "' alt='" . $user_name . "'>";
                $data .= '</div>';
            }
            $data .= '<div class="content pull-left">';
            $data .= "<h3 class='name-user'>$user_name</h3>";
            if ($position) {
                $data .= '<h4 class="jobtitle">' . $position . '</h4>';
            }
            $data .= '<p>' . $content . '</p>';
            $data .= '</div>';
            $data .= '</div>';
            $data .= '</li>';
        } else {
            //old style
            $data .= "<blockquote class='item" . $class . "'>";
            $data .= "<p>" . $content . "</p>";
            $data .= "<div class='cite'>";
            $data .= '<div class="testimonial-footer">';
            if ($image) {
                $data .= "<img src='" . $image . "' >";
            }
            $data .= '<span class="user">' . $user_name . '</span>';
            if ($user_url) {
                $data .= " / ";
                $data .= "<a href='" . $user_url . "' target='_blank'>" . $user_url . "</a>";
            }
            $data .= "</div>";
            $data .= "</div>";
            $data .= "</blockquote>";
        }
        return $data;
    }
    add_shortcode('testimonial', 'anps_testimonial');
}
/* Table */
function anps_table_func($atts,  $content)
{
    return "<div class='table-responsive'><table class='table'>" . do_shortcode($content) . "</table></div>";
}
add_shortcode('table', 'anps_table_func');
/* thead */
function anps_table_thead_func($atts,  $content)
{
    return "<thead>" . do_shortcode($content) . "</thead>";
}
add_shortcode('table_head', 'anps_table_thead_func');
/* tbody */
function anps_table_tbody_func($atts,  $content)
{
    return "<tbody>" . do_shortcode($content) . "</tbody>";
}
add_shortcode('table_body', 'anps_table_tbody_func');
/* tfoot */
function anps_table_tfoot_func($atts,  $content)
{
    return "<tfoot>" . do_shortcode($content) . "</tfoot>";
}
add_shortcode('table_foot', 'anps_table_tfoot_func');
/* data row */
function anps_table_row_func($atts,  $content)
{
    return "<tr>" . do_shortcode($content) . "</tr>";
}
add_shortcode('table_row', 'anps_table_row_func');
/* data column */
function anps_table_td_func($atts,  $content)
{
    return "<td>" . do_shortcode($content) . "</td>";
}
add_shortcode('table_cell', 'anps_table_td_func');
/* data head column */
function anps_table_th_func($atts,  $content)
{
    return "<th>" . do_shortcode($content) . "</th>";
}
add_shortcode('table_heading_cell', 'anps_table_th_func');
/* Heading */
function anps_heading_func($atts,  $content)
{
    extract(shortcode_atts(array(
        'size' => '1',
        'heading_class' => "heading",
        'h_class' => '',
        'h_id' => '',
        'heading_style' => 'style-1',
        'color' => ''
    ), $atts));
    $id = '';
    if ($h_id) {
        $id = " id='" . $h_id . "'";
    }
    switch ($heading_class) {
        case "content_heading":
            $head_class = " class='heading-content $h_class $heading_style'";
            break;
        case "heading":
            $head_class = " class='heading-middle $h_class $heading_style'";
            break;
        case "style-3":
            $head_class = " class='heading-left $h_class $heading_style'";
            break;
    }
    /* heading color */
    $color_h = '';
    if (isset($color) && $color != '') {
        $color_h = " style='color: $color'";
    }
    return '<h' . $size . $head_class . ' ' . $id . $color_h . '><span>' . $content . '</span></h' . $size . '>';
}
add_shortcode('heading', 'anps_heading_func');


/* Timeline */
if (!function_exists('anps_timeline_func')) {
    function anps_timeline_func($atts, $content)
    {
        extract(shortcode_atts(array(), $atts));

        return '<div class="timeline">' . do_shortcode($content) . '</div>';
    }
}
/* END Timeline */
/* Timeline Item */
if (!function_exists('anps_timeline_item_func')) {
    function anps_timeline_item_func($atts, $content)
    {
        extract(shortcode_atts(array(
            'title' => '',
            'year'  => '2016'
        ), $atts));

        $return = '<div class="timeline-item">';
        $return .= '<div class="timeline-year">' . $year . '</div>';
        $return .= '<div class="timeline-content">';
        $return .= '<h3 class="timeline-title">' . $title . '</h3>';
        $return .= '<div class="timeline-text">' . $content . '</div>';
        $return .= '</div>';
        $return .= '</div>';

        return $return;
    }
}
/* END Timeline Item */

/* Featured content */
if (!function_exists('anps_featured_content_func')) {
    function anps_featured_content_func($atts, $content)
    {
        extract(shortcode_atts(array(
            'title' => '',
            'image_u' => '',
            'link' => '',
            'button_text' => 'Read more',
            'video' => '',
            'absolute_img' => '',
            'exposed' => '',
            'icon' => '',
            'style' => ''
        ), $atts));

        if ($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'anps-featured');
            $image = $image[0];
        }

        $has_icon = '';
        if ($icon) {
            $icon = "<i class='fa fa-$icon'></i>";
            $has_icon = ' featured-has-icon';
        }

        $img_class = 'relative';
        $push_top_class = '';
        if ($absolute_img != "") {
            $push_top_class = ' featured-push-top';
        }

        /* Media type */
        $media_class = '';
        if ($video != "") {
            $media_class = ' featured-video';
        }

        $style_class = "";
        if ($style != "") {
            $style_class = ' ' . $style;
        }

        /* Larger content */
        $large_class = '';
        if ($exposed != '') {
            $large_class = ' featured-large';
        }

        $has_link = '';
        if ($link != "") {
            $has_link = ' featured-has-link';
        }

        $has_content = '';
        if ($content != '') {
            $has_content = ' featured-has-content';
        }

        /* Get image from vimeo or youtube if there is no other image */
        if ($video != "" && $image_u == '') {
            if (strpos($video, 'vimeo') !== false) {
                $video_id = explode('/', $video);
                $thumbnail = wp_remote_get('https://vimeo.com/api/v2/video/' . $video_id[3] . '.json');
                if ($thumbnail) {
                    $body = json_decode($thumbnail['body']);
                    $image = $body[0]->thumbnail_large;
                }
            } else {
                $video_explode = explode('v=', $video);
                $image = "https://img.youtube.com/vi/$video_explode[1]/maxresdefault.jpg";
            }
        }

        $output = "<div class='featured$media_class$large_class$push_top_class$has_link$has_icon$has_content$style_class'>";
        $output .= "<div class='featured-header'>";

        $output .= "<img alt='$title' src='$image'/>";

        $output .= "</div>";
        $output .= "<div class='featured-content'>";

        $output .= "<h3 class='featured-title text-uppercase'>{$icon}$title</h3>";

        if ($content != "") {
            $output .= "<p class='featured-desc'>$content</p>";
        }
        if ($link != "") {
            $output .= "<a class='btn btn-md btn-minimal' href='$link'>$button_text</a>";
        }
        $output .= "</div>";
        $output .= "</div>";

        return $output;
    }
}
add_shortcode('anps_featured', 'anps_featured_content_func');
/* END Featured content */
