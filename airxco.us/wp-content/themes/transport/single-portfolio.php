<?php
get_header();
$args = array(
    'post_type' => 'portfolio',
    'p' => get_the_ID()
);
$portfolio_posts = new WP_Query($args);
while ($portfolio_posts->have_posts()) :
    $portfolio_posts->the_post();
    $id = get_the_ID();
    if (get_post_meta($id, 'gallery_images', true)) {
        $gallery_images = explode(",", get_post_meta($id, 'gallery_images', true));

        foreach ($gallery_images as $key => $item) {
            if (!$item) {
                unset($gallery_images[$key]);
            }
        }

        if (anps_get_option('', 'style-1', 'portfolio_single') === 'style-1') {
            $header_media = "<div class='gallery'>";
            $header_media .= "<div class='gallery-inner'>";
            $j = 0;
            foreach ($gallery_images as $item) {
                $image_src = wp_get_attachment_image_src($item, "full");
                if (!$image_src) {
                    continue;
                }
                $header_media .= "<div class='item'>";
                $header_media .= "<a rel='lightbox' href='" . esc_url($image_src[0]) . "'>";
                $header_media .= "<img alt='" . esc_attr(get_the_title($item)) . "'  src='" . esc_url($image_src[0]) . "'>";
                $header_media .= "</a>";
                $header_media .= "</div>";
                $j++;
            }
            $header_media .= "</div>";
            $header_media .= "</div>";
        } else {
            $header_media = "<div id='carousel' class='carousel slide'>";
            if (count($gallery_images) > 1) {
                $header_media .= "<ol class='carousel-indicators'>";
                for ($i = 0; $i < count($gallery_images); $i++) {
                    if ($i == 0) {
                        $active_class = "active";
                    } else {
                        $active_class = "";
                    }
                    $header_media .= "<li data-target='#carousel' data-slide-to='" . $i . "' class='" . $active_class . "'></li>";
                }
                $header_media .= "</ol>";
            }
            $header_media .= "<div class='carousel-inner'>";
            $j = 0;
            foreach ($gallery_images as $item) {
                $image_src = wp_get_attachment_image_src($item, "blog-full");
                if (!$image_src) {
                    continue;
                }
                if ($j == 0) {
                    $active_class = " active";
                } else {
                    $active_class = "";
                }
                $header_media .= "<div class='item{$active_class}'>";
                $header_media .= "<img alt='" . esc_attr(get_the_title($item)) . "'  src='" . esc_url($image_src[0]) . "'>";
                $header_media .= "</div>";
                $j++;
            }
            $header_media .= "</div>";
            if (count($gallery_images) > 1) {
                $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'><div class='tp-leftarrow tparrows default round'></div></a><a class='right carousel-control' href='#carousel' data-slide='next'><div class='tp-rightarrow tparrows default round'></div></a>";
            }
            $header_media .= "</div>";
            $header_media .= "</div>";
        }
    } elseif (has_post_thumbnail($id)) {
        $header_media = get_the_post_thumbnail($id, "full");
    } elseif (get_post_meta($id, $key = 'anps_featured_video', $single = true)) {
        $header_media = do_shortcode(get_post_meta($id, 'anps_featured_video', true));
    } else {
        $header_media = "";
    }
    ?>
<section class="container portfolio-single">
    <div class="row">
        <?php if (anps_get_option('', 'style-1', 'portfolio_single') == 'style-1') : ?>
            <?php
                global $row_inner;
                $row_inner = true;
            ?>
            <div class="col-md-8"><?php $allowed_tags = wp_kses_allowed_html('post');
            echo wp_kses($header_media, $allowed_tags); //PHPCS: XSS ok. ?></div>
            <div class="col-md-4">
                <?php the_content(); ?>
                <div class="row">
                    <div class="col-md-12 buttons folionav">
                        <?php previous_post_link('%link', '<button class="btn btn-lg style-5"><i class="fa fa-angle-left"></i> &nbsp; ' . __('prev', "transport") . "</button>"); ?>
                        <?php next_post_link('%link', '<button class="btn btn-lg style-5">' . __("next", "transport") . ' &nbsp; <i class="fa fa-angle-right"></i></button>'); ?>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php
                global $row_inner;
                $row_inner = true;
            ?>
            <?php
            $hide_img = get_post_meta($post->ID, 'anps_hide_portfolio_img', true);
            if ($hide_img == 0) {
                $allowed_tags = wp_kses_allowed_html('post');
                echo wp_kses($header_media, $allowed_tags); //PHPCS: XSS ok.
            }
            ?>
            <?php the_content(); ?>
        <?php endif; ?>
</section>
<?php endwhile;

wp_reset_postdata();

$portfolio_footer = anps_get_option('', '', 'portfolio_single_footer');

if ($portfolio_footer) : ?>
    <p>&nbsp;</p><p>&nbsp;</p>
<?php endif; ?>

<?php echo do_shortcode(stripslashes($portfolio_footer)); ?>

<?php get_footer();
