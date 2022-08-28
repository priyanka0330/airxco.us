<?php
include_once 'classes/Dummy.php';

if (isset($_GET['save_dummy'])) {
        $dummy->save();
}
?>
<script type="text/javascript">
    function dummy () {
        var reply = confirm("WARNING: You have already insert dummy content and by inserting it again, you will have duplicate content.\r\n\We recommend doing this ONLY if something went wrong the first time and you have already cleared the content.");
        return reply;
    }
</script>
<form action="themes.php?page=theme_options&sub_page=dummy_content&save_dummy" method="post">
    <div class="content-inner envoo-dummy">
        <h3><?php esc_html_e("Insert dummy content: posts, pages, categories", "transport"); ?></h3>
        <p><?php esc_html_e("Importing demo content is the fastest way to get you started. Please install all plugins required by the theme before importing content. If you already have some content on your site, make a backup just in case.", "transport"); ?></p>
        <?php if (!function_exists('anps_portfolio')) : ?>
            <h2><?php esc_html_e('Please enable the Anps Theme Plugin to be able to import dummy content.', 'transport'); ?></h2>
        <?php else : ?>
        <div class="clear"></div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-1.jpg" />
                <div class="demotitle"><h4>Classic demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy1" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/1/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-2.jpg" />
                <div class="demotitle"><h4>Dummy2</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy2" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/2/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-3.jpg" />
                <div class="demotitle"><h4>Dummy3</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy3" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/3/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-4.jpg" />
                <div class="demotitle"><h4>Dummy4</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy4" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/4/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-5.jpg" />
                <div class="demotitle"><h4>Dummy5</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy5" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/5/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-6.jpg" />
                <div class="demotitle"><h4>Dummy6</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy6" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/6/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-7.jpg" />
                <div class="demotitle"><h4>Dummy7</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy7" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/7/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-8.jpg" />
                <div class="demotitle"><h4>Dummy8</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy8" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php esc_html_e("Insert dummy content", "transport"); ?>" />
                    <a class="launch" href="https://anpsthemes.com/transport-new-demos/8/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="clear"></div>
        <div class="absolute fullscreen importspin">
            <div class="table">
                <div class="table-cell center">
                    <div class="messagebox">
                    <i class="fa fa-cog fa-spin" style="font-size:30px;"></i>
                        <h2><strong>Import might take some time, please be patient</strong></h2>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</form>
