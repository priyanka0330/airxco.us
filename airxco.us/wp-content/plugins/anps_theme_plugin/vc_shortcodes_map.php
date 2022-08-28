<?php
/* Custom field for Table shortcode */
function table_field($settings, $value) {
    if($value == "") {
    	$value = "[table_head][table_row][table_heading_cell][/table_heading_cell][/table_row][/table_head][table_body][table_row][table_cell][/table_cell][/table_row][/table_body]";
    }

    $matches = array();
    $match_vals = array(
        'row-start' => array('[table_row]', '<tr>'),
        'row-end' => array('[/table_row]', '</tr>'),
        'heading-start' => array('[table_heading_cell]', '<th><input type="text" placeholder="' . __("Table heading", "transport") . '" value="'),
        'heading-end' => array('[/table_heading_cell]', '" /></th>'),
        'cell-start' => array('[table_cell]', '<td><input type="text" placeholder="' . __("Table cell", "transport") . '" value="'),
        'cell-end' => array('[/table_cell]', '" /></td>')
    );
    /* Get table head */
    $head = preg_match('/\[table_head\](.*?)\[\/table_head\]/s', $value, $matches);
    $head = $matches[1];
    $head = str_replace($match_vals['row-start'][0], $match_vals['row-start'][1], $head);
    $head = str_replace($match_vals['row-end'][0], $match_vals['row-end'][1], $head);
    $head = str_replace($match_vals['heading-start'][0], $match_vals['heading-start'][1], $head);
    $head = str_replace($match_vals['heading-end'][0], $match_vals['heading-end'][1], $head);
    /* Get table body */
    $body = preg_match('/\[table_body\](.*?)\[\/table_body\]/s', $value, $matches);
    $body = $matches[1];
    $body = str_replace($match_vals['row-start'][0], $match_vals['row-start'][1], $body);
    $body = str_replace($match_vals['row-end'][0], $match_vals['row-end'][1], $body);
    $body = str_replace($match_vals['cell-start'][0], $match_vals['cell-start'][1], $body);
    $body = str_replace($match_vals['cell-end'][0], $match_vals['cell-end'][1], $body);
    /* Get table foot */
    $foot = preg_match('/\[table_foot\](.*?)\[\/table_foot\]/s', $value, $matches);
    if( isset($matches[1]) ) {
    	$foot = $matches[1];
	}
    $foot = str_replace($match_vals['row-start'][0], $match_vals['row-start'][1], $foot);
    $foot = str_replace($match_vals['row-end'][0], $match_vals['row-end'][1], $foot);
    $foot = str_replace($match_vals['cell-start'][0], $match_vals['cell-start'][1], $foot);
    $foot = str_replace($match_vals['cell-end'][0], $match_vals['cell-end'][1], $foot);

    $number_of_rows = substr_count($value, '[table_row]');
    $number_of_cells = substr_count($head, '<th>');

    $data = '<input type="text" value="'.$value.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select anps_custom_val '.$settings['param_name'].' '.$settings['type'].'" id="anps_custom_prod">';
    $data .= '<div class="anps-table-field">';
        $data .= '<div class="anps-table-field-remove-rows">';
        for($i=0;$i<$number_of_rows;$i++) {
        	if( $i == 0 ) {
        		$data .= '<button style="visibility: hidden;" title="' . __("Remove row", "transport") . '">&#215;</button>';
        	} else {
        		$data .= '<button title="' . __("Remove row", "transport") . '">&#215;</button>';
        	}
        }
        $data .= '</div>';
        $data .= '<table class="anps-table-field-remove-cells"><tbody><tr>';
        for($i=0;$i<$number_of_cells;$i++) {
            $data .= '<td><button title="' . __("Remove cell", "transport") . '">&#215;</button></td>';
        }
        $data .= '</tr></tbody></table>';
        $data .= '<table data-heading-placeholder="' . __("Table heading", "transport") . '" data-cell-placeholder="' . __("Table cell", "transport") . '" class="anps-table-field-vals">';
        $data .= '<thead>' . $head . '</thead>';
        $data .= '<tbody>' . $body . '</tbody>';
        //$data .= '<tfoot>' . $foot . '</tfoot>';
        $data .= '</table>';
        $data .= '<div class="anps-table-field-add-cells">';
            $data .= '<button title="' . __("Add cells", "transport") . '">+</button>';
        $data .= '</div>';
        $data .= '<div class="anps-table-field-add-rows">';
            $data .= '<button title="' . __("Add row", "transport") . '">+</button>';
        $data .= '</div>';
    $data .= '</div>';
    return $data;
}
vc_add_shortcode_param('table' , 'table_field', get_template_directory_uri() . "/js/vc-table.js", __FILE__);
/* Shortcodes */
/* Testimonials */
global $testimonial_counter, $testimonials_style;
$testimonial_counter = 0;
class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {
    static  function anps_testimonials_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'testimonialheading' => '',
            'style' => ''
        ), $atts ) );
        $testimonials_number = substr_count($content, "[testimonial");
        $class = "testimonials";
        $data_return = "";
        $style_class = "";
        $randomid = substr( md5(rand()), 0, 7);
        global $testimonials_style;
        if($style == 'style-3') {
            //transport style
            $testimonials_style = 'style-3';
            $data_return .= '<div class="relative-wrapper">';
            $data_return .= "<div id='".$randomid."' class='owl-carousel " . $class . " " . $style ."' data-col='2'>";
            $data_return .= do_shortcode($content);
            $data_return .= "</div>";

            if($testimonials_number > 2) {
                $data_return .= '<div class="owl-navigation">';
                $data_return .= '<a class="owlprev"><i class="fa fa-chevron-left"></i> <span class="sr-only">'.__('Previous', 'transport').'<span></a>';
                $data_return .= '<a class="owlnext"><i class="fa fa-chevron-right"></i> <span class="sr-only">'.__('Next', 'transport').'<span></a>';
                $data_return .= '</div>';
            }
            $data_return .= '</div>';
        } elseif($style == 'style-4') {
            //industrial style
            $testimonials_style = 'style-4';
            $data_return = '';
            $data_return .= '<div class="testimonials style-4">';
            $data_return .= "<h3 class='title'>".$testimonialheading."</h3>";
            $data_return .= '<ul class="testimonial-wrap owl-carousel" data-col="2">';
            $data_return .= do_shortcode($content);
            $data_return .= '</ul>';
            /* Slider left/right navigation buttons */
            if($testimonials_number>1) {
                $data_return .= '<div class="testimonial-owl-nav owl-nav-pull-right">';
                $data_return .= '<button class="owlprev"><i class="fa fa-angle-left"></i></button>';
                $data_return .= '<button class="owlnext"><i class="fa fa-angle-right"></i></button>';
                $data_return .= '</div>';
            }
            /* END Slider left/right navigation buttons */
            $data_return .= '</div>';
        } else {
            //old style
            if($style=="white") {
                $class="testimonials white";
            }
            if($testimonials_number>"1") {
                $class = "carousel-inner";
                $data_return .= "<div id='".$randomid."' class='carousel testimonials slide' data-ride='carousel'>";
            }
            global $testimonial_counter;
            $testimonial_counter = 0;
            $data_return .= '<div class="'.$class.'">'.do_shortcode($content).'</div>';
            if($testimonials_number>"1") {
                $data_return .= '<a class="left carousel-control" href="#'.$randomid.'" data-slide="prev">';
                $data_return .= '<span class="fa fa-chevron-left"></span>';
                $data_return .= "</a>";
                $data_return .= '<a class="right carousel-control" href="#'.$randomid.'" data-slide="next">';
                $data_return .= '<span class="fa fa-chevron-right"></span>';
                $data_return .= '</a>';
                $data_return .= "</div>";
            }
        }
        return $data_return;
    }
}
add_shortcode('testimonials', array('WPBakeryShortCode_testimonials','anps_testimonials_func'));
/* END Testimonials */
/* Testimonial item */


class WPBakeryShortCode_anps_testimonial extends WPBakeryShortCode {
    static function anps_testimonial_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'image' => '',
            'image_u' => "",
            'user_name' => '',
            'user_url' => '',
            'position' => '',
        ), $atts ) );
        global $testimonial_counter, $testimonials_style;
        $testimonial_counter++;
        $class = "";
        if($testimonial_counter=="1") {
            $class = " active";
        }

        if($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        }
        $data = "";
        if($testimonials_style == 'style-3') {
            //transport style
            $data .= "<blockquote class='testimonial item".$class."'>";
            $data .= '<div class="row">';
            if($image) {
                $data .= '<div class="col-md-6">';
                $data .= "<img class='testimonial-image' src='".$image."' alt='".$user_name."' >";
                $data .= '</div>';
                $data .= '<div class="col-md-6">';
            } else  {
                $data .= '<div class="col-md-12">';
            }
            $data .= "<h4 class='testimonial-user'>";
            $data .= $user_name;
            $data .= '</h4>';
            if($position) {
                $data .= "<p class='testimonial-position'>".$position."</p>";
            }
            $data .= "<p class='testimonial-content'>".$content."</p>";
            $data .= '</div>';
            $data .= '</div>';
            $data .= "</blockquote>";
        } elseif($testimonials_style == 'style-4') {
            //industrial style
            $data .= '<li class="clearfix row">';
            $data .= '<div class="user pull-left">';
            if($image) {
                    $data .= '<div class="user-image">';
                $data .= "<img class='user-photo' src='".$image."' alt='".$user_name."'>";
                $data .= '</div>';
            }
            $data .= '<div class="content pull-left">';
            $data .= "<h3 class='name-user'>$user_name</h3>";
            if($position) {
                $data .= '<h4 class="jobtitle">'.$position.'</h4>';
            }
            $data .= '<p>'.$content.'</p>';
            $data .= '</div>';
            $data .= '</div>';
            $data .= '</li>';
        } else {
            //old style
            $data .= "<blockquote class='item".$class."'>";
            $data .= "<p>".$content."</p>";
            $data .= "<div class='cite'>";
            $data .= '<div class="testimonial-footer">';
            if($image) {
                $data .= "<img src='".$image."' >";
            }
            $data .= '<span class="user">' . $user_name . '</span>';
            if($user_url) {
                $data .= " / ";
                $data .= "<a href='".$user_url."' target='_blank'>".$user_url."</a>";
            }
            $data .= "</div>";
            $data .= "</div>";
            $data .= "</blockquote>";
        }
        return $data;
    }
}
add_shortcode('testimonial', array('WPBakeryShortCode_anps_testimonial','anps_testimonial_func'));
/* END Testimonial */
/* Google maps */
$google_maps_counter = 0;
class WPBakeryShortCode_google_maps extends WPBakeryShortCodesContainer {
    static function anps_google_maps_func( $atts,  $content ) {
        global $google_maps_counter;
        $google_maps_counter++;
        extract( shortcode_atts( array(
	        'zoom'     => '15',
	        'scroll'   => '',
	        'height'   => '550',
	        'map_type' => 'ROADMAP',
            'style'   => ''
        ), $atts ) );
        $style = str_replace('``', '"', $style);
        $style = str_replace('`{`', '[', $style);
        $style = str_replace('`}`', ']', $style);
        $style = str_replace('`', '', $style);
        $scroll_option = "true";
        if($scroll==true) {
            $scroll_option = "false";
        }
        preg_match_all( '#\](.*?)\[/google_maps_item]#', $content, $matches);
        $location = $matches[1][0];
        wp_enqueue_script('gmap3_link');
        wp_enqueue_script('gmap3');

        return "<div class='map' id='map$google_maps_counter' style='height: {$height}px;' data-type='$map_type' data-styles='$style' data-zoom='$zoom' data-scroll='{$scroll_option}' data-markers='" . do_shortcode($content) . "'></div>";
    }
}
add_shortcode('google_maps', array('WPBakeryShortCode_google_maps','anps_google_maps_func'));
/* END Google maps */
/* Google maps item */
class WPBakeryShortCode_google_maps_item extends WPBakeryShortCode {
    static function anps_google_maps_item_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'info'          => '',
            'pin'           => '',
            'marker_center' => '',
        ), $atts ) );

        $info = preg_replace('/[\n\r]+/', "", $info);
        if( base64_encode(base64_decode($info)) === $info ) {
        	$info = base64_decode($info);
    	}

        if(isset($pin) && $pin!="") {
            $pin_icon = wp_get_attachment_image_src($pin, 'full');
            $pin_icon = $pin_icon[0];
        } else {
            $pin_icon = get_template_directory_uri()."/images/gmap/map-pin.png";
        }

        return '{ "address": "' . $content . '",  "center": "' . $marker_center . '", "data": "' . $info . '", "options": { "icon": "' . $pin_icon . '" } }|';
    }
}
add_shortcode('google_maps_item', array('WPBakeryShortCode_google_maps_item','anps_google_maps_item_func'));
/* END Google maps item */
/* Logos */
class WPBakeryShortCode_logos extends WPBakeryShortCodesContainer {
    static function anps_logos_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'in_row' => '3',
            'style' => 'style-1',
            'nav' => '',
        ), $atts ) );
        $logos_array = explode("[/logo]", $content);
        foreach($logos_array as $key=>$item) {
            if($item=="") {
                unset($logos_array[$key]);
            }
        }
        $data_col = "";
        $data_nav = "";
        $logos_class = "";
        $count_logos = count($logos_array);
        if ($count_logos > $in_row && $style == 'style-2') {
            $data_col = "data-col='{$in_row}'";
            $logos_class = 'owl-carousel';

            if ($nav === 'true') {
                $data_nav = 'data-nav';
            }
        }

        $return = "<div class='logos-wrapper $style'>";
        $return .= "<ul class='logos ". $logos_class ."' ".$data_col." " . $data_nav . ">";

        $i = 0;
        foreach($logos_array as $item) {
            if($i%$in_row==0 && $i!=0 && $style == 'style-1') {
                    $return .= "</ul><ul class='logos'>".do_shortcode($item."[/logo]");
            } else {
                $return .= do_shortcode($item."[/logo]");
            }
            $i++;
        }
        $return .= "</ul></div>";
        return $return;
    }
}
add_shortcode('logos', array('WPBakeryShortCode_logos','anps_logos_func'));
/* END Logos */
/* Logo */
class WPBakeryShortCode_anps_logo extends WPBakeryShortCode {
    static function anps_logo_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'url' => '',
            'alt' => '',
            'image_u' => '',
            'image_u_hover' => '',
            'img_hover' => '',
            'alt_hover' => ''
        ), $atts ) );
        if($image_u) {
            $content = wp_get_attachment_image_src($image_u, 'full');
            $content = $content[0];
        }
        if($image_u_hover) {
            $img_hover = wp_get_attachment_image_src($image_u_hover, 'full');
            $img_hover = $img_hover[0];
        }

        /* Element (span or a) */
        $before = '<span>';
        $after = '</span>';

        if($url) {
            $before = '<a href="'.$url.'" target="_blank">';
            $after = '</a>';
        }

        /* Class */
        $class = '';
        if(!$image_u_hover) {
            $class = ' class="logos-fade"';
        }


        /* Retrun */
        $return = '<li' . $class . '>' . $before . "<img src='".$content."' alt='".$alt."'>";

        if($image_u_hover) {
            $return .=  '<span class="hover"><img src="'.$img_hover.'" alt="'.$alt_hover.'"></span>';
        }

        $return .= $after . '</li>';

        return $return;
    }
}
add_shortcode('logo', array('WPBakeryShortCode_anps_logo','anps_logo_func'));
/* END Logo */
/* Faq */
$faq_counter = 0;
class WPBakeryShortCode_faq extends WPBakeryShortCodesContainer {
    static function anps_faq_func( $atts,  $content ) {
        wp_enqueue_script('collapse');
        global $faq_counter;
        $faq_counter++;
        return "<div class='panel-group faq' id='accordion".$faq_counter."'>".do_shortcode($content)."</div>";
    }
}
add_shortcode('faq', array('WPBakeryShortCode_faq','anps_faq_func'));
/* END faq */
/* Faq item */
$faq_item_counter = 0;
class WPBakeryShortCode_faq_item extends WPBakeryShortCode {
    static function faq_item_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'title' => '',
            'answer_title' => ''
        ), $atts ) );
        global $faq_counter;
        global $faq_item_counter;
        $faq_item_counter++;
        $faq_data = "<div class='panel'>";
        $faq_data .= "<div class='panel-heading'>";
        $faq_data .= "<h4 class='panel-title'>";
        $faq_data .= "<a class='collapsed' data-toggle='collapse' data-parent='#accordion".$faq_counter."' href='#collapse".$faq_item_counter."'>".$title."</a>";
        $faq_data .= "</h4>";
        $faq_data .= "</div>";
        $faq_data .= "<div id='collapse".$faq_item_counter."' class='panel-collapse collapse'>";
        $faq_data .= "<div class='panel-body'>";
        $faq_data .= "<h4>".$answer_title."</h4>";
        $faq_data .= "<p>".$content."</p>";
        $faq_data .= "</div>";
        $faq_data .= "</div>";
        $faq_data .= "</div>";
        return $faq_data;
    }
}
add_shortcode('faq_item', array('WPBakeryShortCode_faq_item','faq_item_func'));
/* END faq item */
/* Pricing table */
class WPBakeryShortCode_pricing_table extends WPBakeryShortCodesContainer {
    static function pricing_table_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'title' => '',
            'currency' => '&euro;',
            'price' => '0',
            'period' => '',
            'button_text' => '',
            'button_url' => '',
            'featured' => ""
        ), $atts ) );

        if( $button_text != '' ) {
        	$button_text = '<li><a class="btn btn-md" href="' . $button_url . '">' . $button_text . '</a></li>';
        }
        $exposed_class = "";
        if($featured) {
            $exposed_class = " exposed";
        }
        $pricing_data = "<div class='pricing-table$exposed_class'>";
        $pricing_data .= "<header>";
        $pricing_data .= "<h2>".$title."</h2>";
        $pricing_data .= "<span class='currency'>".$currency."</span><span class='price'>".$price."</span>";
        if($period) {
            $pricing_data .= "<div class='date'>".$period."</div>";
        }
        $pricing_data .= "</header>";
        $pricing_data .= "<ul>".do_shortcode($content).$button_text."</ul>";
        $pricing_data .= "</div>";
        return $pricing_data;
    }
}
add_shortcode('pricing_table', array('WPBakeryShortCode_pricing_table','pricing_table_func'));
/* END pricing table */
/* Pricing item */
class WPBakeryShortCode_pricing_item extends WPBakeryShortCode {
    static function pricing_item_func( $atts,  $content ) {
        extract( shortcode_atts( array(), $atts ) );
        return '<li>'.$content ."</li>";
    }
}
add_shortcode('pricing_table_item', array('WPBakeryShortCode_pricing_item','pricing_item_func'));
/* END pricing item */
/* Contact info */
class WPBakeryShortCode_contact_info extends WPBakeryShortCodesContainer {
    static function contact_info_func( $atts,  $content ) {
        return "<ul class='contact-info'>".do_shortcode($content)."</ul>";
    }
}
add_shortcode('contact_info', array('WPBakeryShortCode_contact_info','contact_info_func'));
/* END Contact info */
/* Contact info item */
class WPBakeryShortCode_contact_info_item extends WPBakeryShortCode {
    static function contact_info_item( $atts,  $content ) {
        extract( shortcode_atts( array(
            'icon' => '',
            'icon_type' => '',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypo' => '',
            'icon_linecons' => '',
            'icon_monosocial' => ''
        ), $atts ) );

        $icon_class = 'fa fa-' . $icon;
        /* Check for VC icon types */
        vc_icon_element_fonts_enqueue( $icon_type );
        $icon_type = 'icon_' . $icon_type;
        if( $$icon_type ) { $icon_class = $$icon_type; }

        return "<li><i class='".$icon_class."'></i>".$content."</li>";
    }
}
add_shortcode('contact_info_item', array('WPBakeryShortCode_contact_info_item','contact_info_item'));
/* END contact info item */
/* Social icons */
class WPBakeryShortCode_social_icons extends WPBakeryShortCodesContainer {
    static function social_icons_func( $atts,  $content ) {
        return "<ul class='socialize'>".do_shortcode($content)."</ul>";
    }
}
add_shortcode('social_icons', array('WPBakeryShortCode_social_icons','social_icons_func'));
/* END Social icons */
/* Social icon */
class WPBakeryShortCode_social_icon extends WPBakeryShortCode {
    static function social_icon_item_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'url' => '#',
            'icon' => '',
            'target' => '_blank'
        ), $atts ) );
        return "<li><a href='".$url."' target='".$target."' class='fa fa-".$icon."'></a></li>";
    }
}
add_shortcode('social_icon_item', array('WPBakeryShortCode_social_icon','social_icon_item_func'));
/* END Social icon */
/* Statement */
class WPBakeryShortCode_statement extends WPBakeryShortCodesContainer {
    static function statement_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'parallax' => 'false',
            'parallax_overlay' => 'false',
            'image' => '',
            'color' => '',
            'container' => 'false',
            'slug' => '',
            'image_u' => ''
        ), $atts ) );
        if($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        }
        global $anps_parallax_slug;
        $parallax_class = "";
        $parallax_id = "";
        if($parallax=="true") {
            $parallax_class = " parallax";
            $anps_parallax_slug[] = $slug;
            $parallax_id = "id='$slug'";
        }
        $parallax_overlay_class = "";
        if($parallax_overlay=="true") {
            $parallax_overlay_class = " parallax-overlay";
        }
        $containe_class = "";
        $container_before = "";
        $container_after = "";
        $container_class='';
        if($container=="true") {
            $container_before = '<div class="container text-center">';
            $container_after = '</div>';
        }
        $style = '';
        if($image) {
            $style = "background-image: url('$image');";
        } elseif($color) {
            $style = "background-color: $color;";
        }
        return '<section '.$parallax_id.' class="statement'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">'.$container_before.do_shortcode($content).$container_after.'</section>';
    }
}
add_shortcode('statement',array('WPBakeryShortCode_statement','statement_func'));
/* END Statement */
/* Tabs */
global $tabs_counter, $indiv_tab_counter;
$tabs_counter = 0;
$indiv_tab_counter = 0;
class WPBakeryShortCode_tabs extends WPBakeryShortCodesContainer {
    static function tabs_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'type' => ''
        ), $atts ) );
        wp_enqueue_script('tab');
        global $tabs_counter, $indiv_tab_counter, $tabs_single;
        $tabs_counter++;
        $sub_tabs_counter = 1;
        $indiv_tab_counter = 0;
        $tabs_single = 0;
        /* Everything inside [tab] shortcode */
        preg_match_all( '#\[tab(.*?)\]#', $content, $matches);
        if ( isset($matches[1]) ) { $tab_titles = $matches[1]; }
        $class = "";
        $class_before = "";
        $class_after = "";
        $class_content = "";
        if($type == 'vertical') {
            $class = ' vertical';
            $class_before = "<div class='col-2-5'>";
            $class_after = "</div>";
            $class_content = " col-9-5";
        }
        $tabs_menu = '';
        $tabs_menu .= $class_before;
        $tabs_menu .= '<ul class="nav nav-tabs'.$class.'" id="tab-' . $tabs_counter . '">';
        $i=0;
        foreach ( $tab_titles as $tab ) {
            preg_match_all( '/title="(.*?)\"/', $tab, $title_match);
            preg_match_all( '/icon="(.*?)\"/', $tab, $icon_match);
            if(isset($icon_match[1][0])) {
                $icon[$i] = " <i class='fa fa-".$icon_match[1][0]."'></i>";
            } else {
                $icon[$i] = "";
            }
            if( $sub_tabs_counter == 1 ) {
                $tabs_menu .= '<li class="active"><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0].$icon[$i] . '</a></li>';
            } else {
                $tabs_menu .= '<li><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0].$icon[$i] . '</a></li>';
            }
            $i++;
            $sub_tabs_counter++;
        }
        $tabs_menu .= '</ul>';
        $tabs_menu .= $class_after;
        return $tabs_menu . '<div class="tab-content'.$class_content.'">' . do_shortcode($content) . '</div>';
    }
}
add_shortcode('tabs', array('WPBakeryShortCode_tabs','tabs_func'));
/* END Tabs */
/* Tab */
class WPBakeryShortCode_tab extends WPBakeryShortCodesContainer {
    static function tab_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            "title" => "",
            "icon" => ""
        ), $atts ) );
        global $tabs_counter, $tabs_single;
        $active = "";
        if( $tabs_single == 0 ) {
            $active = " active";
        }
        $content = str_replace('&nbsp;', '<p class="blank-line clearfix"><br /></p>', $content);
        $tabs_single++;
        return '<div id="tab' . $tabs_counter . '-' . $tabs_single . '" class="tab-pane' . $active . '">' . do_shortcode( $content ) . '</div>';
    }
}
add_shortcode('tab', array('WPBakeryShortCode_tab','tab_func'));
/* END Tab */
/* Accordion */
global $accordion_opened;
$accordion_counter = 0;
$accordion_opened = false;
class WPBakeryShortCode_accordion extends WPBakeryShortCodesContainer {
    static function accordion_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            "opened" => "false",
            'style' => ''
        ), $atts ) );
        wp_enqueue_script('collapse');
        global $accordion_counter, $accordion_opened;
        $accordion_counter++;
        if($opened=="true") {
            $accordion_opened = true;
        }
        $style_class="";
        if($style=="style-2") {
            $style_class = " style-2 collapsed";
        }
        return '<div class="panel-group'.$style_class.'" id="accordion' . $accordion_counter . '">' .  do_shortcode($content) . '</div>';
    }
}
add_shortcode('accordion', array('WPBakeryShortCode_accordion','accordion_func'));
/* END Accordion */
/* Accordion item */
$accordion_item_counter = 0;
class WPBakeryShortCode_accordion_item extends WPBakeryShortCodesContainer {
    static function accordion_item_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'title' => ''
    ), $atts ) );
    $opened_class = "";
    global $accordion_item_counter, $accordion_opened;
    if( $accordion_opened ) {
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
                        <a data-toggle="collapse" '.$closed_class.' href="#collapse' . $accordion_item_counter . '">' . $title . '</a>
                    </h4>
                </div>
                <div id="collapse' . $accordion_item_counter . '" class="panel-collapse collapse'.$opened_class.'">
                    <div class="panel-body">' .  do_shortcode($content) . '</div>
                </div>
            </div>';
    }
}
add_shortcode('accordion_item', array('WPBakeryShortCode_accordion_item','accordion_item_func'));
/* END Accordion item */
/* List */
global $list_number;
$list_number = false;
class WPBakeryShortCode_anps_list extends WPBakeryShortCodesContainer {
    static function anps_list_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'class' => ''
        ), $atts ) );

        global $list_number;

        if( $class == "number" ) {
        	$list_number = true;
        	$return = "<ol class='list'>".do_shortcode($content)."</ol>";
        	$list_number = false;
        	return $return;
        }
        return "<ul class='list ".$class."'>".do_shortcode($content)."</ul>";
    }
}
add_shortcode('anps_list', array('WPBakeryShortCode_anps_list','anps_list_func'));
/* END List */
/* List item */
class WPBakeryShortCode_anps_list_item extends WPBakeryShortCodesContainer {
    static function anps_list_item_func( $atts,  $content ) {
    	global $list_number;
    	if($list_number) {
    		return "<li><span>".$content."</span></li>";
    	} else {
    		return "<li>".$content."</li>";
    	}
    }
}
add_shortcode('list_item', array('WPBakeryShortCode_anps_list_item','anps_list_item_func'));
/* END List item */
/* Content over image */
class WPBakeryShortCode_content_over_image extends WPBakeryShortCodesContainer {
    static function content_over_image_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'image_location' => 'left',
            'image' => ''
        ), $atts ) );
        if($image) {
            $image_b = wp_get_attachment_image_src($image, 'full');
            $image_b = $image_b[0];
        }
        
        $data = '';
        $data .= "<div class='content-over content-over--{$image_location}'>";
            $data .= "<div style='background-image: url({$image_b});' class='content-over__img'></div>";
            $data .= "<div class='container'><div class='content-over__main'>".do_shortcode($content)."</div></div>";
        $data .= "</div>";
        return $data;
    }
}
add_shortcode('content_over_image', array('WPBakeryShortCode_content_over_image', 'content_over_image_func'));
/* END Content over image */
/* END Shortcodes */
/* Remove Default VC values */
$vc_values = array(
    'vc_cta_button2',
    'vc_message',
    'vc_facebook',
    'vc_tweetmeme',
    'vc_googleplus',
    'vc_pinterest',
    'vc_toggle',
    //'vc_gallery',
    //'vc_images_carousel',
    'vc_tour',
    'vc_accordion',
    'vc_posts_grid',
    'vc_carousel',
    'vc_posts_slider',
    'vc_widget_sidebar',
    'vc_button',
    'vc_cta_button',
    'vc_video',
    'vc_gmaps',
    'vc_raw_js',
    'vc_flickr',
    'vc_progress_bar',
    'vc_pie',
);
foreach ($vc_values as $vc_value) {
    vc_remove_element($vc_value);
}
/* Blog categories new parameter */
function blog_categories_settings_field($settings, $value) {
    $blog_data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $blog_data .= '<option class="0" value="">'.__("All", "transport").'</option>';
    foreach(get_categories() as $val) {
        $selected = '';
        if ($value!=='' && $val->slug === $value) {
             $selected = ' selected="selected"';
        }
        $blog_data .= '<option class="'.$val->slug.'" value="'.$val->slug.'"'.$selected.'>'.$val->name.'</option>';
    }
    $blog_data .= '</select>';
    return $blog_data;
}
vc_add_shortcode_param('blog_categories' , 'blog_categories_settings_field');
/* Portfolio categories new parameter */
function portfolio_categories_settings_field($settings, $value) {
    $categories = get_terms('portfolio_category');
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $data .= '<option class="0" value="0">'.__("All", "transport").'</option>';
    foreach($categories as $val) {
        $selected = '';
        if ($value!=='' && $val->term_id === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->term_id.'" value="'.$val->term_id.'"'.$selected.'>'.$val->name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('portfolio_categories' , 'portfolio_categories_settings_field');
/* Team categories new parameter */
function team_categories_settings_field($settings, $value) {
    $categories = get_terms('team_category');
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $data .= '<option class="0" value="0">'.__("All", "transport").'</option>';
    foreach($categories as $val) {
        $selected = '';
        if ($value!=='' && $val->term_id === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->term_id.'" value="'.$val->term_id.'"'.$selected.'>'.$val->name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('team_categories' , 'team_categories_settings_field');
/* All pages new parameter */
function all_pages_settings_field($settings, $value) {
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    foreach(get_pages() as $val) {
        $selected = '';
        if ($value!=='' && $val->ID === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->ID.'" value="'.$val->ID.'"'.$selected.'>'.$val->post_title.'</option>';
    }
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('all_pages' , 'all_pages_settings_field');
/* VC Blog */
vc_map( array(
   'name' => esc_html__('Blog', 'transport'),
   'base' => 'blog',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_blog.png',
   'params' => array(
      array(
         'type' => 'blog_categories',
         'heading' => esc_html__('Blog categories', 'transport'),
         'param_name' => 'category',
         'description' => esc_html__('Select blog categories.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Posts per page', 'transport'),
         'param_name' => 'content',
         'description' => esc_html__('Enter post per page.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Order By', 'transport'),
         'param_name' => 'orderby',
         'value' => array(
                    esc_html__('Default', 'transport')=>'',
                    esc_html__('Date', 'transport')=>'date',
                    esc_html__('Id', 'transport')=>'ID',
                    esc_html__('Title', 'transport')=>'title',
                    esc_html__('Name', 'transport')=>'name',
                    esc_html__('Author', 'transport')=>'author'
            ),
         'description' => esc_html__('Order by.', 'transport'),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Order', 'transport'),
         'param_name' => 'order',
         'value' => array(
                    esc_html__('Default', 'transport')=>'',
                    esc_html__('ASC', 'transport')=>'ASC',
                    esc_html__('DESC', 'transport')=>'DESC'
             ),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Blog type', 'transport'),
         'param_name' => 'type',
         'value' => array(
                    esc_html__('Default', 'transport')=>'',
                    esc_html__('Grid', 'transport')=>'grid',
                    esc_html__('Masonry', 'transport')=>'masonry'
             ),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Columns', 'transport'),
         'param_name' => 'columns',
         'value' => array(
                    esc_html__('3 columns', 'transport')=>'3',
                    esc_html__('4 columns', 'transport')=>'4'
             ),
         'save_always' => true,
         'admin_label' => true
       )
    )
) );
/* END VC Blog */
/* VC Portfolio */
vc_map( array(
   'name' => esc_html__('Portfolio', 'transport'),
   'base' => 'portfolio',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_portfolio.png',
   'params' => array(
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Number of portfolio posts', 'transport'),
         'param_name' => 'per_page',
         'value' => '',
         'description' => esc_html__('Enter number of portfolio posts.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Show in row', 'transport'),
         'param_name' => 'columns',
         'value' => array(
                    esc_html__('6', 'transport')=>'6',
                    esc_html__('4', 'transport')=>'4',
                    esc_html__('3', 'transport')=>'3',
                    esc_html__('2', 'transport')=>'2'
            ),
         'save_always' => true,
         'admin_label' => true
      ),
      array(
         'type' => 'portfolio_categories',
         'heading' => esc_html__('Portfolio categories', 'transport'),
         'param_name' => 'category',
         'description' => esc_html__('Select portfolio categories.', 'transport'),
         'admin_label' => false
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Filter', 'transport'),
         'param_name' => 'filter',
         'value' => array(
                    esc_html__('On', 'transport')=>'on',
                    esc_html__('Off', 'transport')=>'off'
             ),
         'save_always' => true,
         'admin_label' => false
      ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Filter style', 'transport'),
         'param_name' => 'style',
         'value' => array(
                    esc_html__('Style 1', 'transport')=>'filter-style-1',
                    esc_html__('Style 2', 'transport')=>'filter-style-2',
                    esc_html__('Style 3', 'transport')=>'filter-style-3'
             ),
         'save_always' => true,
         'admin_label' => false
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Portfolio type', 'transport'),
         'param_name' => 'type',
         'value' => array(
                    esc_html__('Default', 'transport')=>'default',
                    esc_html__('Classic', 'transport')=>'classic',
                    esc_html__('Random', 'transport')=>'random'
             ),
         'save_always' => true,
         'admin_label' => true
       ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Image size', 'transport'),
         'param_name' => 'image_size',
         'value' => '',
         'description' => esc_html__('By default set to post-thumb (360x267px)', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Order By', 'transport'),
         'param_name' => 'orderby',
         'value' => array(
                    esc_html__('Default', 'transport')=>'default',
                    esc_html__('Date', 'transport')=>'date',
                    esc_html__('Id', 'transport')=>'ID',
                    esc_html__('Title', 'transport')=>'title',
                    esc_html__('Name', 'transport')=>'name'
             ),
         'description' => esc_html__('Enter order by.', 'transport'),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Order', 'transport'),
         'param_name' => 'order',
         'value' => array(
                    esc_html__('Default', 'transport')=>'',
                    esc_html__('ASC', 'transport')=>'ASC',
                    esc_html__('DESC', "transport")=>'DESC'
             ),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Mobile view', 'transport'),
         'param_name' => 'mobile_class',
         'value' => array(
                    esc_html__('2 columns', 'transport')=>'2',
                    esc_html__('1 column', 'transport')=>'1'
             ),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Filter color', 'transport'),
         'param_name' => 'filter_color',
         'value' => '',
         'description' => esc_html__('Filter color.', 'transport'),
         'admin_label' => false
       )
    )
));
/* END VC Portfolio */
/* VC team */
vc_map( array(
   'name' => esc_html__('Team', 'transport'),
   'base' => 'team',
   'class' => '',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_team.png',
   'params' => array(
       array(
         'type' => 'team_categories',
         'heading' => esc_html__('Team categories', 'transport'),
         'param_name' => 'category',
         'description' => esc_html__('Select team category.', 'transport'),
         'admin_label' => false
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Number of items in column', 'transport'),
         'param_name' => 'columns',
         'value' => array(
                    esc_html__('4', 'transport')=>'4',
                    esc_html__('2', 'transport')=>'2',
                    esc_html__('3', 'transport')=>'3',
                    esc_html__('6', 'transport')=>'6'
             ),
         'description' => esc_html__('Enter number of team item in column.', 'transport'),
         'save_always' => true,
         'admin_label' => true
      ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Number of team members', 'transport'),
         'param_name' => 'number_items',
         'value' => '',
         'description' => esc_html__('Enter number of team members (if you want all than enter -1).', 'transport'),
         'admin_label' => true
      ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Team member id/s', 'transport'),
         'param_name' => 'ids',
         'value' => '',
         'description' => esc_html__('Enter team member id/s. Example: 1,2,3', 'transport'),
         'admin_label' => true
      )
    )
) );
/* END VC team */
/* VC recent blog */
vc_map( array(
   'name' => esc_html__('Recent blog', 'transport'),
   'base' => 'recent_blog',
   'class' => '',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_recentblog.png',
   'params' => array(
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Number of blog posts', 'transport'),
         'param_name' => 'number',
         'value' => '4',
         'description' => esc_html__('Enter number of recent blog posts.', 'transport'),
         'admin_label' => true
       ),
	array(
            'type' => 'dropdown',
            'heading' => esc_html__('Number of columns in a row', 'transport'),
            'param_name' => 'col_number',
            'value' => array(
                        esc_html__('2', 'transport')=>'2',
                        esc_html__('3', 'transport')=>'3',
                        esc_html__('4', 'transport')=>'4',
                        esc_html__('6', 'transport')=>'6'),
            'std' => '3',
            'description' => esc_html__('Select number of items in a row.', 'transport'),
            'admin_label' => true
	),
       )
) );
/* END VC recent blog */
/* VC recent portfolio slider */
vc_map( array(
   'name' => esc_html__('Recent portfolio slider', 'transport'),
   'icon' => get_template_directory_uri().'/images/visual-composer/shortcode_icons-recent.png',
   'base' => 'recent_portfolio_slider',
   'class' => '',
   'category' => 'transport',
   'params' => array(
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Title', 'transport'),
         'param_name' => 'recent_title',
         'value' => '',
         'description' => esc_html__('Recent portfolio title.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Title color', 'transport'),
         'param_name' => 'title_color',
         'value' => '#c1c1c1',
         'description' => esc_html__('Title text color.', 'transport'),
         'admin_label' => false
       ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Image size', 'transport'),
         'param_name' => 'image_size',
         'value' => '',
         'description' => esc_html__('By default set to post-thumb (360x267px)', 'transport'),
         'admin_label' => true
      ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Next/Prev color', 'transport'),
         'param_name' => 'nex_prev_color',
         'value' => '#c1c1c1',
         'description' => esc_html__('Next/previous color.', 'transport'),
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Next/Prev background color', 'transport'),
         'param_name' => 'nex_prev_bg_color',
         'value' => '#3d3d3d',
         'description' => esc_html__('Next/previous background color.', 'transport'),
         'admin_label' => false
       ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Number of portfolio posts', 'transport'),
         'param_name' => 'number',
         'value' => '',
         'description' => esc_html__('Enter number of recent portfolio posts. If you want to display all posts, leave this field empty.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Number in row', 'transport'),
         'param_name' => 'number_in_row',
         'value' => array(
                    esc_html__('3', 'transport')=>'3',
                    esc_html__('4', 'transport')=>'4',
                    esc_html__('5', 'transport')=>'5',
                    esc_html__('6', 'transport')=>'6'
             ),
         'save_always' => true,
         'description' => esc_html__('Select number of items in row.', 'transport'),
         'admin_label' => true
       ),
      array(
         'type' => 'portfolio_categories',
         'heading' => esc_html__('Portfolio categories', 'transport'),
         'param_name' => 'category',
         'description' => esc_html__('Select portfolio categories.', 'transport'),
         'admin_label' => false
      )
    )
) );
/* END VC recent portfolio slider */
/* VC recent portfolio */
vc_map( array(
   'name' => esc_html__('Recent portfolio', 'transport'),
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_recentportfolio.png',
   'base' => 'recent_portfolio',
   'class' => '',
   'category' => 'transport',
   'params' => array(
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Number of portfolio posts', 'transport'),
         'param_name' => 'number',
         'value' => '5',
         'description' => esc_html__('Enter number of recent portfolio posts.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'portfolio_categories',
         'heading' => esc_html__('Portfolio categories', 'transport'),
         'param_name' => 'category',
         'description' => esc_html__('Select portfolio categories.', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Image size', 'transport'),
         'param_name' => 'image_size',
         'value' => '',
         'description' => esc_html__('By default set to post-thumb (360x267px)', 'transport'),
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Mobile view', 'transport'),
         'param_name' => 'mobile_class',
         'value' => array(
                    esc_html__('2 columns', 'transport')=>'2',
                    esc_html__('1 column', 'transport')=>'1'
             ),
         'save_always' => true,
         'admin_label' => true
       )
       )
) );
/* END VC recent portfolio */
/* VC horizontal featured */
vc_map( array(
   'name' => esc_html__('Featured horizontal content', 'transport'),
   'base' => 'anps_featured_horizontal',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_statement.png',
   'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'transport'),
            'param_name' => 'title',
            'admin_label' => true
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Image', 'transport'),
            'param_name' => 'image_u',
            'admin_label' => false
        ),
        array(
            'type' => 'textarea_html',
            'heading' => esc_html__('Content', 'transport'),
            'param_name' => 'content',
            'description' => esc_html__('Enter content of shortcode.', 'transport'),
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Link', 'transport'),
            'param_name' => 'link',
            'admin_label' => true
        )
   )
) );
/* END VC horizontal featured */
/* VC twitter */
vc_map( array(
   'name' => esc_html__('Twitter', 'transport'),
   'base' => 'twitter',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_twitter.png',
   'category' => 'transport',
   'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Slug', 'transport'),
            'param_name' => 'slug',
            'description' => esc_html__('This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)', 'transport'),
            'admin_label' => false
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'transport'),
            'param_name' => 'title',
            'value' => 'Stay tuned, follow us on Twitter',
            'description' => esc_html__('Enter twitter title.', 'transport'),
            'admin_label' => true
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Parallax', 'transport'),
            'param_name' => 'parallax',
            'value' => array(
                        esc_html__('False', 'transport')=>'false',
                        esc_html__('True', 'transport')=>'true'
                ),
            'description' => esc_html__('Enter parallax.', 'transport'),
            'save_always' => true,
            'admin_label' => false
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Parallax overlay', 'transport'),
            'param_name' => 'parallax_overlay',
            'value' => array(
                        esc_html__('False', 'transport')=>'',
                        esc_html__('True', 'transport')=>'true'
                ),
            'description' => esc_html__('Parallax overlay.', 'transport'),
            'save_always' => true,
            'admin_label' => false
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Background image url', 'transport'),
            'param_name' => 'image',
            'description' => esc_html__('Enter background image url.', 'transport'),
            'admin_label' => false
        ),
        array(
            'type' => 'attach_image',
            'holder' => 'div',
            'heading' => esc_html__('Background image', 'transport'),
            'param_name' => 'image_u',
            'admin_label' => false
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background color', 'transport'),
            'param_name' => 'color',
            'value' => '',
            'description' => esc_html__('Background color.', 'transport'),
            'admin_label' => false
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Twitter username', 'transport'),
            'param_name' => 'content',
            'value' => '',
            'description' => esc_html__('Enter twitter username.', 'transport'),
            'admin_label' => true
        )
       )
) );
/* END VC twitter */
/* VC alert */
vc_map( array(
   'name' => esc_html__('Alert', 'transport'),
   'base' => 'alert',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_alert.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Text', 'transport'),
         'param_name' => 'content',
         'value' => '',
         'description' => esc_html__('Enter alert text.', 'transport'),
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Icon', 'transport'),
         'param_name' => 'type',
         'value' => array(
                    esc_html__('', 'transport')=>'',
                    esc_html__('Warning', 'transport')=>'warning',
                    esc_html__('Info', 'transport')=>'info',
                    esc_html__('Success', 'transport')=>'success',
                    esc_html__('Useful', 'transport')=>'useful',
                    esc_html__('Normal', 'transport')=>'normal'),
         'save_always' => true,
         'admin_label' => true
       )
       )
    ));
/* END VC alert */
/* VC counter */
vc_map( array(
   'name' => esc_html__('Counter', 'transport'),
   'base' => 'counter',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_counter.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Text', 'transport'),
         'param_name' => 'content',
         'value' => '',
         'description' => esc_html__('Enter counter text.', 'transport'),
         'admin_label' => true
       ),
       array(
           'type' => 'dropdown',
           'heading' => esc_html__( 'Icon library', 'transport' ),
           'value' => array(
                    esc_html__('Font Awesome', 'transport') => 'fontawesome',
                    esc_html__('Open Iconic', 'transport') => 'openiconic',
                    esc_html__('Typicons', 'transport') => 'typicons',
                    esc_html__('Entypo', 'transport') => 'entypo',
                    esc_html__('Linecons', 'transport') => 'linecons',
                    esc_html__('Mono Social', 'transport') => 'monosocial',
           ),
           'admin_label' => true,
           'param_name' => 'icon_type',
           'save_always' => true,
           'description' => esc_html__('Select icon library.', 'transport'),
       ),
       array(
           'type' => 'iconpicker',
           'heading' => esc_html__('Icon', 'transport'),
           'param_name' => 'icon_fontawesome',
           'settings' => array(
               'iconsPerPage' => 4000,
           ),
           'dependency' => array(
               'element' => 'icon_type',
               'value' => 'fontawesome',
           ),
           'description' => esc_html__('Select icon from library.', 'transport'),
       ),
       array(
           'type' => 'iconpicker',
           'heading' => esc_html__('Icon', 'transport'),
           'param_name' => 'icon_openiconic',
           'settings' => array(
               'type' => 'openiconic',
               'iconsPerPage' => 4000,
           ),
           'dependency' => array(
               'element' => 'icon_type',
               'value' => 'openiconic',
           ),
           'description' => esc_html__('Select icon from library.', 'transport'),
       ),
       array(
           'type' => 'iconpicker',
           'heading' => esc_html__('Icon', 'transport'),
           'param_name' => 'icon_typicons',
           'settings' => array(
               'type' => 'typicons',
               'iconsPerPage' => 4000,
           ),
           'dependency' => array(
               'element' => 'icon_type',
               'value' => 'typicons',
           ),
           'description' => esc_html__('Select icon from library.', 'transport'),
       ),
       array(
           'type' => 'iconpicker',
           'heading' => esc_html__('Icon', 'transport'),
           'param_name' => 'icon_entypo',
           'settings' => array(
               'type' => 'entypo',
               'iconsPerPage' => 4000,
           ),
           'dependency' => array(
               'element' => 'icon_type',
               'value' => 'entypo',
           ),
       ),
       array(
           'type' => 'iconpicker',
           'heading' => esc_html__('Icon', 'transport'),
           'param_name' => 'icon_linecons',
           'settings' => array(
               'type' => 'linecons',
               'iconsPerPage' => 4000,
           ),
           'dependency' => array(
               'element' => 'icon_type',
               'value' => 'linecons',
           ),
           'description' => esc_html__('Select icon from library.', 'transport'),
       ),
       array(
           'type' => 'iconpicker',
           'heading' => esc_html__('Icon', 'transport'),
           'param_name' => 'icon_monosocial',
           'settings' => array(
               'type' => 'monosocial',
               'iconsPerPage' => 4000,
           ),
           'dependency' => array(
               'element' => 'icon_type',
               'value' => 'monosocial',
           ),
           'description' => esc_html__('Select icon from library.', 'transport'),
       ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Max number', 'transport'),
         'param_name' => 'max',
         'value' => '',
         'description' => esc_html__('Enter max number.', 'transport'),
         'admin_label' => true
       ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Min number', 'transport'),
         'param_name' => 'min',
         'value' => '0',
         'description' => esc_html__('Enter min number.', 'transport'),
         'admin_label' => true
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Icon color', 'transport'),
         'param_name' => 'icon_color',
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Number color', 'transport'),
         'param_name' => 'number_color',
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Subtitle color', 'transport'),
         'param_name' => 'subtitle_color',
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         "heading" => esc_html__('Border color', 'transport'),
         'param_name' => 'border_color',
         'admin_label' => false
       )
       )
    ) );
/* END VC counter */
/* VC progress */
vc_map( array(
   'name' => esc_html__('Progress', 'transport'),
   'base' => 'progress',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_progress.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Progress procent', 'transport'),
         'param_name' => 'procent',
         'value' => '',
         'description' => esc_html__('Enter progress procent.', 'transport'),
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Striped', 'transport'),
         'param_name' => 'striped',
         'value' => array(
                    esc_html__('No', 'transport')=>'',
                    esc_html__('Yes', 'transport')=>'true'
             ),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Active', 'transport'),
         'param_name' => 'active',
         'value' => array(
                    esc_html__('No', 'transport')=>'',
                    esc_html__('Yes', 'transport')=>'true'
             ),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Color class', 'transport'),
         'param_name' => 'color_class',
         'value' => array(
                    esc_html__('Success', 'transport')=>'progress-bar-success',
                    esc_html__('Info', 'transport')=>'progress-bar-info',
                    esc_html__('Warning', 'transport')=>'progress-bar-warning',
                    esc_html__('Danger', 'transport')=>'progress-bar-danger'
             ),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Progress title', 'transport'),
         'param_name' => 'content',
         'value' => '',
         'description' => esc_html__('Enter progress title.', 'transport'),
         'admin_label' => true
      )
       )
) );
/* END VC progress */
/* VC icon */
vc_map( array(
   'name' => esc_html__('Icon', 'transport'),
   'base' => 'anps_icon',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_icon.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Text', 'transport'),
         'param_name' => 'content',
         'admin_label' => true
      ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Title', 'transport'),
         'param_name' => 'title',
         'admin_label' => true
      ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Subtitle', 'transport'),
         'param_name' => 'subtitle',
         'admin_label' => true
      ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Link', 'transport'),
         'param_name' => 'url',
         'admin_label' => true
      ),
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Target', 'transport'),
         'param_name' => 'target',
         'value' => '_self',
         'admin_label' => true
      ),
      array(
          'type' => 'dropdown',
          'heading' => esc_html__( 'Icon library', 'transport' ),
          'value' => array(
              esc_html__( 'Font Awesome', 'transport' ) => 'fontawesome',
              esc_html__( 'Open Iconic', 'transport' ) => 'openiconic',
              esc_html__( 'Typicons', 'transport' ) => 'typicons',
              esc_html__( 'Entypo', 'transport' ) => 'entypo',
              esc_html__( 'Linecons', 'transport' ) => 'linecons',
              esc_html__( 'Mono Social', 'transport' ) => 'monosocial',
          ),
          'admin_label' => true,
          'param_name' => 'icon_type',
          'description' => esc_html__( 'Select icon library.', 'transport' ),
          'save_always' => true
      ),
      array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'transport' ),
          'param_name' => 'icon_fontawesome',
          'settings' => array(
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'fontawesome',
          ),
          'description' => esc_html__( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'transport' ),
          'param_name' => 'icon_openiconic',
          'settings' => array(
              'type' => 'openiconic',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'openiconic',
          ),
          'description' => esc_html__( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'transport' ),
          'param_name' => 'icon_typicons',
          'settings' => array(
              'type' => 'typicons',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'typicons',
          ),
          'description' => esc_html__( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'transport' ),
          'param_name' => 'icon_entypo',
          'settings' => array(
              'type' => 'entypo',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'entypo',
          ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'transport' ),
          'param_name' => 'icon_linecons',
          'settings' => array(
              'type' => 'linecons',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'linecons',
          ),
          'description' => esc_html__( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => esc_html__( 'Icon', 'transport' ),
          'param_name' => 'icon_monosocial',
          'settings' => array(
              'type' => 'monosocial',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'monosocial',
          ),
          'description' => esc_html__( 'Select icon from library.', 'transport' ),
      ),
      array(
         'type' => 'attach_image',
         'heading' => esc_html__('Icon image', 'transport'),
         'param_name' => 'image_u',
         'admin_label' => false
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Position', 'transport'),
         'param_name' => 'position',
         'value' => array(
                    esc_html__('Left', 'transport')=>'left',
                    esc_html__('Right', 'transport')=>'right'
             ),
         'save_always' => true,
         'admin_label' => true
      ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Class', 'transport'),
         'param_name' => 'class',
         'value' => array(
                    esc_html__('Style 1', 'transport')=>'',
                    esc_html__('Style 2', 'transport')=>'style-2'
             ),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Title color', 'transport'),
         'param_name' => 'title_color',
         'admin_label' => false
      ),
      array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Subtitle color', 'transport'),
         'param_name' => 'subtitle_color',
         'admin_label' => false
      ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Icon color', 'transport'),
         'param_name' => 'icon_color',
         'admin_label' => false
      ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Icon background color', 'transport'),
         'param_name' => 'icon_bg_color',
         'admin_label' => false
      ),
   )
) );
/* END VC icon */
/* VC quote */
vc_map( array(
   'name' => esc_html__('Quote', 'transport'),
   'base' => 'quote',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_quote.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Quote text', 'transport'),
         'param_name' => "content",
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Style', 'transport'),
         'param_name' => 'style',
         'value' => array(
                    esc_html__('Style 1', 'transport')=>'style-1',
                    esc_html__('Style 2', 'transport')=>'style-2'
             ),
         'save_always' => true,
         'admin_label' => true
       )
   )
) );
/* END VC quote */
/* VC color */
vc_map( array(
   'name' => esc_html__('Color', 'transport'),
   'base' => 'color',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_color.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Color text', 'transport'),
         'param_name' => 'content',
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Style', 'transport'),
         'param_name' => 'style',
         'value' => array(
                    esc_html__('Style 1', 'transport')=>'',
                    esc_html__('Style 2', 'transport')=>'style-2'
             ),
         'save_always' => true
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Custom color', 'transport'),
         'param_name' => 'custom',
         'admin_label' => false
      )
   )
) );
/* END VC color */
/* VC dropcaps */
vc_map( array(
   'name' => esc_html__('Dropcaps', 'transport'),
   'base' => 'dropcaps',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_dropcaps.png',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Dropcaps text', 'transport'),
         'param_name' => 'content',
         'admin_label' => true
      ),
      array(
         'type' => 'dropdown',
         'heading' => esc_html__('Style', 'transport'),
         'param_name' => 'style',
         'value' => array(
                    esc_html__('Style 1', 'transport')=>'',
                    esc_html__('Style 2', 'transport')=>'style-2'
             ),
         'save_always' => true,
         'admin_label' => true
       )
   )
) );
/* END VC dropcaps */
/* VC content over image */
vc_map( array(
   'name' => esc_html__('Content over image', 'transport'),
   'base' => 'content_over_image',
   'content_element' => true,
   'is_container' => true,
   'js_view' => 'VcColumnView',
   'category' => 'transport',
   'params' => array(
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Image location', 'transport'),
         'param_name' => 'image_location',
         'value' => array(
                    esc_html__('Left', 'transport')=>'left',
                    esc_html__('Right', 'transport')=>'right'
             ),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'attach_image',
         'heading' => esc_html__('Background image', 'transport'),
         'param_name' => 'image',
         'admin_label' => false
       ),
   )
) );
/* END VC content over image */
/* VC statement */
vc_map( array(
   'name' => esc_html__('Statement', 'transport'),
   'base' => 'statement',
   'content_element' => true,
   'is_container' => true,
   'js_view' => 'VcColumnView',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_statement.png',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Slug', 'transport'),
         'param_name' => 'slug',
         'description' => esc_html__('This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)', 'transport'),
         'admin_label' => false
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Parallax', 'transport'),
         'param_name' => 'parallax',
         'value' => array(
                    esc_html__('False', 'transport')=>'false',
                    esc_html__('True', 'transport')=>'true'
             ),
         'description' => esc_html__('Enter parallax.', 'transport'),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Parallax overlay', 'transport'),
         'param_name' => 'parallax_overlay',
         'value' => array(
                    esc_html__('False', 'transport')=>'',
                    esc_html__('True', 'transport')=>'true'
             ),
         'description' => esc_html__('Parallax overlay.', 'transport'),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Background image url', 'transport'),
         'param_name' => 'image',
         'admin_label' => false
       ),
       array(
         'type' => 'attach_image',
         'heading' => esc_html__('Background image', 'transport'),
         'param_name' => 'image_u',
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Background color', 'transport'),
         'param_name' => 'color',
         'value' => '',
         'description' => esc_html__('Background color.', 'transport'),
         'admin_label' => false
       )
   )
) );
/* END VC statement */
/* VC heading */
vc_map( array(
   'name' => esc_html__('Heading', 'transport'),
   'base' => 'heading',
   'class' => '',
   'category' => 'transport',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_heading.png',
   'params' => array(
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Title', 'transport'),
         'param_name' => 'content',
         'value' => '',
         'description' => esc_html__('Enter title.', 'transport'),
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Size', 'transport'),
         'param_name' => 'size',
         'value' => array(
                    esc_html__('H1', 'transport')=>'1',
                    esc_html__('H2', 'transport')=>'2',
                    esc_html__('H3', 'transport')=>'3',
                    esc_html__('H4', 'transport')=>'4',
                    esc_html__('H5', 'transport')=>'5'),
         'description' => esc_html__('Enter title size.', 'transport'),
         'save_always' => true,
         'admin_label' => true
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Heading class', 'transport'),
         'param_name' => 'heading_class',
         'value' => array(
                    esc_html__('Middle heading', 'transport')=>'heading',
                    esc_html__('Content heading', 'transport')=>'content_heading',
                    esc_html__('Left heading', 'transport')=>'style-3'
             ),
         'description' => esc_html__('Choose heading.', 'transport'),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'dropdown',
         'heading' => esc_html__('Heading style', 'transport'),
         'param_name' => 'heading_style',
         'value' => array(
                    esc_html__('Style 1', 'transport')=>'style-1',
                    esc_html__('Style 2', 'transport')=>'divider-sm',
                    esc_html__('Style 3', 'transport')=>'divider-lg'
             ),
         'description' => esc_html__('Choose heading style.', 'transport'),
         'save_always' => true,
         'admin_label' => false
       ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Id', 'transport'),
         'param_name' => 'h_id',
         'value' => '',
         'description' => esc_html__('Enter id.', 'transport'),
         'admin_label' => false
       ),
       array(
         'type' => 'textfield',
         'heading' => esc_html__('Class', 'transport'),
         'param_name' => 'h_class',
         'value' => '',
         'description' => esc_html__('Enter class.', 'transport'),
         'admin_label' => false
       ),
       array(
         'type' => 'colorpicker',
         'heading' => esc_html__('Color', 'transport'),
         'param_name' => 'color',
         'description' => esc_html__('Heading text color.', 'transport'),
         'admin_label' => false
      )
    )
) );
/* END VC heading */
/* VC Google maps (as parent) */
vc_map( array(
   'name' => esc_html__('Google maps', 'transport'),
   'base' => 'google_maps',
   'category' => 'transport',
   'content_element' => true,
   'is_container' => true,
   'as_parent' => array('only' => 'google_maps_item'),
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_googlemaps.png',
   'js_view' => 'VcColumnView',
   'params' => array(
		array(
			'type' => 'textfield',
			"heading" => esc_html__('Zoom', 'transport'),
			'param_name' => 'zoom',
			'value' => '15',
			'description' => esc_html__('Enter zoom.', 'transport'),
                        'admin_label' => true
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__('Map Type', 'transport'),
			'param_name' => 'map_type',
			'value'      => array(
				esc_html__('Road map', 'transport')  => 'ROADMAP',
				esc_html__('Satellite', 'transport') => 'SATELLITE',
				esc_html__('Hybrid', 'transport')    => 'HYBRID',
				esc_html__('Terrain', 'transport')   => 'TERRAIN'
			),
			'description' => esc_html__('Choose between four types of maps.', 'transport'),
			'save_always' => true,
                        'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Height', 'transport'),
			'param_name' => 'height',
			'value' => '550',
			'description' => esc_html__('Enter height in px.', 'transport'),
                        'admin_label' => true
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Disable scrolling', 'transport'),
			'param_name' => 'scroll',
			'description' => esc_html__('Disable scrolling and dragging (mobile).', 'transport'),
			'save_always' => true,
                        'admin_label' => false
		),
        array(
			'type' => 'textarea',
			'heading' => esc_html__('Style', 'transport'),
			'param_name' => 'style',
			'description' => esc_html__('Custom styles', 'transport'),
                        'admin_label' => false
		)
     )
) );
/* END VC Google maps */
/* VC Google maps item (as child) */
vc_map( array(
    'name' => esc_html__('Google maps item', 'transport'),
    'base' => 'google_maps_item',
    'content_element' => true,
    'category' => 'transport',
    'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_googlemaps.png',
    'as_child' => array('only' => 'google_maps'),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Location', 'transport'),
            'param_name' => 'content',
            'description' => esc_html__('Enter address.', 'transport'),
            'admin_label' => true
        ),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show marker at center', 'transport'),
			'param_name' => 'marker_center',
			'save_always' => true,
                        'admin_label' => false
		),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Pin', 'transport'),
            'param_name' => 'pin',
            'description' => esc_html__('Select or upload pin icon.', 'transport'),
            'admin_label' => false
        ),
        array(
            'type' => 'textarea_raw_html',
            'heading' => esc_html__('Info', 'transport'),
            'param_name' => 'info',
            'value' => '',
            'description' => esc_html__('Enter info about location.', 'transport'),
            'admin_label' => false
        )
    )
) );
/* END VC Google maps item */
/* VC vimeo */
vc_map( array(
   'name' => esc_html__('Vimeo', 'transport'),
   'base' => 'vimeo',
   'class' => '',
   'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_vimeo.png',
   'category' => 'transport',
   'params' => array(
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Video id', 'transport'),
         'param_name' => 'content',
         'value' => '',
         'description' => esc_html__('Enter vimeo video id.', 'transport'),
         'admin_label' => true
      )
       )
) );
/* END VC vimeo */
/* VC youtube */
vc_map( array(
   'name' => esc_html__('Youtube', 'transport'),
   'base' => 'youtube',
   'class' => '',
   'icon' => 'icon-wpb-film-youtube',
   'category' => 'transport',
   'params' => array(
      array(
         'type' => 'textfield',
         'heading' => esc_html__('Video id', 'transport'),
         'param_name' => 'content',
         'value' => '',
         'description' => esc_html__('Enter youtube video id.', 'transport'),
         'admin_label' => true
      )
       )
) );
/* END VC youtube */
/* VC social icons */
vc_map( array(
    'name' => esc_html__('Social icons', 'transport'),
    'base' => 'social_icons',
    'content_element' => true,
    'as_parent' => array('only' => 'social_icon_item'),
    'show_settings_on_create' => false,
    'category' => 'transport',
    'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_social.png',
    'js_view' => 'VcColumnView'
) );
/* END VC social icons */
/* VC social icon */
vc_map( array(
    'name' => esc_html__('Social icon item', 'transport'),
    'base' => 'social_icon_item',
    'content_element' => true,
    'is_container' => true,
    'category' => 'transport',
    'as_child' => array('only' => 'social_icons'),
    'icon' => get_template_directory_uri().'/images/visual-composer/anpsicon_social.png',
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Url', 'transport'),
            'param_name' => 'url',
            'description' => esc_html__('Enter url.', 'transport'),
            'value' => '#',
            'admin_label' => true
        ),
        array(
         "type" => "dropdown",
         "heading" => __("Social network", "transport"),
         "param_name" => "icon",
         "save_always" => true,
         "value" => array(__("", "transport")=>'',
            html_entity_decode("&#xf170; ") . __("Adn", "transport")=>"adn",
            html_entity_decode("&#xf17b; ") . __("Android", "transport")=>"android",
            html_entity_decode("&#xf179; ") . __("Apple", "transport")=>"apple",
            html_entity_decode("&#xf1b4; ") . __("Behance", "transport")=>"behance",
            html_entity_decode("&#xf1b5; ") . __("Behance square", "transport")=>"behance-square",
            html_entity_decode("&#xf171; ") . __("Bitbucket", "transport")=>"bitbucket",
            html_entity_decode("&#xf172; ") . __("Bitbucket square", "transport")=>"bitbucket-square",
            html_entity_decode("&#xf15a; ") . __("Bitcoin", "transport")=>"bitcoin",
            html_entity_decode("&#xf15a; ") . __("Btc", "transport")=>"btc",
            html_entity_decode("&#xf1cb; ") . __("Codepen", "transport")=>"codepen",
            html_entity_decode("&#xf13c; ") . __("Css3", "transport")=>"css3",
            html_entity_decode("&#xf1a5; ") . __("Delicious", "transport")=>"delicious",
            html_entity_decode("&#xf1bd; ") . __("Deviantart", "transport")=>"deviantart",
            html_entity_decode("&#xf1a6; ") . __("Digg", "transport")=>"digg",
            html_entity_decode("&#xf17d; ") . __("Dribbble", "transport")=>"dribbble",
            html_entity_decode("&#xf16b; ") . __("Dropbox", "transport")=>"dropbox",
            html_entity_decode("&#xf1a9; ") . __("Drupal", "transport")=>"drupal",
            html_entity_decode("&#xf1d1; ") . __("Empire", "transport")=>"empire",
            html_entity_decode("&#xf09a; ") . __("Facebook", "transport")=>"facebook",
            html_entity_decode("&#xf082; ") . __("Facebook square", "transport")=>"facebook-square",
            html_entity_decode("&#xf16e; ") . __("Flickr", "transport")=>"flickr",
            html_entity_decode("&#xf180; ") . __("Foursquare", "transport")=>"foursquare",
            html_entity_decode("&#xf1d1; ") . __("Ge", "transport")=>"ge",
            html_entity_decode("&#xf1d3; ") . __("Git", "transport")=>"git",
            html_entity_decode("&#xf1d2; ") . __("Git square", "transport")=>"git-square",
            html_entity_decode("&#xf09b; ") . __("Github", "transport")=>"github",
            html_entity_decode("&#xf113; ") . __("Github alt", "transport")=>"github-alt",
            html_entity_decode("&#xf092; ") . __("Github square", "transport")=>"github-square",
            html_entity_decode("&#xf184; ") . __("Gittip", "transport")=>"gittip",
            html_entity_decode("&#xf1a0; ") . __("Google", "transport")=>"google",
            html_entity_decode("&#xf0d5; ") . __("Google plus", "transport")=>"google-plus",
            html_entity_decode("&#xf0d4; ") . __("Google plus square", "transport")=>"google-plus-square",
            html_entity_decode("&#xf1d4; ") . __("Hacker news", "transport")=>"hacker-news",
            html_entity_decode("&#xf13b; ") . __("Html5", "transport")=>"html5",
            html_entity_decode("&#xf16d; ") . __("Instagram", "transport")=>"instagram",
            html_entity_decode("&#xf1aa; ") . __("Joomla", "transport")=>"joomla",
            html_entity_decode("&#xf1cc; ") . __("Jsfiddle", "transport")=>"jsfiddle",
            html_entity_decode("&#xf0e1; ") . __("Linkedin", "transport")=>"linkedin",
            html_entity_decode("&#xf08c; ") . __("Linkedin square", "transport")=>"linkedin-square",
            html_entity_decode("&#xf17c; ") . __("Linux", "transport")=>"linux",
            html_entity_decode("&#xf136; ") . __("Maxcdn", "transport")=>"maxcdn",
            html_entity_decode("&#xf041; ") . __("Map marker", "transport")=>"map-marker",
            html_entity_decode("&#xf19b; ") . __("Openid", "transport")=>"openid",
            html_entity_decode("&#xf18c; ") . __("Pagelines", "transport")=>"pagelines",
            html_entity_decode("&#xf1a7; ") . __("Pied piper", "transport")=>"pied-piper",
            html_entity_decode("&#xf1a8; ") . __("Pied piper alt", "transport")=>"pied-piper-alt",
            html_entity_decode("&#xf1a7; ") . __("Pied piper square", "transport")=>"pied-piper-square",
            html_entity_decode("&#xf0d2; ") . __("Pinterest", "transport")=>"pinterest",
            html_entity_decode("&#xf0d3; ") . __("Pinterest square", "transport")=>"pinterest-square",
            html_entity_decode("&#xf1d6; ") . __("Qq", "transport")=>"qq",
            html_entity_decode("&#xf1d0; ") . __("Ra", "transport")=>"ra",
            html_entity_decode("&#xf1d0; ") . __("Rebel", "transport")=>"rebel",
            html_entity_decode("&#xf1a1; ") . __("Reddit", "transport")=>"reddit",
            html_entity_decode("&#xf1a2; ") . __("Reddit square", "transport")=>"reddit-square",
            html_entity_decode("&#xf18b; ") . __("Renren", "transport")=>"renren",
            html_entity_decode("&#xf1e0; ") . __("Share alt", "transport")=>"share-alt",
            html_entity_decode("&#xf1e1; ") . __("Share alt square", "transport")=>"share-alt-square",
            html_entity_decode("&#xf17e; ") . __("Skype", "transport")=>"skype",
            html_entity_decode("&#xf198; ") . __("Slack", "transport")=>"slack",
            html_entity_decode("&#xf1be; ") . __("Soundcloud", "transport")=>"soundcloud",
            html_entity_decode("&#xf1bc; ") . __("Spotify", "transport")=>"spotify",
            html_entity_decode("&#xf18d; ") . __("Stack exchange", "transport")=>"stack-exchange",
            html_entity_decode("&#xf16c; ") . __("Stack overflow", "transport")=>"stack-overflow",
            html_entity_decode("&#xf1b6; ") . __("Steam", "transport")=>"steam",
            html_entity_decode("&#xf1b7; ") . __("Steam square", "transport")=>"steam-square",
            html_entity_decode("&#xf1a4; ") . __("Stumbleupon", "transport")=>"stumbleupon",
            html_entity_decode("&#xf1a3; ") . __("Stumbleupon circle", "transport")=>"stumbleupon-circle",
            html_entity_decode("&#xf1d5; ") . __("Tencent weibo", "transport")=>"tencent-weibo",
            html_entity_decode("&#xf181; ") . __("Trello", "transport")=>"trello",
            html_entity_decode("&#xf173; ") . __("Tumblr", "transport")=>"tumblr",
            html_entity_decode("&#xf174; ") . __("Tumblr square", "transport")=>"tumblr-square",
            html_entity_decode("&#xf099; ") . __("Twitter", "transport")=>"twitter",
            html_entity_decode("&#xf081; ") . __("Twitter square", "transport")=>"twitter-square",
            html_entity_decode("&#xf194; ") . __("Vimeo square", "transport")=>"vimeo-square",
            html_entity_decode("&#xf1ca; ") . __("Vine", "transport")=>"vine",
            html_entity_decode("&#xf189; ") . __("Vk", "transport")=>"vk",
            html_entity_decode("&#xf1d7; ") . __("Wechat", "transport")=>"wechat",
            html_entity_decode("&#xf18a; ") . __("Weibo", "transport")=>"weibo",
            html_entity_decode("&#xf1d7; ") . __("Weixin", "transport")=>"weixin",
            html_entity_decode("&#xf17a; ") . __("Windows", "transport")=>"windows",
            html_entity_decode("&#xf19a; ") . __("Wordpress", "transport")=>"wordpress",
            html_entity_decode("&#xf168; ") . __("Xing", "transport")=>"xing",
            html_entity_decode("&#xf169; ") . __("Xing square", "transport")=>"xing-square",
            html_entity_decode("&#xf19e; ") . __("Yahoo", "transport")=>"yahoo",
            html_entity_decode("&#xf167; ") . __("Youtube", "transport")=>"youtube",
            html_entity_decode("&#xf16a; ") . __("Youtube play", "transport")=>"youtube-play",
            html_entity_decode("&#xf166; ") . __("Youtube square", "transport")=>"youtube-square"
             ),
            'admin_label' => false
        ),
        array(
            "type" => "textfield",
            "heading" => __("Target", "transport"),
            "param_name" => "target",
            "value" => "_blank",
            "description" => __("Enter target.", "transport"),
            'admin_label' => false
        )
    )
));
/* END VC social icon */
/* VC contact info */
vc_map( array(
    "name" => __("Contact info", "transport"),
    "base" => "contact_info",
    "as_parent" => array('only' => 'contact_info_item'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_contactinfo.png",
    "js_view" => 'VcColumnView'
) );
/* END VC contact info */
/* VC contact info item */
vc_map( array(
    "name" => __("Contact info item", "transport"),
    "base" => "contact_info_item",
    "content_element" => true,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_contactinfo.png",
    "as_child" => array('only' => 'contact_info'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Text", "transport"),
            "param_name" => "content",
            "description" => __("Enter text.", "transport"),
            'admin_label' => true
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'transport' ),
            'value' => array(
                __( 'Font Awesome', 'transport' ) => 'fontawesome',
                __( 'Open Iconic', 'transport' ) => 'openiconic',
                __( 'Typicons', 'transport' ) => 'typicons',
                __( 'Entypo', 'transport' ) => 'entypo',
                __( 'Linecons', 'transport' ) => 'linecons',
                __( 'Mono Social', 'transport' ) => 'monosocial',
            ),
            'admin_label' => true,
            'param_name' => 'icon_type',
            'description' => __( 'Select icon library.', 'transport' ),
            "save_always" => true
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'transport' ),
            'param_name' => 'icon_fontawesome',
            'settings' => array(
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'transport' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'transport' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'transport' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'transport' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'transport' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'transport' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'type' => 'entypo',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'transport' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'transport' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'transport' ),
            'param_name' => 'icon_monosocial',
            'settings' => array(
                'type' => 'monosocial',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'transport' ),
        )
    )
) );
/* END VC contact info item */
/* VC Faq */
vc_map( array(
    "name" => __("Faq", "transport"),
    "base" => "faq",
    "as_parent" => array('only' => 'faq_item'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_faq.png",
    "js_view" => 'VcColumnView'
) );
/* END VC Faq */
/* VC Faq item */
vc_map( array(
    "name" => __("Faq item", "transport"),
    "base" => "faq_item",
    "content_element" => true,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_faq.png",
    "as_child" => array('only' => 'faq'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", "transport"),
            "param_name" => "title",
            "description" => __("Enter faq title.", "transport"),
            'admin_label' => true
        ),
        array(
            "type" => "textfield",
            "heading" => __("Answer title", "transport"),
            "param_name" => "answer_title",
            "description" => __("Enter faq answer title.", "transport"),
            'admin_label' => true
        ),
        array(
            "type" => "textfield",
            "heading" => __("Faq content", "transport"),
            "param_name" => "content",
            "description" => __("Enter faq text content.", "transport"),
            'admin_label' => false
        )
    )
));
/* END VC Faq item */
/* VC logos (as parent) */
vc_map( array(
    "name" => __("Logos", 'transport'),
    "base" => "logos",
    "as_parent" => array('only' => 'logo'),
    "content_element" => true,
    "is_container" => true,
    "category" => 'transport',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_logo.png",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Logos in row", 'transport'),
            "param_name" => "in_row",
            "description" => __("Logos in one row.", 'transport'),
            "value" => "3",
            'admin_label' => true
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Style", 'transport'),
            "param_name" => "style",
            "value" => array(esc_html__("Style 1", 'transport')=>'style-1', esc_html__("Carousel Logos", 'transport')=>'style-2'),
            "description" => __("Select logos style.", 'transport'),
            "save_always" => true,
            'admin_label' => true
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Arrow navigation", 'transport'),
            "param_name" => "nav",
            "admin_label" => false,
            'dependency' => array(
                'element' => 'style',
                'value' => 'style-2',
            ),
        ),
    )
) );
/* END VC logos*/
/* VC logo (as child) */
vc_map( array(
    "name" => __("Logo", 'transport'),
    "base" => "logo",
    "content_element" => true,
    "category" => 'transport',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_logo.png",
    "as_child" => array('only' => 'logos'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Image url", 'transport'),
            "param_name" => "content",
            "description" => __("Enter image url.", 'transport'),
            'admin_label' => false
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Image", 'transport'),
            "param_name" => "image_u",
            'admin_label' => false
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Image on hover", 'transport'),
            "param_name" => "image_u_hover",
            'admin_label' => false
        ),
        array(
            "type" => "textfield",
            "heading" => __("Url", 'transport'),
            "param_name" => "url",
            "description" => __("Logo url.", 'transport'),
            'admin_label' => true
        ),
        array(
            "type" => "textfield",
            "heading" => __("Alt", 'transport'),
            "param_name" => "alt",
            "description" => __("Logo alt.", 'transport'),
            'admin_label' => true
        )
    )
) );

/* END VC logo */
/* VC testimonials (as parent) */
vc_map( array(
    "name" => __("Testimonials", "transport"),
    "base" => "testimonials",
    "as_parent" => array('only' => 'testimonial'),
    "content_element" => true,
    "show_settings_on_create" => true,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_testimonials.png",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
         "type" => "dropdown",
         "heading" => __("Style", "transport"),
         "param_name" => "style",
         "value" => array(__('Style 1', 'transport') => '', __('Style 2', 'transport') => 'white', __('Style 3', 'transport') => 'style-3', __('Style 4', 'transport') => 'style-4'),
         "description" => __('Select testimonials style.', 'transport'),
         "save_always" => true,
         'admin_label' => true
      ),
      array(
          "type" => "textfield",
          "heading" => esc_html__("title", 'transport'),
          "param_name" => "testimonialheading",
          "description" => esc_html__('Applicable only for style 4 testimonials.', 'transport'),
          "admin_label" => true,
          'admin_label' => false
      )
    )
) );
/* END VC testimonials */
/* VC testimonial (as child) */
vc_map( array(
    "name" => __("Testimonial item", "transport"),
    "base" => "testimonial",
    "content_element" => true,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_testimonials.png",
    "as_child" => array('only' => 'testimonials'),
    "params" => array(
        array(
            "type" => "textarea",
            "heading" => __("Testimonial text", "transport"),
            "param_name" => "content",
            "description" => __("Enter user testimonial text", "transport"),
            'admin_label' => true
        ),
        array(
            "type" => "textfield",
            "heading" => __("User name", "transport"),
            "param_name" => "user_name",
            "description" => __("Enter user name", "transport"),
            'admin_label' => true
        ),
        array(
            "type" => "textfield",
            "heading" => __('Job Position', 'transport'),
            "param_name" => "position",
            "description" => __("Applicable only for style 3 and style 4 testimonials.", 'transport'),
            'admin_label' => false
        ),
        array(
            "type" => "textfield",
            "heading" => __("User url", "transport"),
            "param_name" => "user_url",
            "description" => __("Enter user url", "transport"),
            'admin_label' => false
        ),
        array(
            "type" => "attach_image",
            "heading" => __("User image", "transport"),
            "param_name" => "image_u",
            "description" => __("Choose image (71x61px).", "transport"),
            'admin_label' => false
        ),
        array(
            "type" => "textfield",
            "heading" => __("User image url", "transport"),
            "param_name" => "image",
            "description" => __("Enter image url (71x61px).", "transport"),
            'admin_label' => false
        )
    )
) );
/* END VC testimonial */
/* VC button */
vc_map( array(
   "name" => __("Button", "transport"),
   "base" => "button",
   "category" => "transport",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_button.png",
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Text", "transport"),
         "param_name" => "content",
         "description" => __("Enter button text.", "transport"),
         'admin_label' => true
      ),
      array(
         "type" => "textfield",
         "heading" => __("Link", "transport"),
         "param_name" => "link",
         "value" => "#",
         "description" => __("Enter button link.", "transport"),
         'admin_label' => false
      ),
      array(
         "type" => "textfield",
         "heading" => __("Target", "transport"),
         "param_name" => "target",
         "value" => "_self",
         "description" => __("Enter button target.", "transport"),
         'admin_label' => false
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Size", "transport"),
         "param_name" => "size",
         "value" => array(__("Small", "transport")=>'small', __("Medium", "transport")=>'medium', __("Large", "transport")=>'large'),
         "description" => __("Enter button size.", "transport"),
         "save_always" => true,
         'admin_label' => true
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Style", "transport"),
         "param_name" => "style_button",
         "value" => array(__("Style1", "transport")=>'style-1', __("Style2", "transport")=>'style-2', __("Style3", "transport")=>'style-3', __("Style4", "transport")=>'style-4'),
         "description" => __("Enter button style.", "transport"),
         "save_always" => true,
         'admin_label' => false
      ),
      array(
         "type" => "colorpicker",
         "heading" => __("Color", "transport"),
         "param_name" => "color",
         "description" => __("Enter button text color.", "transport"),
         'admin_label' => true
      ),
      array(
         "type" => "colorpicker",
         "heading" => __("Background", "transport"),
         "param_name" => "background",
         "description" => __("Enter button background color.", "transport"),
         'admin_label' => true
      ),
      array(
          'type' => 'dropdown',
          'heading' => __( 'Icon library', 'transport' ),
          'value' => array(
              __( 'Font Awesome', 'transport' ) => 'fontawesome',
              __( 'Open Iconic', 'transport' ) => 'openiconic',
              __( 'Typicons', 'transport' ) => 'typicons',
              __( 'Entypo', 'transport' ) => 'entypo',
              __( 'Linecons', 'transport' ) => 'linecons',
              __( 'Mono Social', 'transport' ) => 'monosocial',
          ),
          'admin_label' => true,
          'param_name' => 'icon_type',
          'description' => __( 'Select icon library.', 'transport' ),
          'save_always' => true
      ),
      array(
          'type' => 'iconpicker',
          'heading' => __( 'Icon', 'transport' ),
          'param_name' => 'icon_fontawesome',
          'settings' => array(
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'fontawesome',
          ),
          'description' => __( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => __( 'Icon', 'transport' ),
          'param_name' => 'icon_openiconic',
          'settings' => array(
              'type' => 'openiconic',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'openiconic',
          ),
          'description' => __( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => __( 'Icon', 'transport' ),
          'param_name' => 'icon_typicons',
          'settings' => array(
              'type' => 'typicons',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'typicons',
          ),
          'description' => __( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => __( 'Icon', 'transport' ),
          'param_name' => 'icon_entypo',
          'settings' => array(
              'type' => 'entypo',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'entypo',
          ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => __( 'Icon', 'transport' ),
          'param_name' => 'icon_linecons',
          'settings' => array(
              'type' => 'linecons',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'linecons',
          ),
          'description' => __( 'Select icon from library.', 'transport' ),
      ),
      array(
          'type' => 'iconpicker',
          'heading' => __( 'Icon', 'transport' ),
          'param_name' => 'icon_monosocial',
          'settings' => array(
              'type' => 'monosocial',
              'iconsPerPage' => 4000,
          ),
          'dependency' => array(
              'element' => 'icon_type',
              'value' => 'monosocial',
          ),
          'description' => __( 'Select icon from library.', 'transport' ),
      )
     )
) );
/* END VC button */
/* VC Pricing table */
vc_map( array(
    "name" => __("Pricing table", "transport"),
    "base" => "pricing_table",
    "content_element" => true,
    "category" => "transport",
    "as_parent" => array('only' => 'pricing_table_item'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_pricingtable.png",
    "params" => array(
        array(
         "type" => "textfield",
         "heading" => __("Title", "transport"),
         "param_name" => "title",
         "description" => __("Enter pricing table title.", "transport"),
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Currency", "transport"),
         "param_name" => "currency",
         "value" => "",
         "description" => __("Enter currency symbol.", "transport"),
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Price", "transport"),
         "param_name" => "price",
         "value" => "0",
         "description" => __("Enter price.", "transport"),
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Period", "transport"),
         "param_name" => "period",
         "description" => __("Enter period (optional).", "transport"),
         'admin_label' => false
       ),
        array(
         "type" => "textfield",
         "heading" => __("Button Text", "transport"),
         "param_name" => "button_text",
         "description" => __("Enter pricing table button text.", "transport"),
         'admin_label' => false
        ),
        array(
         "type" => "textfield",
         "heading" => __("Button Url", "transport"),
         "param_name" => "button_url",
         "description" => __("Enter pricing table button url.", "transport"),
         'admin_label' => false
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Featured", "transport"),
            "param_name" => "featured",
            "save_always" => true,
            "value" =>array(
                __("No", "transport")=>'',
                __("yes", "transport")=>'true'),
            "description" => __("Featured pricing table.", "transport"),
            'admin_label' => false
        )
    ),
    "js_view" => 'VcColumnView'
) );
/* END VC Pricing table */
/* VC Pricing item */
vc_map( array(
    "name" => __("Pricing item", "transport"),
    "base" => "pricing_table_item",
    "content_element" => true,
    "is_container" => true,
    "category" => "transport",
    "as_child" => array('only' => 'pricing_table'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_pricingtable.png",
    "params" => array(
        array(
         "type" => "textfield",
         "heading" => __("Text", "transport"),
         "param_name" => "content",
         "description" => __("Enter pricing item text.", "transport"),
         'admin_label' => true
       )
     )
    ));
/* END VC Pricing item */
/* VC list (as parent) */
vc_map( array(
    "name" => __("List", "transport"),
    "base" => "anps_list",
    "content_element" => true,
    "category" => "transport",
    //"is_container" => true,
    "as_parent" => array('only' => 'list_item'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_list.png",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("List icon", "transport"),
            "param_name" => "class",
            "save_always" => true,
            "value" =>array(
                __("Default", "transport")=>'',
                __("Circle arrow", "transport")=>'circle-arrow',
                __("Triangle", "transport")=>'triangle',
                __("Hand", "transport")=>'hand',
                __("Square", "transport")=>'square',
                __("Arrow", "transport")=>'anps_arrow',
                __("Circle", "transport")=>'circle',
                __("Circle check", "transport")=>'circle-check',
            	__("Number", "transport")=>'number'),
            "description" => __("Select type.", "transport"),
            'admin_label' => true
        )
    )
) );
/* END VC list */
/* VC list item (as child) */
vc_map( array(
    "name" => __("List item", "transport"),
    "base" => "list_item",
    "content_element" => true,
    "category" => "transport",
    //"is_container" => true,
    "as_child" => array('only' => 'anps_list'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_list.png",
    "params" => array(
        array(
         "type" => "textfield",
         "heading" => __("Text", "transport"),
         "param_name" => "content",
         "description" => __("Enter list text.", "transport"),
         'admin_label' => true
       )
     )
    ));
/* END VC list item */
/* VC accordion (as parent) */
vc_map( array(
    "name" => __("Accordion/Toggle", "transport"),
    "base" => "accordion",
    "content_element" => true,
    "as_parent" => array('only' => 'accordion_item'),
    "show_settings_on_create" => true,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_accordion.png",
    "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Opened", "transport"),
            "param_name" => "opened",
            "value" =>array(__("No", "transport")=>'false', __("Yes", "transport")=>'true'),
            "description" => __("Opened Accordion/Toggle item.", "transport"),
            "save_always" => true,
            'admin_label' => true
        ),
      array(
            "type" => "dropdown",
            "heading" => __("Style", "transport"),
            "param_name" => "style",
            "value" =>array(__("Style 1", "transport")=>'', __("Style 2", "transport")=>'style-2'),
            "description" => __("Select style.", "transport"),
            "save_always" => true,
            'admin_label' => true
        )
    ),
    "js_view" => 'VcColumnView'
) );
/* END VC accordion */
/* VC accordion item (as child) */
vc_map( array(
    "name" => __("Accordion/Toggle item", "transport"),
    "base" => "accordion_item",
    "content_element" => true,
    "is_container" => true,
    "category" => "transport",
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_accordion.png",
    "as_child" => array('only' => 'accordion'),
    'js_view' => 'VcColumnView',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", "transport"),
            "param_name" => "title",
            "description" => __("Accordion item title.", "transport"),
            'admin_label' => true
        )
    )
) );
/* END VC accordion item */
/* VC Error 404 */
vc_map( array(
   "name" => __("Error 404", "transport"),
   "base" => "error_404",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_error404.png",
   "category" => "transport",
   "params" => array(
       array(
         "type" => "textfield",
         "heading" => __("Title", "transport"),
         "param_name" => "title",
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Subtitle", "transport"),
         "param_name" => "sub_title",
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Button text (go back)", "transport"),
         "param_name" => "content",
         'admin_label' => true
      )
    )
));
/* VC END Error 404 */
/* VC Tables */
vc_map( array(
   "name" => __("Table", "transport"),
   "base" => "table",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_table.png",
   "category" => "transport",
   "params" => array(
        array(
         "type" => "table",
         "heading" => __("Content", "transport"),
         "description" => "Table content",
         "param_name" => "content",
         'admin_label' => false
        ),
     )
));
/* END VC Tables */
/* VC Coming soon */
vc_map( array(
   "name" => __("Coming soon", "transport"),
   "base" => "coming_soon",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_commingsoon.png",
   "category" => "transport",
   "params" => array(
       array(
         "type" => "textfield",
         "heading" => __("Title", "transport"),
         "param_name" => "title",
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Subtitle", "transport"),
         "param_name" => "subtitle",
         'admin_label' => true
       ),
       array(
         "type" => "textfield",
         "heading" => __("Date", "transport"),
         "param_name" => "date",
         'admin_label' => true
      ),
      array(
        "type" => "attach_image",
        "heading" => __("Image", "transport"),
        "param_name" => "image_u",
        'admin_label' => false
      ),
      array(
        "type" => "textfield",
        "heading" => __("Image url", "transport"),
        "param_name" => "image",
        "description" => __("Enter image url.", "transport"),
        'admin_label' => false
        ),
      array(
        "type" => "textarea",
        "heading" => __("Newslleter shortcode", "transport"),
        "param_name" => "content",
        "description" => __("Enter newsletter shortcode [newsletter /].", "transport"),
        'admin_label' => false
        )
    )
));
/* VC END Coming soon */
/* Add parameter vc_row */
vc_add_param('vc_row', array("type" => "textfield", 'heading'=>__("Id", "transport"), 'param_name' =>'id'));
if(get_option("anps_vc_legacy", "0"=="on")) {
    vc_add_param('vc_row', array("type" => "dropdown", 'heading'=>__("Content wrapper", "transport"), 'param_name' =>'has_content', "value" =>array(__("On", "transport")=>'true', __("Off", "transport")=>'false', __("Inside content wrapper", "transport")=>'inside')));
    /* Add parameter vc_row_inner */
    vc_add_param('vc_row_inner', array("type" => "dropdown", 'heading'=>__("Content wrapper", "transport"), 'param_name' =>'has_content', "value" =>array(__("On", "transport")=>'true', __("Off", "transport")=>'false'), __("Inside content wrapper", "transport")=>'inside'));
}
/* Add parameter vc_tabs */
vc_add_param('vc_tta_tabs', array("type" => "dropdown", 'heading'=>__("Type", "transport"), 'param_name' =>'type', "value" =>array(__("Horizontal", "transport")=>'', __("Vertical", "transport")=>'vertical')));
vc_add_param('vc_tabs', array("type" => "dropdown", 'heading'=>__("Type", "transport"), 'param_name' =>'type', "value" =>array(__("Horizontal", "transport")=>'', __("Vertical", "transport")=>'vertical')));
/* Add anps style to backend vc_tta_tabs dropdown */
vc_add_param('vc_tta_tabs', array(
    "type" => "dropdown",
    "heading" => __( 'Style', 'transport' ),
    'param_name' =>'style',
    'value' => array(
                __( 'Anpsthemes', 'transport' ) => 'anps_tabs',
                __( 'Classic', 'transport' ) => 'classic',
                __( 'Modern', 'transport' ) => 'modern',
                __( 'Flat', 'transport' ) => 'flat',
                __( 'Outline', 'transport' ) => 'outline',
        ),
    'description' => __( 'Select tabs display style.', 'transport' )
    )
);
/* Add anps style to backend vc_tta_accordion dropdown */
vc_add_param('vc_tta_accordion', array(
    "type" => "dropdown",
    "heading" => __( 'Style', 'transport' ),
    'param_name' =>'style',
    'value' => array(
                __( 'Anpsthemes', 'transport' ) => 'anps_accordion',
                __( 'Classic', 'transport' ) => 'classic',
                __( 'Modern', 'transport' ) => 'modern',
                __( 'Flat', 'transport' ) => 'flat',
                __( 'Outline', 'transport' ) => 'outline',
        ),
    'description' => __( 'Select accordion display style.', 'transport' )
    )
);

/* Timeline */
if(!function_exists('anps_timeline_func')) {
    function anps_timeline_func($atts, $content) {
        extract( shortcode_atts( array(), $atts ) );

        return '<div class="timeline">' . do_shortcode($content) . '</div>';
    }
}
/* END Timeline */
add_shortcode('timeline', array('WPBakeryShortCode_timeline','anps_timeline_func'));
/* Timeline Item */
if(!function_exists('anps_timeline_item_func')) {
    function anps_timeline_item_func($atts, $content) {
        extract( shortcode_atts( array(
            'title' => '',
            'year'  => '2016'
        ), $atts ) );

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
add_shortcode('timeline_item', array('WPBakeryShortCode_timeline_item','anps_timeline_item_func'));
/* END Timeline Item */

/* Timeline */
class WPBakeryShortCode_timeline extends WPBakeryShortCodesContainer {
    static function anps_timeline_func($atts, $content) {
        return anps_timeline_func($atts, $content);
    }
}
/* END Timeline */
/* Timeline item */
class WPBakeryShortCode_timeline_item extends WPBakeryShortCode {
    static function anps_timeline_item_func($atts, $content) {
        return anps_timeline_item_func($atts, $content);
    }
}
/* VC Timeline (as parent) */
vc_map( array(
   "name" => esc_html__("Timeline", 'transport'),
   "base" => "timeline",
   "category" => 'transport',
   "content_element" => true,
   "is_container" => true,
   "show_settings_on_create" => false,
   "as_parent" => array('only' => 'timeline_item'),
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_timeline.png",
   "js_view" => 'VcColumnView',
   "params" => array(
     )
) );
/* END VC Timeline */
/* VC Timeline item (as child) */
vc_map( array(
    "name" => esc_html__("Timeline item", 'transport'),
    "base" => "timeline_item",
    "content_element" => true,
    "category" => 'transport',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_timeline.png",
    "as_child" => array('only' => 'timeline'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Year", 'transport'),
            "param_name" => "year",
            "value" => "2016",
            "description" => esc_html__("Enter year number.", 'transport'),
            'admin_label' => true
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title", 'transport'),
            "param_name" => "title",
            "description" => esc_html__("Enter title.", 'transport'),
            'admin_label' => true
        ),
        array(
            "type" => "textarea",
            "heading" => esc_html__("Content", 'transport'),
            "param_name" => "content",
            "description" => esc_html__("Enter content.", 'transport'),
            'admin_label' => true
        )
    )
) );
/* END VC Timeline item */

/* Add height to backend vc_round_chart dropdown */
vc_add_param('vc_round_chart', array(
    "name" => esc_html__("Height", 'transport'),
    "type" => "textfield",
    "heading" => esc_html__( 'Height', 'transport' ),
    'param_name' =>'anps_height',
    'description' => __( 'Set the graph height in px.', 'transport' )
    )
);

/* Add height to backend vc_line_chart dropdown */
vc_add_param('vc_line_chart', array(
    "name" => esc_html__("Height", 'transport'),
    "type" => "textfield",
    "heading" => esc_html__( 'Height', 'transport' ),
    'param_name' =>'anps_height',
    'description' => __( 'Set the graph height in px.', 'transport' )
    )
);

/* VC featured */
vc_map( array(
   "name" => esc_html__("Featured content", 'transport'),
   "base" => "anps_featured",
   "category" => 'transport',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_statement.png",
   "params" => array(
       array(
         "type" => "textfield",
         "heading" => esc_html__("Title", 'transport'),
         "param_name" => "title",
         "admin_label" => true
       ),
       array(
         "type" => "attach_image",
         "heading" => esc_html__("Image", 'transport'),
         "param_name" => "image_u",
         "admin_label" => false
       ),
       array(
         "type" => "textfield",
         "heading" => esc_html__("Video", 'transport'),
         "description" => esc_html__("Enter youtube or vimeo video url. Example: https://vimeo.com/146064760", 'transport'),
         "param_name" => "video",
         "admin_label" => false
       ),
       array(
         "type" => "textarea_html",
         "heading" => esc_html__("Content", 'transport'),
         "param_name" => "content",
         "description" => esc_html__("Enter content of shortcode.", 'transport'),
         "admin_label" => true
      ),
      array(
          "type" => "textfield",
          "heading" => esc_html__("Link", 'transport'),
          "param_name" => "link",
          "admin_label" => false
       ),
       array(
         'type' => 'iconpicker',
         'heading' => esc_html__( 'Icon', 'transport' ),
         'param_name' => 'icon',
         'value' => '',
         'settings' => array(
            'emptyIcon' => true,
            'iconsPerPage' => 4000,
         ),
         'description' => esc_html__( 'Select icon from library.', 'transport' ),
         "admin_label" => false
       ),
       array(
         "type" => "textfield",
         "heading" => esc_html__("Button text", 'transport'),
         "param_name" => "button_text",
         "admin_label" => false
       ),
      array(
         "type" => "checkbox",
         "heading" => esc_html__("position image above? (use below slider)", 'transport'),
         "param_name" => "absolute_img",
         "admin_label" => true
       ),
       array(
         "type" => "checkbox",
         "heading" => esc_html__("Exposed content", 'transport'),
         "param_name" => "exposed",
         "admin_label" => true
       ),
        array(
         "type" => "dropdown",
         "heading" => esc_html__("Style", 'transport'),
         "param_name" => "style",
         "value" => array(esc_html__("default", 'transport')=>'', esc_html__("Simple", 'transport')=>'simple-style'),
         "save_always" => true,
         "admin_label" => false
       )
   )
) );
/* END VC featured */
