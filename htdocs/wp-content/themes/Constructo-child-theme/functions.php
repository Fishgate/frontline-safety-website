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
function ff_shortcode_empty_paragraph_fix( $content ) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr( $content, $array );
    
    return $content;
}
add_filter( 'the_content', 'ff_shortcode_empty_paragraph_fix' );