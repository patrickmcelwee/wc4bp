<?php
/**
 * @package        WordPress
 * @subpackage     BuddyPress, Woocommerce
 * @author         GFireM
 * @copyright      2017, Themekraft
 * @link           https://github.com/Themekraft/BP-Shop-Integration
 * @license        http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

// No direct access is allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC4BP_MyAccount {
	
	protected $base_html = '<span class=\'wc4bp-my-account-page\'>wc4bp</span>';
	
	protected $current_title;
	
	public function __construct() {
		
		add_action( 'update_option_wc4bp_options', array( $this, "process_saved_settings" ), 10, 2 );
		add_filter( 'the_title', array( $this, 'add_title_mark' ), 10, 2 );
		
		add_filter( 'esc_html', array( $this, "esc_html_for_title" ), 10, 2 );
		
		add_filter( 'woocommerce_get_endpoint_url', array( $this, 'endpoint_url' ), 1, 4 );
		
		add_filter( 'woocommerce_get_myaccount_page_permalink', array( $this, 'my_account_page_permalink' ), 10, 1 );
		add_filter( 'woocommerce_get_myaccount_page_id', array( $this, 'my_account_page_id' ), 10, 1 );
		
		add_filter( 'woocommerce_get_view_order_url', array( $this, 'get_view_order_url' ), 10, 2 );
	}
	
	public function get_base_url( $endpoint ) {
		return bp_core_get_user_domain( bp_loggedin_user_id() ) . "shop/" . $endpoint;
	}
	
	/**
	 * Change url for view order endpoint.
	 *
	 * @param $view_order_url
	 * @param $order
	 *
	 * @return string
	 */
	public function get_view_order_url( $view_order_url, $order ) {
		$view_order_url = wc_get_endpoint_url( 'view-order', $order->id, $this->get_base_url( 'wc4bp_orders' ) );
		return $view_order_url;
	}
	
	public function endpoint_url( $url, $endpoint, $value, $permalink ) {
		if ( wc4bp_Manager::is_current_active() ) {
			global $current_user, $bp;
			
			$current_user = wp_get_current_user();
			$userdata     = get_userdata( $current_user->ID );
			
			$base_path = get_bloginfo( 'url' ) . '/' . $bp->pages->members->slug . '/' . $userdata->user_nicename . '/shop/';
			
			switch ( $endpoint ) {
				case "payment-methods":
					$url = $base_path . 'payment';
					break;
				case "set-default-payment-method":
				case "delete-payment-method":
					$url = add_query_arg( $endpoint, $value, $base_path . 'payment' );
					break;
				case "add-payment-method":
					$url = add_query_arg( $endpoint, "w2ewe3423ert", $base_path . 'payment/add-payment' );
					break;
			}
		}
		
		return $url;
	}
	
	/**
	 * Redirect WC my Account to BP member profile page
	 *
	 * @param $permalink
	 *
	 * @return string
	 */
	public function my_account_page_permalink( $permalink ) {
		global $current_user, $bp;
		
		$current_user = wp_get_current_user();
		$userdata     = get_userdata( $current_user->ID );
		
		$wc4bp_endpoint = WC4BP_MyAccount::get_active_endpoints();
		
		if ( ! empty( $wc4bp_endpoint ) ) {
			foreach ( $wc4bp_endpoint as $active_page_key => $active_page_name ) {
				if ( $bp->current_action == $active_page_key ) {
					$permalink = get_bloginfo( 'url' ) . '/' . $bp->pages->members->slug . '/' . $userdata->user_nicename . '/shop/' . $bp->current_action;
					break;
				}
			}
		}
		
		return $permalink;
	}
	
	/**
	 * Get the BP member page id
	 *
	 * @param $page_id
	 *
	 * @return string
	 */
	public function my_account_page_id( $page_id ) {
		$page = get_page_by_path( "member" );
		return $page->ID;
	}
	
	public function esc_html_for_title( $safe_text, $text ) {
		if ( ! empty( $this->current_title ) && $text == $this->current_title ) {
			return $text;
		}
		
		return $safe_text;
	}
	
	public function add_title_mark( $title, $id ) {
		$titles    = self::get_active_endpoints();
		$post_meta = get_post_meta( $id, 'wc4bp-my-account-template', true );
		if ( ! empty( $titles ) && in_array( $title, $titles ) && ! empty( $post_meta ) ) {
			$title               = $title . $this->base_html;
			$this->current_title = $title;
		}
		
		return $title;
	}
	
	/**
	 * @param $old_value
	 * @param $new_value
	 */
	public function process_saved_settings( $old_value, $new_value ) {
		$wc4bp_options = get_option( 'wc4bp_options' );
		if ( empty( $wc4bp_options["tab_activity_disabled"] ) ) {
			foreach ( self::get_available_endpoints() as $end_point_key => $end_point_value ) {
				$post = self::get_page_by_name( 'wc4bp_' . $end_point_key );
				if ( ! empty( $wc4bp_options[ 'wc4bp_endpoint_' . $end_point_key ] && $wc4bp_options[ 'wc4bp_endpoint_' . $end_point_key ] == "1" ) ) {
					if ( ! empty( $post ) ) {
						wp_delete_post( $post->ID, true );
					}
				} else {
					if ( empty( $post ) ) {
						$r = wp_insert_post(
							array(
								'comment_status' => 'closed',
								'ping_status'    => 'closed',
								'post_title'     => $end_point_value,
								'post_name'      => 'wc4bp_' . $end_point_key,
								'post_content'   => self::get_page_content( $end_point_key ),
								'post_status'    => 'publish',
								'post_type'      => 'page',
								'meta_input'     => array(
									'wc4bp-my-account-template' => 1,
								),
							)
						);
					}
				}
			}
		} else {
			self::remove_all_endpoints();
		}
	}
	
	public static function add_all_endpoints() {
		foreach ( self::get_available_endpoints() as $end_point_key => $end_point_value ) {
			$post = self::get_page_by_name( 'wc4bp_' . $end_point_key );
			if ( empty( $post ) ) {
				$r = wp_insert_post(
					array(
						'comment_status' => 'closed',
						'ping_status'    => 'closed',
						'post_title'     => $end_point_value,
						'post_name'      => 'wc4bp_' . $end_point_key,
						'post_content'   => self::get_page_content( $end_point_key ),
						'post_status'    => 'publish',
						'post_type'      => 'page',
						'meta_input'     => array(
							'wc4bp-my-account-template' => 1,
						),
					)
				);
			}
		}
	}
	
	public static function remove_all_endpoints() {
		foreach ( self::get_available_endpoints() as $end_point_key => $end_point_value ) {
			$post = self::get_page_by_name( 'wc4bp_' . $end_point_key );
			if ( ! empty( $post ) ) {
				wp_delete_post( $post->ID, true );
			}
		}
	}
	
	/**
	 * Get my account pages content
	 *
	 * @param string $end_point_key
	 *
	 * @return array|String
	 */
	public static function get_page_content( $end_point_key = "" ) {
		$result    = array();
		$available = self::get_available_endpoints();
		if ( ! empty( $available ) ) {
			if ( empty( $end_point_key ) ) {
				foreach ( $available as $available_key => $available_value ) {
					$result = array_merge( $result, array(
							$available_key => apply_filters( "wc4bp_woocommerce_endpoint_content_" . $available_key, "[" . $available_key . "]" )
						)
					);
				}
			} else {
				if ( ! empty( $available[ $end_point_key ] ) ) {
					$result = apply_filters( "wc4bp_woocommerce_endpoint_content_" . $end_point_key, "[" . $end_point_key . "]" );
				}
			}
		}
		
		return $result;
	}
	
	public static function get_page_by_name( $post_name, $output = OBJECT ) {
		global $wpdb;
		$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type='page'", $post_name ) );
		if ( $post ) {
			return get_post( $post, $output );
		}
		
		return null;
	}
	
	public static function get_active_endpoints() {
		$wc4bp_options = get_option( 'wc4bp_options' );
		$result        = array();
		foreach ( self::get_available_endpoints() as $end_point_key => $end_point_value ) {
			if ( empty( $wc4bp_options[ 'wc4bp_endpoint_' . $end_point_key ] ) ) {
				$result[ $end_point_key ] = $end_point_value;
			}
		}
		
		return $result;
	}
	
	public static function get_available_endpoints() {
		if ( wc4bp_Manager::is_woocommerce_active() ) {
			$end_points = wc_get_account_menu_items();
			$exclude    = apply_filters( "wc4bp_woocommerce_exclude_endpoint", array( "customer-logout", "dashboard" ) );
			
			return array_diff_key( $end_points, array_flip( $exclude ) );
			
		} else {
			return array();
		}
	}
}