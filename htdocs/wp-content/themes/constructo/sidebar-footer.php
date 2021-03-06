<?php 
global $anps_options_data;
$footer_columns = get_option('footer_style', '4'); 
$prefooter_columns = get_option('prefooter_style', '4');
$prefooter = get_option('prefooter');
$footer_disable = get_option('footer_disable');
$copyright_footer = get_option('copyright_footer', '1');
$footer_class = "2";
if(isset($anps_options_data['footer_columns'])&&$anps_options_data['footer_columns']=="1") {
    $footer_class = "col-xs-12";
} else {
    $footer_class = "col-xs-6";
}
?>
 
<footer class="site-footer style-2">
    <?php if($prefooter=="on") : ?>
    <div class="container">
        <div class="row">
            <?php if($prefooter_columns=='2' || $prefooter_columns=='5' || $prefooter_columns=='6') : ?>
                <div class="<?php echo esc_attr($footer_class); ?> col-md-<?php if($prefooter_columns=='2'){echo "6";}elseif($prefooter_columns=='5'){echo "9";}elseif($prefooter_columns=='6'){echo "3";} ?>"><ul><?php dynamic_sidebar( 'prefooter-1' ); ?></ul></div>
                <div class="<?php echo esc_attr($footer_class); ?> col-md-<?php if($prefooter_columns=='2'){echo "6";}elseif($prefooter_columns=='5'){echo "3";}elseif($prefooter_columns=='6'){echo "9";} ?>"><ul><?php dynamic_sidebar( 'prefooter-2' ); ?></ul></div>
            <?php elseif($prefooter_columns=='3') : ?>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-1' ); ?></ul></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-2' ); ?></ul></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-3' ); ?></ul></div>
            <?php elseif($prefooter_columns=='4' || $prefooter_columns=='0') : ?>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-1' ); ?></ul></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-2' ); ?></ul></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-3' ); ?></ul></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'prefooter-4' ); ?></ul></div>
            <?php endif; ?>
	</div>
    </div>
    <?php endif; ?>
    <?php if($footer_disable!="on") : ?>
    <div class="container">
        <div class="row">
            <?php if($footer_columns=='2') : ?>
                <div class="col-md-6 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-1' ); ?></ul></div>
                <div class="col-md-6 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-2' ); ?></ul></div>
            <?php elseif($footer_columns=='3') : ?>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-1' ); ?></ul></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-2' ); ?></ul></div>
                <div class="col-md-4 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-3' ); ?></ul></div>
            <?php elseif($footer_columns=='4' || $footer_columns=='0') : ?>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-1' ); ?></ul></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-2' ); ?></ul></div>
                <div class="col-md-3 tablets-clear <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-3' ); ?></ul></div>
                <div class="col-md-3 <?php echo esc_attr($footer_class); ?>"><ul><?php dynamic_sidebar( 'footer-4' ); ?></ul></div>
            <?php endif; ?>
	</div>
    </div>
    <?php endif; ?>
    <div class="copyright-footer">
        <div class="container">
            <div class="row">
                <?php if($copyright_footer=="1" || $copyright_footer=="0") : ?>
                    <ul class="text-center"><?php dynamic_sidebar( 'copyright-1' ); ?></ul>
                <?php elseif($copyright_footer=="2") : ?>
                    <div class="col-md-6"><ul><?php dynamic_sidebar( 'copyright-1' ); ?></ul></div>
                    <div class="col-md-6 text-right"><ul><?php dynamic_sidebar( 'copyright-2' ); ?></ul></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>