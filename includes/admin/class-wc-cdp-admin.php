<?php
/**
 * WooCommerce Custom Display Price
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@sudosystems.net.au so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Custom Display 
 * Price to newer versions in the future.
 *
 * @package     WC-CDP/Admin
 * @author      Sudo Systems
 * @copyright   Copyright (c) 2014, Sudo Systems
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Custom Display Price Admin Class
 *
 * Adds general CDP settings and the display price meta field to products
 *
 * @since 0.1
 */
class WC_CDP_Admin {

	/** WC_CDP the plugin */
	private $plugin;
	
	/**
	 * Setup admin class
	 *
	 * @since 0.1
	 * @param WC_CDP $plugin the plugin
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

		/* Product Hooks */

		// add display price field to simple products under the 'General' tab
		add_action( 'woocommerce_product_options_pricing', array( $this, 'add_display_price_field_to_simple_product' ) );

		// add display price field to variable products under the 'General' tab
		add_action( 'woocommerce_product_options_sku', array( $this, 'add_display_price_field_to_variable_product' ) );
		
		// save the display price field for simple products
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_display_price' ), 10, 2 );
		
		// save the display price field for simple subscription products
		add_action( 'woocommerce_process_product_meta_simple-subscription', array( $this, 'save_product_display_price' ), 10, 2 );
		
		// save the display price field for variable products
		add_action( 'woocommerce_process_product_meta_variable', array( $this, 'save_product_display_price_variable' ), 10, 2 );
		
		// save the display price field for variable subscription products
		add_action( 'woocommerce_process_product_meta_variable-subscription', array( $this, 'save_product_display_price_variable' ), 10, 2 );

	}
	
	/**
	 * Add display price field to simple products under the 'General' tab
	 *
	 * @since 0.1
	 */
	public function add_display_price_field_to_simple_product() {

		woocommerce_wp_text_input(
			array(
				'id'                => '_wc_cdp_price',
				'class'             => 'wc_input_price short',
				'label'             => sprintf( __( 'Display Price (%s)', WC_CDP::TEXT_DOMAIN ), get_woocommerce_currency_symbol() ),
				'data_type'         => 'price',
				'desc_tip'          => true,
				'description'       => __( 'Override product display price. This does not affect the actual product price.', WC_CDP::TEXT_DOMAIN ),
			)
		);
	}
	
	/**
	 * Add display price field to variable products under the 'General' tab
	 *
	 * @since 0.1
	 */
	public function add_display_price_field_to_variable_product() {

		woocommerce_wp_text_input(
			array(
				'id'                => '_wc_cdp_price_variable',
				'class'             => 'wc_input_price short',
				'wrapper_class'     => 'show_if_variable',
				'label'             => sprintf( __( 'Display Price (%s)', WC_CDP::TEXT_DOMAIN ), get_woocommerce_currency_symbol() ),
				'data_type'         => 'price',
				'desc_tip'          => true,
				'description'       => __( 'Override product display price. This does not affect the actual product price.', WC_CDP::TEXT_DOMAIN ),
			)
		);
	}
	
	/**
	 * Save display price field for simple product
	 *
	 * @since 0.1
	 */
	public function save_product_display_price( $post_id ) {

		update_post_meta( $post_id, '_wc_cdp_price', stripslashes( $_POST['_wc_cdp_price'] ) );

	}
	
	/**
	 * Save display price field for variable product
	 *
	 * @since 0.1
	 */
	public function save_product_display_price_variable( $post_id ) {

		update_post_meta( $post_id, '_wc_cdp_price_variable', stripslashes( $_POST['_wc_cdp_price_variable'] ) );

	}

}