<?php
/* Get all widgets */
function get_all_widgets() {
    $dir = get_template_directory() . '/anps-framework/widgets';
    if ($handle = opendir($dir)) {
        $arr = array();
        // Get all files and store it to array
        while (false !== ($entry = readdir($handle))) {
            $arr[] = $entry;
        }
        closedir($handle); 
      
        /* Remove widgets, ., .. */
        unset($arr[remove_widget('widgets.php', $arr)], $arr[remove_widget('.', $arr)], $arr[remove_widget('..', $arr)]);
        return $arr;
    }
}
/* Remove widget function */
function remove_widget($name, $arr) {
    return array_search($name, $arr);
}
/* Include all widgets */ 
foreach(get_all_widgets() as $item) {
    $item_file = get_template_directory() . '/anps-framework/widgets/'.$item;
    if( file_exists( $item_file ) ) {
        include_once $item_file;
    }
} 
/** Register sidebars by running widebox_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'anps_widgets_init');
function anps_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => __('Sidebar', ANPS_TEMPLATE_LANG),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Secondary Sidebar', ANPS_TEMPLATE_LANG),
        'id' => 'secondary-widget-area',
        'description' => __('Secondary widget area', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Top bar left', ANPS_TEMPLATE_LANG),
        'id' => 'top-bar-left',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Top bar right', ANPS_TEMPLATE_LANG),
        'id' => 'top-bar-right',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', ANPS_TEMPLATE_LANG),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    $prefooter = get_option('prefooter');
    if($prefooter=="on") {
        $prefooter_columns = get_option('prefooter_style', '4');
        if($prefooter_columns=='2' || $prefooter_columns=='5' || $prefooter_columns=='6') {
            register_sidebar(array(
                'name' => __('Prefooter 1', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
        } elseif($prefooter_columns=='3') {
            register_sidebar(array(
                'name' => __('Prefooter 1', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
            register_sidebar(array(
                'name' => __('Prefooter 3', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-3',
                'description' => __('Prefooter 3', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif($prefooter_columns=='4' || $prefooter_columns=='0') {
            register_sidebar(array(
                'name' => __('Prefooter 1', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
            register_sidebar(array(
                'name' => __('Prefooter 3', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-3',
                'description' => __('Prefooter 3', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 4', ANPS_TEMPLATE_LANG),
                'id' => 'prefooter-4',
                'description' => __('Prefooter 4', ANPS_TEMPLATE_LANG),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
        }
    }
    $footer_columns = get_option('footer_style', '4');
    if($footer_columns=='2') {
        register_sidebar(array(
            'name' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'footer-1',
            'description' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'id' => 'footer-2',
            'description' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
    } elseif($footer_columns=='3') {
        register_sidebar(array(
            'name' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'footer-1',
            'description' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'id' => 'footer-2',
            'description' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'id' => 'footer-3',
            'description' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($footer_columns=='4' || $footer_columns=='0') {
        register_sidebar(array(
            'name' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'footer-1',
            'description' => __('Footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'id' => 'footer-2',
            'description' => __('Footer 2', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'id' => 'footer-3',
            'description' => __('Footer 3', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 4', ANPS_TEMPLATE_LANG),
            'id' => 'footer-4',
            'description' => __('Footer 4', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    $copyright_footer = get_option('copyright_footer', '1');
    if($copyright_footer=="1" || $copyright_footer=="0") {
        register_sidebar(array(
            'name' => __('Copyright footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'copyright-1',
            'description' => __('Copyright footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($copyright_footer=="2") {
        register_sidebar(array(
            'name' => __('Copyright footer 1', ANPS_TEMPLATE_LANG),
            'id' => 'copyright-1',
            'description' => __('Copyright footer 1', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Copyright footer 2', ANPS_TEMPLATE_LANG),
            'id' => 'copyright-2',
            'description' => __('Copyright footer 2', ANPS_TEMPLATE_LANG),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
}