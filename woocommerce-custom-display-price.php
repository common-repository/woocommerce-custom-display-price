<?php
	/*
	Plugin Name: WooCommerce Custom Display Price
	Plugin URI: http://www.sudosystems.net.au
	Description: Customise WooCommerce product display prices individually.
	Version: 0.1
	Author: Bowdie Mercieca
	Author URI: http://github.com/sudosystems/
	Requires at least: 3.5
	Tested up to: 4.0
	Text Domain: wc-cdp
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Copyright: (c) 2014 Sudo Systems Integration & Consulting (support@sudosystems.net.au)
	*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Check that WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! class_exists( 'WC_CDP' ) ) {

		class WC_CDP {
		
			/** plugin version number */
			const VERSION = '0.1';

			/** plugin id */
			const PLUGIN_ID = 'cdp';

			/** plugin text domain */
			const TEXT_DOMAIN = 'woocommerce-custom-display-price';
			
			/** @var \WC_CDP_Admin instance plugin admin */
			public $admin;
			
			/**
	 		* Initialize the plugin
	 		*
	 		* @since 0.1
	 		*/
			public function __construct() {
			
				// Include necessary files
				$this->includes();
				
				add_filter( 'woocommerce_get_price_html', array( $this, 'get_custom_display_price' ), 10, 2 );
				add_filter( 'woocommerce_subscriptions_product_price_string', array( $this, 'get_custom_display_price' ), 10, 2 );
				add_filter( 'woocommerce_subscription_price_string', array( $this, 'get_subscription_price_string' ), 10, 2 );
			}
			
			/**
	 		* Include required files
	 		*
	 		* @since 0.1
	 		*/
			private function includes() {
			
				require_once( 'includes/class-wc-cdp-product.php' );

				if ( is_admin() ) {
					$this->admin_includes();
				}
			}

			/**
	 		* Include required admin files
	 		*
	 		* @since 0.1
	 		*/
			private function admin_includes() {

				require_once( 'includes/admin/class-wc-cdp-admin.php' );
				$this->admin = new WC_CDP_Admin( $this );

			}
			
			/**
	 		* Fetch the correct price and override if necessary
	 		*
	 		* @since 0.1
	 		*/
			function get_custom_display_price( $price, $product ) {
			
				if( $product->is_type( array( 'simple' ) ) ) {
				
					if( $display_price = get_post_meta( $product->id, '_wc_cdp_price', true ) )
						return woocommerce_price( $display_price );
				
				} elseif( $product->is_type( array( 'variable' ) ) ) {
				
					if( $display_price = get_post_meta( $product->id, '_wc_cdp_price_variable', true ) )
						return woocommerce_price( $display_price );
				
				}
				
				return $price;
				
			}
		
		}
		
	}
	
	/**
	 * The WC_CDP global object
	 * @name $wc_cdp
 	 * @global WC_Small $GLOBALS['wc_cdp']
 	 */
	$GLOBALS['wc_cdp'] = new WC_CDP();

}