<?php
/* Header image, video, gallery (blog, portfolio) */
function anps_header_media($id, $image_class="") { 
    if(has_post_thumbnail($id)) { 
        $header_media = get_the_post_thumbnail($id, $image_class);
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) { 
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    else { 
        $header_media = "";
    }
    return $header_media;
}
/* Header image, video, gallery (single blog/portfolio) */
function anps_header_media_single($id, $image_class="") {
    if(has_post_thumbnail($id) && !get_post_meta($id, $key ='gallery_images', $single = true )) { 
        $header_media = get_the_post_thumbnail($id, $image_class);
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) { 
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    elseif(get_post_meta($id, $key ='gallery_images', $single = true )) { 
        $gallery_images = explode(",",get_post_meta($id, $key ='gallery_images', $single = true )); 
        
        foreach($gallery_images as $key=>$item) {
            if($item == '') {
                unset($gallery_images[$key]);
            }
        }
        $number_images = count($gallery_images);
        $header_media = "";
        $header_media .= "<div id='carousel' class='carousel slide'>";
        if($number_images>"1") {
            $header_media .= "<ol class='carousel-indicators'>";
            for($i=0;$i<count($gallery_images);$i++) {
                if($i==0) {
                    $active_class = "active";
                } else {
                    $active_class = "";
                }
                $header_media .= "<li data-target='#carousel' data-slide-to='".$i."' class='".$active_class."'></li>";
            }
            $header_media .= "</ol>";
        }
        $header_media .= "<div class='carousel-inner'>";
        $j=0;
        foreach($gallery_images as $item) {
            $image_src = wp_get_attachment_image_src($item, $image_class); 
            $image_title = get_the_title($item); 
            if($j==0) {
                $active_class = " active";
            } else {
                $active_class = "";
            }
            $header_media .= "<div class='item$active_class'>";
            $header_media .= "<img alt='".$image_title."'  src='".$image_src[0]."'>";
            $header_media .= "</div>";
            $j++;
        }
        $header_media .= "</div>";
        if($number_images>"1") {
            $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'>
                                <span class='fa fa-chevron-left'></span>
                              </a>
                              <a class='right carousel-control' href='#carousel' data-slide='next'>
                                <span class='fa fa-chevron-right'></span>
                              </a>";
                      
        }
        $header_media .= "</div>";
    }
    else { 
        $header_media = "";
    }
    return $header_media;
}
function anps_get_header() {
    
    //Let's get menu type   
    if (is_front_page() == "true") {
        $anps_menu_type = get_option('anps_menu_type', '2');
    } else {
        $anps_menu_type = "2";
    }

    $anps_full_screen = get_option('anps_full_screen', "");
 
    $menu_type_class = " style-2";
    $header_position_class = " relative";
    $header_bg_style_class = " bg-normal";
    $absoluteheader = "false";

    
    //Header classes and variables 
    if($anps_menu_type == "1") {
        $menu_type_class = " style-1";
        $header_position_class = " absolute";
        $header_bg_style_class = " bg-transparent";
        $absoluteheader = "true";
    } elseif($anps_menu_type == "3") {
        $menu_type_class = " style-3";
        $header_position_class = " absolute moveup";
        $header_bg_style_class = " bg-transparent";
        $absoluteheader = "true";
    } elseif($anps_menu_type == "4") {
        $menu_type_class = " style-4";
        $header_position_class = " relative";
        $header_bg_style_class = " bg-normal";
        $absoluteheader = "false";
    } 

    //Top menu style 
    $topmenu_style = get_option('topmenu_style', '1');
   
    //left, right and center menu styles: 
    $menu_left_center_right_class = "";
    $menu_center = get_option('menu_center', "");
    if ($menu_center =="on" && ($anps_menu_type =="2"||$anps_menu_type =="4")) {
        $menu_left_center_right_class=" style-3";
    } 

    //sticky menu
    $sticky_menu = get_option('sticky_menu', "");
    $sticky_menu_class = "";
    if ($sticky_menu=="on") {
        $sticky_menu_class = "sticky";    
    }
    //if coming soon page is enabled
    $coming_soon = get_option('coming_soon', '0');
    if($coming_soon=="0"||is_super_admin()) : 
    ?>


    <?php //search ?>
    <?php if ($anps_menu_type == "1" || $anps_menu_type == "2") : ?>
    <div class="site-search">
            <?php anps_get_search(); ?>
    </div>
    <?php endif; ?>

    <?php //added option for transparent top bar menu type 1 (24.2.2015)
    if($anps_menu_type == "1" and (get_option('topmenu_style') == '1')) : ?>
    <div class="transparent top-bar<?php if($topmenu_style=="2") {echo " style-2";} ?>">
        <?php anps_get_top_bar(); ?>
    </div>
    <?php endif; ?>


    <?php //topmenu
    if($anps_menu_type == "2" and (get_option('topmenu_style') == '1')) : ?>
    <div class="top-bar<?php if($topmenu_style=="2") {echo " style-2";} ?>">
        <?php anps_get_top_bar(); ?>
    </div>
    <?php endif; ?>

    <?php // load shortcode from theme options textarea if needed 
    if ($anps_menu_type=="3" || $anps_menu_type=="4") {
        echo do_shortcode($anps_full_screen);
    }
    ?>


    <?php     
    global $anps_media_data;
    $has_sticky_class= "";

    if (isset($anps_media_data['sticky_logo']) && $anps_media_data['sticky_logo'] != "")  {
        $has_sticky_class = " has_sticky";
    } ?>

    <?php  //pushdown class adjusts header to be 60px from the top, so there is a place for an absolute positioned top-bar
    $pushdown = "";
    if($anps_menu_type == "1" and (get_option('topmenu_style') == '1')) {
        $pushdown = " push-down";
    }; ?>

    <?php $anps_header_styles = $sticky_menu_class . $menu_type_class . $header_position_class . $header_bg_style_class . $has_sticky_class . $pushdown;?>


    <?php //search ?>
    <?php if ($anps_menu_type == "4") : ?>
    <div class="site-search">
            <?php anps_get_search(); ?>
    </div>
    <?php endif; ?>

    <header class="site-header <?php echo $anps_header_styles ?>">
        <div class="nav-wrap<?php echo $menu_left_center_right_class; ?>">
            <div class="container"><?php anps_get_sticky_logo() . anps_get_site_header();?></div>
        </div>  
        <div class="sticky-holder"></div>   
    </header>
    <?php if ($anps_menu_type == "3") : ?>
    <div class="site-search">
            <?php anps_get_search(); ?>
    </div>
    <?php endif; ?>


    <?php global $anps_options_data, $anps_page_data;
        $disable_single_page = "";
        if(function_exists( 'is_woocommerce' ) && is_woocommerce()) {
            if(is_shop()) {
                $disable_single_page = get_post_meta(get_option( 'woocommerce_shop_page_id' ), $key ='anps_disable_heading', $single = true );
            } elseif(is_product()) {
                $disable_single_page = get_post_meta(get_queried_object_id(), $key ='anps_disable_heading', $single = true );
            }
        } else {
            $disable_single_page = get_post_meta(get_queried_object_id(), $key ='anps_disable_heading', $single = true );
        }
        if(!$disable_single_page=="1") : 
            if(is_front_page()==false && !isset($anps_options_data['disable_heading'])) : 
                global $anps_media_data;
                $style = "";
                $class = "";
                $single_page_bg = get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true );
                if(is_search()) {
                    if($anps_media_data['search_heading_bg']) {
                        $style = ' style="background-image: url('.esc_url($anps_media_data['search_heading_bg']).');"';
                    } else {
                        $class = "style-2";
                    }
                } elseif(function_exists( 'is_woocommerce' ) && is_woocommerce()) {
                    if(is_product()) { 
                        if(!get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true )) {
                            $shop_page_bg = get_post_meta(get_option( 'woocommerce_shop_page_id' ), $key ='heading_bg', $single = true );
                        } else {
                            $shop_page_bg = get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true );
                        }
                    } elseif(is_shop()) {
                        $shop_page_bg = get_post_meta(get_option( 'woocommerce_shop_page_id' ), $key ='heading_bg', $single = true );
                    }
                    if(isset($shop_page_bg)) {
                        $style = ' style="background-image: url('.$shop_page_bg.');"'; 
                    }
                    elseif($anps_media_data['heading_bg']) {
                        $style = ' style="background-image: url('.$anps_media_data['heading_bg'].');"';
                    } else {
                        $class = "style-2";
                    }
                } else {
                    if($single_page_bg) {
                        $style = ' style="background-image: url('.esc_url($single_page_bg).');"'; 
                    }
                    elseif($anps_media_data['heading_bg']) {
                        $style = ' style="background-image: url('.esc_url($anps_media_data['heading_bg']).');"';
                    } else {
                        $class = "style-2";
                    }
                } 
                ?>
                <div class='page-heading <?php echo esc_attr($class); ?>'<?php echo $style; ?>>
                    <div class='container'>
                        <?php if (is_home() && !is_front_page()) { 
                            echo "<h1>".get_the_title(get_option('page_for_posts'))."</h1>";                       
                        } else if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_shop() ) {
                            echo "<h1>".get_the_title(get_option('woocommerce_shop_page_id'))."</h1>";
                        } else if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product_category() ) {
                            echo "<h1>".single_cat_title("", false)."</h1>";
                        } else if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product_tag() ) {
                            echo "<h1>".single_cat_title("", false)."</h1>";
                        } else if( is_archive() ) {
                            if( is_category() ) {
                                $cat = get_category(get_queried_object_id());
                                echo "<h1>".__("Archives for", ANPS_TEMPLATE_LANG) . ' ' . $cat->name . " </h1>";
                            }
                            else if(is_author()) {
                                $author = get_the_author_meta('display_name', get_query_var("author"));
                                echo "<h1>".__("Posts by", ANPS_TEMPLATE_LANG) . ' ' . $author .  " </h1>";
                            } elseif(is_tag()) {
                                $cat = get_tag(get_queried_object_id());
                                echo "<h1>".$cat->name . "</h1>";
                            } 
                            else {
                                echo "<h1>".__("Archives for", ANPS_TEMPLATE_LANG) . " " . get_the_date('F') . ' ' . get_the_date('Y')."</h1>";
                            }
                        } elseif(is_search()) {
                            echo "<h1>".__("Search results", ANPS_TEMPLATE_LANG)."</h1>";
                        }
                        else { ?>
                        <h1><?php if(get_the_title()) { echo get_the_title(); } else { echo get_the_title($anps_page_data['error_page']); } ?></h1>
                        <?php } ?>
                        <?php if(!isset($anps_options_data['breadcrumbs'])) { echo anps_the_breadcrumb(); } ?>
                    </div>
                </div>
        <?php endif; ?>
    <?php endif; ?>
<?php 
endif;
}

function anps_get_sticky_logo() { 
    global $anps_media_data;
    if (isset($anps_media_data['sticky_logo']) && $anps_media_data['sticky_logo'] != "") : ?>
        <div class="logo-wrap table absolute"><a id="sticky-logo" href="<?php echo esc_url(home_url("/")); ?>"><img alt="Site logo" src="<?php echo esc_url($anps_media_data['sticky_logo']); ?>"></a></div>
    <?php endif;
}

/* Breadcrumbs */ 
function anps_the_breadcrumb() {
    global $anps_page_data, $post;
    $return_val = "<ul class='breadcrumbs'>";
    
    $return_val .= '<li><a href="' . home_url() .'">' . __("Home", ANPS_TEMPLATE_LANG) . '</a></li>';
    if (is_home() && !is_front_page()) { 
        $return_val .= "<li>".get_the_title(get_option('page_for_posts'))."</li>";
    } else {
        if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ) {
            $return_val = "<ul class='breadcrumbs'>";
            ob_start();
            woocommerce_breadcrumb();
            $return_val .= ob_get_clean();
        } elseif (is_category() || is_single()) { 
            if (is_single()) { 
                if (get_post_type() != "portfolio" && get_post_type() != "post") { 
                    $return_val .= '<li>' . get_the_title(get_option('page_for_posts')) . '</li>';
                } else {
                    $custom_breadcrumbs = get_post_meta( get_the_ID(), $key = 'custom_breadcrumbs', $single = true );
                    if($custom_breadcrumbs!="" && $custom_breadcrumbs!="0") { 
                        $return_val .= "<li><a href='".get_permalink($custom_breadcrumbs)."'>".get_the_title($custom_breadcrumbs)."</a></li>";
                    }
                    $return_val .= "<li>".get_the_title()."</li>";
                }
            }
        }
        elseif (is_page()) { 
            if(isset($post->post_parent)) { 
                $parent_id  = $post->post_parent;
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                }
                for($i=count($breadcrumbs);$i>=0;$i--) {
                    $return_val .= $breadcrumbs[$i];
                }
                $return_val .= "<li>".get_the_title()."</li>";
            } else {
                $return_val .= "<li>".get_the_title()."</li>";
            }
        } elseif (is_archive()) {
            if (is_author()) {
                $author = get_the_author_meta('display_name', get_query_var("author"));
                $return_val .= "<li>" . $author ."</li>";
            } elseif(is_tag()) {
                $cat = get_tag(get_queried_object_id());
                $return_val .= "<li>".$cat->name . "</li>";
            } else {
                $return_val .= "<li>" . __("Archives for", ANPS_TEMPLATE_LANG) . " " . get_the_date('F') . ' ' . get_the_date('Y')."</li>";
            }
        } else {
            if (get_search_query() != "") {
            } else {
                if( isset($anps_page_data['error_page']) && $anps_page_data['error_page'] != '' ) {
                    $page = get_page($anps_page_data['error_page']); 
                    $return_val .= "<li>".$page->post_title."</li>";
                }
            }
        }
    }
    if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ) {
    } elseif (single_cat_title("", false) != "" && !is_tag()) {
        $return_val .= "<li>" . single_cat_title("", false)."</li>";
    }
    $return_val .= "</ul>"; 
    return $return_val;
}
/* search container */
function anps_get_search() {
    ?>
    <div class="container">
        <form role="search" method="get" id="searchform-header" class="searchform-header" action="<?php echo home_url(); ?>">
            <input name="s" type="text" placeholder="<?php _e("type and press &#8216;enter&#8217;", ANPS_TEMPLATE_LANG); ?>">
        </form>
	<span class="close">&times;</span>
    </div>
<?php
}
/* top bar menu */
function anps_get_top_bar() { 
    if (is_active_sidebar( 'top-bar-left') || is_active_sidebar( 'top-bar-right') ) {
        echo '<div class="container">';
            echo '<ul class="left">';
                    do_shortcode(dynamic_sidebar( 'top-bar-left' ));
            echo '</ul>';
            echo '<ul class="right">';
                    do_shortcode(dynamic_sidebar( 'top-bar-right' ));
            echo '</ul>';
	echo '</div>';
		}
    ?>
    <span class="close fa fa-chevron-down"></span>
    <?php
}
/*function anps_blog_image_size($id) {
    $left_sidebar = get_post_meta($id, 'sbg_selected_sidebar', true);
    $right_sidebar = get_post_meta($id, 'sbg_selected_sidebar_replacement', true);
    if((isset($left_sidebar) && $left_sidebar!="0") && (isset($right_sidebar) && $right_sidebar!="0")) { 
        $blog_image = 'blog-two-sidebar';
    } elseif((isset($left_sidebar) && $left_sidebar!="0") || (isset($right_sidebar) && $right_sidebar!="0")) { 
        $blog_image = 'large';
    } else { 
        $blog_image = 'blog-no-sidebar';
    }
    return $blog_image;
}
add_action('init', 'anps_blog_image_size');*/

function anps_is_responsive($rtn)  {
    global $anps_options_data;   
    $responsive = "";
    $boxed_backgorund = '';
    $hide_body_class = '';
    if(isset($anps_options_data['preloader']) && $anps_options_data['preloader']=="on") {
        $hide_body_class = ' hide-body';
    }    
    if ( isset($anps_options_data['pattern']) && $anps_options_data['pattern'] && isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == 'on') {
        $boxed_backgorund .= ' pattern-' . $anps_options_data['pattern'];
    }
    if (isset($anps_options_data['responsive'])) $responsive = $anps_options_data['responsive'];
    if ( $responsive != "on" ) {
        if ( $rtn == true ) {
            return " responsive" . $hide_body_class . $boxed_backgorund;
        } else {?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php }
    } else {
        return " responsive-off" . $hide_body_class . $boxed_backgorund;
    }
    
}
function anps_body_style() {
    global $anps_options_data;   
    
    if ( $anps_options_data['pattern'] == '0' ) {
        if(isset($anps_options_data['type']) && $anps_options_data['type'] == "custom color") {
            echo ' style="background-color: ' . $anps_options_data['bg_color'] . ';"';
        }else if (isset($anps_options_data['type']) && $anps_options_data['type'] == "stretched") {
            echo ' style="background: url(' . $anps_options_data['custom_pattern'] . ') center center fixed;background-size: cover;     -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;"';
        } else {
            echo ' style="background: url(' . $anps_options_data['custom_pattern'] . ')"';
        }
    } 
}
function anps_theme_after_styles() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
    
    get_template_part("includes/google_analytics");
    get_template_part("includes/shortcut_icon");
}
/* Return site logo */
function anps_get_logo() { 
    global $anps_media_data;
    $first_page_logo = get_option('anps_front_logo', '');
    $menu_type = get_option('anps_menu_type');
    //$size_sticky = getimagesize($anps_media_data['sticky-logo']);
    $size_sticky = array(120, 120);
    if( ! $size_sticky ) {
        $size_sticky = array(120, 120);
    }
    $logo_width = 158;
    $logo_height = 33;
    if( $anps_media_data['logo-width'] ) {
        $logo_width = $anps_media_data['logo-width'];
    }
    
    if( $anps_media_data['logo-height'] ) {
        $logo_height = $anps_media_data['logo-height'];
    } 
    if(isset($anps_media_data['auto_adjust_logo']) && $anps_media_data['auto_adjust_logo'] =='on' ) {
        $logo_height = 60;
        $logo_width = "auto";
    } 
    else { $logo_width .='px';
    }
    if(($menu_type==1 || $menu_type==3) && $first_page_logo && (is_front_page())) : ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($first_page_logo); ?>"></a>
    <?php
    elseif (isset($anps_media_data['logo']) && $anps_media_data['logo'] != "") : ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($anps_media_data['logo']); ?>"></a>
    <?php else: ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="http://anpsthemes.com/constructo/wp-content/uploads/2014/12/constructo-logoV4.png"></a>        
    <?php endif;
}
/* Tags and author */
function anps_tagsAndAuthor() {
    ?>
        <div class="tags-author">
    <?php echo __('posted by', ANPS_TEMPLATE_LANG); ?> <?php echo get_the_author(); ?>
    <?php
    $posttags = get_the_tags();
    if ($posttags) {
        echo " &nbsp;|&nbsp; ";
        echo __('Taged as', ANPS_TEMPLATE_LANG) . " - ";
        $first_tag = true;
        foreach ($posttags as $tag) {
            if ( ! $first_tag) {
                echo ', ';
            }
            echo '<a href="' . esc_url(home_url('/')) . 'tag/' . esc_html($tag->slug) . '/">';
            echo esc_html($tag->name);
            echo '</a>';
            $first_tag = false;
        }
    }
    ?>
        </div>
    <?php
}
/* Current page url */
function anps_curPageURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"])) $pageURL .= "s";
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") 
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    else 
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    
    return $pageURL;
}
/* Gravatar */
add_filter('avatar_defaults', 'anps_newgravatar');
function anps_newgravatar($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/images/move_default_avatar.jpg';
    $avatar_defaults[$myavatar] = "Anps default avatar";
    return $avatar_defaults;
}
/* Get post thumbnail src */
function anps_get_the_post_thumbnail_src($img) {
    return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}   
function anps_get_menu() {
    $menu_center = get_option('menu_center', '');
    if( isset($_GET['header']) && $_GET['header'] == 'type-3' ) {
        $menu_center = 'on';
    }

    $menu_description = '';
    $menu_style = get_option('menu_style', '1');
    if( isset($_GET['header']) && $_GET['header'] == 'type-2' ) {
        $menu_style = '2';
    }

    if( $menu_style == '2' ) {
        $menu_description = ' description';
    }
?>
    <nav class="site-navigation<?php echo esc_attr($menu_description); ?>">
        <?php
            $locations = get_theme_mod('nav_menu_locations');

            /* Check if menu is selected */

            $walker = '';
            $menu = '';
            $locations = get_theme_mod('nav_menu_locations');

            if($locations && $locations['primary']) {
                $menu = $locations['primary'];
                if( (isset($_GET['page']) && $_GET['page'] == 'one-page') ) {
                    $menu = 21;
                }
                $walker = new description_walker();
            }

            wp_nav_menu( array(
                'container' => false,
                'menu_class' => '',
                'echo' => true,
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'depth' => 0,
                'walker' => $walker,
                'menu'=>$menu
            ));
        ?>
        <button class="fa fa-search desktop"></button>
    </nav>
    <?php
}
function anps_get_site_header() { 
    $menu_center = get_option('menu_center', '');
    if( isset($_GET['header']) && $_GET['header'] == 'type-3' ) {
        $menu_center = 'on';
    }
    ?>
     <?php
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            
            $shopping_cart_header = get_option('shopping_cart_header','shop_only');
            if (($shopping_cart_header == 'shop_only' &&  is_woocommerce() ) || $shopping_cart_header == 'always' ) {
                anps_woocommerce_header();
            }
        }
    ?>  

    <div class="site-logo retina"><?php anps_get_logo(); ?></div>
    <!-- Search icon next to menu -->
    <button class="fa fa-search mobile"></button>
    <!-- Used for mobile menu -->
    <button class="navbar-toggle" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?php anps_get_menu(); ?>
<?php }
add_filter("the_content", "anps_the_content_filter");
function anps_the_content_filter($content) {
    // array of custom shortcodes requiring the fix 
    $block = join("|",array("recent_blog","section","contact", "form_item", "services", "service", "tabs", "tab", "accordion", "accordion_item", "progress", "quote", "statement", "color", "google_maps", "vimeo", "youtube", "contact_info", "contact_info_item","logos", "logo", "button", "error_404", "icon", "icon_group", "content_half", "content_third", "content_two_third", "content_quarter", "content_two_quarter", "content_three_quarter", "twitter", "social_icons", "social_icon", "data_tables", "data_thead", "data_tbody", "data_tfoot", "data_row", "data_th", "data_td", "testimonials", "testimonial"));
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
    return $rep;
 
}
/* Post gallery */
add_filter( 'post_gallery', 'anps_my_post_gallery', 10, 2 );
function anps_my_post_gallery( $output, $attr) {
    global $post, $wp_locale;
    static $instance = 0;
    $instance++;
    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }
    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));
    
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';
    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }
    if ( empty($attachments) )
        return '';
    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $size = 100/$columns;

    $output = '<div class="gallery recent-posts clearfix">'; 
    foreach ( $attachments as $id => $attachment ) {
        $image_full = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image_src($id, 'full', false) : wp_get_attachment_image_src($id, 'full', false);
        $image_full = $image_full[0];

        $image_thumb = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image_src($id, 'post-thumb', false) : wp_get_attachment_image_src($id, 'post-thumb', false);
        $image_thumb = $image_thumb[0];

        $output .= '
            <article class="post col-md-3" style="width: ' . $size . '%;">
                <header>
                    <a rel="lightbox" class="post-hover" href="' . $image_full . '">
                        <img src="' . $image_thumb . '" alt="blog-8m">
                    </a>
                </header>
            </article>';
    }
    $output .= '</div>'; 
    return $output;
}
//get post_type    
function get_current_post_type() {
    if (is_admin()) {
        global $post, $typenow, $current_screen;
        //we have a post so we can just get the post type from that
        if ($post && $post->post_type)
            return $post->post_type;
        //check the global $typenow - set in admin.php
        elseif ($typenow)
            return $typenow;
        //check the global $current_screen object - set in sceen.php
        elseif ($current_screen && $current_screen->post_type)
            return $current_screen->post_type;
        //lastly check the post_type querystring
        elseif (isset($_REQUEST['post_type']))
            return sanitize_key($_REQUEST['post_type']);
        elseif (isset($_REQUEST['post']))
            return get_post_type($_REQUEST['post']);
        //we do not know the post type!
        return null;
    }
}
/* hide sidebar generator on testimonials and portfolio */
if (get_current_post_type() != 'testimonials' && get_current_post_type() != 'portfolio') {
    //add sidebar generator
    include_once 'sidebar_generator.php';
}
/* Admin/backend styles */
add_action('admin_head', 'backend_styles');
function backend_styles() {
    echo '<style type="text/css">
        .mceListBoxMenu {
            height: auto !important;
        }
        .wp_themeSkin .mceListBoxMenu {
            overflow: visible;
            overflow-x: visible;
        }
    </style>';
}
add_action('admin_head', 'show_hidden_customfields');
function show_hidden_customfields() {
    echo "<input type='hidden' value='" . get_template_directory_uri() . "' id='hidden_url'/>";
}
if (!function_exists('anps_admin_header_style')) :
    /*
     * Styles the header image displayed on the Appearance > Header admin panel.
     * Referenced via add_custom_image_header() in widebox_setup().
     */
    function anps_admin_header_style() {
        ?>
        <style type="text/css">
            /* Shows the same border as on front end */
            #headimg {
                border-bottom: 1px solid #000;
                border-top: 4px solid #000;
            }
        </style>
        <?php
    }
endif;
/* Filter wp title */
add_filter('wp_title', 'anps_filter_wp_title', 10, 2);
function anps_filter_wp_title($title, $separator) {
    // Don't affect wp_title() calls in feeds.
    if (is_feed())
        return $title;
    // The $paged global variable contains the page number of a listing of posts.
    // The $page global variable contains the page number of a single post that is paged.
    // We'll display whichever one applies, if we're not looking at the first page.
    global $paged, $page;
    if (is_search()) {
        // If we're a search, let's start over:
        $title = sprintf(__('Search results for %s', ANPS_TEMPLATE_LANG), '"' . get_search_query() . '"');
        // Add a page number if we're on page 2 or more:
        if ($paged >= 2)
            $title .= " $separator " . sprintf(__('Page %s', ANPS_TEMPLATE_LANG), $paged);
        // Add the site name to the end:
        $title .= " $separator " . get_bloginfo('name', 'display');
        // We're done. Let's send the new title back to wp_title():
        return $title;
    }
    // Otherwise, let's start by adding the site name to the end:
    $title .= get_bloginfo('name', 'display');
    // If we have a site description and we're on the home/front page, add the description:
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() ))
        $title .= " $separator " . $site_description;
    
    // Add a page number if necessary:
    if ($paged >= 2 || $page >= 2)
        $title .= " $separator " . sprintf(__('Page %s', ANPS_TEMPLATE_LANG), max($paged, $page));
    // Return the new title to wp_title():
    return $title;
}
/* Page menu show home */
add_filter('wp_page_menu_args', 'anps_page_menu_args');
function anps_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}
/* Sets the post excerpt length to 40 characters. */
add_filter('excerpt_length', 'anps_excerpt_length');
function anps_excerpt_length($length) {
    return 40;
}
/* Returns a "Continue Reading" link for excerpts */
function anps_continue_reading_link() {
    return ' <a href="' . get_permalink() . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', ANPS_TEMPLATE_LANG) . '</a>';
}
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and widebox_continue_reading_link(). */
add_filter('excerpt_more', 'anps_auto_excerpt_more');
function anps_auto_excerpt_more($more) {
    return ' &hellip;' . anps_continue_reading_link();
}
/* Adds a pretty "Continue Reading" link to custom post excerpts. */
add_filter('get_the_excerpt', 'anps_custom_excerpt_more');
function anps_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= anps_continue_reading_link();
    }
    return $output;
}
/* Remove inline styles printed when the gallery shortcode is used. */
add_filter('gallery_style', 'anps_remove_gallery_css');
function anps_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}
/* WIDGET: Remove recent comments sytle */
add_action('widgets_init', 'anps_remove_recent_comments_style');
function anps_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
/* Prints HTML with meta information for the current post-date/time and author. */
if (!function_exists('widebox_posted_on')) :    
    function widebox_posted_on() {
        printf(__('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', ANPS_TEMPLATE_LANG), 'meta-prep meta-prep-author', sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()
                ), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', ANPS_TEMPLATE_LANG), get_the_author()), get_the_author()
                )
        );
    }
endif;
/* Prints HTML with meta information for the current post (category, tags and permalink).*/
if (!function_exists('widebox_posted_in')) :   
    function widebox_posted_in() {
        // Retrieves tag list of current post, separated by commas.
        $tag_list = get_the_tag_list('', ', ');
        if ($tag_list) {
            $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ANPS_TEMPLATE_LANG);
        } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
            $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ANPS_TEMPLATE_LANG);
        } else {
            $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', ANPS_TEMPLATE_LANG);
        }
        // Prints the string, replacing the placeholders.
        printf($posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0'));
    }
endif;
/* After setup theme */
add_action('after_setup_theme', 'anps_setup');
if (!function_exists('anps_setup')):
    function anps_setup() {
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain(ANPS_TEMPLATE_LANG, get_template_directory() . '/languages');
        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Navigation', ANPS_TEMPLATE_LANG),
        ));
        // This theme allows users to set a custom background
        //add_custom_background();
        // Your changeable header business starts here
        define('HEADER_TEXTCOLOR', '');
        // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
        define('HEADER_IMAGE', '%s/images/headers/path.jpg');
        // The height and width of your custom header. You can hook into the theme's own filters to change these values.
        // Add a filter to widebox_header_image_width and widebox_header_image_height to change these values.
        define('HEADER_IMAGE_WIDTH', apply_filters('widebox_header_image_width', 190));
        define('HEADER_IMAGE_HEIGHT', apply_filters('widebox_header_image_height', 54));
        // We'll be using post thumbnails for custom header images on posts and pages.
        // We want them to be 940 pixels wide by 198 pixels tall.
        // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
        set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);
        // Don't support text inside the header image.
        define('NO_HEADER_TEXT', true);
        // Add a way for the custom header to be styled in the admin panel that controls
        // custom headers. See widebox_admin_header_style(), below.
        //add_custom_image_header( '', 'widebox_admin_header_style' );
        // ... and thus ends the changeable header business.
        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        register_default_headers(array(
            'berries' => array(
                'url' => '%s/images/headers/logo.png',
                'thumbnail_url' => '%s/images/headers/logo.png',
                /* translators: header image description */
                'description' => __('Move default logo', ANPS_TEMPLATE_LANG)
            )
        ));
        if (!isset($_GET['stylesheet']))
            $_GET['stylesheet'] = '';
        $theme = wp_get_theme($_GET['stylesheet']);
        if (!isset($_GET['activated']))
            $_GET['activated'] = '';
        if ($_GET['activated'] == 'true' && $theme->get_template() == 'widebox132') {
            
            $arr = array(
                    0=>array('label'=>'e-mail', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'email', 'validation'=>'email'),
                    1=>array('label'=>'subject', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'subject', 'validation'=>'none'),
                    2=>array('label'=>'contact number', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'contact number', 'validation'=>'phone'),
                    3=>array('label'=>'lorem ipsum', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'lorem ipsum', 'validation'=>'none'),
                    4=>array('label'=>'message', 'input_type'=>'textarea', 'is_required'=>'on', 'placeholder'=>'message', 'validation'=>'none'),
                );
            update_option('anps_contact', $arr);
        } 
    }
endif;
/* theme options init */
add_action('admin_init', 'anps_theme_options_init');
function anps_theme_options_init() {
    register_setting('sample_options', 'sample_theme_options');
}
/* If user is admin, he will see theme options */
add_action('admin_menu', 'anps_theme_options_add_page');
function anps_theme_options_add_page() {
    global $current_user; 
    if($current_user->user_level==10) {
        add_theme_page('Theme Options', 'Theme Options', 'read', 'theme_options', 'theme_options_do_page');
    }
}
function theme_options_do_page() {
    include_once "admin_view.php";
}
/* Wp_mail */
function anps_MailFunction(){
    include_once get_template_directory().'/anps-framework/classes/Options.php';
    $anps_social_data = $options->get_social();
    $to = $anps_social_data['email'];    //your e-mail to which the message will be sent
    $from = $anps_social_data['email'];        //e-mail address from which the e-mail will be sent
    $subject_contact_us = 'Someone has sent you a message!';   //subject of the e-mail for the form on contact-us.html
    $subject_follow_us = 'I want to follow you';       //subject of the e-mail for the form on follow-us.html
    $message = '';
    $message .= '<table cellpadding="0" cellspacing="0">';
    foreach ($_POST['form_data'] as $postname => $post) {
        if ($postname != 'envoo-admin-mail' && $postname != "recaptcha_challenge_field" && $postname != "recaptcha_response_field") {
            $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>" . urldecode($postname) . ":</strong>" . "</td><td style='padding: 5px; color: #444'>" . $post . "</td></tr>";
        }
    } 
    $message .= '</table>';
    $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: info@yourdomain.com' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    wp_mail($to, $subject_contact_us, $message, $headers);
}
add_action('wp_ajax_nopriv_MailFunction', 'anps_MailFunction');
add_action( 'wp_ajax_MailFunction', 'anps_MailFunction' ); 
/* Comments */
function anps_comment($comment, $args, $depth) {
    $email = $comment->comment_author_email;
    $user_id = -1;
    if (email_exists($email)) {
        $user_id = email_exists($email);
    }
    $GLOBALS['comment'] = $comment;
    // time difference
    $today = new DateTime(date("Y-m-d H:i:s"));
    $pastDate = $today->diff(new DateTime(get_comment_date("Y-m-d H:i:s")));
    if($pastDate->y>0) {
        if($pastDate->y=="1") {
            $text = __("year ago", ANPS_TEMPLATE_LANG);
        } else {
            $text = __("years ago", ANPS_TEMPLATE_LANG);
        }
        $comment_date = $pastDate->y." ".$text;
    } elseif($pastDate->m>0) {
        if($pastDate->m=="1") {
            $text = __("month ago", ANPS_TEMPLATE_LANG);
        } else {
            $text = __("months ago", ANPS_TEMPLATE_LANG);
        }
        $comment_date = $pastDate->m." ".$text;
    } elseif($pastDate->d>0) {
        if($pastDate->d=="1") {
            $text = __("day ago", ANPS_TEMPLATE_LANG);
        } else {
            $text = __("days ago", ANPS_TEMPLATE_LANG);
        }
        $comment_date = $pastDate->d." ".$text;
    } elseif($pastDate->h>0) {
        if($pastDate->h=="1") {
            $text = __("hour ago", ANPS_TEMPLATE_LANG);
        } else {
            $text = __("hours ago", ANPS_TEMPLATE_LANG);
        }
        $comment_date = $pastDate->h." ".$text;
    } elseif($pastDate->i>0) {
        if($pastDate->i=="1") {
            $text = __("minute ago", ANPS_TEMPLATE_LANG);
        } else {
            $text = __("minutes ago", ANPS_TEMPLATE_LANG);
        }
        $comment_date = $pastDate->i." ".$text;
    } elseif($pastDate->s>0) {
        if($pastDate->s=="1") {
            $text = __("second ago", ANPS_TEMPLATE_LANG);
        } else {
            $text = __("seconds ago", ANPS_TEMPLATE_LANG);
        }
        $comment_date = $pastDate->s." ".$text;
    } 
    ?>  
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <header>
                <h1><?php comment_author(); ?></h1> 
                <span class="date"><?php echo esc_html($comment_date);?></span>
                <?php echo comment_reply_link(array_merge(array('reply_text' => 'Reply'), array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </header>
            <div class="comment-content"><?php comment_text(); ?></div>
        </article>
    </li>
<?php }
add_filter('comment_reply_link', 'replace_reply_link_class');
function replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link btn", $class);
    return $class;
}
/* Remove Excerpt text */
function sbt_auto_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'sbt_auto_excerpt_more', 20 );
function sbt_custom_excerpt_more( $output ) {
    return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
}
add_filter( 'get_the_excerpt', 'sbt_custom_excerpt_more', 20 );
function anps_getFooterTwitter() {
    $twitter_user = get_option('footer_twitter_acc', 'twitter');
    $settings = array(
        'oauth_access_token' => "1485322933-3Xfq0A59JkWizyboxRBwCMcnrIKWAmXOkqLG5Lm",
        'oauth_access_token_secret' => "aFuG3JCbHLzelXCGNmr4Tr054GY5wB6p1yLd84xdMuI",
        'consumer_key' => "D3xtlRxe9M909v3mrez3g",
        'consumer_secret' => "09FiAL70fZfvHtdOJViKaKVrPEfpGsVCy0zKK2SH8E"
    );
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $twitter_user . '&count=1';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $twitter_json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest();
    $twitter_json = json_decode($twitter_json, true);
    $twitter_user_url = "https://twitter.com/" . $twitter_user;
    $twitter_text = $twitter_json[0]["text"];
    $twitter_tweet_url = "https://twitter.com/" . $twitter_user . "/status/" . $twitter_json[0]["id_str"];
    ?>
    <div class="twitter-footer"><div class="container"><a href="<?php echo esc_url($twitter_user_url); ?>" target="_blank" class="tw-icon"></a><a href="<?php echo esc_url($twitter_user_url); ?>" target="_blank" class="tw-heading"><?php _e("twitter feed", ANPS_TEMPLATE_LANG); ?></a><a href="<?php echo esc_url($twitter_tweet_url); ?>" target="_blank" class="tw-content"><?php echo $twitter_text; ?></a></div></div>
    <?php
}
function get_excerpt(){
    $excerpt = get_the_content();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, 100);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    if( $excerpt != "" ) {
        $excerpt = $excerpt.'...';
    }
    return $excerpt;
}
add_filter('widget_tag_cloud_args','set_cloud_tag_size');
function set_cloud_tag_size($args) {
    $args = array('smallest' => 13, 'largest' => 24);
    return $args;
} 
function anps_boxed() {
    global $anps_options_data;
    if (isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == 'on') {
        return ' boxed';
    }
}