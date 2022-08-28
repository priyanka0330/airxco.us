<?php
/* number of sidebars */
$meta = get_post_meta(get_queried_object_id());
$sidebars = anps_parse_sidebars_from_meta($meta, 'post');

$left_sidebar = $sidebars['left_sidebar'];
$right_sidebar = $sidebars['right_sidebar'];
$num_of_sidebars = $sidebars['num_of_sidebars'];

$image_class = $num_of_sidebars > 0 ? 'large' : 'blog-full';

/* get blog categories */
$post_categories = wp_get_post_categories(get_the_ID());
?>
<?php if (anps_header_media_single(get_the_ID()) != "" && $num_of_sidebars > 0) : ?>
    <article class="post style-2">
        <header>
            <?php echo anps_header_media_single(get_the_ID(), 'blog-full'); ?>

            <div class="post-meta">
                <ul>
                    <?php if (get_option('anps_post_meta_comments') != '1') : ?>
                    <li class="post-meta-comments"><i class='hovercolor fa fa-comment-o'></i><a href='<?php echo get_permalink() . "#comments"; ?>'><?php echo get_comments_number() . " " . __("comments", 'transport'); ?></a></li>
                    <?php endif; ?>
                    <?php if (get_option('anps_post_meta_categories') != '1') : ?>
                    <li class="post-meta-categories"><i class='hovercolor fa fa-folder-o'></i><span>
                        <?php $first_item = false;
                        foreach ($post_categories as $c) {
                            $cat = get_category($c);
                            if ($first_item) {
                                echo ", ";
                            }
                            $first_item = true;
                            echo "<a href='" . get_category_link($c) . "'>" . $cat->name . "</a>";
                        } ?>
                    </span></li>
                    <?php endif; ?>
                    <?php if (get_option('anps_post_meta_author') != '1') : ?>
                    <li class="post-meta-author"><i class='hovercolor fa fa-user'></i><span><?php echo __("posted by", 'transport') . " <a href='" . get_author_posts_url(get_the_author_meta('ID')) . "' class='author'>" . get_the_author() . "</a>"; ?></span></li>
                    <?php endif; ?>
                    <?php if (get_option('anps_post_meta_date') != '1') : ?>
                    <li class="post-meta-date"><i class='hovercolor fa fa-calendar'></i><span><?php echo get_the_date(); ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>
        </header>
                <h1 ><?php the_title();?></h1>
        <div class="post-content clearfix"><?php the_content(); ?></div>
    </article>
<?php elseif ($num_of_sidebars === 0) : ?>
    <article class='post style-2'>
        <header class="text-center">
        <?php echo anps_header_media_single(get_the_ID(), 'blog-full'); ?>
        <h1 class="single-blog"><?php the_title(); ?></h1>
        <div class='post-meta'>
        <ul>
        <?php if (get_option('anps_post_meta_comments') != '1') : ?>
        <li class="post-meta-comments"><i class='fa fa-comment'></i><a href='<?php echo get_permalink() . "#comments"; ?>'><?php echo get_comments_number() . " " . __("comments", 'transport'); ?></a></li>
        <?php endif; ?>
        <?php if (get_option('anps_post_meta_categories') != '1') : ?>
        <li class="post-meta-categories"><i class='fa fa-folder-open'></i>
            <?php
            $first_item = false;
            $post_data = "";
            foreach ($post_categories as $c) {
                $cat = get_category($c);
                if ($first_item) {
                    $post_data .= ", ";
                }
                $first_item = true;
                $post_data .= "<a href='" . get_category_link($c) . "'>" . esc_html($cat->name) . "</a>";
            } ?>
            <?php $allowed_tags = wp_kses_allowed_html('post');
            echo wp_kses($post_data, $allowed_tags); //PHPCS: XSS ok. ?>
        <?php endif; ?>
        </li>
        <?php if (get_option('anps_post_meta_author') != '1') : ?>
        <li class="post-meta-author"><i class='fa fa-user'></i><?php echo __("posted by", 'transport') . " <a href='" . get_author_posts_url(get_the_author_meta('ID')) . "' class='author'>" . get_the_author() . "</a>"; ?></li>
        <?php endif; ?>
        <?php if (get_option('anps_post_meta_date') != '1') : ?>
        <li class="post-meta-date"><i class='fa fa-calendar'></i><?php echo get_the_date() ?></li>
        <?php endif; ?>
        </ul>
        </div>
        </header>
        <div class='post-content clearfix'><?php echo the_content(); ?></div>
    </article>
<?php else : ?>
    <article class='post style-2'>
        <header>
        <span><?php echo get_the_date() ?></span>
        <h1><?php the_title(); ?></h1>
        <div class='post-meta'>
        <ul>
        <li><i class='fa fa-comment'></i><a href='<?php echo get_permalink() . "#comments"; ?>'><?php echo get_comments_number() . " " . __("comments", 'transport'); ?></a></li>
        <li><i class='fa fa-folder-open'></i>
        <?php
        $first_item = false;
        $post_data = "";
        foreach ($post_categories as $c) {
            $cat = get_category($c);
            if ($first_item) {
                $post_data .= ", ";
            }
            $first_item = true;
            $post_data .= "<a href='" . get_category_link($c) . "'>" . esc_html($cat->name) . "</a>";
        } ?>
        <?php $allowed_tags = wp_kses_allowed_html('post');
        echo wp_kses($post_data, $allowed_tags); //PHPCS: XSS ok. ?>
        </li>
        <li><i class='fa fa-user'></i><?php echo __("posted by", 'transport') . " <a href='" . get_author_posts_url(get_the_author_meta('ID')) . "' class='author'>" . get_the_author() . "</a>"; ?></li>
        </ul>
        </div>
        </header>
        <div class='post-content clearfix'><?php echo the_content(); ?></div>
    </article>
<?php endif; ?>
