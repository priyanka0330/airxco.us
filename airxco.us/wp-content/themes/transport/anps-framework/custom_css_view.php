<?php 
wp_enqueue_script('ace-editor');

if (isset($_GET['save_css'])) {
    update_option("anps_custom_css", stripcslashes($_POST['anps_custom_css']));
    delete_transient('anps_theme_options_styles_css');
    header("Location: themes.php?page=theme_options&sub_page=theme_style_custom_css");
}
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_custom_css&save_css" method="post">
    <div class="content-inner">
        <h3><?php esc_html_e("Custom css", "transport"); ?></h3>    
        <div class="input fullwidth hidden" id="anps_custom_css_wrapper">
            <label for="anps_custom_css"><?php esc_html_e("Custom css", "transport"); ?></label>
            <textarea name="anps_custom_css" id="anps_custom_css" class="fullwidth"><?php echo get_option('anps_custom_css', ''); ?></textarea>    
        </div>

        <!-- Editor -->
        <div class="input fullwidth">
            <div class="anps-editor-wrapper">
                <div class="anps-editor" id="editor"><?php echo get_option('anps_custom_css', ''); ?></div>
            </div>
        </div>
    </div>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">        
        <input type="submit" value="<?php _e("Save all changes", "transport"); ?>">        
        <div class="clear"></div>    
    </div>
    <div class="submit-right">
        <button type="submit" class="fixsave fixed fontawesome"><i class="fa fa-floppy-o"></i></button>
    <div class="clear"></div>    
</form>