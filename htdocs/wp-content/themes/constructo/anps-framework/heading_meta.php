<?php
add_action('add_meta_boxes', 'anps_heading_add_custom_box');
add_action('save_post', 'anps_heading_save_postdata');

function anps_heading_add_custom_box() { 
    $screens = array('page', 'post');
    foreach($screens as $screen) {
        if($screen=="product") {
            $anps_priority = "low";
        } else {
            $anps_priority = "high";
        }
        add_meta_box('anps_heading_meta', __('Page title and breadcrumbs', ANPS_TEMPLATE_LANG), 'display_meta_box_heading', $screen, 'normal', $anps_priority);
    }
    add_meta_box('anps_heading_meta', __('Page title and breadcrumbs', ANPS_TEMPLATE_LANG), 'display_meta_box_heading', 'portfolio', 'normal', 'core');
}

function display_meta_box_heading( $post ) { 
    $value2 = get_post_meta($post->ID, $key ='anps_disable_heading', $single = true ); 
    $heading_value = get_post_meta($post->ID, $key ='heading_bg', $single = true ); 
    $checked = '';
    if($value2=='1') {
        $checked = 'checked';
    }
    echo "<p>Disable heading <input type='checkbox' name='anps_disable_heading' value='1' $checked /></p>"; ?>
    <p>
        <label for="heading_bg"><?php _e("Page heading background", ANPS_TEMPLATE_LANG); ?></label>
        <input id="heading_bg" type="text" size="36" name="heading_bg" value="<?php echo esc_attr($heading_value); ?>" />
        <input id="_btn" class="upload_image_button button" type="button" value="Upload" />
    </p>
    <script>
        jQuery(document).ready(function() {  
    var formfield; 
    jQuery('.upload_image_button').click(function() {
        jQuery('html').addClass('Image');
        formfield = jQuery(this).prev().attr('name'); 
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    }); 
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){ 
        if (formfield) { 
            fileurl = jQuery('img',html).attr('src'); 
            jQuery('#'+formfield).val(fileurl);
            tb_remove();
            jQuery('html').removeClass('Image');
            formfield = '';
        } else { 
            window.original_send_to_editor(html);
        }
    }; 
 
});
    </script>
<?php
}

function anps_heading_save_postdata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (empty($_POST))
        return;

    $post_ID = $_POST['post_ID'];

    if (!isset($_POST['anps_disable_heading'])) {
        $_POST['anps_disable_heading'] = '0';
    }
    $mydata2 = $_POST['anps_disable_heading']; 
    
    if (!isset($_POST['heading_bg'])) {
        $_POST['heading_bg'] = '';
    }
    $heading_data = $_POST['heading_bg']; 

    add_post_meta($post_ID, 'anps_disable_heading', $mydata2, true) or update_post_meta($post_ID, 'anps_disable_heading', $mydata2);
    add_post_meta($post_ID, 'heading_bg', $heading_data, true) or update_post_meta($post_ID, 'heading_bg', $heading_data);
}
