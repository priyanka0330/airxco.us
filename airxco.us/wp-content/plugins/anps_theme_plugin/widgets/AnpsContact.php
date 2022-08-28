<?php

class AnpsContact extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'AnpsContact', __('AnpsThemes - Contact', 'transport'), array('description' => __('Enter contact.', 'transport'),)
        );
        add_action( 'admin_enqueue_scripts', array( $this, 'anps_enqueue_scripts' ) );
        add_action( 'admin_footer-widgets.php', array( $this, 'anps_print_scripts' ), 9999 );
    }
    
    public static function anps_register_widget() {
        return register_widget("AnpsContact");
    }

    function anps_enqueue_scripts( $hook_suffix ) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }

    function anps_print_scripts() {
        ?>
        <script>
            ( function( $ ){
                function initColorPicker( widget ) {
                    widget.find( '.anps-color-picker' ).wpColorPicker();
                }

                function onFormUpdate( event, widget ) {
                    initColorPicker( widget );
                }

                $( document ).on( 'widget-added widget-updated', onFormUpdate );
                $( document ).ready( function() {
                    $( '#widgets-right .widget:has(.anps-color-picker)' ).each( function () {
                        initColorPicker( $( this ) );
                    } );
                } );
            }( jQuery ) );
        </script>
        <?php
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title'=>'', 'text'=>'', 'button_text'=>'', 'url'=>'', 'title_color'=>'', 'text_color'=>'', 'bg_color'=>'', 'button_text_color'=>'', 'button_bg_color'=>''));

        $text = htmlentities($instance['text']);
        $title = htmlentities($instance['title']);
        $button_text = htmlentities($instance['button_text']);
        $url = $instance['url'];
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'transport'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php esc_html_e('Text', 'transport'); ?></label>
            <textarea id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>" type="text" class="widefat"><?php echo esc_attr($text); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>"><?php esc_html_e('Button text', 'transport'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" class="widefat" value="<?php echo esc_attr($button_text); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php esc_html_e('Url', 'transport'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" class="widefat" value="<?php echo esc_attr($url); ?>" />
        </p>
        <!-- colors -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title_color')); ?>"><?php esc_html_e('Title color', 'transport'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('title_color'); ?>" name="<?php echo $this->get_field_name('title_color'); ?>" type="text" value="<?php echo esc_attr($instance['title_color']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text_color')); ?>"><?php esc_html_e('Text color', 'transport'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" type="text" value="<?php echo esc_attr($instance['text_color']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('bg_color')); ?>"><?php esc_html_e('Background color', 'transport'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('bg_color'); ?>" name="<?php echo $this->get_field_name('bg_color'); ?>" type="text" value="<?php echo esc_attr($instance['bg_color']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text_color')); ?>"><?php esc_html_e('Button text color', 'transport'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('button_text_color'); ?>" name="<?php echo $this->get_field_name('button_text_color'); ?>" type="text" value="<?php echo esc_attr($instance['button_text_color']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_bg_color')); ?>"><?php esc_html_e('Button background color', 'transport'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('button_bg_color'); ?>" name="<?php echo $this->get_field_name('button_bg_color'); ?>" type="text" value="<?php echo esc_attr($instance['button_bg_color']); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['text'] = $new_instance['text'];
        $instance['button_text'] = $new_instance['button_text'];
        $instance['url'] = $new_instance['url'];
        $instance['title_color'] = $new_instance['title_color'];
        $instance['text_color'] = $new_instance['text_color'];
        $instance['bg_color'] = $new_instance['bg_color'];
        $instance['button_text_color'] = $new_instance['button_text_color'];
        $instance['button_bg_color'] = $new_instance['button_bg_color'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = $instance['title'];
        $text = $instance['text'];
        $button_text = $instance['button_text'];
        $url = $instance['url'];
        $title_color = $instance['title_color'];
        $text_color = $instance['text_color'];
        $bg_color = $instance['bg_color'];
        $button_text_color = $instance['button_text_color'];
        $button_bg_color = $instance['button_bg_color'];

        $title_color_HTML = $text_color_HTML = $button_text_color_att = $button_bg_color_att = $bg_color_att = '';

        if ($title_color != '') {
           $title_color_HTML = "style=color:" . $title_color . ";";
        }
        if ($text_color != '') {
           $text_color_HTML = "style=color:" . $text_color . ";";
        }
        if ($button_text_color != '') {
           $button_text_color_att = "color:" . $button_text_color . ";";
        }
        if ($button_bg_color != '') {
           $button_bg_color_att = "background-color:" . $button_bg_color . ";";
        }
        if ($bg_color != '') {
           $bg_color_att = "style=background-color:" . $bg_color . ";";
        }

        echo $before_widget;
        ?>

        <div class="widget-wrap" <?php echo esc_html($bg_color_att);?>>
            <div class="widget-content col-md-12">
                <span class="title primary font-1" <?php echo esc_html($title_color_HTML);?>><?php echo esc_html($title); ?></span>
                <p <?php echo esc_html($text_color_HTML);?> ><?php echo esc_html($text); ?></p>
                <a class="btn btn-sm style-1" <?php if ($button_text_color != '' || $button_bg_color != ''):?> style="<?php echo esc_html($button_text_color_att)?> <?php echo esc_html($button_bg_color_att);?>"
                <?php endif;?> href="<?php echo esc_url($url);?>"><?php echo esc_html($button_text);?></a>
             </div>
        </div>
        <?php
        echo $after_widget;
    }

}

add_action( 'widgets_init', array('AnpsContact', 'anps_register_widget'));
