<?php
/**
 * @package        WordPress
 * @subpackage    BuddyPress, WooCommerce
 * @author        Boris Glumpler
 * @copyright    2011, Themekraft
 * @link        https://github.com/Themekraft/BP-Shop-Integration
 * @license        http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

/**
 * Screen function to display the shopping cart
 *
 * Template can be changed via the <code> wc4bp_template_member_home</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_cart() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_cart', 'shop/member/cart' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the checkout
 *
 * Template can be changed via the <code> wc4bp_template_member_checkout</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since   1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_checkout() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_checkout', 'shop/member/checkout' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the purchase history
 *
 * Template can be changed via the <code> wc4bp_template_member_history</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_history() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_history', 'shop/member/history' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function for tracking an order
 *
 * Template can be changed via the <code> wc4bp_template_member_track_order</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_track() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_track', 'shop/member/track' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the order list
 *
 * Template can be changed via the <code> wc4bp_template_member_order</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_orders() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_order', 'shop/member/orders' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the download list
 *
 * Template can be changed via the <code> wc4bp_template_member_download</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_downloads() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_download', 'shop/member/download' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the edit account
 *
 * Template can be changed via the <code> wc4bp_template_member_edit_account</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_edit_account() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_edit_account', 'shop/member/edit-account' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the edit address
 *
 * Template can be changed via the <code> wc4bp_template_member_edit_address</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_edit_address() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_edit_address', 'shop/member/edit-address' );
	bp_core_load_template( $screen_path );
}

/**
 * Screen function to display the payment methods
 *
 * Template can be changed via the <code> wc4bp_template_member_payment_methods</code>
 * filter hook. Note that template files can also be copied to the current theme.
 *
 * @since    1.0
 * @uses    bp_core_load_template()
 * @uses    apply_filters()
 */
function wc4bp_screen_payment_methods() {
	/**
	 * Change the path the screen
	 *
	 * @param string The current path
	 */
	$screen_path = apply_filters( 'wc4bp_template_member_payment_methods', 'shop/member/payment-methods' );
	bp_core_load_template( $screen_path );
}

/**
 * Output the tracked order
 *
 * @since    1.0.8
 */
function wc4bp_output_tracking_order() {
	try {
		global $current_order;

		if ( $current_order instanceof WC_Order ) {
			do_action( 'woocommerce_track_order', $current_order->get_id() );
			echo '<h3>' . __( 'Your Order', 'wc4bp' ) . '<h3>';

			wc_get_template( 'order/tracking.php', array(
				'order' => $current_order
			) );
		}
	} catch ( Exception $exception ) {
		WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
	}
}

add_action( 'wc4bp_after_track_body', 'wc4bp_output_tracking_order' );

function wc4bp_screen_plugins() {
	if ( bp_displayed_user_id() && bp_is_current_component( wc4bp_Manager::get_shop_slug() ) && bp_current_action() ) {
		bp_core_load_template( apply_filters( 'wc4bp_template_member_plugin', 'shop/member/plugin' ) );
	}
}
