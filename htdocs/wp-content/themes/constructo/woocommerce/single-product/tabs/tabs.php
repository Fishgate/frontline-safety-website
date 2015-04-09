<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
	
	<?php $return = '[vc_tabs]'; ?>
		
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<?php 
					ob_start();
					call_user_func( $tab['callback'], $key, $tab );
					$content = ob_get_clean();
					$return .= '[vc_tab title="' . apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) . '" tab_id="' . $key . '_tab"]' . $content . '[/vc_tab]';

				?>

			<?php endforeach; ?>

	<?php $return .= '[/vc_tabs]'; ?>

	<?php echo do_shortcode($return); ?>

<?php endif; ?>