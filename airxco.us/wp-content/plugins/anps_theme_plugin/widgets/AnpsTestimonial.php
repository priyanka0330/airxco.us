<?php

class AnpsTestimonial extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'AnpsTestimonial', 'AnpsThemes - Testimonial', array('description' => __('Enter testimonial', 'transport'),)
        );
    }
    
    public static function anps_register_widget() {
        return register_widget("AnpsTestimonial");
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'image' => '', 'name'=>'', 'text'=>'', 'job_title'=>''));

        $image = $instance['image'];
        $title = $instance['title'];
        $name = $instance['name'];
        $text = $instance['text'];
        $job_title = $instance['job_title'];
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e("Title", 'transport'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image', 'transport'); ?></label>
            <?php $images = get_children('post_type=attachment&post_mime_type=image'); ?>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>">
                <option value="">Select an image</option>
                <?php foreach ($images as $item) : ?>
                    <option <?php if ($item->ID == $image) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item->ID); ?>"><?php echo esc_html($item->post_title); ?></option>
            <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php esc_html_e('Text', 'transport'); ?></label>
            <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('text')); ?>" id="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php echo esc_attr($text); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('name')); ?>"><?php esc_html_e('Name', 'transport'); ?></label>
            <input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('name')); ?>" id="<?php echo esc_attr($this->get_field_id('name')); ?>" value="<?php echo esc_attr($name); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('job_title')); ?>"><?php esc_html_e('Job title', 'transport'); ?></label>
            <input class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('job_title')); ?>" id="<?php echo esc_attr($this->get_field_id('job_title')); ?>" value="<?php echo esc_attr($job_title); ?>"/>
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image'] = $new_instance['image'];
        $instance['title'] = $new_instance['title'];
        $instance['name'] = $new_instance['name'];
        $instance['text'] = $new_instance['text'];
        $instance['job_title'] = $new_instance['job_title'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = $instance['title'];
        $text = $instance['text'];
        $name = $instance['name'];  
        $job_title = $instance['job_title'];        

        echo $before_widget;
        ?>     

        <?php if($title) : ?>
            <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
        <div class="widget-wrap">
            <div class="widget-header">
                <?php echo wp_get_attachment_image($instance['image'], 'large'); ?>
            </div>

            <?php if($text) : ?>
                <div class="widget-content col-md-12">
                    <p><?php echo esc_html($text); ?></p>
                </div>
            <?php endif; ?>        

            <div class="widget-footer col-md-12">
                <span class="name primary"><?php echo esc_html($name); ?></span>
                <span class="headings-color job-title"><?php echo esc_html($job_title); ?></span>
            </div>
        </div>

        <?php
        echo $after_widget;
    }

}

add_action( 'widgets_init', array('AnpsTestimonial', 'anps_register_widget'));
