<?php
/* Get all widgets */
function get_all_widgets()
{
    $dir = WP_PLUGIN_DIR . '/anps_theme_plugin/widgets';
    if ($handle = opendir($dir)) {
        $arr = array();
        // Get all files and store it to array
        while (false !== ($entry = readdir($handle))) {
            $explode_entry = explode('.', $entry);
            if ($explode_entry[1] == 'php') {
                $arr[] = $entry;
            }
        }
        closedir($handle);

        /* Remove widgets, ., .. */
        unset($arr[remove_widget('widgets.php', $arr)]);
        return $arr;
    }
}
/* Remove widget function */
function remove_widget($name, $arr)
{
    return array_search($name, $arr);
}
/* Include all widgets */
foreach (get_all_widgets() as $item) {
    $item_file = WP_PLUGIN_DIR . '/anps_theme_plugin/widgets/' . $item;
    if (file_exists($item_file)) {
        include_once $item_file;
    }
}
