<?php
/*
 * enqueue scripts and styles for the frontend
 */
function fishgato_enqueue(){
    // register font awesome css (http://fortawesome.github.io/Font-Awesome/)
    wp_register_style( 'font-awesome-styles', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '', 'all' );
    wp_enqueue_style( 'font-awesome-styles' );

    // register fishgato css
    wp_register_style('fishgato-styles', get_stylesheet_directory_uri() . '/css/main.css', array('font-awesome-styles'), '1.0', 'all');
    wp_enqueue_style('fishgato-styles');
    
    // register fishgato js
    wp_register_script('fishgato-js', get_stylesheet_directory_uri() . '/js/scripts.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('fishgato-js');    
}
add_action('wp_print_styles', 'fishgato_enqueue');

/*
 * Shortcode Empty Paragraph Fix
 * http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
 * 
 */
function fishgato_shortcode_empty_paragraph_fix( $content ) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr( $content, $array );
    
    return $content;
}
add_filter( 'the_content', 'fishgato_shortcode_empty_paragraph_fix' );

/*
 * Register footer navigation
 */
function fishgato_register_footer_nav(){
    register_nav_menu('footer_nav', __('Footer Navigation'));
}
add_action('after_setup_theme', 'fishgato_register_footer_nav');

/*
 * Embed footer navigation shortcode
 */
function fishgato_embed_footer_nav(){
    $menu_slug = 'footer_nav';

    if ( ($locations = get_nav_menu_locations()) && isset($locations[$menu_slug]) ) {
        $menu_id = wp_get_nav_menu_object($locations[$menu_slug])->term_id;
        $menu_items = wp_get_nav_menu_items($menu_id);

        $footer_nav = '<nav class="menu-'.$menu_slug.'"><ul>';

        foreach ($menu_items as $key => $menu_item) {
            $footer_nav .= '<li><a href="'.$menu_item->url.'">'.$menu_item->title.'</a></li>';

            if( end(array_keys($menu_items)) != $key ) {
                $footer_nav .= '<li>&nbsp;|&nbsp;</li>';
            }
        }

        $footer_nav .= '</ul></nav>';

        return $footer_nav;
    } else {

    }
}
add_shortcode('footernav', 'fishgato_embed_footer_nav');